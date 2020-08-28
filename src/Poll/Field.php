<?php declare(strict_types=1);
/**
 * @author    Nikolay Mikhaylov sonny@milton.pro>
 * @copyright Copyright (c) 2020, Nikolay Mikhaylov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Milton\PollBundle\Poll;

use Symfony\Component\Form\Exception\InvalidArgumentException;

/**
 * Field
 */
class Field
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var array
     */
    private $options;

    /**
     * Field constructor.
     *
     * @param string $name
     * @param string $type
     * @param array  $options
     */
    public function __construct(string $name, string $type, array $options = [])
    {
        $this->name    = $name;
        $this->type    = $this->normalizeTypeName($type);
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param string $type
     *
     * @return string
     */
    private function normalizeTypeName(string $type): string
    {
        if (class_exists($type)) {
            return $type;
        }

        $class = sprintf('Symfony\Component\Form\Extension\Core\Type\%sType', ucfirst($type));

        if (!class_exists($class)) {
            throw new InvalidArgumentException(sprintf('Could not load type "%s": class does not exist.', $class));
        }

        return $class;
    }
}
