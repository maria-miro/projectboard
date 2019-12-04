<div class="field mb-6">
    <label class="block text-sm mb-2" for="title">Title</label>
    <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 border-muted-light leading-tight focus:outline-none focus:shadow-outline" id="title" name="title" value="{{ $project->title }}">
</div>
<div class="field mb-6">
    <label class="block text-sm mb-2" for="description">Description</label>
    <textarea rows="10" class="shadow appearance-none border rounded w-full py-2 px-3 border-muted-light leading-tight focus:outline-none focus:shadow-outline" id="description" rows="3" name="description">{{ $project->description }}</textarea>
</div>
      