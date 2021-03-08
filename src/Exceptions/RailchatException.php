<?php

namespace Railroad\Railchat\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class RailchatException extends Exception
{
    protected $message;
    protected $title;

    /**
     * RailchatException constructor.
     *
     * @param string $message
     */
    public function __construct($message)
    {
        $this->message = $message;
        $this->title = 'Railchat Exception';
    }

    /**
     * @return JsonResponse
     */
    public function render()
    {
        return response()->json(
            [
                'errors' => [
                    [
                        'title' => $this->title,
                        'detail' => $this->message,
                    ]
                ],
            ],
            404
        );
    }
}
