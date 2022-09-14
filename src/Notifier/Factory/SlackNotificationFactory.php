<?php

namespace App\Notifier\Factory;

use App\Notifier\Notification\SlackNotification;
use Symfony\Component\Notifier\Notification\Notification;

class SlackNotificationFactory implements NotificationFactory, IndexableNotificationFactory
{

    public function create(): Notification
    {
        return new SlackNotification();
    }

    public function getDefaultIndexName()
    {
        return 'slack';
    }
}