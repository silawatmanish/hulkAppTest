@extends('layouts.master')

@section('page_title', 'Add task')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{url('projects')}}">Projects</a></li>
      <li class="breadcrumb-item" aria-current="page"> <a href="{{ route('project.tasks', $project_id)}}">Tasks</a></li>

      <li class="breadcrumb-item active" aria-current="page">Add task</li>

    </ol>
  </nav>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
      <h4 class="card-title">Create task</h4>
      
      <form class="forms-sample" action="{{route('projects.store-task', $project_id)}}" method="post" enctype="multipart/form-data">

        @csrf

        <div class="form-group">
          <label for="exampleInputName1">Title</label>
          <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputName1" placeholder="Title" name="title" value="{{ old('title') }}">

            @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                </span>
            @enderror

        </div>


        <div class="form-group">
            <label for="exampleTextarea1">Description</label>
            <textarea class="form-control" id="description" rows="4" name="description"></textarea>
        </div>

        <div class="form-group">
          <label class="col-form-label">Priority</label>
         
            <div class="form-check">
              <label class="form-check-label">
                <input type="radio" class="form-check-input" name="priority" id="membershipRadios1" value="High" checked=""> High <i class="input-helper"></i></label>
            </div>
        
        
            <div class="form-check">
              <label class="form-check-label">
                <input type="radio" class="form-check-input" name="priority" id="membershipRadios2" value="Low"> Low <i class="input-helper"></i></label>
            </div>
         
        </div>


        {{-- <div class="form-group">
          <label for="exampleInputName1">Deadline date</label>
          <input type="text" class="form-control @error('deadline') is-invalid @enderror"  placeholder="Enter deadline date" name="deadline" value="{{ old('deadline') }}">

            @error('deadline')
                <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                </span>
            @enderror

        </div> --}}


        <div class="form-group">
          <label for="status">Status</label>
          <select class="form-control" id="status" name="status">
            <option value="Inprogress">In progress</option>
            <option value="Todo">Todo</option>
            <option value="Done">Done</option>
            
          </select>
        </div>
        
        <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
        <a href="{{url('projects')}}" class="btn btn-light">Cancel</a>
      </form>
    </div>
  </div>

 
  
  @endsection



