<div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid bg-dark text-white">
            <a class="navbar-brand" href="../views/index.php">USS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                    aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link {{ request()->routeIs('index') ? 'active' : '' }}" aria-current="page" href="{{ url('/') }}">Home</a>
                    <a class="nav-link {{ request()->routeIs('details') ? 'active' : '' }}" aria-current="page" href="{{ url('/details') }}">details</a>
                    <a class="nav-link {{ request()->routeIs('submission.index') ? 'active' : '' }}" aria-current="page" href="{{ route('submission.index') }}">Submission</a>
                </div>
            </div>
        </div>
    </nav>
</div>
