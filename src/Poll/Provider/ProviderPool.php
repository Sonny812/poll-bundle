<?php declare(strict_types=1);
/**
 * @author    Nikolay Mikhaylov sonny@milton.pro>
 * @copyright Copyright (c) 2020, Nikolay Mikhaylov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Milton\PollBundle\Poll\Provider;

/**
 * Poll provider pool
 */
class ProviderPool extends AbstractProvider
{
    /**
     * @var array|\Milton\PollBundle\Poll\Provider\PollProviderInterface[]
     */
    private $providers;

    /**
     * @var null|array|\Milton\PollBundle\Poll\Poll[]
     */
    private $polls;

    /**
     * @inheritDoc
     */
    public function getAllPolls(): iterable
    {
        if (null !== $this->polls) {
            return $this->polls;
        }

        $this->polls = [];

        foreach ($this->providers as $provider) {
            foreach ($provider->getAllPolls() as $poll) {
                $this->polls [] = $poll;
            }
        }

        return $this->polls;
    }

    /**
     * @param \Milton\PollBundle\Poll\Provider\PollProviderInterface $pollProvider
     */
    public function addProvider(PollProviderInterface $pollProvider): void
    {
        $this->providers [] = $pollProvider;
    }
}
