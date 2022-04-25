@extends('layouts.master')

@section('page_title', 'Projects')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Projects</li>
      
    </ol>
  </nav>
@endsection

@section('content')

<div class="row">
    <div class="col-12 grid-margin">
      
      @if($message = Session::get('success'))
        <div class="alert alert-success">
          {{ $message }}
        </div>
      @endif
      
      <div class="card">
        <div>
          <div class="p-3" style="float:right;">
            <a href="{{route('projects.create')}}" class="btn btn-gradient-dark btn-fw ">Create new project</a>
          </div>
        </div>
        <div class="card-body">    

          {{-- <h4 class="card-title">Projects</h4> --}}
          
          {{-- <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                 
                  <div class="" style="float:right;">
                  <a href="{{route('projects.create')}}" class="btn btn-gradient-dark btn-fw ">Crete new project</a>
                </div>

                </div>
              </div>
             
            </div>
          </div> --}}

          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th> Title </th>
                  <th> Status </th>
                  <th> Created at </th>
                  <th> Action </th>
                </tr>
              </thead>
              <tbody>

                @foreach ($projects as $project)
                    <tr>
                        <td>{{$project->title}}</td>
                        <td>
                           @php
                               $badgeClass = '';
                          

                            if ($project->status == 'Done')
                                $badgeClass = 'badge-gradient-success';
                            elseif ($project->status == 'Progress')
                            $badgeClass = 'badge-gradient-primary';
                            elseif ($project->status == 'On Hold')
                            $badgeClass = 'badge-gradient-info';

                            else 
                            $badgeClass = 'badge-gradient-danger';
                            //endif
                            @endphp
                            <label class="badge {{$badgeClass}} ">{{$project->status}}</label>
                        </td>
                        <td>{{ date('d-m-Y', strtotime($project->created_at)) }}</td>

                        <td>
                            <a href="{{route('projects.edit', $project->id)}}" class="btn btn-outline-primary btn-sm">Edit</a>
                           
                            <a  onclick="return confirm('Are you sure want to delete ?')" href="{{route('deleteProject', $project->id)}}" class="btn btn-outline-danger btn-sm">Delete</a>

                            <a href="{{ route('project.tasks', $project->id) }}" class="btn btn-outline-info btn-sm">Project Tasks</a>
                        </td>

                    </tr>
            
                    
                @endforeach

                
                
              </tbody>
            </table>

           {!! $projects->links() !!} 

          </div>
        </div>
      </div>
    </div>
  </div>

@stop