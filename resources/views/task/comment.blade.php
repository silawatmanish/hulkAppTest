
@extends('layouts.master')

@section('page_title', 'Leave Comment')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{url('projects')}}">Projects</a></li>
      <li class="breadcrumb-item" aria-current="page"> <a href="{{ route('project.tasks', $project_id)}}">Tasks</a></li>

      <li class="breadcrumb-item active" aria-current="page">Add Comment</li>

    </ol>
  </nav>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Add Comment </h4>
       
        <div class="form-group">
            <textarea class="form-control" id="comment" rows="4" name="comment" placeholder="Add a comment ..."></textarea>
        </div>

        <p style="display:none; color:red;" id="errComment">Please enter comment text.</p>


        <button type="button" class="btn btn-gradient-primary me-2" onclick="submitComment('<?php echo $user_id; ?>', '<?php echo $project_id; ?>', '<?php echo $id; ?>')">Comment</button>
        <a href="{{url('project/'.$project_id.'/tasks')}}" class="btn btn-light">Cancel</a>
    
    </div>
  </div>

  <div id="commentParentDiv">
 @foreach ($comments as $comm)
     
    @php
        $commentId = $comm->id;

        $resCommentReply = DB::select( DB::raw("SELECT * FROM `comment_reply` WHERE `comment_id` = $comm->id order by id Desc"));

        // echo "<pre>";
        // print_r($resCommentReply);

    @endphp


    <div class="card mt-3" id="commentCard{{$comm->id}}">
        <div class="card-body">
            <div style="float:right;">
                <small >Commented by <strong>{{$user->name}}</strong> </small>
                <small>On {{date("j F  Y, g:i a", strtotime($comm->created_at))}}</small>
                
                <div>
                    <a title="Delet Comment" href="javascript:void(0);" onclick="deleteComment({{$comm->id}});"><i class="mdi mdi-delete"></i> Delete</a>
                </div>

            </div>
            <p>{{$comm->comment}}</p>
    
            <a href="javascript:void(0);" onclick="showReplyBox({{$comm->id}});" class="mb-3" >Reply</a>
    
            <div id="replybox{{$comm->id}}" style="display: none;">
                <div class="form-group mt-3" >
                    <textarea class="form-control" id="text{{$comm->id}}" rows="4" name="text" placeholder="Add a reply note ..."></textarea>
                </div>

                <p style="display:none; color:red;" id="textErr">Please enter reply text.</p>
    
                <button type="button" class="btn btn-gradient-primary me-2" onclick="storeReply({{$comm->id}});" >Post Reply</button>
                <a href="javascript:void(0)" class="btn btn-light" onclick="hideReplyButton({{$comm->id}})">Cancel</a>            
            </div>

            <hr />

           <div id="replyParentDiv">
            @foreach ($resCommentReply as $reply)
                
                <div class="row" id="replyboxid{{$reply->id}}">
                    <div class="col-md-6">

                        <div  >
                            <small >Replied by <strong>{{$user->name}}</strong> </small>
                            <small>On {{date("j F  Y, g:i a", strtotime($comm->created_at))}}</small>
                            
                            <div>
                                <a title="Delete Reply" href="javascript:void(0);" onclick="deleteReply({{$reply->id}});"><i class="mdi mdi-delete"></i> Delete</a>
                            </div>
        
                        </div>

                    </div>
                    
                    <div class="col-md-6">

                        <div>
                            <p style="float:right; margin-left:30px;">{{$reply->text}}</p>
                            
                        </div>                        
                    </div>
                </div>
        
            @endforeach

        </div>

        </div>
      </div>   
      
      @endforeach
      
  </div>

  <script>
 
      function submitComment(userId, projectId, taskId){

        var comment = $("#comment").val();

        if(comment == "") {
            $("#errComment").show();
        } else {
            $("#errComment").hide();
            
            var url = '{{route("store-comment")}}';
            var _token = "{{ csrf_token() }}";

            $.ajax({
                url:url,
                type:"POST",
                data:{
                    userId:userId,
                    projectId:projectId,
                    taskId:taskId,
                    comment:comment,
                    _token:_token
                },
                enctype: 'multipart/form-data',
                success:function(result) {
                    
                    showCommentList(taskId, projectId);
                }
            });            
        }
      }

      function showCommentList(taskId, projectId) {
          
        var url = '{{route("get-last-comment")}}';
            var _token = "{{ csrf_token() }}";

            $.ajax({
                url:url,
                type:"GET",
                data:{
                    taskId:taskId,
                    projectId:projectId,
                    _token:_token
                },
                success:function(result) {
                    //console.log(result);
                    $("#comment").val('');
                    $('#commentParentDiv').prepend(result);
                }
            });              
                
      }

    function showReplyBox(commentId) {
        $("#replybox"+commentId).show();
    }
    function hideReplyButton(commentId){
        $("#replybox"+commentId).hide();
    }

    function deleteComment(commentId) {
  
        var url = '{{route("delete-comment")}}';
            var _token = "{{ csrf_token() }}";

        $.ajax({
            url:url,
            type:"GET",
            data:{
                commentId:commentId,
                _token:_token
            },
            success:function(result) {
                //console.log(result);
                //$("#comment").val('');
                if(result == 'comment_deleted') {
                    $("#commentCard"+commentId).hide();
                    alert('Comment deleted successfully.');
                }
            }
        });              
            
    }


    function storeReply(commentId) {

        var text = $("#text"+commentId).val();
        if(text == '') {
            $("#textErr").show();

        } else {
            $("#textErr").hide();

            var url = '{{route("store-reply")}}';
            var _token = "{{ csrf_token() }}";

            $.ajax({
                url:url,
                type:"POST",
                data:{
                    text:text,
                    commentId:commentId,
                    _token:_token
                },
                success:function(result) {
                    console.log(result);
                    $("#text"+commentId).val('');
                    showLatestReplyList(commentId);
                }
            });             
        }
    }



    function showLatestReplyList(commentId) {
          
          var url = '{{route("get-last-reply")}}';
              var _token = "{{ csrf_token() }}";
  
              $.ajax({
                  url:url,
                  type:"GET",
                  data:{
                    commentId:commentId,
                      _token:_token
                  },
                  success:function(result) {
                      //console.log(result);
                      //$("#comment").val('');
                      $('#replyParentDiv').prepend(result);
                  }
              });              
                  
        }    


    function deleteReply(replyId) {
  
        var url = '{{route("delete-reply")}}';
            var _token = "{{ csrf_token() }}";

        $.ajax({
            url:url,
            type:"GET",
            data:{
                replyId:replyId,
                _token:_token
            },
            success:function(result) {
                //console.log(result);
                //$("#comment").val('');
                if(result == 'reply_deleted') {
                    $("#replyboxid"+replyId).hide();
                    alert('Reply deleted successfully.');
                }
            }
        });              
            
    }        

  </script>


  @endsection