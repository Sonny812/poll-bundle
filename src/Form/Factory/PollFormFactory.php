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
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Poll form factory
 */
class PollFormFactory implements PollFormFactoryInterface
{
    /**
     * @var \Symfony\Component\Form\FormFactoryInterface
     */
    private $genericFormFactory;

    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;

    /**
     * PollFormFactory constructor.
     *
     * @param \Symfony\Component\Form\FormFactoryInterface $genericFormFactory
     * @param \Symfony\Component\Routing\RouterInterface   $router
     */
    public function __construct(FormFactoryInterface $genericFormFactory, RouterInterface $router)
    {
        $this->genericFormFactory = $genericFormFactory;
        $this->router             = $router;
    }

    /**
     * @inheritDoc
     */
    public function createPollForm(Poll $poll, array $options = []): FormInterface
    {
        $defaultOptions = [
            'method' => 'POST',
            'action' => $this->router->generate('milton_poll_submit', ['name' => $poll->getName()]),
        ];

        $builder = $this->genericFormFactory->createNamedBuilder(
            sprintf('milton_%s_poll', $poll->getName()),
            FormType::class,
            null,
            array_merge($defaultOptions, $options)
        );

        foreach ($poll->getFields() as $field) {
            $builder->add($field->getName(), $field->getType(), $field->getOptions());
        }

        return $builder->getForm();
    }
}
