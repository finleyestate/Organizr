<?php

namespace Examples\Transmissions;

require dirname(__FILE__).'/../bootstrap.php';

use SparkPost\SparkPost;
use GuzzleHttp\Client;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;

$httpClient = new GuzzleAdapter(new Client());

$sparky = new SparkPost($httpClient, ["key" => "YOUR_API_KEY"]);

$promise = $sparky->transmissions->post([
    'content' => [
        'from' => [
            'name' => 'SparkPost Team',
            'email' => 'from@sparkpostbox.com',
        ],
        'subject' => 'Mailing With Recipient List From PHP',
        'html' => '<html><body><h1>Congratulations, {{name}}!</h1><p>You just sent an email to everyone on your recipient list!</p></body></html>',
        'text' => 'Congratulations, {{name}}! You just sent an email to everyone on your recipient list!',
    ],
    'substitution_data' => ['name' => 'YOUR_FIRST_NAME'],
    'recipients' => ['list_id' => 'RECIPIENT_LIST_ID'],
]);

try {
    $response = $promise->wait();
    echo $response->getStatusCode()."\n";
    print_r($response->getBody())."\n";
} catch (\Exception $e) {
    echo $e->getCode()."\n";
    echo $e->getMessage()."\n";
}
