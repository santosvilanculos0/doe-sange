<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a class="brand-link" href="index3.html">
    <img class="brand-image img-circle elevation-3"
      src="{{ asset('/image/red_cross.svg') }}" alt="AdminLTE Logo"
      style="opacity: .8">
    <span class="brand-text font-weight-light">Doe Sangue</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <div class="user-panel d-flex mb-3 mt-3 pb-3">
      <div class="image">
        <img class="img-circle elevation-2" src="/image/portrait.jpg"
          alt="" style="object-fit: cover;aspect-ratio:1">
      </div>
      <div class="info">
        <a class="d-block"
          href="{{ route('profile.edit') }}">{{ auth()->user()->name }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview"
        data-accordion="false" role="menu">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

        <li class="nav-item">
          <a href="{{ route('dashboard') }}" @class([
              'nav-link',
              'active' => Route::currentRouteName() === 'dashboard',
          ])>
            <i class="nav-icon fas fa-chart-bar"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('users.index') }}" @class([
              'nav-link',
              'active' => Route::currentRouteName() === 'users.index',
          ])>
            <i class="nav-icon fas fa-user"></i>
            <p>
              Usuários
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('branches.index') }}" @class([
              'nav-link',
              'active' => Route::currentRouteName() === 'branches.index',
          ])>
            <i class="nav-icon fas fa-code-branch"></i>
            <p>
              Pontos de coleta
            </p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
    <form class="mt-4" action="{{ route('logout') }}" method="POST">
      @csrf
      <button class="btn btn-danger w-100" type="submit">
        Logout
      </button>
    </form>
  </div>

  <!-- /.sidebar -->
</aside>
