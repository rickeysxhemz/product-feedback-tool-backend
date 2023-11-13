<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\Response\GlobalApiResponse;
use App\Libs\Response\GlobalApiResponseCodeBook;
use App\Services\FeedbackService;
use App\Http\Requests\FeedbackRequests\CreateFeedbackRequest;

class FeedbackController extends Controller
{
    public function __construct(FeedbackService $FeedbackService, GlobalApiResponse $GlobalApiResponse)
    {
        $this->feedback_service = $FeedbackService;
        $this->global_api_response = $GlobalApiResponse;
    }
    
    public function create(CreateFeedbackRequest $request)
    {
        $create = $this->feedback_service->create($request);
        if (!$create)
            return ($this->global_api_response->error(GlobalApiResponseCodeBook::INTERNAL_SERVER_ERROR, "Feedback did not created!", $create));
       
        return ($this->global_api_response->success(1, "Feedback created successfully!", $create));
    }
    public function list()
    {
        $list = $this->feedback_service->list();
        if (!$list)
            return ($this->global_api_response->error(GlobalApiResponseCodeBook::INTERNAL_SERVER_ERROR, "Feedback did not listed!", $list));
       
        return ($this->global_api_response->success(1, "Feedback listed successfully!", $list));
    }
    public function view($id)
    {
        $view = $this->feedback_service->view($id);
        if (!$view)
            return ($this->global_api_response->error(GlobalApiResponseCodeBook::INTERNAL_SERVER_ERROR, "Feedback did not viewed!", $view));
       
        return ($this->global_api_response->success(1, "Feedback viewed successfully!", $view));
    }
    public function vote($id)
    {
        $vote = $this->feedback_service->vote($id);
        if (!$vote)
            return ($this->global_api_response->error(GlobalApiResponseCodeBook::RECORD_ALREADY_EXISTS, "you already vote on this feedback!",$vote));
        return ($this->global_api_response->success(1, "Feedback voted successfully!", $vote));
    }
    public function comment(Request $request)
    {
        $comment = $this->feedback_service->comment($request);
        if (!$comment)
            return ($this->global_api_response->error(GlobalApiResponseCodeBook::INTERNAL_SERVER_ERROR, "Feedback did not commented!", $comment));
        return ($this->global_api_response->success(1, "Feedback commented successfully!", $comment));
    }
    public function comments($id)
    {
        $comments = $this->feedback_service->comments($id);
        if (!$comments)
            return ($this->global_api_response->error(GlobalApiResponseCodeBook::INTERNAL_SERVER_ERROR, "Feedback did not commented!", $comments));
        return ($this->global_api_response->success(1, "Feedback commented successfully!", $comments));
    }
}
