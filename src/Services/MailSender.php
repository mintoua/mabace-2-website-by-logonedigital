<?php
namespace App\Services;

use Mailjet\Client;
use Mailjet\Resources;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MailSender {

    public function __construct(private ParameterBagInterface $params)
    {
        
    }

    public function send($to_email, $to_name, $content, $subject){
        $mj = new Client($this->params->get('api_key'), $this->params->get('api_key_secret'),true,['version' => 'v3.1']);
        //dd($content);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "emmanuelbenjamin@logonedigital.com",
                        'Name' => "logonedigital"
                        ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => 4169301,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    
                    'Variables' => [
                        'content'=>$content
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
       
    }

}