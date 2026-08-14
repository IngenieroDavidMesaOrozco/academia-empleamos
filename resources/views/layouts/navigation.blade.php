<nav class="bg-white border-b border-gray-200 px-4 py-3">

    <div class="d-flex justify-content-between align-items-center">

        <!-- Logo corporativo -->
        <a href="/admin/dashboard" class="d-flex align-items-center text-decoration-none gap-3">

            <img src="{{ asset('imagenes/logoET.png') }}"
                 alt="Empleamos"
                 style="width:42px;height:42px;object-fit:contain;">

            <div>
                <div class="fw-bold text-dark">Empleamos</div>
                <small class="text-muted">Academia Corporativa</small>
            </div>

        </a>

        <!-- Usuario -->
        @auth
        <div class="dropdown">

            <a class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark"
               href="#"
               data-bs-toggle="dropdown">

                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                     style="width:38px;height:38px;font-weight:700;">

                    {{ strtoupper(substr(Auth::user()->name,0,1)) }}

                </div>

                <span class="fw-semibold">{{ Auth::user()->name }}</span>

            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">

                <li>
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="fa-solid fa-user me-2"></i>
                        Perfil
                    </a>
                </li>

                <li><hr class="dropdown-divider"></li>

                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="fa-solid fa-right-from-bracket me-2"></i>
                            Cerrar sesión
                        </button>
                    </form>
                </li>

            </ul>

        </div>
        @endauth

    </div>

</nav>