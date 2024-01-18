<?php

namespace App\Models;

use Illuminate\Support\Arr;


trait RecordsActivity
{

    public $oldAttributes = [];


    public static function bootRecordsActivity()
    {
        static ::updating(function ($model) {
            $model->oldAttributes = $model->getOriginal();

        });

        foreach(static::recordableEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($model->activityDescription($event));
            });
        }

    }

    public function activity()
    {
        return $this->morphMany(Activity::class,'subject')->latest();
    }

    public function recordActivity($description)
    {
        $this->activity()->create([
            'description' => $description,
            'changes' => $this->getActivityChanges(),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id,

        ]);
    }

    protected static function recordableEvents()
    {
        if(isset(static::$recordableEvents)) {
            return static::$recordableEvents;
        }

        return ['created', 'updated' ];
    }


    protected function activityDescription($description)
    {

        return "{$description}_" . strtolower(class_basename($this));
    }

    protected function getActivityChanges()
    {
        if($this->wasChanged()) {
            return [
                'before' => Arr::except(array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'),
                'after' => Arr::except($this->getChanges(), 'updated_at'),
            ];
        }
    }


}