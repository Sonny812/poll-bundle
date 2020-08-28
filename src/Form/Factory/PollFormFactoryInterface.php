<?php declare(strict_types=1);
/**
 * @author    Nikolay Mikhaylov sonny@milton.pro>
 * @copyright Copyright (c) 2020, Nikolay Mikhaylov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Milton\PollBundle\Form\Factory;

use Milton\PollBundle\Poll\Poll;
use Symfony\Component\Form\FormInterface;

/**
 * Poll form factory interface
 */
interface PollFormFactoryInterface
{
    /**
     * @param \Milton\PollBundle\Poll\Poll $poll
     * @param array                        $options
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createPollForm(Poll $poll, array $options = []): FormInterface;
}
