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
        $response = $this->client->get("contacts/find_by_custom_field", [
            'field_id' => 'phone',
            'value'    => $phone,
        ]);

        if($response->successful()){
            $result = $response->json();
            if(!empty($result['data'])){
                return $result['data'][0];
            }
        }

        throw new \Exception("Contact not found");
    }

    public function create(array $data)
    {
        $response = $this->client->post("contacts", $data);
        if($response->successful()){
            $result = $response->json();
            if($result['success'] && !empty($result['data'])){
                return $result['data'];
            }
        }

        throw new \Exception("Failed to create contact");
    }

    public function sendContent($id, $data){
        $response = $this->client->post("contacts/{$id}/send_content", $data);

        if($response->successful()){
            return $response->json();
        }

        throw new \Exception("Failed to send content to contact");
    }

    public function sendText($id, string $text, string $channel = 'omnichannel'){
        return $this->sendContent($id, ['text' => $text, 'channel' => $channel]);
    }

}
