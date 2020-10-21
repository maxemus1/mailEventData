<?php

namespace App\Services\DispatchService;

interface DispatchInterface
{
    public function sending(string $domain, array $request);
}