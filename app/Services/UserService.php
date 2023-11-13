<?php

namespace App\Services;

use App\Libs\Response\GlobalApiResponseCodeBook;
use App\Helper\Helper;
use App\Models\User;
use Exception;


class UserService extends BaseService
{
    public function mention()
    {
        try{
            $users = User::get(['id', 'name']);
            return $users;
        }catch(Exception $e){
            $error = "Error: Message: " . $e->getMessage() . " File: " . $e->getFile() . " Line #: " . $e->getLine();
            Helper::errorLogs("UserService: mention", $error);
            return false;
        }
    }
}