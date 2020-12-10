<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name', 'concluded', 'user_id'
    ];

    public $with = ['user'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function task()
    {
        return $this->hasMany('App\Task');
    }

    public static function get_projects () {
        return DB::table('projects')->select('id','name','created_at','concluded')->get();
    }
}
