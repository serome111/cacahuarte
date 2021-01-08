@if(session('status'))
<div class="col-3 alert alert-warning alert-dismissible fade show position-absolute top-50 start-50 translate-middle" role="alert">
    <strong>{{ session('status') }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

@endif