<?php

namespace App\Http\Controllers;

use App\Task;
use App\Project;
use Illuminate\Http\Request;
use Auth;

class TaskController extends Controller
{
      /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list($project)
    {
        $project = Project::find($project);
        $tasks = Task::tasksByUserAndProject($project->id);
        
        return view('tasks/index', compact('tasks', 'project'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->input();
        $data['concluded'] = false;
        
        $validation = \Validator::make($data, [
            'description' => 'required',
            'project_id' => 'required',
        ]);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $res = Task::create($data);

            if ($res) {
                $request->session()->flash('success', 'Tarefa adicionada');
            } else {
                $request->session()->flash('error', 'Sua tarefa não pode ser salvo :(');
            }
            return redirect()->back();
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return $task;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        return $task;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $data = $request->all();

        if (!isset($request->concluded)) { $data['concluded'] = 0; }

        $validation = \Validator::make($data, [
            'description' => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }
        
        $res = Task::find($task->id)->update($data);
        if ($res) {
            $request->session()->flash('success', 'Tarefa atualizada!');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $res = Task::find($id)->delete();
        if ($res) {
            $request->session()->flash('success', 'Tarefa deletada!');
        } else {
            $request->session()->flash('error', 'Erro ao apagar tarefa!');
        }
        return redirect()->back();
    }
}
