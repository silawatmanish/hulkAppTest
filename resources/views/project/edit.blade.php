@extends('layouts.master')

@section('page_title', 'Edit project')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{url('projects')}}">Projects</a></li>
      <li class="breadcrumb-item active" aria-current="page">Edit project</li>

    </ol>
  </nav>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
      <h4 class="card-title">Update project</h4>
      {{-- <p class="card-description"> Basic form elements </p> --}}
      <form class="forms-sample" action="{{url('update-project', $project->id )}}" method="post" enctype="multipart/form-data">

        @csrf

        <div class="form-group">
          <label for="exampleInputName1">Title</label>
          <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputName1" placeholder="Title" name="title" value="{{ $project->title  }}">

            @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                </span>
            @enderror

        </div>

       
        {{-- <div class="form-group">
          <label for="exampleInputName1">Project file</label>
          <input type="file" class="form-control" id="exampleInputName1" placeholder="Title" name="project_file">
        </div> --}}
  

        <div class="form-group">
            <label for="exampleTextarea1">Description</label>
            <textarea class="form-control" id="description" rows="4" name="description">{{ $project->description }}</textarea>
        </div>

        <div class="form-group">
          <label for="exampleSelectGender">Status</label>
          <select class="form-control" id="" name="status">
            
            <option 
                @if ($project->status =='Progress')
                    selected='selected';    
                @endif 
            value="Progress">Progress</option>
            
            <option 
                @if ($project->status =='On Hold')
                    selected='selected';    
                @endif
            value="On Hold">On Hold</option>

            <option 
                @if ($project->status =='Done')
                    selected='selected';    
                @endif
            value="Done">Done</option>
            <option 
                @if ($project->status =='Rejected')
                    selected='selected';    
                @endif
            value="Rejected">Rejected</option>
          </select>
     
        </div>
        
        <button type="submit" class="btn btn-gradient-primary me-2">Update</button>
        <a href="{{url('projects')}}" class="btn btn-light">Cancel</a>
      </form>
    </div>
  </div>

  @endsection