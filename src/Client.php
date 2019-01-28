<?php

namespace ExpoClient;

class Client
{

    /**
     * @var string
     */
    private $apiUrl = 'https://exp.host/--/api/v2/push/send';

    /**
     * @param PushToken[]
     * @param Notification $notification
     *
     * @throws Exception
     *
     * @return PushToken[]
     */
    public function notify (array $pushTokens, Notification $notification)
    {
        $postData = [];

        foreach ($pushTokens as $pushToken) {
            $postData[] = $notification->toArray() + ['to' => $pushToken->getToken()];
        }

        $ch = curl_init();
        // Set cURL opts
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'accept: application/json',
            'content-type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

        $result = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($statusCode == 200 && $result && ($json = json_decode($result, true))) {

            /* @var PushToken $pushToken */
            foreach ($json['data'] as $i => $ticket) {
                $pushTokens[$i]->setResponse($ticket);
            }

            curl_close($ch);
            return $pushTokens;
        }

        $error = curl_error($ch);
        curl_close($ch);

        throw new Exception('API call failed: ' . $error);
    }
}