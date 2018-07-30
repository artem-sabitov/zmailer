<?php

declare(strict_types=1);

namespace Zmailer\Exception;

class RuntimeException extends \RuntimeException
{
    /**
     * @var array
     */
    protected $messages;

    /**
     * @return array
     */
    public function getMessages()
    {
        if ($this->messages === null) {
            $this->messages = [$this->getMessage()];
        }

        return $this->messages;
    }

    public function withMessages(array $messages)
    {
        $this->messages = $messages;

        return $this;
    }
}
