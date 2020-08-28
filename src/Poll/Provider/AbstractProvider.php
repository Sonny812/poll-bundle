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
 * Abstract poll provider
 */
abstract class AbstractProvider implements PollProviderInterface
{
    /**
     * @inheritDoc
     */
    abstract public function getAllPolls(): iterable;

    /**
     * @inheritDoc
     */
    public function getPoll(string $name): Poll
    {
        foreach ($this->getAllPolls() as $poll) {
            if ($name === $poll->getName()) {
                return $poll;
            }
        }

        throw new \InvalidArgumentException(sprintf('Poll with name %s does not exist.', $name));
    }

    /**
     * @inheritDoc
     */
    public function hasPoll(string $name): bool
    {
        foreach ($this->getAllPolls() as $poll) {
            if ($name === $poll->getName()) {
                return true;
            }
        }

        return false;
    }
}
