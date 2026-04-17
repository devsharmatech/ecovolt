<!-- ========== Left Sidebar Start ========== -->
<style>
/* ─── Sidebar Container ──────────────────────────── */
.vertical-menu {
    background: linear-gradient(180deg, #1a7a1a 0%, #1e8c1e 40%, #239123 100%);
    width: 260px;
    height: calc(100vh - 55px);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    position: fixed;
    left: 0; top: 0;
    z-index: 1000;
    box-shadow: 4px 0 20px rgba(0,0,0,.18);
    transition: width .3s ease;
}

/* ─── Brand / Logo Area ──────────────────────────── */
.sb-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 18px 20px 16px;
    border-bottom: 1px solid rgba(255,255,255,.12);
    flex-shrink: 0;
    min-height: 72px;
}
.sb-logo-img {
    width: 48px; height: 48px;
    border-radius: 0;
    object-fit: contain;
    background: transparent;
    padding: 0;
    box-shadow: none;
    flex-shrink: 0;
    filter: brightness(0) invert(1);
}
.sb-brand-text .brand-name {
    font-size: .95rem;
    font-weight: 800;
    color: #fff;
    line-height: 1.1;
    letter-spacing: .02em;
}
.sb-brand-text .brand-sub {
    font-size: .65rem;
    color: rgba(255,255,255,.65);
    letter-spacing: .06em;
    text-transform: uppercase;
}

/* ─── Admin Info Strip ───────────────────────────── */
.sb-admin-strip {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 20px;
    background: rgba(0,0,0,.08);
    border-bottom: 1px solid rgba(255,255,255,.08);
    flex-shrink: 0;
}
.sb-admin-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: rgba(255,255,255,.25);
    display: flex; align-items: center; justify-content: center;
    font-size: .9rem; font-weight: 700; color: #fff;
    flex-shrink: 0;
}
.sb-admin-info .admin-name { font-size: .78rem; font-weight: 700; color: #fff; line-height: 1.2; }
.sb-admin-info .admin-role { font-size: .65rem; color: rgba(255,255,255,.6); text-transform: uppercase; letter-spacing: .05em; }

/* ─── Scrollable Nav ─────────────────────────────── */
.sb-nav {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 16px 14px 8px;
}
.sb-nav::-webkit-scrollbar { width: 4px; }
.sb-nav::-webkit-scrollbar-track { background: transparent; }
.sb-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,.25); border-radius: 4px; }

/* ─── Section Label ──────────────────────────────── */
.sb-section-label {
    font-size: .6rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: rgba(255,255,255,.45);
    padding: 12px 8px 6px;
    display: block;
}

