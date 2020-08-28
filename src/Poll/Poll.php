<?php declare(strict_types=1);
/**
 * @author    Nikolay Mikhaylov sonny@milton.pro>
 * @copyright Copyright (c) 2020, Nikolay Mikhaylov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Milton\PollBundle\Poll;

/**
 * Poll
 */
class Poll
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $enabled;

    /**
     * @var array|\Milton\PollBundle\Poll\Field[]
     */
    private $fields;

    /**
     * Poll constructor.
     *
     * @param string $name
     * @param bool   $enabled
     * @param array  $fields
     */
    public function __construct(string $name, bool $enabled, array $fields)
    {
        $this->name    = $name;
        $this->enabled = $enabled;
        $this->fields  = array_map(static function (string $fieldName, array $fieldParams) {
            return new Field($fieldName, ...array_values($fieldParams));
        }, array_keys($fields), $fields);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param \Milton\PollBundle\Poll\Field $field
     */
    public function addField(Field $field): void
    {
        $this->fields[] = $field;
    }

    /**
     * @param string $fieldName
     */
    public function removeField(string $fieldName): void
    {
        foreach ($this->fields as $key => $field) {
            if ($fieldName === $field->getName()) {
                unset($this->fields[$key]);
            }
        }
    }
}
