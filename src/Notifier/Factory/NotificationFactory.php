<?php

namespace App\Notifier\Factory;

use Symfony\Component\Notifier\Notification\Notification;

interface NotificationFactory
{
    public function create(): Notification;
}