<?php


use Symfony\Component\Validator\Validation as Validation;
use Symfony\Component\Validator\Constraints as Constraints;

class MyValidator
{
    private $validator;
    public function __construct()
    {
        $this->validator = Validation::createValidator();
    }

    public function check(array $param)
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

        // формирование проверочного массива
        $checkList =[
            'product' => [
                new Constraints\Regex('(\d{'.strlen($param["product"]).'})')
            ],
            'taxNumber' => [
                new Constraints\Length(min:$param["taxNumberLength"],max: $param["taxNumberLength"]),
                new Constraints\Regex('([A-Z]*\d{'.$param["digitsLength"].'})')
            ]];

        // добавление проверки необязательных полей (купон)
        if($param["couponCode"])
            $checkList['couponCode'] = [   new Constraints\Regex('([A-Z]\d{2})')];

        $constraints = new Constraints\Collection($checkList );

        $errors = $this->validator->validate( $param, $constraints );

        if (count($errors) > 0) return (string) $errors;


    }
}