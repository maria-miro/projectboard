@extends('layouts.app')

@section('content')

    <header class="flex items-center mb-3">
        <div class="flex justify-between items-end  w-full">
            <h2 class="text-muted text-base font-light">My projects</h2>
            <a @click.prevent = "$modal.show('new-project')" href="" class="button">Create a new project</a>

        </div>
    </header>

    <div class="lg:flex flex-wrap -mx-3">
        @forelse ($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6">
                @include('projects.card')
            </div>          
        @empty
            <div class="flex justify-center items-center w-full mt-10">
                <p>Your projects will be displayed here</p>
            </div>
        @endforelse
    </div>

    <new-project-modal></new-project-modal>
    
@endsection