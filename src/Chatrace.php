<?php

namespace Kevinwbh\Chatrace;

use Kevinwbh\Chatrace\Endpoints\Contacts;
use Kevinwbh\Chatrace\Http\Client;

class Chatrace
{

    protected Client $client;

    public function __construct(string $apiKey)
    {
        $this->client = new Client($apiKey);
    }

    public function contacts(){
        return new Contacts($this->client);
    }
}