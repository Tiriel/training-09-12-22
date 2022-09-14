<?php

namespace App\Notifier\Factory;

use App\Notifier\Notification\FirebaseNotification;
use Symfony\Component\Notifier\Notification\Notification;

class FirebaseNotificationFactory implements NotificationFactory, IndexableNotificationFactory
{

    public function create(): Notification
    {
        return new FirebaseNotification();
    }

    public function getDefaultIndexName()
    {
        return 'firebase';
    }
}