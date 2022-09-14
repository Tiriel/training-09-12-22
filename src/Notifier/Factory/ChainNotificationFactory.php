<?php

namespace App\Notifier\Factory;

use Symfony\Component\Notifier\Notification\Notification;

class ChainNotificationFactory implements NotificationFactory
{
    private array $factories;

    public function __construct(iterable $factories)
    {
        $this->factories = $factories instanceof \Traversable ? iterator_to_array($factories) : $factories;
        // ['discord' => $discordFactory, 'slack' => $slackFactory...
    }

    public function create($channel = ''): Notification
    {
        return $this->factories[$channel]->create();
    }
}