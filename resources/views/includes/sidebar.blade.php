<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('images/pharmacy_logo.png') }}" alt="Pharmacy Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Malolos Pharmacy</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('images/default_avatar.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    {{ auth()->user()->fname }} {{ auth()->user()->lname }}
                </a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @php 
                    $routes = Route::getRoutes();
                @endphp

                @foreach($routes as $route)
                    @if(isset($route->defaults['sidebar']))
                        @if(in_array(Auth::user()->role, $route->defaults['roles']) || (isset($route->defaults['sped']) && in_array(auth()->user()->id, $route->defaults['sped'])))
                            <li class="nav-item {{ str_contains(request()->path(), $route->uri) ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url($route->defaults['href']) }}">
                                    <i class="nav icon {{ $route->defaults['icon'] }}"></i> 
                                    <p>{{ $route->defaults['name'] }}</p>
                                </a>
                            </li>
                        @endif
                    @endif
                @endforeach

                <li class="nav-item">
                    <a href="pages/gallery.html" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Tables
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Simple Tables</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>