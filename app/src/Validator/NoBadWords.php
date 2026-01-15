<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class NoBadWords extends Constraint
{
    public string $message = 'Le message contient un langage inapproprié, merci de changer de vocabulaire';

}