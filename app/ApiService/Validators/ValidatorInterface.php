<?php namespace App\ApiService\Validators;
interface ValidatorInterface {
    public function decode($token);
}