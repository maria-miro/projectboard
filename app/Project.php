<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Project extends Model
{
    use RecordsActivity, HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function path()
    {
    	return "/projects/{$this->id}";
    }

    public function owner()
    {
    	return $this->belongsTo(User::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class,'project_members');
    }


    public function tasks()
    {
    	return $this->hasMany(Task::class)->latest('updated_at');
    }

    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
    }

    public function addTask($body)
    {
    	return $this->tasks()->create(compact('body'));
    }

    public function invite(User $user)
    {
        $this->members()->attach($user);
    }


}
