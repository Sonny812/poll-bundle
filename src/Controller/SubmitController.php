<?php declare(strict_types=1);
/**
 * @author    Nikolay Mikhaylov sonny@milton.pro>
 * @copyright Copyright (c) 2020, Nikolay Mikhaylov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Milton\PollBundle\Controller;

use Milton\PollBundle\Event\PollEvents;
use Milton\PollBundle\Event\SubmitEvent;
use Milton\PollBundle\Form\Factory\PollFormFactoryInterface;
use Milton\PollBundle\Poll\Provider\PollProviderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment;

/**
 * Submit controller
 */
class SubmitController
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
     * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var \Twig\Environment
     */
    private $twig;

    /**
     * SubmitController constructor.
     *
     * @param \Milton\PollBundle\Poll\Provider\PollProviderInterface      $pollProvider
     * @param \Milton\PollBundle\Form\Factory\PollFormFactoryInterface    $pollFormFactory
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher
     * @param \Twig\Environment                                           $twig
     */
    public function __construct(
        PollProviderInterface $pollProvider,
        PollFormFactoryInterface $pollFormFactory,
        EventDispatcherInterface $eventDispatcher,
        Environment $twig
    ) {
        $this->pollProvider    = $pollProvider;
        $this->pollFormFactory = $pollFormFactory;
        $this->eventDispatcher = $eventDispatcher;
        $this->twig            = $twig;
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

        if (!$poll->isEnabled()) {
            throw new AccessDeniedHttpException(sprintf('Poll with name %s is not enabled.', $name));
        }

        $form = $this
            ->pollFormFactory
            ->createPollForm($poll)
            ->handleRequest($request);

        if (!$form->isSubmitted()) {
            throw new BadRequestHttpException();
        }

        if (!$form->isValid()) {
            return $this->createJsonResponse(false, ['errors' => $form->getErrors()]);
        }

        $event = new SubmitEvent($poll, $request, $form->getData());
        $this->eventDispatcher->dispatch($event, PollEvents::SUBMITTED);

        if ($request->isXmlHttpRequest()) {
            $response = $this->createJsonResponse(true);
        } else {
            $response = new Response($this->twig->render('@MiltonPoll/poll/submit/success.html.twig'));
        }

        return $response;
    }

    /**
     * @param bool  $success
     * @param array $data
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    private function createJsonResponse(bool $success, array $data = []): JsonResponse
    {
        return new JsonResponse([
            'success' => $success,
            'data'    => $data,
        ]);
    }
}
