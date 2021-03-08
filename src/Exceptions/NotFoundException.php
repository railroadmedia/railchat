<?php

namespace Railroad\Railchat\Exceptions;

class NotFoundException extends RailchatException
{
    /**
     * NotFoundException constructor.
     *
     * @param string $message
     */
    public function __construct($message)
    {
        $this->message = $message;
        $this->title = 'Not found.';
    }
}
