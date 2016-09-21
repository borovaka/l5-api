<?php namespace App\ApiService\Validators;

class AlgorithmOne implements ValidatorInterface {
    /**
     * Returns the user ID
     * @return integer
     */
    public function decode($token) {
        return 1;
    }
}