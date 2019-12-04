@extends('layouts.app')

@section('content')

    <div class="lg:w-1/2 lg:mx-auto bg-card py-12 px-16 rounded shadow">
        <h1 class="text-2xl font-normal text-center mb-10">Edit a project</h1>

        <form method="POST" action="{{ $project->path() }}">
            
            @csrf
            @method('PATCH')
            
            @include('projects.form')      
            <div class="field">
                <button type="submit" class="button mr-2">Edit</button>
                <a href="{{ $project->path() }}">Cancel</a>
            </div> 
        </form>
    </div>

@endsection