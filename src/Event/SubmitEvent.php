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
use Symfony\Component\HttpFoundation\Request;

/**
 * Submit event
 */
class SubmitEvent extends PollEvent
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * @var array
     */
    private $pollData;

    /**
     * SubmitEvent constructor.
     *
     * @param \Milton\PollBundle\Poll\Poll              $poll
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param array                                     $pollData
     */
    public function __construct(Poll $poll, Request $request, array $pollData)
    {
        parent::__construct($poll);

        $this->request  = $request;
        $this->pollData = $pollData;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return array
     */
    public function getPollData(): array
    {
        return $this->pollData;
    }
}
