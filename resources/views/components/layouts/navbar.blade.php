<nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-gradient shadow">
    <div class="container-fluid">
        <a class="navbar-brand fw-bolder" href="{{ route('home') }}"><i class="bi bi-safe"></i> Message Vault</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a @class(['nav-link', 'active' => Route::is('home')]) href="{{ route('home') }}"><i class="bi bi-house"></i> Home</a>
                </li>

                <li class="nav-item">
                    <a @class(['nav-link', 'active' => Route::is('about')]) href="{{ route('about') }}"><i class="bi bi-info-circle"></i> About</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
