<?php

namespace Railroad\Railchat\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Railroad\Railchat\Requests\BanUserRequest;
use Railroad\Railchat\Requests\UnbanUserRequest;
use Railroad\Railchat\Services\RailchatService;
use Throwable;

class AccessController extends Controller
{
    /**
     * @var RailchatService
     */
    private $railchatService;

    /**
     * AccessController constructor.
     *
     * @param RailchatService $railchatService
     */
    public function __construct(
        RailchatService $railchatService
    ) {
        $this->railchatService = $railchatService;
    }

    /**
     * Ban user
     *
     * @param BanUserRequest $request
     *
     * @return JsonResponse
     *
     * @throws Throwable
     */
    public function banUser(BanUserRequest $request)
    {
        $this->railchatService->banUser($request->get('user_id'));
    }

    /**
     * Unban user
     *
     * @param UnbanUserRequest $request
     *
     * @return JsonResponse
     *
     * @throws Throwable
     */
    public function unbanUser(UnbanUserRequest $request)
    {
        $this->railchatService->unbanUser($request->get('user_id'));
    }
}
