<?php

declare(strict_types=1);

namespace Zmailer;

use Zend\Mail\Exception\RuntimeException;
use Zend\Mail\Message;

interface MailerInterface
{
    /**
     * @throws RuntimeException
     */
    public function send(Message $message) : void;

    /**
     * @throws RuntimeException
     */
    public function sendBatch(\ArrayObject $batch) : void;
}
