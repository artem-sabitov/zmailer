<?php

declare(strict_types=1);

namespace Zmailer;

interface RecipientInterface
{
    public function getFirstname(): string;

    public function getLastname(): string;

    public function getEmail(): string;
}