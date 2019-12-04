<div class="card flex flex-col" style="height:200px">
    <h3 class="font-normal text-m py-4 -ml-5 mb-3 border-l-4 border-accent-light pl-4">
        <a class="no-underline text-default" href="{{ $project->path() }}">
            {{ $project->title }}
        </a>
    </h3>
    <div class="mb-4 font-normal text-sm flex-1">{{ $project->description }}</div>

    @can('manage', $project)
        <footer>
            <form method="POST" action="{{ $project->path() }}" class="text-right">

                @csrf
                @method('DELETE')

                <button type="submit" class="text-xs">Delete</button>
            </form>
        </footer>
    @endcan
</div>