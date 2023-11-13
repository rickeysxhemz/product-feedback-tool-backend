<?php

namespace App\Services;

use App\Libs\Response\GlobalApiResponseCodeBook;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use App\Models\Feedback;
use App\Models\FeedbackVote;
use App\Models\Comment;
use Exception;
use App\Helper\Helper;


class FeedbackService extends BaseService
{
    public function create($request)
    {
        try{
            $feedback = new Feedback();
            $feedback->user_id = Auth::user()->id;
            $feedback->title = $request->title;
            $feedback->description = $request->description;
            $feedback->category = $request->category;
            $feedback->save();
            return $feedback;
        }catch(Exception $e){
            $error = "Error: Message: " . $e->getMessage() . " File: " . $e->getFile() . " Line #: " . $e->getLine();
            Helper::errorLogs("FeedbackService: create", $error);
            return false;
        }
    }
    public function list()
    {
        try{
            $feedback = Feedback::with('user')->paginate(10);
            return $feedback;
        }catch(Exception $e){
            $error = "Error: Message: " . $e->getMessage() . " File: " . $e->getFile() . " Line #: " . $e->getLine();
            Helper::errorLogs("FeedbackService: list", $error);
            return false;
        }
    }
    public function view($id)
    {
        try{
            $feedback = Feedback::with(['user', 'comments.user'])->where('id', $id)->first();
            return $feedback;
        }catch(Exception $e){
            $error = "Error: Message: " . $e->getMessage() . " File: " . $e->getFile() . " Line #: " . $e->getLine();
            Helper::errorLogs("FeedbackService: view", $error);
            return false;
        }
    }
    public function vote($id)
    {
        try{
            $vote_check =FeedbackVote::where('user_id', Auth::user()->id)->where('feedback_id', $id)->first();
            
            if($vote_check)
            {
                return false;
            }
            
            $feedback = Feedback::where('id', $id)->first();
            $feedback->vote_count = $feedback->vote_count + 1;
            $feedback->save();
            
            $feedback_vote = new FeedbackVote();
            $feedback_vote->user_id = Auth::user()->id;
            $feedback_vote->feedback_id = $id;
            $feedback_vote->save();
            
            return true;

        }catch(Exception $e){
            $error = "Error: Message: " . $e->getMessage() . " File: " . $e->getFile() . " Line #: " . $e->getLine();
            Helper::errorLogs("FeedbackService: vote", $error);
            return false;
        }
    }
    public function comment($request)
    {
        try{
            $comment = new Comment();
            $comment->user_id = Auth::user()->id;
            $comment->feedback_id = $request->feedback_id;
            $comment->comment = $request->comment;
            $comment->commented_at = Carbon::now();
            $comment->save();
            return $comment;
        }catch(Exception $e){
            $error = "Error: Message: " . $e->getMessage() . " File: " . $e->getFile() . " Line #: " . $e->getLine();
            Helper::errorLogs("FeedbackService: comment", $error);
            return false;
        }
    }
    public function comments($id)
    {
        try{
            $comments = Comment::with('user')->where('feedback_id', $id)->get();
            return $comments;
        }catch(Exception $e){
            $error = "Error: Message: " . $e->getMessage() . " File: " . $e->getFile() . " Line #: " . $e->getLine();
            Helper::errorLogs("FeedbackService: comments", $error);
            return false;
        }
    }
}