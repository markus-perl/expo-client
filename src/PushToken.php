<?php

namespace ExpoClient;

class PushToken
{

    const STATUS_NOT_SENT = 'NotSent';

    const STATUS_OK = 'ok';

    const STATUS_ERROR = 'error';

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $error;

    /**
     * ExpoPushToken constructor.
     * @param string $token
     */
    public function __construct (string $token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getToken ()
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getStatus ()
    {
        return $this->status;
    }

    /**
     * @return string|null
     */
    public function getMessage ()
    {
        return $this->message;
    }

    /**
     * @return string|null
     */
    public function getError ()
    {
        return $this->error;
    }

    public function setResponse (array $ticket)
    {
        if (isset($ticket['status'])) {
            $this->status = $ticket['status'];
        } else {
            throw new Exception('Cannot parse response. Status missing: ' . print_r($ticket, true));
        }

        if (isset($ticket['message'])) {
            $this->message = $ticket['message'];
        }

        if (isset($ticket['details'], $ticket['details']['error'])) {
            $this->error = $ticket['details']['error'];
        }
    }

    public function __toString ()
    {
        $data = [
            'Token' => $this->getToken(),
            'Status' => $this->getStatus(),
            'Message' => $this->getMessage(),
            'Error' => $this->getError(),
        ];

        $dataCleanedUp = [];
        foreach ($data as $key => $value) {
            if ($value) {
                $dataCleanedUp[] = $key . ': ' . $value;
            }
        }

        return implode(', ', $dataCleanedUp);
    }
}