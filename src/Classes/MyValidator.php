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

    public function check(array $request, array $param)
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
                new Constraints\Regex('(\d{'.strlen($request["product"]).'})')
            ],
            'taxNumber' => [
                new Constraints\Regex('/^[A-Z]{'.$param["taxNumberLength"]-$param["digitsLength"].'}\d{'.$param["digitsLength"].'}$/')
            ]];

        // добавление проверки необязательных полей (купон)
        if($request["couponCode"])
            $checkList['couponCode'] = [   new Constraints\Regex('/^[A-Z]\d{2}$/')];

        if($request["paymentProcessor"])
            $checkList['paymentProcessor'] = [   new Constraints\Regex('([A-z]*)')];

        $constraints = new Constraints\Collection($checkList );

        $errors = $this->validator->validate( $request, $constraints );

        if (count($errors) > 0) return array("error" =>(string) $errors);


    }
}