<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Task extends Model
{
    protected $fillable = [
        'description', 'concluded', 'project_id'
    ];
    
    public $with = ['project'];
    public function Project()
    {
        return $this->belongsTo('App\Project');
    }
    
    public static function tasksByUserAndProject($project) {
        return DB::table('tasks')
        ->join('projects', 'projects.id', 'project_id')
        ->where('projects.user_id', Auth::id())
        ->where('tasks.project_id', $project)
        ->select('tasks.*')
        ->get();
    }
}