@if ($errors->{$bag ?? 'default'}->any())
    <div class="field mb-3" role="alert">
        <ul class="list-reset">
            @foreach ($errors->{$bag ?? 'default'}->all() as $error)
                <li class="text-xs text-red-dark">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

