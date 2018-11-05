<?php

namespace CleverAge\EAVManager\AkeneoEnterpriseBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Fabien Salles <fsalles@clever-age.com>
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('clever_age_eav_manager_akeneo_enterprise');

        $rootNode
            ->children()
                ->arrayNode('product_owners')
                    ->scalarPrototype()
                        ->info('list of roles that can be owner of products. By default, all roles are owners')
                        ->example(['ROLE_USER', 'ROLE_ADMIN'])
                    ->end()
                ->end()
                ->scalarNode('public_uri')->defaultValue('%eav_manager.akeneo_product.api.base_uri%')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
