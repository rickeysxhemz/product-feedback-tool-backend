<?php

namespace App\Http\Controllers;

use App\Services\AdminService;
use Illuminate\Http\Request;
use App\Libs\Response\GlobalApiResponse;
use App\Libs\Response\GlobalApiResponseCodeBook;

class AdminController extends Controller
{
    public function __construct(AdminService $AdminService, GlobalApiResponse $GlobalApiResponse)
    {
        $this->admin_service = $AdminService;
        $this->global_api_response = $GlobalApiResponse;
    }
    
    public function userList()
    {
        $list = $this->admin_service->userList();
        if (!$list)
            return ($this->global_api_response->error(GlobalApiResponseCodeBook::INTERNAL_SERVER_ERROR, "users did not listed!", $list));
       
        return ($this->global_api_response->success(1, "users listed successfully!", $list));
    }

    public function deleteUser($id)
    {
        $delete = $this->admin_service->deleteUser($id);
        if (!$delete)
            return ($this->global_api_response->error(GlobalApiResponseCodeBook::INTERNAL_SERVER_ERROR, "user did not deleted!", $delete));
       
        return ($this->global_api_response->success(1, "user deleted successfully!", $delete));
    }

    public function feedbackList()
    {
        $list = $this->admin_service->feedbackList();
        if (!$list)
            return ($this->global_api_response->error(GlobalApiResponseCodeBook::INTERNAL_SERVER_ERROR, "feedbacks did not listed!", $list));
       
        return ($this->global_api_response->success(1, "feedbacks listed successfully!", $list));
    }

    public function feedbackDelete($id)
    {
        $delete = $this->admin_service->feedbackDelete($id);
        if (!$delete)
            return ($this->global_api_response->error(GlobalApiResponseCodeBook::INTERNAL_SERVER_ERROR, "feedback did not deleted!", $delete));
       
        return ($this->global_api_response->success(1, "feedback deleted successfully!", $delete));
    }
    public function CommentStatus($id)
    {
        $status = $this->admin_service->CommentStatus($id);
        if (!$status)
            return ($this->global_api_response->error(GlobalApiResponseCodeBook::INTERNAL_SERVER_ERROR, "Comment status did not updated!", $status));
       
        return ($this->global_api_response->success(1, "Comment status updated successfully!", $status));
    }
}
