<?php declare(strict_types=1);

namespace App\Infrastructure\Common\DependencyInjection;

use App\Infrastructure\Common\Service\CommandBus;
use App\Infrastructure\Common\Service\QueryBus;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Maps:
 *   tactician.commandbus.query   -> App\Infrastructure\Common\Service\QueryBus
 *   tactician.commandbus.command -> App\Infrastructure\Common\Service\CommandBus
 *
 * In effect we can use purely a simple autowiring dependency injection.
 */
class BusPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $originalQueryBus = $container->getDefinition('tactician.commandbus.query');
        $destinationQueryBus = $container->getDefinition(QueryBus::class);
        $destinationQueryBus->setArguments($originalQueryBus->getArguments());

        $originalCommandBus = $container->getDefinition('tactician.commandbus.command');
        $destinationCommandBus = $container->getDefinition(CommandBus::class);
        $destinationCommandBus->setArguments($originalCommandBus->getArguments());
    }
}
