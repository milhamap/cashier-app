<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="{{Request::is('dashboard') ? '#' : '/dashboard'}}">Cashier App</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <input class="form-control form-control bg-dark w-100 rounded-0 border-0 bg-gradient text-white" type="text" placeholder="Search" aria-label="Search">
    <div class="navbar-nav">
      <div class="nav-item text-nowrap">
          <form method="POST" action="/logout">
              @csrf
              <button type="submit" class="nav-link px-3 bg-dark border-0"><span data-feather="logout" class="align-text-bottom"></span> Logout</button>
          </form>
      </div>
    </div>
  </header>
