<?php

namespace TremulantTech\LaravelEbayApi;

class Configuration
{
    private array $config;

    public function __construct(array $config = []) {
        $this->config = $config;
    }
}