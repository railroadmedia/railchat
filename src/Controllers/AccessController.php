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
use Railroad\Railchat\Requests\DeleteUserMessagesRequest;
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
            error_log($e);
            if ($e->getCode() == 404) {
                throw new NotFoundException('StreamChat could not find specified user');
            } else {
                throw new UpstreamException('StreamChat exception occured while trying to ban user');
            }
        } catch (Exception $e) {
            error_log($e);
            throw new RailchatException('Exception occured while trying to ban user');
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
            error_log($e);
            if ($e->getCode() == 404) {
                throw new NotFoundException('StreamChat could not find specified user');
            } else {
                throw new UpstreamException('StreamChat exception occured while trying to unban user');
            }
        } catch (Exception $e) {
            error_log($e);
            throw new RailchatException('Exception occured while trying to unban user');
        }

        return response()->json();
    }

    /**
     * Remove all user messages from chat
     *
     * @param DeleteUserMessagesRequest $request
     *
     * @return JsonResponse
     *
     * @throws Throwable
     */
    public function deleteUserMessages(DeleteUserMessagesRequest $request)
    {
        $this->permissionService->canOrThrow(auth()->id(), 'chat.delete_user_messages');

        try {
            $this->railchatService->deleteUserMessages($request->get('user_id'));
        } catch (StreamException $e) {
            error_log($e);
            if ($e->getCode() == 404) {
                throw new NotFoundException('StreamChat could not find specified user');
            } else {
                throw new UpstreamException('StreamChat exception occured while trying to remove user messages');
            }
        } catch (Exception $e) {
            error_log($e);
            throw new RailchatException('Exception occured while trying to remove user messages');
        }

        return response()->json();
    }
}
