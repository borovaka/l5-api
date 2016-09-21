<?php namespace App\ApiService;

interface AuthValidation
{
    /**
     * Determines if the incoming request has valid credentials
     *
     * @return bool
     */
    public function check();


    /**
     * Get the ID for the currently authenticated entity
     *
     * @return int|null
     */
    public function id();
}