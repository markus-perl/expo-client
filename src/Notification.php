<?php

namespace ExpoClient;

class Notification
{

    /**
     * @var string
     */
    private $body;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $image;

    /**
     * @return string
     */
    public function getBody (): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody (string $body): void
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getTitle (): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle (string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getImage (): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage (string $image): void
    {
        $this->image = $image;
    }

    public function toArray ()
    {
        $style = null;
        if ($this->getImage()) {
            $style = 'picture';
        }

        return [
            'body' => $this->getBody(),
            'title' => $this->getTitle(),
            'style' => $style,
            'image' => $this->getImage(),
            'picture' => $this->getImage(),
        ];
    }
}