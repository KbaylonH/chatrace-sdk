<?php

namespace Kevinwbh\Chatrace\Endpoints;

use Kevinwbh\Chatrace\Http\Client;

class Contacts
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getById(string $id)
    {
        return $this->client->get("contacts/{$id}");
    }

    public function getByPhone(string $phone)
    {
        return $this->client->get("contacts/find_by_custom_field", [
            'field_id' => 'phone',
            'value'    => $phone,
        ]);
    }

    public function create(array $data)
    {
        return $this->client->post("contacts", $data);
    }

    public function sendContent($id, $data){
        return $this->client->post("contacts/{$id}/send_content", $data);
    }

    public function sendText($id, string $text, string $channel = 'omnichannel'){
        return $this->sendContent($id, ['text' => $text, 'channel' => $channel]);
    }

}
