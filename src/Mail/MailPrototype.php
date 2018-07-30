<?php

declare(strict_types=1);

namespace Zmailer\Mail;

use User\User;

class MailPrototype implements MailPrototypeInterface
{
    /**
     * @var User
     */
    protected $recipient;

    /**
     * @var string
     */
    protected $subject;

    /**
     * @var string|null
     */
    protected $body;

    /**
     * @var string|null
     */
    protected $template;

    /**
     * @var array|null
     */
    protected $parameters;

    /**
     * MailPrototype constructor.
     * @param User $recipient
     * @param string $subject
     * @param null|string $body
     * @param null|string $template
     * @param array|null $parameters
     */
    public function __construct(
        User $recipient,
        string $subject,
        ?string $body = null,
        ?string $template = null,
        ?array $parameters = null
    ) {
        $this->recipient = $recipient;
        $this->subject = $subject;
        $this->body = $body;
        $this->template = $template;
        $this->parameters = $parameters;
    }

    public function getRecipient() : User
    {
        return $this->recipient;
    }

    public function getSubject() : string
    {
        return $this->subject;
    }

    public function setSubject(string $subject) : MailPrototype
    {
        $this->subject = $subject;

        return $this;
    }

    public function getBody() : ?string
    {
        return $this->body;
    }

    public function setBody(?string $body = null) : MailPrototype
    {
        $this->body = $body;

        return $this;
    }

    public function getTemplate() : ?string
    {
        return $this->template;
    }

    public function setTemplate(?string $template = null) : MailPrototype
    {
        $this->template = $template;

        return $this;
    }

    public function getParameters() : ?array
    {
        return $this->parameters;
    }

    public function setParameters(?array $parameters = null) : MailPrototype
    {
        $this->parameters = $parameters;

        return $this;
    }
}
