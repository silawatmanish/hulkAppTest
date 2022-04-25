<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Auth;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $userId = $user->id;
        $data['projects'] = Project::where('user_id', $userId)->paginate(10);
        return view('project.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('project.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:projects',
        ]);

        // get auth user id.
        $user = Auth::user();
        $userId = $user->id;
        //$project_file = $request->file('project_file');

        Project::create([
            'user_id' => $userId,
            'title' => $request->title,
            //'project_file' => $project_file,
            'status' => $request->status,
            'description' => $request->description
        ]);

        return redirect('/projects')->with('success', 'Project added successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $data['project'] = $project;
        return view('project.edit', $data);
    }



    public function deleteProject(Request $request, $id) {
        $project = Project::find($id);
        $project->delete();
        return back()->with('success', 'Project deleted successfully');
        
    }


    public function updateProject(Request $request, $id) {

        $request->validate([
            'title' => 'required|'.\Illuminate\Validation\Rule::unique('projects')->ignore($id),
        ]);

        // get auth user info..
        $user = Auth::user();

        Project::where('id', $id)->update([
            'user_id' => $user->id,
            'title' => $request->title,
            'status' => $request->status,
            'description' => $request->description
        ]);

        return redirect('/projects')->with('success', 'Project updated successfully.');

    }





}
