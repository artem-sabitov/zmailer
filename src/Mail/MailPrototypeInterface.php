<?php

declare(strict_types=1);

namespace Zmailer\Mail;

use Zmailer\RecipientInterface;

interface MailPrototypeInterface
{
    public function getRecipient() : RecipientInterface;

    public function getSubject() : string;

    public function getBody() : ?string;

    public function getTemplate() : ?string;

    public function getParameters() : ?array;
}
