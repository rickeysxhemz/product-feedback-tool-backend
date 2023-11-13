<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\Response\GlobalApiResponse;
use App\Libs\Response\GlobalApiResponseCodeBook;
use App\Services\UserService;

class UserController extends Controller
{
        public function __construct(UserService $UserService, GlobalApiResponse $GlobalApiResponse)
        {
            $this->user_service = $UserService;
            $this->global_api_response = $GlobalApiResponse;
        }
        
        public function mention()
        {
            $mention = $this->user_service->mention();
            if (!$mention)
                return ($this->global_api_response->error(GlobalApiResponseCodeBook::INTERNAL_SERVER_ERROR, "Mention did not listed!", $mention));
            return ($this->global_api_response->success(1, "Mention listed successfully!", $mention));
        }    
}
