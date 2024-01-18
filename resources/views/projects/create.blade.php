@extends('layouts.app')

@section('content')

    
    <div class="lg:w-1/2 lg:mx-auto bg-card py-12 px-16 rounded shadow">
        <h1 class="text-2xl font-normal text-center mb-10">Create a project</h1>

        <form method="POST" action="/projects">
            
            @csrf
            
            @include('projects.form',['project' => new App\Models\Project])
       
            <div class="field">
                <button type="submit" class="button mr-2">Create</button>
                <a href="/projects">Cancel</a>
            </div> 
        </form>

    </div>
    
@endsection