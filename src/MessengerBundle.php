<?php

declare(strict_types=1);

namespace Ujwaldhakal\OpentracingMessengerBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Ujwaldhakal\OpentracingMessengerBundle\DependencyInjection\MessengerExtension;

final class MessengerBundle extends Bundle
{
    public function getPath(): string
    {
        return __DIR__;
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container); 
        $container->registerExtension(new MessengerExtension());
    }
}
