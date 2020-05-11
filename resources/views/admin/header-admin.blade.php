<div class="row">
    <div class="col-md-12">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="dashboard">Tableau De Bord</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href={{ route('admin.users.list') }}>Utilisateurs <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href={{ route('admin.projets.list') }}>Projets</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Gestion annexe</a>
            </li>
            </ul>
        </div>
        </nav>
    </div>
</div>