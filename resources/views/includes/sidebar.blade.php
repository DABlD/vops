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
                <a href="#" class="d-block" id="profile">
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

@push('scripts')
    <script src="{{ asset('js/flatpickr.min.js') }}"></script>
    <script>
        $('#profile').on('click', () => {
            $.ajax({
                url: "{{ route('user.get') }}",
                data: {
                    cols: 'users.*',
                    where: ['id', {{ auth()->user()->id }}]
                },
                success: user => {
                    user = JSON.parse(user)[0];

                    function input(name, placeholder, value, type = "text"){
                        return `
                            <div class="row input">
                                <div class="col-md-2">
                                    ${placeholder}
                                </div>
                                <div class="col-md-10">
                                    <input type="${type}" name="${name}" placeholder="Enter ${placeholder}" class="form-control"} value="${value ?? ""}">
                                </div>
                            </div>
                        `;
                    }

                    Swal.fire({
                        html: `
                            <div class="row" style="margin-top: 30px;">
                                <div class="col-md-3">
                                    <img src="${user.avatar}" alt="User Avatar" width="200px" height="200px">
                                </div>
                                <div class="col-md-9">
                                    ${input("fname", "First Name", "{{ auth()->user()->fname }}")}
                                    ${input("mname", "Middle Name", "{{ auth()->user()->mname }}")}
                                    ${input("lname", "Last Name", "{{ auth()->user()->lname }}")}
                                    ${input("email", "Email", "{{ auth()->user()->email }}")}
                                    ${input("birthday", "Birthday", "{{ auth()->user()->birthday }}")}
                                    ${input("gender", "Gender", "{{ auth()->user()->gender }}")}
                                    ${input("address", "Address", "{{ auth()->user()->address }}")}
                                    ${input("contact", "Contact #", "{{ auth()->user()->contact }}", "number")}
                                </div>
                            </div"
                        `,
                        width: "1000px",
                        confirmButtonText: 'Update',
                        @if(auth()->user()->fname == null && auth()->user()->lname == null)
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        @else
                            showCancelButton: true,
                            cancelButtonColor: errorColor,
                            cancelButtonText: 'Exit',
                        @endif
                        didOpen: () => {
                            $('#swal2-html-container').css('overflow', 'hidden');
                            $('#swal2-html-container .col-md-2').css('margin', 'auto');
                            $('#swal2-html-container .col-md-2').css('text-align', 'left');
                            $('.input.row').css('margin-bottom', '5px');

                            $('[name="birthday"]').flatpickr({
                                altInput: true,
                                altFormat: 'F j, Y',
                                dateFormat: 'Y-m-d',
                            })
                        }
                    }).then(result => {
                        if(result.value){
                            let data = {
                                id: "{{ auth()->user()->id }}",
                                fname: $("[name='fname']").val(),
                                mname: $("[name='mname']").val(),
                                lname: $("[name='lname']").val(),
                                email: $("[name='email']").val(),
                                birthday: $("[name='birthday']").val(),
                                gender: $("[name='gender']").val(),
                                address: $("[name='address']").val(),
                                contact: $("[name='contact']").val(),
                            };

                            data._token = $('meta[name="csrf-token"]').attr('content');

                            $.ajax({
                                url: "{{ route('user.update') }}",
                                data: data,
                                type: "POST",
                                success: result => {
                                    window.location.reload();
                                }
                            });
                        }
                    });
                }
            });
        });

        @if(auth()->user()->fname == null && auth()->user()->lname == null)
            $('#profile').click();
        @endif
    </script>
@endpush