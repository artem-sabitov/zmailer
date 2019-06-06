<?php

declare(strict_types=1);

namespace Zmailer;

use Zend\Mail;
use Zend\Mail\Exception;
use Zend\Mime;
use Zend\Mail\Transport\TransportInterface;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\RendererInterface;
use Zmailer\Exception\RuntimeException;
use Zmailer\Mail\MailPrototypeInterface;

class Mailer implements MailerInterface
{
    protected const ENCODING = 'UTF-8';
    protected const BODY_TYPE = 'text/html';

    /**
     * @var array
     */
    protected $config;

    /**
     * @var TransportInterface
     */
    protected $transport;

    /**
     * @var RendererInterface
     */
    protected $renderer;

    public function __construct(
        array $config,
        TransportInterface $transport = null,
        RendererInterface $renderer = null
    ) {
        $this->config = $config;
        $this->transport = $transport;
        $this->renderer = $renderer;
    }

    /**
     * @throws Exception\RuntimeException
     */
    public function send(Mail\Message $message) : void
    {
        try {
            $this->transport->send($message);
        } catch (Exception\RuntimeException $e) {
            $fromList = implode((array) $message->getFrom(), ', ');
            $toList = implode((array) $message->getTo(), ', ');
            $exceptionMessage = sprintf('Failed: %s → %s', $fromList, $toList);

            throw new RuntimeException($exceptionMessage, 0, $e);
        }
    }

    public function createMessage(MailPrototypeInterface $mailPrototype) : Mail\Message
    {
        $recipient = $mailPrototype->getRecipient();
        $fullName = $recipient->getFirstname() . ' ' . $recipient->getLastname();

        $body = $this->renderBody(
            $mailPrototype->getTemplate(),
            $mailPrototype->getParameters()
        );

        $mail = (new Mail\Message())
            ->addFrom($this->config['from'], $this->config['from_name'])
            ->addTo($recipient->getEmail(), $fullName)
            ->setSubject($mailPrototype->getSubject())
            ->setBody($body)
            ->setEncoding(static::ENCODING);

        return $mail;
    }

    protected function renderBody(string $template, array $variables) : Mime\Message
    {
        $view = (new ViewModel())
            ->setTemplate($template)
            ->setVariables($variables);

        $html = $this->renderer->render($view);
        $bodyMessage = (new Mime\Part($html))->setType(static::BODY_TYPE);

        return (new Mime\Message())->addPart($bodyMessage);
    }

    /**
     * @throws RuntimeException
     */
    public function sendBatch(MailBatch $batch) : array
    {
        $exceptions = [];

        foreach ($batch as $mailPrototype) {
            if ($mailPrototype instanceof MailPrototypeInterface) {
                try {
                    $this->send($this->createMessage($mailPrototype));
                } catch (RuntimeException $e) {
                    // TODO return SendingResult
                    $exceptions[] = $e;
                }
            }
        }

        return $exceptions;
    }
}
