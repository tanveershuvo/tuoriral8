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
                    <a class="nav-link {{ request()->routeIs('submission.index') ? 'active' : '' }}" aria-current="page" href="{{ route('submission.index') }}">Submission</a>
                    <a class="nav-link" data-bs-toggle="modal" data-bs-target="#regModal" href="#" tabindex="-1"
                       aria-disabled="true">Registration</a>
                    <a class="nav-link " data-bs-toggle="modal" data-bs-target="#loginModal" href="#" tabindex="-1"
                       aria-disabled="true">Login</a>
                </div>
            </div>
        </div>
    </nav>
</div>
