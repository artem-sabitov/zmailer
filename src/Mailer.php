<?php

declare(strict_types=1);

namespace Zmailer;

use Zend\Mail;
use Zend\Mail\Exception\RuntimeException;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mail\Transport\TransportInterface;
use Zmailer\Mail\MailPrototypeInterface;

class Mailer implements MailerInterface
{
    /**
     * @var array
     */
    private $config;

    public function __construct(array $config, TransportInterface $transport = null)
    {
        $this->config = $config;

        if ($transport === null) {
            $transport = $this->initializeDefaultTransport();
        }
        $this->transport = $transport;
    }

    private function initializeDefaultTransport()
    {
        $config = new SmtpOptions($this->config['smtp_transport']);

        return (new SmtpTransport())->setOptions($config);
    }


    /**
     * @throws RuntimeException
     */
    public function send(Message $message) : void
    {
    }

    public function createMessage(MailPrototypeInterface $mailPrototype) : Message
    {
        $user = $mailPrototype->getRecipient();
        $fullName = $user->getFirstname() . ' ' . $user->getLastname();

        $mail = new Mail\Message();
        $mail
            ->setSubject($mailPrototype->getSubject())
            ->setBody()
            ->setFrom($this->config['from'], $this->config['from_name'])
            ->addTo($user->getEmail(), $fullName);

    }

    /**
     * @throws RuntimeException
     */
    public function sendBatch(\ArrayObject $batch) : void
    {
        // TODO: Implement sendBatch() method.
    }
}
