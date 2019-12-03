<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use League\Tactician\CommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\Mapping\CommandToHandlerMapping;
use League\Tactician\Handler\Mapping\MapByNamingConvention;
use Psr\Container\ContainerInterface;

class TacticianProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CommandBus::class, function (ContainerInterface $container) {
            return new CommandBus(
                new CommandHandlerMiddleware(
                    $container,
                    new class () implements CommandToHandlerMapping
                    {
                        public function getClassName(string $commandClassName): string
                        {
                            return preg_replace('#Commands\\\\#', 'Handlers\\', $commandClassName) . 'Handler';
                        }

                        public function getMethodName(string $commandClassName): string
                        {
                            return '__invoke';
                        }
                    }
                )
            );
        });
    }
}
