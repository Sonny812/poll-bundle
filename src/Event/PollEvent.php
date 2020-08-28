<?php declare(strict_types=1);
/**
 * @author    Nikolay Mikhaylov sonny@milton.pro>
 * @copyright Copyright (c) 2020, Nikolay Mikhaylov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Milton\PollBundle\Event;

use Milton\PollBundle\Poll\Poll;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Poll event
 */
class PollEvent extends Event
{
    /**
     * @var \Milton\PollBundle\Poll\Poll
     */
    private $poll;

    /**
     * PollEvent constructor.
     *
     * @param \Milton\PollBundle\Poll\Poll $poll
     */
    public function __construct(Poll $poll)
    {
        $this->poll = $poll;
    }

    /**
     * @return \Milton\PollBundle\Poll\Poll
     */
    public function getPoll(): Poll
    {
        return $this->poll;
    }
}
