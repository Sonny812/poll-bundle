<?php declare(strict_types=1);
/**
 * @author    Nikolay Mikhaylov sonny@milton.pro>
 * @copyright Copyright (c) 2020, Nikolay Mikhaylov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Milton\PollBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('milton_poll');

        $root = $treeBuilder->getRootNode();

        $root
            ->children()
                ->arrayNode('polls')->useAttributeAsKey('name')
                    ->arrayPrototype()->canBeDisabled()
                    ->children()
                        ->arrayNode('fields')->useAttributeAsKey('field_name')
                        ->arrayPrototype()
                        ->children()
                            ->scalarNode('type')->defaultValue('string')->end()
                            ->arrayNode('options')->variablePrototype()->end()
                        ->end()
                    ->end()
                ->end();


        return $treeBuilder;
    }
}
