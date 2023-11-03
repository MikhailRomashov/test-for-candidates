<?php
namespace App;

use Symfony\Component\Validator\Validation as Validation;
use Symfony\Component\Validator\Constraints as Constraints;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MyValidator
{
    private $validator;
    public function __construct()
    {
        $this->validator = Validation::createValidator();
    }

    public function check($json)
    {
        /*DEXXXXXXXXX - для жителей Германии,

        ITXXXXXXXXXXX - для жителей Италии,

        GRXXXXXXXXX - для жителей Греции,

        FRYYXXXXXXXXX - для жителей Франции

        где:

        первые два символа - это код страны,
        X - любая цифра от 0 до 9,
        Y - любая буква
        */
        // вычленить код страны
        // получить данные о длине налогового номера
        // если такой страны нет вернуть ошибку

        $constraints = new Constraints\Collection( [
                'product' => [
                    new Constraints\NotBlank(),
                    new Constraints\Regex('(\d*)')
                ],
                'taxNumber' => [
                    new Constraints\NotBlank(),
                    new Constraints\Regex('^(?=.{13,})([A-Z]*\d{11})$')
                ],
                'couponCode' => [
                    new Constraints\Regex('([A-Z]\d{2})')
                ]  ]
        );

        $errors = $this->validator->validate( ['product' => 1,'taxNumber' =>"IT12345678900"], $constraints );

    }
}