<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Task extends Model
{
    use RecordsActivity, HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $touches = ['project'];

    protected $casts = [
        'completed' => 'boolean',
    ];

    protected static $recordableEvents = ['created', 'deleted'];

    public function project()
    {
    	return $this->belongsTo(Project::class);
    }

    public function path()
    {
    	return '/tasks/' . $this->id;
    }

    public function complete()
    {
        $this->update(['completed' => true]);

        $this->recordActivity('completed_task');
    }

    public function incomplete()
    {
        $this->update(['completed' => false]);
        
        $this->recordActivity('incompleted_task');
    }
}
