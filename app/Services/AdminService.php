<?php

namespace App\Services;

use App\Libs\Response\GlobalApiResponseCodeBook;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Feedback;
use Exception;
use App\Helper\Helper;

class AdminService extends BaseService
{
    public function userList()
    {
        try{
            $users = User::role('user')->paginate(10);
            return $users;
        }catch(Exception $e){
            $error = "Error: Message: " . $e->getMessage() . " File: " . $e->getFile() . " Line #: " . $e->getLine();
            Helper::errorLogs("AdminService: list", $error);
            return false;
        }
    }
    
    public function deleteUser($id)
    {
        try{
            $user = User::find($id);
            $user->delete();
            return $user;
        }catch(Exception $e){
            $error = "Error: Message: " . $e->getMessage() . " File: " . $e->getFile() . " Line #: " . $e->getLine();
            Helper::errorLogs("AdminService: delete", $error);
            return false;
        }
    }

    public function feedbackList()
    {
        try{
            $feedbacks = Feedback::with('user')->paginate(10);
            return $feedbacks;
        }catch(Exception $e){
            $error = "Error: Message: " . $e->getMessage() . " File: " . $e->getFile() . " Line #: " . $e->getLine();
            Helper::errorLogs("AdminService: list", $error);
            return false;
        }
    }
    public function feedbackDelete($id)
    {
        try{
            $feedback = Feedback::find($id);
            $feedback->delete();
            return $feedback;
        }catch(Exception $e){
            $error = "Error: Message: " . $e->getMessage() . " File: " . $e->getFile() . " Line #: " . $e->getLine();
            Helper::errorLogs("AdminService: delete", $error);
            return false;
        }
    }
    public function CommentStatus($id)
    {
        try{
            $status = Feedback::find($id);
            $status->comment_status = ($status->comment_status === 'enable') ? 'disable' : 'enable';
            $status->save();
            return $status;
        }catch(Exception $e){
            $error = "Error: Message: " . $e->getMessage() . " File: " . $e->getFile() . " Line #: " . $e->getLine();
            Helper::errorLogs("AdminService: CommentStatus", $error);
            return false;
        }
    }
}