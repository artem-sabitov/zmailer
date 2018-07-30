<?php

declare(strict_types=1);

namespace Zmailer;

use Psr\Container\ContainerInterface;
use Zend\View\Resolver\TemplateMapResolver;

class MailTemplateResolverFactory
{
    public function __invoke(ContainerInterface $container) : TemplateMapResolver
    {
        $templates = $container->get('config')['mailer']['templates'] ?? null;
        if ($templates === null) {
            throw new Exception\InvalidConfigException(
                'Template map is missing'
            );
        }

        return new TemplateMapResolver($templates);
    }
}
