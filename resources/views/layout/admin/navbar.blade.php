<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">



        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            @if (App\Models\Notification::where('user_id', Auth::user()->id)->count() > 0)
                <a class="nav-link text-warning dropdown-toggle" href="#" id="alertsDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-fw"></i>
                    <!-- Counter - Alerts -->
                    <span class="badge badge-danger badge-counter"></span>
                </a>
                <!-- Dropdown - Alerts -->
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header">
                        Notifikasi
                    </h6>
                    <div id="alert">
                        @foreach (App\Models\Notification::where('user_id', Auth::user()->id)->limit(3)->orderBy('created_at', 'desc')->get() as $alert)
                            <a class="dropdown-item d-flex align-items-center" href="{{ $alert->link }}">
                                <div class="mr-3">
                                    <div class="icon-circle bg-{{ $alert->color }}">
                                        <i class="{{ $alert->icon }} text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">
                                        {{ Carbon\Carbon::parse($alert->created_at)->diffForHumans() }}
                                    </div>
                                    <span class="font-weight-bold">{!! $alert->message !!}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    @if (App\Models\Notification::where('user_id', Auth::user()->id)->count() > 3)
                        <button class="dropdown-item text-center small text-gray-500" data-bs-toggle="modal"
                            data-bs-target="#alertlist">Lihat Semua</button>
                    @endif
                    @if (App\Models\Notification::where('user_id', Auth::user()->id)->count() > 0)
                        <button id="alltop" class="dropdown-item text-center small text-gray-500">Hapus
                            Semua</button>
                        @push('scripts')
                            <script>
                                $('#alltop').click(() => {

                                    // ajax get
                                    $.ajax({
                                        url: "/notification/delete/{{ $alert->user_id }}/0",
                                        type: "GET",
                                        success: function(data) {
                                            $('#alertsDropdown').hide()
                                        }
                                    });
                                });
                            </script>
                        @endpush
                    @endif

                </div>
            @endif

        </li>

        {{-- <!-- Nav Item - Messages -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">7</span>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                    Message Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="img/undraw_profile_1.svg" alt="...">
                        <div class="status-indicator bg-success"></div>
                    </div>
                    <div class="font-weight-bold">
                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                            problem I've been having.</div>
                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                    </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="img/undraw_profile_2.svg" alt="...">
                        <div class="status-indicator"></div>
                    </div>
                    <div>
                        <div class="text-truncate">I have the photos that you ordered last month, how
                            would you like them sent to you?</div>
                        <div class="small text-gray-500">Jae Chun · 1d</div>
                    </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="img/undraw_profile_3.svg" alt="...">
                        <div class="status-indicator bg-warning"></div>
                    </div>
                    <div>
                        <div class="text-truncate">Last month's report looks great, I am very happy
                            with
                            the progress so far, keep up the good work!</div>
                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                    </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="...">
                        <div class="status-indicator bg-success"></div>
                    </div>
                    <div>
                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                            told me that people say this to all dogs, even if they aren't good...</div>
                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                    </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Read More
                    Messages</a>
            </div>
        </li> --}}

        {{-- <div class="topbar-divider d-none d-sm-block"></div> --}}

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                <img class="img-profile rounded-circle"
                    src="{{ Auth::user()->img ? asset('storage/people') . '/' . Auth::user()->img : asset('dashboard/img/undraw_profile.svg') }}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="/profile">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profil
                </a>
                {{-- <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a> --}}
                <div class="dropdown-divider"></div>
                <button class="dropdown-item" id="logout">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Keluar
                </button>
            </div>
        </li>

    </ul>

</nav>


@if (App\Models\Notification::where('user_id', Auth::user()->id)->count() > 0)
    <!-- Modal -->
    <div class="modal fade " id="alertlist" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable" style="max-height: 40rem;">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Notifikasi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table" id="notif-table">
                        @foreach (App\Models\Notification::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get() as $alert)
                            <tr id="full{{ $alert->id }}">
                                <th class="align-middle" style="width: 10%">
                                    <div class="icon-circle bg-{{ $alert->color }}">
                                        <i class="{{ $alert->icon }} text-white"></i>
                                    </div>
                                </th>
                                <th class="align-middle" style="width: ">
                                    <span
                                        class="d-flex small text-gray-500">{{ Carbon\Carbon::parse($alert->created_at)->diffForHumans() }}</span>
                                    <a href="{{ $alert->link }}" class="text-black">{!! $alert->message !!}</a>
                                </th>
                                <th class="align-middle" style="width: 5%">
                                    <button class="btn" id="notif{{ $alert->id }}"><i
                                            class="fa-solid fa-xmark fa-2x"></i></button>
                                    @push('scripts')
                                        <script>
                                            $('#notif{{ $alert->id }}').click(() => {
                                                // ajax get
                                                $.ajax({
                                                    url: "/notification/delete/0/{{ $alert->id }}",
                                                    type: "GET",
                                                    success: function(data) {
                                                        $('#full{{ $alert->id }}').remove();
                                                    }
                                                });
                                            });
                                        </script>
                                    @endpush
                                </th>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-danger" id="allbottom" data-bs-dismiss="modal">Hapus
                        Semua</button>
                    @push('scripts')
                        <script>
                            $('#allbottom').click(() => {
                                // ajax get
                                $.ajax({
                                    url: "/notification/delete/{{ $alert->user_id }}/0",
                                    type: "GET",
                                    success: function(data) {
                                        $('#alertsDropdown').hide()
                                    }
                                });
                            });
                        </script>
                    @endpush
                </div>
            </div>
        </div>
    </div>
@endif