/* ─── Nav Item ───────────────────────────────────── */
.sb-item { margin-bottom: 4px; }
.sb-link {
    display: flex;
    align-items: center;
    gap: 12px;
    color: rgba(255,255,255,.85) !important;
    background: transparent;
    border-radius: 12px;
    padding: 10px 14px;
    font-size: .82rem;
    font-weight: 500;
    text-decoration: none !important;
    transition: background .2s, color .2s, transform .15s;
    cursor: pointer;
    border: none;
    width: 100%;
    text-align: left;
    white-space: nowrap;
}
.sb-link:hover {
    background: rgba(255,255,255,.15);
    color: #fff !important;
    transform: translateX(2px);
}
.sb-link.active-link {
    background: #fff !important;
    color: #1a7a1a !important;
    font-weight: 700;
    box-shadow: 0 4px 14px rgba(0,0,0,.2);
}
.sb-link.active-link i { color: #1a7a1a !important; }
.sb-link .sb-icon {
    width: 32px; height: 32px; border-radius: 9px;
    background: rgba(255,255,255,.15);
    display: flex; align-items: center; justify-content: center;
    font-size: .85rem; flex-shrink: 0;
    transition: background .2s;
}
.sb-link.active-link .sb-icon { background: rgba(26,122,26,.12); }
.sb-link:hover .sb-icon { background: rgba(255,255,255,.22); }
.sb-link .sb-chevron {
    margin-left: auto; font-size: .65rem;
    transition: transform .25s;
    opacity: .7;
}
.sb-link.open .sb-chevron { transform: rotate(180deg); }

/* ─── Submenu ────────────────────────────────────── */
.sb-submenu {
    display: none;
    margin: 4px 0 4px 14px;
    border-left: 2px solid rgba(255,255,255,.2);
    padding-left: 10px;
}
.sb-submenu.open { display: block; }
.sb-sub-link {
    display: flex;
    align-items: center;
    gap: 10px;
    color: rgba(255,255,255,.75) !important;
    background: transparent;
    border-radius: 9px;
    padding: 8px 12px;
    font-size: .8rem;
    font-weight: 500;
    text-decoration: none !important;
    transition: background .2s, color .2s;
    margin-bottom: 2px;
}
.sb-sub-link:hover, .sb-sub-link.active-sub {
    background: rgba(255,255,255,.15);
    color: #fff !important;
}
.sb-sub-link i { font-size: .78rem; width: 16px; text-align: center; }

/* ─── Logout Footer ──────────────────────────────── */
.sb-footer {
    flex-shrink: 0;
    padding: 10px 14px 14px;
    border-top: 1px solid rgba(255,255,255,.1);
}
.sb-logout-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    width: 100%;
    padding: 11px 14px;
    border-radius: 12px;
    background: rgba(239,68,68,.15);
    border: 1px solid rgba(239,68,68,.3);
    color: #fca5a5 !important;
    font-size: .82rem; font-weight: 600;
    text-decoration: none !important;
    cursor: pointer;
    transition: background .2s, color .2s;
}
.sb-logout-btn:hover {
    background: rgba(239,68,68,.28);
    color: #fff !important;
}
.sb-logout-btn .sb-icon { background: rgba(239,68,68,.2); color: #fca5a5; }
</style>

<div class="vertical-menu" id="sidebar" style="margin-top: 55px;">


    {{-- ── SCROLLABLE NAV ──────────────────────────── --}}
    <div class="sb-nav">
        @php $role = auth()->user()->getRoleNames()->first(); @endphp

        <span class="sb-section-label">Main Menu</span>

        {{-- Dashboard --}}
        <div class="sb-item">
            <a href="{{ route($role . '.dashboard') }}"
               class="sb-link {{ request()->routeIs($role . '.dashboard') ? 'active-link' : '' }}">
                <span class="sb-icon"><i class="fas fa-th-large"></i></span>
                Dashboard
            </a>
        </div>

        {{-- My Profile --}}
        <div class="sb-item">
            <a href="{{ route($role . '.profile') }}"
               class="sb-link {{ request()->routeIs($role . '.profile') ? 'active-link' : '' }}">
                <span class="sb-icon"><i class="fas fa-user-circle"></i></span>
                My Profile
            </a>
        </div>

        {{-- Users Management --}}
        @if($role == 'admin')
        @can('users.view')
        <div class="sb-item">
            <a href="javascript:void(0);" id="userMenuToggle"
               onclick="toggleSubmenu('usersSubmenu','userMenuToggle')"
               class="sb-link {{ request()->routeIs($role . '.users.*') ? 'active-link open' : '' }}">
                <span class="sb-icon"><i class="fas fa-user-friends"></i></span>
                Users Management
                <i class="fas fa-chevron-down sb-chevron"></i>
            </a>
            <div class="sb-submenu {{ request()->routeIs($role . '.users.*') ? 'open' : '' }}" id="usersSubmenu">
                <a href="{{ route($role . '.users.index') }}?role=Accounts"
                   class="sb-sub-link {{ request()->is('*/users*') && request()->query('role') == 'Accounts' ? 'active-sub' : '' }}">
                    <i class="fas fa-calculator"></i> Accounts
                </a>
                <a href="{{ route($role . '.users.index') }}?role=Dealer"
                   class="sb-sub-link {{ request()->is('*/users*') && request()->query('role') == 'Dealer' ? 'active-sub' : '' }}">
                    <i class="fas fa-store"></i> Dealer
                </a>
                <a href="{{ route($role . '.users.index') }}?role=Employee"
                   class="sb-sub-link {{ request()->is('*/users*') && request()->query('role') == 'Employee' ? 'active-sub' : '' }}">
                    <i class="fas fa-user-tie"></i> Employee
                </a>
                <a href="{{ route($role . '.users.index') }}?role=Customer"
                   class="sb-sub-link {{ request()->is('*/users*') && request()->query('role') == 'Customer' ? 'active-sub' : '' }}">
                    <i class="fas fa-users"></i> Customer
                </a>
            </div>
        </div>
        @endcan
        @endif

        @if($role == 'dealer')
        <span class="sb-section-label">Dealer Portal</span>

        {{-- 1. Create Lead (Requirement Understanding) --}}
        <div class="sb-item">
            <a href="{{ route($role . '.leads.create') }}"
               class="sb-link {{ request()->routeIs($role . '.leads.create') ? 'active-link' : '' }}">
                <span class="sb-icon"><i class="fas fa-plus-circle"></i></span>
                 Requirement Analysis
            </a>
        </div>

        {{-- 2. Lead Management --}}
        <div class="sb-item">
            <a href="{{ route($role . '.leads.index') }}"
               class="sb-link {{ request()->routeIs($role . '.leads.index') ? 'active-link' : '' }}">
                <span class="sb-icon"><i class="fas fa-users-cog"></i></span>
                 Lead Management
            </a>
        </div>

        {{-- 3. Project & Track --}}
        <div class="sb-item">
            <a href="{{ route($role . '.projects.index') }}"
               class="sb-link {{ request()->routeIs($role . '.projects.*') ? 'active-link' : '' }}">
                <span class="sb-icon"><i class="fas fa-map-marker-alt"></i></span>
                 Project Tracking
            </a>
        </div>

        {{-- 4. Discount Request --}}
        <div class="sb-item">
            <a href="{{ route($role . '.discount-offer.index') }}"
               class="sb-link {{ request()->routeIs($role . '.discount-offer.*') ? 'active-link' : '' }}">
                <span class="sb-icon"><i class="fas fa-percentage"></i></span>
                 Discount Requests
            </a>
        </div>

        <span class="sb-section-label">Finance & Others</span>
        {{-- Commission Tracking --}}
        <div class="sb-item">
            <a href="{{ route($role . '.reports.index') }}?type=commission"
               class="sb-link {{ request()->is('*/reports*') && request()->query('type') == 'commission' ? 'active-link' : '' }}">
                <span class="sb-icon"><i class="fas fa-coins"></i></span>
                My Commission
            </a>
        </div>

        {{-- My Profile --}}
        <div class="sb-item">
            <a href="{{ route($role . '.profile') }}"
               class="sb-link {{ request()->routeIs($role . '.profile') ? 'active-link' : '' }}">
                <span class="sb-icon"><i class="fas fa-user-circle"></i></span>
                My Profile
            </a>
        </div>

        {{-- Payout --}}
        <div class="sb-item">
            <a href="{{ route($role . '.accounts.index') }}"
               class="sb-link {{ request()->routeIs($role . '.accounts.index') ? 'active-link' : '' }}">
                <span class="sb-icon"><i class="fas fa-wallet"></i></span>
                Payout Status
            </a>
        </div>
        @endif

        @if($role != 'dealer')
        <span class="sb-section-label">Lead & Project Flow</span>

        @can('leads.view')
        <div class="sb-item">
            <a href="{{ route($role . '.leads.index') }}"
               class="sb-link {{ request()->routeIs($role . '.leads.index') ? 'active-link' : '' }}">
                <span class="sb-icon"><i class="fas fa-user-plus"></i></span>
                 Lead Management
            </a>
        </div>
        @endcan

        <div class="sb-item">
            <a href="{{ route($role . '.projects.index') }}"
               class="sb-link {{ request()->routeIs($role . '.projects.*') ? 'active-link' : '' }}">
                <span class="sb-icon"><i class="fas fa-project-diagram"></i></span>
                 Project Management
            </a>
        </div>

        <div class="sb-item">
            <a href="{{ route($role . '.quotes.index') }}"
                class="sb-link {{ request()->is('*/quotes*') ? 'active-link' : '' }}">
                <span class="sb-icon"><i class="fas fa-file-invoice"></i></span>
                 Quotaton Management
            </a>
        </div>

        @can('documents.view')
        <div class="sb-item">
            <a href="{{ route($role . '.documents.index') }}"
               class="sb-link {{ request()->routeIs($role . '.documents.*') ? 'active-link' : '' }}">
                <span class="sb-icon"><i class="fas fa-file-alt"></i></span>
                Doc Management
            </a>
        </div>
        @endcan

        <span class="sb-section-label">Utility & Services</span>

        <div class="sb-item">
            <a href="{{ route($role . '.locker.index') }}"
               class="sb-link {{ request()->routeIs($role . '.locker.*') ? 'active-link' : '' }}">
                <span class="sb-icon"><i class="fas fa-file-invoice"></i></span>
                Digital Locker
            </a>
        </div>

        @if($role == 'admin')
        <div class="sb-item">
            <a href="{{ route($role . '.services.index') }}"
               class="sb-link {{ request()->routeIs($role . '.services.*') ? 'active-link' : '' }}">
                <span class="sb-icon"><i class="fas fa-tools"></i></span>
                Service Requests
            </a>
        </div>

        <div class="sb-item">
            <a href="{{ route($role . '.enquiries.index') }}"
               class="sb-link {{ request()->routeIs($role . '.enquiries.*') ? 'active-link' : '' }}">
                <span class="sb-icon"><i class="fas fa-calendar-plus"></i></span>
                Solar Enquiries
            </a>
        </div>
        @endif
        @endif

        @if($role != 'dealer')
        @can('payments.view')
        <div class="sb-item">
            <a href="{{ route($role . '.accounts.index') }}"
               class="sb-link {{ request()->is('*/accounts*') ? 'active-link' : '' }}">
                <span class="sb-icon"><i class="fas fa-university"></i></span>
                Accounts & Collections
            </a>
        </div>
        @endcan

        {{-- Discounts & Offers Dropdown --}}
        @canany(['discount-offers.view', 'payments.view', 'discounts.view'])
        <div class="sb-item">
            <a href="javascript:void(0);" id="discountMenuToggle"
               onclick="toggleSubmenu('discountSubmenu','discountMenuToggle')"
               class="sb-link {{ request()->is('*/discount-offer*') || request()->is('*/payments*') || request()->is('*/discounts*') ? 'active-link open' : '' }}">
                <span class="sb-icon"><i class="fas fa-tags"></i></span>
                Discounts & Offers
                <i class="fas fa-chevron-down sb-chevron"></i>
            </a>
            <div class="sb-submenu {{ request()->is('*/discount-offer*') || request()->is('*/payments*') || request()->is('*/discounts*') ? 'open' : '' }}" id="discountSubmenu">
                @can('payments.view')
                <a href="{{ route($role . '.payments.index') }}"
                    class="sb-sub-link {{ request()->is('*/payments*') ? 'active-sub' : '' }}">
                    <i class="fas fa-wallet"></i> Payment Structure
                </a>
                @endcan
                @can('discounts.view')
                <a href="{{ route($role . '.discounts.index') }}"
                    class="sb-sub-link {{ request()->is('*/discounts*') ? 'active-sub' : '' }}">
                    <i class="fas fa-user-check"></i> Discount & Approval Tiers
                </a>
                @endcan
                @can('discount-offers.view')
                <a href="{{ route($role . '.discount-offer.index') }}"
                    class="sb-sub-link {{ request()->is('*/discount-offer*') ? 'active-sub' : '' }}">
                    <i class="fas fa-certificate"></i> Manage Offers
                </a>
                @endcan
            </div>
        </div>
        @endcanany

        @can('reports.view')
        <div class="sb-item">
            <a href="{{ route($role . '.reports.index') }}"
               class="sb-link {{ request()->routeIs($role . '.reports.*') ? 'active-link' : '' }}">
                <span class="sb-icon"><i class="fas fa-chart-area"></i></span>
                Report & Analytics
            </a>
        </div>
        @endcan

        @if($role == 'admin')
        <span class="sb-section-label">Mobile App</span>

        <div class="sb-item">
            <a href="javascript:void(0);" id="appMgmtToggle"
               onclick="toggleSubmenu('appMgmtSubmenu','appMgmtToggle')"
               class="sb-link {{ request()->routeIs($role . '.support.*') || request()->routeIs($role . '.cms.*') || request()->routeIs($role . '.pricings.*') || request()->routeIs($role . '.gst.*') || request()->routeIs($role . '.notification.*') ? 'active-link open' : '' }}">
                <span class="sb-icon"><i class="fas fa-mobile-alt"></i></span>
                App Management
                <i class="fas fa-chevron-down sb-chevron"></i>
            </a>
            <div class="sb-submenu {{ request()->routeIs($role . '.support.*') || request()->routeIs($role . '.cms.*') || request()->routeIs($role . '.pricings.*') || request()->routeIs($role . '.gst.*') || request()->routeIs($role . '.notification.*') ? 'open' : '' }}" id="appMgmtSubmenu">
                @can('pricings.view')
                <a href="{{ route($role . '.pricings.index') }}"
                    class="sb-sub-link {{ request()->routeIs($role . '.pricings.*') ? 'active-sub' : '' }}">
                    <i class="fas fa-solar-panel"></i> Solar Pricing
                </a>
                @endcan

                @can('gst.view')
                <a href="{{ route($role . '.gst.index') }}"
                    class="sb-sub-link {{ request()->routeIs($role . '.gst.*') ? 'active-sub' : '' }}">
                    <i class="fas fa-percent"></i> GST Settings
                </a>
                @endcan

                <!-- @can('notification-settings.view')
                <a href="{{ route($role . '.notification.settings') }}"
                    class="sb-sub-link {{ request()->routeIs($role . '.notification.*') ? 'active-sub' : '' }}">
                    <i class="fas fa-bell"></i> Push Notifications
                </a>
                @endcan -->

                <a href="{{ route($role . '.support.index') }}"
                    class="sb-sub-link {{ request()->routeIs($role . '.support.*') ? 'active-sub' : '' }}">
                    <i class="fas fa-headset"></i> Support & FAQs
                </a>

                @can('cms.view')
                <a href="{{ route($role . '.cms.index') }}"
                    class="sb-sub-link {{ request()->routeIs($role . '.cms.*') ? 'active-sub' : '' }}">
                    <i class="fas fa-file-signature"></i> Legal Documents
                </a>
                @endcan
            </div>
        </div>
        @endif

        @if($role == 'admin')
        <span class="sb-section-label">System</span>

        @canany(['roles.view', 'permissions.view'])
        <div class="sb-item">
            <a href="javascript:void(0);" id="rolesMenuToggle"
               onclick="toggleSubmenu('rolesSubmenu','rolesMenuToggle')"
               class="sb-link {{ request()->routeIs($role . '.roles.*') || request()->routeIs($role . '.permissions.*') ? 'active-link open' : '' }}">
                <span class="sb-icon"><i class="fas fa-user-shield"></i></span>
                Roles & Permissions
                <i class="fas fa-chevron-down sb-chevron"></i>
            </a>
            <div class="sb-submenu {{ request()->routeIs($role . '.roles.*') || request()->routeIs($role . '.permissions.*') ? 'open' : '' }}" id="rolesSubmenu">
                @can('roles.view')
                <a href="{{ route($role . '.roles.index') }}"
                   class="sb-sub-link {{ request()->routeIs($role . '.roles.*') ? 'active-sub' : '' }}">
                    <i class="fas fa-user-tag"></i> Roles
                </a>
                @endcan
                @can('permissions.view')
                <a href="{{ route($role . '.permissions.index') }}"
                   class="sb-sub-link {{ request()->routeIs($role . '.permissions.*') ? 'active-sub' : '' }}">
                    <i class="fas fa-key"></i> Permissions
                </a>
                @endcan
            </div>
        </div>
        @endcanany
        @endif
        @endif

    </div>{{-- /sb-nav --}}

    {{-- ── LOGOUT FOOTER ────────────────────────────── --}}
    <div class="sb-footer">
        <a href="{{ route('logout') }}" class="sb-logout-btn"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <span class="sb-icon"><i class="fas fa-power-off"></i></span>
            Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </div>

</div>
<!-- Left Sidebar End -->

<script>
function toggleSubmenu(submenuId, toggleId) {
    const submenu = document.getElementById(submenuId);
    const toggle  = document.getElementById(toggleId);
    const isOpen  = submenu.classList.contains('open');

    // Close all
    document.querySelectorAll('.sb-submenu.open').forEach(s => s.classList.remove('open'));
    document.querySelectorAll('.sb-link.open').forEach(t => t.classList.remove('open'));

    if (!isOpen) {
        submenu.classList.add('open');
        toggle.classList.add('open');
    }
}

// Keep open on active route
document.addEventListener('DOMContentLoaded', function () {
    const activeLinks = document.querySelectorAll('.sb-link.active-link');
    activeLinks.forEach(link => {
        const submenuId = link.getAttribute('onclick');
        if (submenuId) link.classList.add('open');
    });
});
</script>
