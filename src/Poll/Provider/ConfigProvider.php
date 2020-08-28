<?php declare(strict_types=1);
/**
 * @author    Nikolay Mikhaylov sonny@milton.pro>
 * @copyright Copyright (c) 2020, Nikolay Mikhaylov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Milton\PollBundle\Poll\Provider;

use Milton\PollBundle\Poll\Poll;

/**
 * Poll config provider
 */
class ConfigProvider extends AbstractProvider
{
    /**
     * @var null|array|Poll[]
     */
    private $polls;

    /**
     * @var array
     */
    private $config;

    /**
     * ConfigProvider constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->polls  = null;
    }

    /**
     * @inheritDoc
     */
    function getAllPolls(): iterable
    {
        if (null !== $this->polls) {
            return $this->polls;
        }

        $polls = [];

        foreach ($this->config as $name => $configEntry) {
            $poll     = new Poll($name, ...array_values($configEntry));
            $polls [] = $poll;

            yield $poll;
        }

        $this->polls = $polls;
    }
}
