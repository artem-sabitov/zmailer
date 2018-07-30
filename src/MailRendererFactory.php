<?php

declare(strict_types=1);

namespace Zmailer;

use Psr\Container\ContainerInterface;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver\ResolverInterface;

class MailRendererFactory
{
    public function __invoke(ContainerInterface $container) : PhpRenderer
    {
        $templateResolver = $container->has(ResolverInterface::class) ?
            $container->get(ResolverInterface::class) :
            null;

        if ($templateResolver === null) {
            throw new Exception\InvalidConfigException(
                'ResolverInterface service is missing'
            );
        }

        return (new PhpRenderer())->setResolver($templateResolver);
    }
}
