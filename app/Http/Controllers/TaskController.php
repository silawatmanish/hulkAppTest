<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Comment;
use App\User;
use App\CommentReply;
use Auth;


class TaskController extends Controller
{

    public function index($project_id) {

        // get all tasks of project id.. 
        $data['tasks'] = Task::where('project_id', $project_id)->paginate(10);
        $data['project_id'] =  $project_id;
        
       return view('task.list', $data);

    }
    
    public function addTask(Request $request, $project_id) {

        $data['project_id'] = $project_id;
        return view('task.add', $data);
    }


    public function storeTask(Request $request, $project_id) {
      
        $request->validate([
            'title' => 'required',
            'priority' => 'required',
           
        ]);

        $todayDate = date('Y-m-d');
        // add 15 days from task create date.. 
        $deadLineDate = date('Y-m-d', strtotime($todayDate. ' + 15 days'));
        //die;

        $task = new Task;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->priority = $request->priority;
        $task->deadline = $deadLineDate;
        $task->status = $request->status;
        $task->project_id = $project_id;

        $task->save();

        return redirect()->route('project.tasks', $project_id)->with('success', 'Task added successfully.');


    }

    public function deleteTask(Request $request, $id) {
        $project = Task::find($id);
        $project->delete();
        return back()->with('success', 'Task deleted successfully');
        
    }

    public function edit($project_id, $id)
    {
        $data['task'] = Task::where('id',$id)->first();
        return view('task.edit', $data);
    }


    public function updateTask(Request $request, $project_id, $id) {
       
       

        $request->validate([
            'title' => 'required',
            'priority' => 'required',
        ]);        

        $task = Task::find($id);
        $task->title = $request->title;
        $task->description = $request->description;
        $task->priority = $request->priority;
        $task->status = $request->status;

        $task->save();

       return redirect()->route('project.tasks', $task->project_id)->with('success', 'Tast updated.');

    }


    public function comment($project_id, $id) {
        $user = Auth::user();
        $data['user_id'] = $user->id;
        $data['project_id'] = $project_id;
        $data['id'] = $id;

        // get all comments.. 
        $data['comments'] = Comment::where(['project_id' => $project_id, 'task_id' => $id])->orderBy('id', 'DESC')->get();


        $data['user']  = User::find($user->id);
       
        return view('task.comment', $data);
    }



    public function check() {
        return view('task.datepicker');
    }

    public function storeComment(Request $request) {

        $comment = new Comment;
        $comment->user_id = $request->userId;
        $comment->project_id = $request->projectId;
        $comment->task_id = $request->taskId;
        $comment->comment = $request->comment;

        $comment->save();

        return json_encode([
             $request->taskId,
            $request->projectId,
        ]);

    }


    public function getLastComment(Request $request) {

       $comments = Comment::where(['project_id' => $request->projectId, 'task_id' => $request->taskId])->latest()->first();

       $user = Auth::user();

        return '<div id="commentCard'.$comments->id.'" class="card mt-3">
        <div class="card-body">

            <div style="float:right;">
                <small >Commented by <strong>'.$user->name.'</strong> </small>
                <small>On '.date("j F  Y, g:i a", strtotime($comments->created_at)).'</small>

                <div>
                    <a title="Delet Comment" href="javascript:void(0);" onclick="deleteComment('.$comments->id.');"><i class="mdi mdi-delete"></i> Delete</a>
                </div>

            </div>

            <p>'.$comments->comment.'</p>
    
            <a href="javascript:void(0);" onclick="showReplyBox('.$comments->id.')" class="mb-3" >Reply</a>
    
            <div id="replybox'.$comments->id.'" style="display: none;">
                <div class="form-group mt-3" >
                    <textarea class="form-control" id="text'.$comments->id.'"  rows="4" name="text" placeholder="Add a reply note ..."></textarea>
                </div>
    
                <button type="button" onclick="storeReply('.$comments->id.');" class="btn btn-gradient-primary me-2" >Post Reply</button>
                <a href="javascript:void(0)" class="btn btn-light" onclick="hideReplyButton('.$comments->id.')">Cancel</a> 
                
            </div>
    
        </div>
      </div>';  

    }


    public function deleteComment(Request $request) {
       
        $commentId = $request->commentId;

        $comment = Comment::find($commentId);
        $comment->delete();

        echo "comment_deleted";

    }


    public function deleteReply(Request $request) {
       
        $replyId = $request->replyId;

        $commentReply = CommentReply::find($replyId);
        $commentReply->delete();

        echo "reply_deleted";

    }

    

    public function storeReply(Request $request) {

        $user = Auth::user();
        $userId = $user->id;
        CommentReply::create([
            'comment_id' => $request->commentId,
            'text' => $request->text,
            'user_id' => $userId,
        ]);
       
        return "Comment reply saved";
    }


    public function getLastReply(Request $request) {

        $commentReply = CommentReply::where(['comment_id' => $request->commentId])->latest()->first();
 
        $user = Auth::user();
 
         return '<div class="row">
         <div class="col-md-6">

             <div>
                 <small >Replied by <strong>'.$user->name.'</strong> </small>
                 <small>On '.date("j F  Y, g:i a", strtotime($commentReply->created_at)).'</small>
                 
                 <div>
                     <a title="Delete Reply"  href="javascript:void(0);" onclick="deleteReply('.$commentReply->id.');"><i class="mdi mdi-delete"></i> Delete</a>
                 </div>

             </div>

         </div>
         
         <div class="col-md-6">

             <div>
                 <p style="float:right; margin-left:30px;">'.$commentReply->text.'</p>
                 
             </div>                        
         </div>
     </div>';  
 
     }


}
