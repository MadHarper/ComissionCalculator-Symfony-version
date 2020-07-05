<?php

namespace App\Validator\Constraints;

use App\Utils\BasicEnum;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class EnumValidator extends ConstraintValidator
{
    /**
     * @param mixed $value
     * @param Constraint|Enum $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        $enumClass = $constraint->class;

        if (null === $value) {
            return;
        }

        if (!class_exists($enumClass) && !method_exists($enumClass, 'isValidValue')) {
            throw new UnexpectedTypeException($constraint, BasicEnum::class);
        }

        if (!is_string($value)) {
            throw new UnexpectedTypeException($constraint, 'string');
        }

        if (!$enumClass::isValidValue($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $this->formatValue($value))
                ->setInvalidValue($value)
                ->setCode(Enum::NOT_CORRECT)
                ->addViolation();
        }
    }
}
