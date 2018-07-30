<?php

declare(strict_types=1);

namespace Zmailer;

use Psr\Container\ContainerInterface;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;

class SmtpTransportFactory
{
    public function __invoke(ContainerInterface $container) : Smtp
    {
        $smtpConfig = $container->get('config')['mailer']['transport'] ?? null;
        if ($smtpConfig === null) {
            throw new Exception\InvalidConfigException(
                'SMTP options is missing'
            );
        }

        return new Smtp(new SmtpOptions($smtpConfig));
    }
}
