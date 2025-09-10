<?php

namespace App\Http\Controllers;

use App\Exceptions\UserLoginException;
use App\Http\DataTransferObjects\UserDTO;
use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordAlias;
use Mockery\Exception;
use phpDocumentor\Reflection\Types\Boolean;
use Ramsey\Uuid\Uuid;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use function PHPUnit\Framework\isEmpty;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function createAdminUser(Request $request) : JsonResponse{
        $validated = $request->validate([
            "email" => "required |email",
            "password" => [
                'required',
                'string',
            ]
        ]);
        $userDTO = $this->userService->createRegularUser($validated["email"], $validated["password"]);
        return response()->json([
            "data" => $userDTO
        ]);
    }
    public function createRegularUser(Request $request) : JsonResponse
    {
        $validated = $request->validate([
            "email" => "required |email",
            "password" => [
                'required',
                'string',
            ]
        ]);
        $userDTO = $this->userService->createRegularUser($validated["email"], $validated["password"]);
        return response()->json([
            "data" => $userDTO
        ]);
     }
//
    /**
     * @throws UserLoginException
     */
    public function userLogin(Request $request) : JsonResponse {
        $credentials = $request->validate([
            "email" => "required |email",
            "password" => [
                'required',
                'string',
            ]
        ]);
        $token = $this->userService->userLogin($credentials["email"], $credentials["password"]);
        return response()->json([
            "token_type" => "bearer",
            "access_token" => $token,
            "expires_in" => JWTAuth::factory()->getTTL() . " Minutes"
        ]);
    }
//    /**
//     */
    public function getUserByEmail($email) : JsonResponse{
        $userDTO = $this->userService->getUserByEmail($email);
        return response()->json([
            "data" => $userDTO
        ]);
    }
    public function getUserById() : JsonResponse{
        $user_id = auth()->user()->user_id;
        $userDTO = $this->userService->getUserById($user_id);
        return response()->json([
            "data" => $userDTO
        ]);
    }
    public function deleteUserById() : JsonResponse{
        $user_id = auth()->user()->user_id;
        $operation_success_status = $this->userService->deleteUserById($user_id);
        return response()->json([
            "success_status" => $operation_success_status
        ]);
    }
    public function deleteUserByEmail($email) : JsonResponse{
        $operation_success_status = $this->userService->deleteUserByEmail($email);
        return response()->json([
            "success_status" => $operation_success_status
        ]);
    }
//
//    /**
//     * @throws JWTException
//     */
    public function updateUserPassword(Request $request) : JsonResponse{
        $user_id = auth()->user()->user_id;
        $new_password = $request->input("new_password");
        $operation_success_status = $this->userService->updateUserPassword($user_id, $new_password);
        return response()->json([
            "success_status" => $operation_success_status
        ]);
    }
    public function promoteRegularUserToAdmin(string $email) : JsonResponse{
        $operation_success_status = $this->userService->promoteRegularUserToAdmin($email);
        return response()->json([
            "success_status" => $operation_success_status
        ]);
    }
    /**
     * @throws UserLoginException
     */
    public function checkOldPasswordMatches(Request $request){
        $email = auth()->user()->email;
        return $this->userService->checkOldPasswordMatches($email, $request->input("old_password"));
    }
}
