<?php

declare(strict_types=1);

namespace Zmailer\Mail;

interface MailPrototypeInterface
{
    public function getRecipient() : string;

    public function getSubject() : string;

    public function getBody() : string;

    public function getTemplate() : ?string;

    public function getParameters() : ?array;
}
