<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="http://localhost:8000/home">
      <i class="bi bi-house fs-1"></i>CoopHogar
    </a>
    <div class="collapse navbar-collapse" id="navbarNav">
      <div class="navbar-nav d-flex d-flex justify-content-center align-items-center">
        @if(auth()->guard('admin')->check())  
          <a class="nav-link" href="{{ route('solicitudes') }}"><i class="fs-4 mx-1 bi bi-person-fill-down"></i>Solicitudes de registro</a>
          <a class="nav-link" href="{{ route('users') }}"><i class="fs-5 mx-1 bi bi-people-fill"></i>Socios</a>
          <a class="nav-link" href="{{ route('pending.comprobantes') }}"><i class="fs-5 mx-1 bi bi-file-arrow-down-fill"></i>Comprobantes pendientes</a>
          <a class="nav-link" href="{{ route('unidades') }}"><i class="fs-5 mx-1 bi bi-houses-fill"></i>Unidades Habitacionales</a>
          <a class="nav-link" href="{{ route('asambleas') }}"><i class="fs-5 mx-1 bi bi-chat-square-dots"></i>Asambleas</a>
          <a class="nav-link" href="{{ route('admin.profile') }}"><i class="bi bi-person-circle fs-5 mx-1 "></i>Mi perfil</a>
          <a class="nav-link" href="{{ route('admin.create') }}"><i class=""></i>Crear Admin</a>
          <form method="POST" action="{{ route('logout') }}">
          @csrf
            <input class="nav-link" type="submit" value="Cerrar Sesión" />  
          </form>
        @else 
          <a class="nav-link" href="{{ route('login.view') }}">Login</a>
        @endif
      </div>
    </div>
  </div>
</nav>