<?php declare(strict_types=1);
/**
 * @author    Nikolay Mikhaylov <sonny@milton.pro>
 * @copyright Copyright (c) 2020, Nikolay Mikhaylov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Milton\PollBundle\Controller;

use Milton\PollBundle\Form\Factory\PollFormFactoryInterface;
use Milton\PollBundle\Poll\Provider\PollProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment;

/**
 * Show controller
 */
class ShowController
{
    /**
     * @var \Milton\PollBundle\Poll\Provider\PollProviderInterface
     */
    private $pollProvider;

    /**
     * @var \Milton\PollBundle\Form\Factory\PollFormFactoryInterface
     */
    private $pollFormFactory;

    /**
     * @var \Twig\Environment
     */
    private $twig;

    /**
     * ShowController constructor.
     *
     * @param \Milton\PollBundle\Poll\Provider\PollProviderInterface   $pollProvider
     * @param \Milton\PollBundle\Form\Factory\PollFormFactoryInterface $pollFormFactory
     * @param \Twig\Environment                                        $templating
     */
    public function __construct(PollProviderInterface $pollProvider, PollFormFactoryInterface $pollFormFactory, Environment $templating)
    {
        $this->pollProvider    = $pollProvider;
        $this->pollFormFactory = $pollFormFactory;
        $this->twig            = $templating;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param string                                    $name
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, string $name): Response
    {
        if (!$this->pollProvider->hasPoll($name)) {
            throw new NotFoundHttpException(sprintf('Poll with name %s does not exist.', $name));
        }

        $poll = $this->pollProvider->getPoll($name);

        $form = $this
            ->pollFormFactory
            ->createPollForm($poll);

        return new Response(
            $this->twig->render('@MiltonPoll/poll/show.html.twig', [
                'form' => $form->createView(),
            ])
        );
    }
}
