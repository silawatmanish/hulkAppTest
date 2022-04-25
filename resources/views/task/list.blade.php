@extends('layouts.master')

@section('page_title', 'Tasks')


@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{url('projects')}}">Projects</a></li>
      <li class="breadcrumb-item active" aria-current="page">Project tasks</li>

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
          <div class=""><div class="p-3 " style="float:right;">
            <a href="{{route('projects.add-tast', $project_id)}}" class="btn btn-gradient-dark btn-fw ">Create new task</a>
          </div></div>
        <div class="card-body">    

          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th> Title </th>
                  <th> Priority </th>
                  <th>Deadline Date</th>
                 
                  <th> Status </th>
                  <th> Created at </th>
                  <th> Action </th>
                </tr>
              </thead>
              <tbody>
                @forelse ($tasks as $task)

                <tr>
                    <td>{{$task->title}}</td>

                    <td>
                        @php
                            $priorityClass = '';

                            if($task->priority == 'High') {
                                $priorityClass = 'badge-gradient-danger';
                            } else {
                                $priorityClass = 'badge-gradient-primary';
                            }

                        @endphp 

                        <label class="badge {{$priorityClass}} ">{{$task->priority}}</label>

                        
                        
                    </td>
                    <td>{{ date('m-d-Y', strtotime($task->deadline)) }}</td>


                    <td>
                       @php
                           $badgeClass = '';
                      

                        if ($task->status == 'Done')
                            $badgeClass = 'badge-gradient-success';
                        elseif ($task->status == 'Inprogress')
                        $badgeClass = 'badge-gradient-primary';
                        
                        else 
                        $badgeClass = 'badge-gradient-danger';
                        //endif
                        @endphp
                        <label class="badge {{$badgeClass}} ">{{$task->status}}</label>
                    </td>
                    <td>{{ date('d-m-Y', strtotime($task->created_at)) }}</td>

                    <td>
                        <a href="{{route('project.edit-task',[$project_id, $task->id])}}" class="btn btn-outline-primary btn-sm">Edit</a>
                       
                        <a  onclick="return confirm('Are you sure want to delete ?')" href="{{route('deleteTask', $task->id)}}" class="btn btn-outline-danger btn-sm">Delete</a>

                        <a href="{{route('project.task.leave-comments',[$project_id, $task->id])}}" class="btn btn-outline-info btn-sm">Leave Comment</a>
                    </td>

                </tr>                
                    
                @empty
                    <tr>
                        <td colspan="7">No record found.</td>
                    </tr>
                @endforelse

                         
                    


                
                
              </tbody>
            </table>
           
            {{ $tasks->links() }} 
          

          </div>
        </div>
      </div>
    </div>
  </div>

@stop