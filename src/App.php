<?php

namespace Mdojr\EmailProvider;

use DI\Bridge\Slim\App as DIBridgeApp;
use DI\ContainerBuilder;

class App extends DIBridgeApp
{
    /**
     * PHP-DI container definition
     *
     * @var array
     */
    private $containerDefinition;

    public function __construct(array $containerDefinition)
    {
        $this->containerDefinition = $containerDefinition;
        parent::__construct();
    }

    /**
     * {@inheritDoc}
     */
    protected function configureContainer(ContainerBuilder $builder)
    {
        $builder->addDefinitions($this->containerDefinition);
    }
}
