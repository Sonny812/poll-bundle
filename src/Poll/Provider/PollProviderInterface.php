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
 * Poll provider interface
 */
interface PollProviderInterface
{
    /**
     * @return array|\Milton\PollBundle\Poll\Poll[]
     */
    function getAllPolls(): iterable;

    /**
     * @param string $name
     *
     * @return \Milton\PollBundle\Poll\Poll
     */
    function getPoll(string $name): Poll;

    /**
     * @param string $name
     *
     * @return bool
     */
    function hasPoll(string $name): bool;
}
