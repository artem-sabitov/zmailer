<?php

declare(strict_types=1);

namespace Zmailer;

use Zend\Mail\Transport\TransportInterface;
use Zend\View\Renderer\RendererInterface;
use Zend\View\Resolver\ResolverInterface;

class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'mailer' => $this->getMailerConfig(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'aliases' => [
                MailerInterface::class => Mailer::class,
            ],
            'factories'  => [
                Mailer::class => MailerFactory::class,
                RendererInterface::class => MailRendererFactory::class,
                ResolverInterface::class => MailTemplateResolverFactory::class,
                TransportInterface::class => SmtpTransportFactory::class,
            ],
        ];
    }

    public function getMailerConfig() : array
    {
        return [
            /*
             * Example: smtp.mailgun.org
             *
             * [
             *     'robot' => [
             *         'from' => 'robot@example.com',
             *         'from_name' => 'Robot',
             *     ],
             *     'templates' => [
             *         'example' => __DIR__ . '/../view/mails/example.phtml,
             *     ],
             *     'transport' => [
             *         'name' => 'example.com',
             *         'host' => 'smtp.mailgun.org',
             *         'port' => 2525,
             *         'connection_class' => 'login',
             *         'connection_config' => [
             *             'username' => 'username',
             *             'password' => 'password',
             *         ],
             *     ],
             * ],
             */
        ];
    }
}
