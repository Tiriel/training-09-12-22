<?php

namespace App\Notifier;

use App\Notifier\Factory\ChainNotificationFactory;
use App\Notifier\Factory\FirebaseNotificationFactory;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;

class MovieNotifier
{
    private NotifierInterface $notifier;
    private ChainNotificationFactory $factory;

    public function __construct(NotifierInterface $notifier, ChainNotificationFactory $factory)
    {
        $this->notifier = $notifier;
        $this->factory = $factory;
    }

    public function sendNotification($message)
    {
        $user = new class {
            public function getPreferredChannel() {
                return 'discord';
            }
        };
        // $user->getPreferredChannel() = 'discord'
        /** @var Notification $notification */
        $notification = $this->factory->create($user->getPreferredChannel());


        $this->notifier->send($notification);
    }
}