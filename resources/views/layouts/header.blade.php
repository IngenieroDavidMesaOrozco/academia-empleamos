<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-custom-header shadow-sm py-3">
        <div class="container-fluid px-4">

            <a class="navbar-brand d-flex align-items-center fw-semibold" href="{{ url('/home') }}">
                <img src="{{ asset('imagenes/logoET.png') }}"
                     alt="Logo Empleamos"
                     style="height:44px;width:44px;border-radius:50%;object-fit:cover;margin-right:12px;">

                <div class="d-flex flex-column lh-sm">
                    <span class="fw-bold">ACADEMIA CORPORATIVA</span>
                    <small class="text-white-50">Empleamos Temporales</small>
                </div>
            </a>

            <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">

                @auth
                    <ul class="navbar-nav align-items-lg-center gap-lg-2">

                        @if(auth()->user()->hasRole('SuperAdmin') || auth()->user()->hasRole('Admin'))

                            <li class="nav-item">
                                <a href="{{ route('admin.dashboard') }}"
                                   class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active fw-semibold' : '' }}">
                                    <i class="fa-solid fa-gauge me-1"></i>
                                    Dashboard
                                </a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle {{ request()->routeIs('usuarios.*') || request()->routeIs('areas.*') ? 'active fw-semibold' : '' }}"
                                   href="#"
                                   role="button"
                                   data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-users me-1"></i>
                                    Administración
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('usuarios.index') }}">
                                            <i class="fa-solid fa-user-gear me-2 text-primary"></i>Usuarios
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="{{ route('areas.index') }}">
                                            <i class="fa-solid fa-building me-2 text-primary"></i>Áreas
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle {{ request()->routeIs('cursos.*') || request()->routeIs('modulos.*') || request()->routeIs('lecciones.*') ? 'active fw-semibold' : '' }}"
                                   href="#"
                                   role="button"
                                   data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-book-open me-1"></i>
                                    Capacitaciones
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('cursos.index') }}">
                                            <i class="fa-solid fa-book me-2 text-primary"></i>Cursos
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="{{ route('modulos.index') }}">
                                            <i class="fa-solid fa-layer-group me-2 text-primary"></i>Módulos
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="{{ route('lecciones.index') }}">
                                            <i class="fa-solid fa-file-lines me-2 text-primary"></i>Lecciones
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle {{ request()->routeIs('evaluaciones.*') || request()->routeIs('preguntas.*') || request()->routeIs('recursos.*') ? 'active fw-semibold' : '' }}"
                                   href="#"
                                   role="button"
                                   data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-clipboard-check me-1"></i>
                                    Contenido
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('evaluaciones.index') }}">
                                            <i class="fa-solid fa-clipboard-check me-2 text-primary"></i>Evaluaciones
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="{{ route('preguntas.index') }}">
                                            <i class="fa-solid fa-circle-question me-2 text-primary"></i>Preguntas
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="{{ route('recursos.index') }}">
                                            <i class="fa-solid fa-paperclip me-2 text-primary"></i>Recursos
                                        </a>
                                    </li>
                                </ul>
                            </li>

                        @else

                            <li class="nav-item">
                                <a href="{{ route('estudiante.dashboard') }}"
                                   class="nav-link {{ request()->routeIs('estudiante.*') ? 'active fw-semibold' : '' }}">
                                    <i class="fa-solid fa-house me-1"></i>
                                    Mis cursos
                                </a>
                            </li>

                        @endif

                        <li class="nav-item dropdown ms-lg-2">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2"
                               href="#"
                               role="button"
                               data-bs-toggle="dropdown">

                                <span class="bg-white text-primary rounded-circle d-inline-flex align-items-center justify-content-center fw-bold"
                                      style="width:34px;height:34px;">
                                    {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                                </span>

                                <span class="d-none d-lg-inline">{{ auth()->user()->name }}</span>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">

                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="fa-solid fa-user me-2 text-primary"></i>Perfil
                                    </a>
                                </li>

                                <li><hr class="dropdown-divider"></li>

                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item text-danger" type="submit">
                                            <i class="fa-solid fa-right-from-bracket me-2"></i>Cerrar sesión
                                        </button>
                                    </form>
                                </li>

                            </ul>
                        </li>

                    </ul>
                @else
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link">Iniciar sesión</a>
                        </li>
                    </ul>
                @endauth

            </div>

        </div>
    </nav>
</header>