<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Libs\Response\GlobalApiResponse;
use App\Libs\Response\GlobalApiResponseCodeBook;
use App\Http\Requests\AuthRequests\RegisterRequest;
use App\Http\Requests\AuthRequests\LoginRequest;

class AuthController extends Controller
{
    public function __construct(AuthService $AuthService, GlobalApiResponse $GlobalApiResponse)
    {
        $this->auth_service = $AuthService;
        $this->global_api_response = $GlobalApiResponse;
    }
    public function adminRegister(RegisterRequest $request)
    {
            $register = $this->auth_service->adminRegister($request);
            if (!$register)
                return ($this->global_api_response->error(GlobalApiResponseCodeBook::INTERNAL_SERVER_ERROR, "admin did not registered!", $register));
            if ($register['outcomeCode'] === GlobalApiResponseCodeBook::RECORD_ALREADY_EXISTS['outcomeCode'])
                return ($this->global_api_response->error(GlobalApiResponseCodeBook::RECORD_ALREADY_EXISTS, "Record Already Exist!", $register['record']));
        
            return ($this->global_api_response->success(1, "admin registered successfully!", $register));
    }

    public function userRegister(RegisterRequest $request)
    {
            $register = $this->auth_service->userRegister($request);
            if (!$register)
                return ($this->global_api_response->error(GlobalApiResponseCodeBook::INTERNAL_SERVER_ERROR, "User did not registered!", $register));
            if ($register['outcomeCode'] === GlobalApiResponseCodeBook::RECORD_ALREADY_EXISTS['outcomeCode'])
                return ($this->global_api_response->error(GlobalApiResponseCodeBook::RECORD_ALREADY_EXISTS, "Record Already Exist!", $register['record']));
        
            return ($this->global_api_response->success(1, "User registered successfully!", $register));
    }
    
    public function login(LoginRequest $request)
    {
        $login = $this->auth_service->login($request);
        
        if (!$login)
            return ($this->global_api_response->error(GlobalApiResponseCodeBook::INTERNAL_SERVER_ERROR, "Login not successful!", $login['record']));

        if ($login['outcomeCode'] == GlobalApiResponseCodeBook::INVALID_CREDENTIALS['outcomeCode'])
            return ($this->global_api_response->error(GlobalApiResponseCodeBook::INVALID_CREDENTIALS, "Your email or password is invalid!", 'Your email or password is invalid!'));
        
        return ($this->global_api_response->success(1, "Login successfully!", $login['record']));
    }
    public function logout()
    {
        $logout = $this->auth_service->logout();

        if ($logout === GlobalApiResponseCodeBook::NOT_AUTHORIZED['outcomeCode'])
            return ($this->global_api_response->error(GlobalApiResponseCodeBook::NOT_AUTHORIZED, "User is not authorized to logout!", $logout));

        if (!$logout)
            return (new GlobalApiResponse())->error(GlobalApiResponseCodeBook::INTERNAL_SERVER_ERROR, "Logout not successful!", $logout);

        return (new GlobalApiResponse())->success(1, "User logout successfully!", $logout);
    }
}
