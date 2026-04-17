<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">

            <!-- LOGO -->
            <div class="navbar-brand-box" style="display:flex;align-items:center;gap:10px;padding:0 16px;">
                <a href="{{ route(auth()->user()->getRoleNames()->first() . '.dashboard') }}"
                   style="display:flex;align-items:center;gap:10px;text-decoration:none;">
                    
                    <div style="line-height:1.15;">
                        <div style="font-size:1.5rem;font-weight:800;color:#fff;letter-spacing:.02em;">EcoVolt</div>
                        <div style="font-size:.7rem;color:rgba(255,255,255,.65);text-transform:uppercase;letter-spacing:.08em;">Solar Panel Portal</div>
                    </div>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="mdi mdi-menu"></i>
            </button>


        </div>

        <!-- Search input -->
        <div class="search-wrap" id="search-wrap">
            <div class="search-bar">
                <input class="search-input form-control" placeholder="Search" />
                <a href="#" class="close-search toggle-search" data-target="#search-wrap">
                    <i class="mdi mdi-close-circle"></i>
                </a>
            </div>
        </div>

        <div class="d-flex">
            <div class="dropdown d-none d-lg-inline-block">
                <button type="button" class="btn header-item toggle-search noti-icon waves-effect"
                    data-target="#search-wrap">
                    <i class="mdi mdi-magnify"></i>
                </button>
            </div>


            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="mdi mdi-fullscreen"></i>
                </button>
            </div>


            <style>
                #notification-list .notification-item {
                    border-bottom: 1px solid #f1f5f9;
                    transition: all 0.2s;
                    display: block;
                }
                #notification-list .notification-item:hover {
                    background-color: #f8fafc;
                }
                #notification-list .notification-item.unread {
                    background-color: #f0fdf4;
                }
                #notification-list .avatar-title {
                    background-color: #15803d !important;
                    color: #fff !important;
                }
                #notification-badge {
                    background-color: #15803d !important;
                }
                .dropdown-menu-lg {
                    width: 320px !important;
                    z-index: 9999 !important;
                    overflow: hidden;
                    border-radius: 8px;
                }
                #notification-list {
                    overflow-x: hidden;
                }
                .notification-item h6 {
                    white-space: normal;
                    word-wrap: break-word;
                }
                .notification-item p {
                    white-space: normal;
                    word-wrap: break-word;
                    line-height: 1.4;
                }
            </style>
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                    data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-bell-outline"></i>
                    <span class="badge rounded-pill" id="notification-badge" style="display: none; background-color: #15803d;">0</span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0 shadow-lg border-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3 border-bottom">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0 font-weight-bold" style="color: #15803d;"> Notifications </h6>
                            </div>
                            <div class="col-auto">
                                <a href="javascript:void(0)" class="small text-muted" id="mark-all-read-btn"> Mark all as read</a>
                            </div>
                        </div>
                    </div>
                    <div style="max-height: 300px; overflow-y: auto; overflow-x: hidden;" id="notification-list">
                        <!-- Notifications will be loaded here -->
                        <div class="text-center p-4">
                            <div class="spinner-border spinner-border-sm text-success" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-3 border-top d-grid bg-light">
                        <a class="btn btn-sm btn-link font-size-14 text-center text-success fw-bold" href="javascript:void(0)">
                            <i class="mdi mdi-arrow-right-circle me-1"></i> View All Notifications
                        </a>
                    </div>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    <img src="{{ Auth::user()->profile_picture ? asset(Auth::user()->profile_picture) : 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=80' }}"
                        alt="Header Avatar" class="rounded-circle header-profile-user">

                    <span class="d-none d-xl-inline-block ms-1" style="text-align:left; line-height:1.2;">
                        <span style="display:block; font-size:.85rem; font-weight:700; color:#1e293b;">{{ Auth::user()->name }}</span>
                        @php $role = Auth::user()->getRoleNames()->first(); @endphp
                        <span style="display:block; font-size:.65rem; font-weight:800; padding: 1px 8px; border-radius: 20px; text-transform:uppercase; letter-spacing:1px;
                            background: {{ $role=='admin' ? '#dcfce7' : ($role=='dealer' ? '#dbeafe' : '#fef9c3') }};
                            color: {{ $role=='admin' ? '#15803d' : ($role=='dealer' ? '#1d4ed8' : '#92400e') }};">
                            {{ ucfirst($role) }}
                        </span>
                    </span>

                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route(auth()->user()->getRoleNames()->first() . '.profile') }}">
                        <i class="mdi mdi-account-circle-outline font-size-16 align-middle me-1"></i>
                        Profile
                    </a>



                    {{-- <a class="dropdown-item d-block" href=""><span
                            class="badge badge-success float-end">11</span><i
                            class="mdi mdi-cog-outline font-size-16 align-middle me-1"></i> Settings</a> --}}
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-power font-size-16 align-middle me-1 text-danger"></i> Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="GET" style="display: none;">
                        @csrf
                    </form>

                </div>
            </div>

            {{-- <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                    <i class="mdi mdi-cog-outline font-size-20"></i>
                </button>
            </div> --}}

        </div>
    </div>
</header>

@push('scripts')
<script>
    $(document).ready(function() {
        function loadLatestNotifications() {
            $.ajax({
                url: "{{ route('admin.notification.latest') }}",
                method: "GET",
                success: function(response) {
                    let unreadCount = response.unreadCount;
                    if (unreadCount > 0) {
                        $('#notification-badge').text(unreadCount).show();
                    } else {
                        $('#notification-badge').hide();
                    }

                    let notifications = response.notifications;
                    let html = '';

                    if (notifications.length > 0) {
                        notifications.forEach(function(n) {
                            let unreadClass = n.is_read ? '' : 'unread';
                            html += `
                                <a href="javascript:void(0)" class="text-reset notification-item mark-as-read ${unreadClass}" data-id="${n.id}">
                                    <div class="d-flex p-3">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar-xs">
                                                <span class="avatar-title rounded-circle font-size-16 text-white">
                                                    <i class="mdi mdi-bell"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1" style="font-weight: ${n.is_read ? '500' : '700'}; color: #1e293b;">${n.title}</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1" style="margin-bottom: 4px;">${n.description}</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> ${new Date(n.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            `;
                        });
                    } else {
                        html = '<div class="text-center p-4 text-muted"><i class="mdi mdi-bell-off-outline d-block font-size-24 mb-2"></i>No new notifications</div>';
                    }

                    $('#notification-list').html(html);
                }
            });
        }

        loadLatestNotifications();
        setInterval(loadLatestNotifications, 60000);

        $(document).on('click', '.mark-as-read', function() {
            let id = $(this).data('id');
            let element = $(this);
            $.ajax({
                url: "{{ url('admin/notifications') }}/" + id + "/read",
                method: "POST",
                data: { _token: "{{ csrf_token() }}" },
                success: function() {
                    element.removeClass('unread');
                    element.find('h6').css('font-weight', '500');
                    loadLatestNotifications();
                }
            });
        });

        $('#mark-all-read-btn').click(function() {
            $.ajax({
                url: "{{ route('admin.notification.read-all') }}",
                method: "POST",
                data: { _token: "{{ csrf_token() }}" },
                success: function() {
                    loadLatestNotifications();
                }
            });
        });
    });
</script>
@endpush
