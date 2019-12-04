@extends('layouts.app')

@section('content')

    <header class="flex items-center mb-6 pb-4">
        <div class="flex justify-between items-end  w-full">
            <p class="text-muted font-light">
                <a href="/projects" class="no-underline text-muted font-normal">My projects</a>
                / {{ $project->title}}
            </p>
            <div class="flex items-center">
                @foreach($project->members as $member)
                    <img src="{{ gravatar_url($member->email) }}" alt="{{ $member->name }}" class="rounded-full w-8 mr-2">

                @endforeach

                <img src="{{ gravatar_url($project->owner->email) }}" alt="{{  $project->owner->name }}" class="rounded-full w-8 mr-2">
                <a href="{{ $project->path() . '/edit' }}" class="button ml-4">Edit project</a>
            </div>


        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">              
                <div class="mb-8">
                    <h2 class="text-lg text-muted font-light mb-3">Tasks</h2>                   
                    @foreach($project->tasks as $task)
                        <div class="bg-card card mb-3 text-default">
                            <form method="POST" action="{{ $task->path() }}">
                                @csrf
                                @method('PATCH')
                                <div class="flex">
                                    <input value="{{ $task->body }}" name="body" class="text-default bg-card w-full 
                                        {{$task->completed ? 'line-through text-muted' : ''}}">
                                    <input type="checkbox" name="completed" onChange="this.form.submit()"
                                        {{ $task->completed ? 'checked' : '' }}> 
                                </div>
                                   
                            </form>                   
                        </div>                     
                    @endforeach
                        <div class="card">
                            <form method="POST" action="{{ $project->path() . '/tasks' }}">
                                @csrf
                                <input placeholder="Add a new task" name="body" class="text-default bg-card w-full">
                            </form>
                        </div>                        
                </div>
                <div>
                    <h2 class="text-lg text-muted font-light mb-3">General notes</h2>             
                    <form method="POST" action="{{ $project->path() }}">
                        @csrf
                        @method('PATCH')
                        <textarea
                            name="notes" 
                            class="card  text-default w-full mb-4" 
                            style="min-height: 200px"
                            >{{ $project->notes }}</textarea>
                        <button type="Submit" class="button">Save</button>
                    </form>

                    @include('errors')

                </div>              
            </div>
            <div class="lg:w-1/4 px-3 mt-8">
                @include('projects.card')

                @include('projects.activity.card')

                @can('invite', $project)
                    @include('projects.invite')
                @endcan

            </div>           
        </div>
    </main>



@endsection