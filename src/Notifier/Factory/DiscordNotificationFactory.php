<?php

namespace App\Notifier\Factory;

use App\Notifier\Notification\DiscordNotification;
use Symfony\Component\Notifier\Notification\Notification;

class DiscordNotificationFactory implements NotificationFactory, IndexableNotificationFactory
{

    public function create(): Notification
    {
        return new DiscordNotification();
    }

    public function getDefaultIndexName()
    {
        return 'discord';
    }
}