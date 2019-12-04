<div class="card flex flex-col mt-3">
    <h3 class="font-normal text-m py-4 -ml-5 mb-3 border-l-4 border-accent-light pl-4">
        Invite a user
    </h3>
     <form method="POST" action="{{ $project->path() .'/invitations' }}">

         @csrf

         <div class="{{ $errors->any() ? '' : 'mb-3'}}">
             <input type="email" name="email" class="border border-muted rounded py-2 px-3 w-full" placeholder="Email address">
         </div>

         @include('errors',['bag' => 'invitations'])

         <button type="submit" class="button">Invite</button>
     </form>
</div>
