@extends('layouts.master')

@section('page_title', 'Edit task')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{url('projects')}}">Projects</a></li>
      <li class="breadcrumb-item" aria-current="page"> <a href="{{route('project.tasks',$task->project_id)}}">Tasks</a></li>

      <li class="breadcrumb-item active" aria-current="page">Edit task</li>

    </ol>
  </nav>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
      <h4 class="card-title">Edit task</h4>
      
        <form class="forms-sample" action="{{url('update-task', [$task->project_id, $task->id] )}}" method="post" enctype="multipart/form-data">


        @csrf

        <div class="form-group">
          <label for="exampleInputName1">Title</label>
          <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputName1" placeholder="Title" name="title" value="{{ $task->title }}" >

            @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                </span>
            @enderror

        </div>


        <div class="form-group">
            <label for="exampleTextarea1">Description</label>
            <textarea class="form-control" id="description" rows="4" name="description">{{$task->description}}</textarea>
        </div>

        <div class="form-group">
          <label class="col-form-label">Priority</label>
         
            <div class="form-check">
              <label class="form-check-label">
                <input type="radio" class="form-check-input" name="priority" id="membershipRadios1" value="High" @if($task->priority == 'High') checked=""@endif> High <i class="input-helper">
                    </i></label>
            </div>
        
        
            <div class="form-check">
              <label class="form-check-label">
                <input type="radio" class="form-check-input" name="priority" id="membershipRadios2" value="Low" @if($task->priority == 'Low') checked=""@endif> Low <i class="input-helper"></i></label>
            </div>
         
        </div>


        <div class="form-group">
          <label for="status">Status</label>
          <select class="form-control" id="status" name="status">
            <option 
            @if ($task->status =='Inprogress')
                    selected='selected';    
            @endif 
            value="Inprogress">In progress</option>

            <option 
            @if ($task->status =='Todo')
                    selected='selected';    
            @endif 
            value="Todo">Todo</option>

            <option
            @if ($task->status =='Done')
            selected='selected';    
            @endif 
            value="Done">Done</option>
            
          </select>
        </div>
        
        <button type="submit" class="btn btn-gradient-primary me-2">Update</button>
        <a href="{{url('project/'.$task->project_id.'/tasks')}}" class="btn btn-light">Cancel</a>
      </form>
    </div>
  </div>

 
  
  @endsection



