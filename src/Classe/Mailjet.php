<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class Mailjet
{
    private $api_key = '93a4eb1db914245466db86830e2642db';
    private $api_key_secret = '71b4f01e095cbe420ff6c0949d2cf4a9';

    public function send($to_email, $to_name, $subject, $content)
    {

        $mj = new Client($this->api_key, $this->api_key_secret,true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "cedric.hourcade1@gmail.com",
                        'Name' => "La boutique Delta Ecommerce"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => 3446737,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'content' => $content
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }
}