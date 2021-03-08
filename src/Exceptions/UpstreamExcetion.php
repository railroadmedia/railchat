<?php

namespace Railroad\Railchat\Exceptions;

class UpstreamExcetion extends RailchatException
{
    protected $message;

    /**
     * UpstreamExcetion constructor.
     *
     * @param string $message
     */
    public function __construct($message)
    {
        $this->message = $message;
        $this->title = 'StreamChat Exception';
    }
}
