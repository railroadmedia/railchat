<?php

namespace Railroad\Railchat\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class RailchatException extends Exception
{
    protected $message;
    protected $title;
    protected $code;

    /**
     * RailchatException constructor.
     *
     * @param string $message
     */
    public function __construct($message, $code = 500)
    {
        $this->message = $message;
        $this->title = 'Railchat Exception';
        $this->code = $code;
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
            $this->code
        );
    }
}
