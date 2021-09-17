<?php

namespace Vx\JsUploadBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('vx_js_upload');

        
        // upload, external_pages, worker, contact, customer, logo, lead;

        $treeBuilder
            ->getRootNode()
            ->children()
                ->arrayNode('profile')
                ->arrayPrototype()
                    ->children()
                        ->scalarNode('unique_filename')->end()
                        ->scalarNode('upload_dir')->end()
                    ->end()
                    ->children()
                        ->arrayNode('image_versions')
                            ->arrayPrototype()
                                ->children()
                                    ->integerNode('max_height')->end()
                                    ->integerNode('max_width')->end()
                                    ->booleanNode('crop')->end()
                                ->end()
                            ->end()
        ;

        return $treeBuilder;
    }
}
