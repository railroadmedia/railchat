<?php

namespace Railroad\Railchat\Controllers;

use Exception;
use GetStream\StreamChat\StreamException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Railroad\Permissions\Services\PermissionService;
use Railroad\Railchat\Exceptions\NotFoundException;
use Railroad\Railchat\Exceptions\RailchatException;
use Railroad\Railchat\Exceptions\UpstreamException;
use Railroad\Railchat\Requests\BanUserRequest;
use Railroad\Railchat\Requests\UnbanUserRequest;
use Railroad\Railchat\Services\RailchatService;
use Throwable;

class AccessController extends Controller
{
    /**
     * @var PermissionService
     */
    private $permissionService;

    /**
     * @var RailchatService
     */
    private $railchatService;

    /**
     * AccessController constructor.
     *
     * @param PermissionService $permissionService
     * @param RailchatService $railchatService
     */
    public function __construct(
        PermissionService $permissionService,
        RailchatService $railchatService
    ) {
        $this->permissionService = $permissionService;
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
        $this->permissionService->canOrThrow(auth()->id(), 'chat.ban_user');

        try {
            $this->railchatService->banUser($request->get('user_id'));
        } catch (StreamException $e) {
            if ($e->getCode() == 404) {
                throw new NotFoundException('StreamChat could not find specified user');
            } else {
                throw new UpstreamException('StreamChat exception occured while trying to ban user');
            }
            error_log($e);
        } catch (Exception $e) {
            throw new RailchatException('Exception occured while trying to ban user');
            error_log($e);
        }

        return response()->json();
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
        $this->permissionService->canOrThrow(auth()->id(), 'chat.unban_user');

        try {
            $this->railchatService->unbanUser($request->get('user_id'));
        } catch (StreamException $e) {
            if ($e->getCode() == 404) {
                throw new NotFoundException('StreamChat could not find specified user');
            } else {
                throw new UpstreamException('StreamChat exception occured while trying to unban user');
            }
            error_log($e);
        } catch (Exception $e) {
            throw new RailchatException('Exception occured while trying to unban user');
            error_log($e);
        }

        return response()->json();
    }
}
