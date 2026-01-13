<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class NoBadWordsValidator extends ConstraintValidator
{
    // Liste de mots interdits (ajoute les tiens)
   private array $badWords = [
    'merde',
    'putain',
    'pute',
    'connard',
    'connasse',
    'con',
    'conne',
    'enculé',
    'encule',
    'enculer',
    'salaud',
    'salope',
    'bordel',
    'batard',
    'bâtard',
    'chiant',
    'chiante',
    'chiotte',
    'chiottes',
    'bite',
    'couille',
    'couilles',
    'cul',
    'couillon',
    'branleur',
    'branleuse',
    'crétin',
    'debile',
    'débile',
    'abruti',
    'abrutie',
    'taré',
    'tarée',
    'fdp',
    'ntm',
    'nique',
    'niquer',
    'ta gueule',
    'tg',
    'va te faire foutre',
    'trou du cul',
    'fils de pute',
    'pute de merde',
    'sale con',
    'sale pute',
];

    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof NoBadWords) {
            throw new UnexpectedTypeException($constraint, NoBadWords::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        // Convert into smallcase
        $lowerValue = mb_strtolower($value);
        
        // check every bad word
        foreach ($this->badWords as $badWord) {
            if (preg_match('/\b' . preg_quote($badWord, '/') . '\b/iu', $lowerValue))
                // checking if no break, utf-8 support accents, special chars...
             {
                $this->context->buildViolation($constraint->message)
                    ->addViolation();
                return;
            }
        }
    }
}
