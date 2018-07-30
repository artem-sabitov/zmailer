<?php

declare(strict_types=1);

namespace Zmailer;

use Psr\Container\ContainerInterface;
use Zend\Mail\Transport\TransportInterface;
use Zend\View\Renderer\RendererInterface;

class MailerFactory
{
    public function __invoke(ContainerInterface $container) : Mailer
    {
        $config = $container->get('config')['mailer']['robot'] ?? null;
        if ($config === null) {
            throw new Exception\InvalidConfigException(
                'Mailer config is missing'
            );
        }

        if (! isset($config['from'])) {
            throw new Exception\InvalidConfigException(
                'Invalid mailer config; field \'from\' is missing'
            );
        }

        if (! isset($config['from_name'])) {
            throw new Exception\InvalidConfigException(
                'Invalid mailer config; field \'from_name\' is missing'
            );
        }

        $transport = $container->has(TransportInterface::class) ?
            $container->get(TransportInterface::class) :
            null;
        if ($transport === null) {
            throw new Exception\InvalidConfigException(
                'TransportInterface service is missing'
            );
        }

        $renderer = $container->has(RendererInterface::class) ?
            $container->get(RendererInterface::class) :
            null;
        if ($renderer === null) {
            throw new Exception\InvalidConfigException(
                'RendererInterface service is missing'
            );
        }

        return new Mailer($transport, $renderer);
    }
}
