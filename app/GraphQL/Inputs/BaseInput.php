<?php

namespace App\GraphQL\Inputs;

use App\GraphQL\Traits\Inputs\BaseInputTrait;
use Rebing\GraphQL\Support\InputType;

abstract class BaseInput extends InputType
{
    use BaseInputTrait;
}
