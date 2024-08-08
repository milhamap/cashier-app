<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-white sidebar collapse">
    <div class="position-sticky pt-3">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link {{ Request::is('dashboard') ? 'text-dark' : 'text-secondary' }}" aria-current="page" href="/dashboard">
            <i class="bi bi-house-door"></i>
            Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('dashboard/products') ? 'text-dark' : 'text-secondary' }}" href="/dashboard/products">
            <i class="bi bi-bag"></i>
            Our Products
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('dashboard/transactions') ? 'text-dark' : 'text-secondary' }}" href="/dashboard/transactions">
            <i class="bi bi-cart"></i>
            Our Transactions
          </a>
        </li>
      </ul>
    </div>
</nav>
