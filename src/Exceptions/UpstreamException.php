<?php

namespace Railroad\Railchat\Exceptions;

class UpstreamException extends RailchatException
{
    protected $message;

    /**
     * UpstreamExcetion constructor.
     *
     * @param string $message
     */
    public function __construct($message, $code = 503)
    {
        $this->message = $message;
        $this->title = 'StreamChat Exception';
        $this->code = $code;
    }
}
