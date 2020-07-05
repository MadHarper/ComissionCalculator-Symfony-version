<?php

namespace App\Validator\Constraints;

use App\Utils\BasicEnum;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Enum extends Constraint
{
    public const NOT_CORRECT = 'NOT_CORRECT';

    /**
     * @var BasicEnum
     */
    public $class;

    public $message = 'Значение не корректно';
}
