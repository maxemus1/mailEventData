<?php

namespace App\Services\ProcessingEmail\CheckEmailServices;

interface CheckEmailInterface
{
    public function check(string $email);
}