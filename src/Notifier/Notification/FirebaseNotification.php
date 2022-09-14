<?php

namespace App\Notifier\Notification;

use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\Recipient\SmsRecipientInterface;

class FirebaseNotification extends \Symfony\Component\Notifier\Notification\Notification implements \Symfony\Component\Notifier\Notification\SmsNotificationInterface
{

    public function asSmsMessage(SmsRecipientInterface $recipient, string $transport = null): ?SmsMessage
    {
        // TODO: Implement asSmsMessage() method.
        return new SmsMessage($recipient->getPhone(), '');
    }
}