<?php

declare(strict_types=1);

namespace Zmailer\Mail;

use User\User;

interface MailPrototypeInterface
{
    public function getRecipient() : User;

    public function getSubject() : string;

    public function getBody() : ?string;

    public function getTemplate() : ?string;

    public function getParameters() : ?array;
}
