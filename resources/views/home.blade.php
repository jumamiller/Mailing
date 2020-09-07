<div class="container">
    <div class="alert alert-success alert-dismissible fade show"role="alert">
        {{$status}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <p class="text-center text-secondary">Welcome to our webpage {{Auth::user()}}</p>
</div>
