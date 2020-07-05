<?php

namespace App\Utils\Enum;

use App\Utils\BasicEnum;

class OperationTypeEnum extends BasicEnum
{
    public const CASH_IN_OPERATION_TYPE = 'cash_in';
    public const CASH_OUT_OPERATION_TYPE = 'cash_out';
}