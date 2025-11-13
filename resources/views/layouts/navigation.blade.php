<style>
    .modern-navbar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
        position: sticky;
        top: 0;
        z-index: 1000;
    }
    
    .navbar-container {
        max-width: 1800px;
        margin: 0 auto;
        padding: 0 2rem;
    }
    
    .navbar-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 70px;
    }
    
    .navbar-brand {
        display: flex;
        align-items: center;
        gap: 1rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .navbar-brand:hover {
        transform: scale(1.05);
    }
    
    .brand-logo {
        width: 45px;
        height: 45px;
        background: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 800;
        color: #667eea;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .brand-text {
        color: white;
        font-size: 1.5rem;
        font-weight: 800;
        letter-spacing: -0.5px;
    }
    
    .navbar-links {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .nav-link {
        color: white;
        text-decoration: none;
        padding: 0.6rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
    }
    
    .nav-link:hover {
        background: rgba(255,255,255,0.25);
        transform: translateY(-2px);
    }
    
    .nav-link.active {
        background: white;
        color: #667eea;
    }
    
    .user-menu {
        position: relative;
    }
    
    .user-button {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255,255,255,0.3);
        padding: 0.5rem 1.25rem;
        border-radius: 50px;
        color: white;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .user-button:hover {
        background: rgba(255,255,255,0.3);
        border-color: rgba(255,255,255,0.5);
        transform: translateY(-2px);
    }
    
    .user-avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #667eea;
        font-size: 0.9rem;
    }
    
    .dropdown-menu {
        position: absolute;
        top: calc(100% + 0.5rem);
        right: 0;
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        min-width: 220px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s ease;
        z-index: 1050;
        display: block !important;
    }
    
    .user-menu.open .dropdown-menu,
    .user-menu[data-open="true"] .dropdown-menu,
    .dropdown-menu.show {
        opacity: 1 !important;
        visibility: visible !important;
        transform: translateY(0) !important;
    }
    
    .dropdown-header {
        padding: 1.25rem;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .dropdown-name {
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 0.25rem;
    }
    
    .dropdown-email {
        font-size: 0.85rem;
        color: #8b92a7;
    }
    
    .dropdown-item {
        display: flex !important;
        align-items: center;
        gap: 0.75rem;
        padding: 0.875rem 1.25rem;
        color: #2d3748;
        text-decoration: none;
        transition: all 0.2s ease;
        font-weight: 500;
        cursor: pointer;
        width: 100%;
        text-align: left;
    }
    
    .dropdown-item:hover {
        background: #f8f9ff;
        color: #667eea;
    }
    
    .dropdown-item i {
        font-size: 1.1rem;
        width: 20px;
    }
    
    .dropdown-item.logout-btn {
        color: #dc3545;
    }
    
    .dropdown-item.logout-btn:hover {
        background: #fff5f5;
        color: #c82333;
    }
    
    .dropdown-divider {
        height: 1px;
        background: #f0f0f0;
        margin: 0.5rem 0;
    }
    
    .mobile-menu-button {
        display: none;
        background: rgba(255,255,255,0.2);
        border: 2px solid rgba(255,255,255,0.3);
        color: white;
        padding: 0.5rem;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .mobile-menu-button:hover {
        background: rgba(255,255,255,0.3);
    }
    
    .mobile-menu {
        display: none;
        background: white;
        border-top: 1px solid rgba(255,255,255,0.2);
        padding: 1rem;
    }
    
    .mobile-menu.open {
        display: block;
    }
    
    .mobile-nav-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.875rem 1rem;
        color: #2d3748;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 500;
        margin-bottom: 0.5rem;
        transition: all 0.2s ease;
    }
    
    .mobile-nav-link:hover {
        background: #f8f9ff;
        color: #667eea;
    }
    
    .mobile-nav-link.active {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }
    
    @media (max-width: 768px) {
        .navbar-links {
            display: none;
        }
        .mobile-menu-button {
            display: block;
        }
        .navbar-container {
            padding: 0 1rem;
        }
        .brand-text {
            font-size: 1.2rem;
        }
    }
</style>

<nav class="modern-navbar" x-data="{ open: false, userMenuOpen: false }">
    <div class="navbar-container">
        <div class="navbar-content">
            <!-- Brand -->
            <a href="{{ route('dashboard') }}" class="navbar-brand">
                <div class="brand-logo">
                    🚀
                </div>
                <span class="brand-text">JobTracker</span>
            </a>

            <!-- Desktop Navigation -->
            <div class="navbar-links">
                <a href="{{ route('dashboard') }}" 
                   class="nav-link {{ request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') || request()->routeIs('team.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    Dashboard
                </a>
                
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.earnings.index') }}" 
                       class="nav-link {{ request()->routeIs('admin.earnings.*') ? 'active' : '' }}">
                        <i class="bi bi-graph-up-arrow"></i>
                        Earnings
                    </a>
                @else
                    <a href="{{ route('team.earnings.index') }}" 
                       class="nav-link {{ request()->routeIs('team.earnings.*') ? 'active' : '' }}">
                        <i class="bi bi-cash-coin"></i>
                        My Earnings
                    </a>
                @endif
                
                <!-- User Menu -->
                <div class="user-menu" @click.away="userMenuOpen = false" id="userMenuContainer">
                    <button type="button" @click="userMenuOpen = !userMenuOpen" class="user-button" id="userMenuButton">
                        @if(Auth::user()->profile_picture)
                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" 
                                 alt="{{ Auth::user()->name }}" 
                                 class="user-avatar"
                                 style="object-fit: cover;">
                        @else
                            <div class="user-avatar">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                        @endif
                        <span>{{ Auth::user()->name }}</span>
                        <i class="bi bi-chevron-down" id="userMenuChevron" :class="{'rotate-180': userMenuOpen}" style="transition: transform 0.2s;"></i>
                    </button>
                    
                    <div class="dropdown-menu" :class="{'open': userMenuOpen}" id="userDropdownMenu">
                        <div class="dropdown-header">
                            <div class="dropdown-name">{{ Auth::user()->name }}</div>
                            <div class="dropdown-email">{{ Auth::user()->email }}</div>
                        </div>
                        
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <i class="bi bi-person-circle"></i>
                            Profile Settings
                        </a>
                        
                        <div class="dropdown-divider"></div>
                        
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" class="dropdown-item logout-btn" style="border: none; background: none; padding: 0.875rem 1.25rem;">
                                <i class="bi bi-box-arrow-right"></i>
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <button type="button" @click="open = !open" class="mobile-menu-button" id="mobileMenuButton">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path :class="{'hidden': open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': !open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu" :class="{'open': open}">
        <a href="{{ route('dashboard') }}" 
           class="mobile-nav-link {{ request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') || request()->routeIs('team.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            Dashboard
        </a>
        
        @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.earnings.index') }}" 
               class="mobile-nav-link {{ request()->routeIs('admin.earnings.*') ? 'active' : '' }}">
                <i class="bi bi-graph-up-arrow"></i>
                Earnings
            </a>
        @else
            <a href="{{ route('team.earnings.index') }}" 
               class="mobile-nav-link {{ request()->routeIs('team.earnings.*') ? 'active' : '' }}">
                <i class="bi bi-cash-coin"></i>
                My Earnings
            </a>
        @endif
        
        <div class="dropdown-divider"></div>
        
        <div class="px-3 py-2">
            <div class="font-weight-bold text-dark">{{ Auth::user()->name }}</div>
            <div class="small text-muted">{{ Auth::user()->email }}</div>
        </div>
        
        <a href="{{ route('profile.edit') }}" class="mobile-nav-link">
            <i class="bi bi-person-circle"></i>
            Profile Settings
        </a>
        
        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
            @csrf
            <button type="submit" class="mobile-nav-link" style="border: none; background: none; width: 100%; text-align: left; color: #dc3545;">
                <i class="bi bi-box-arrow-right"></i>
                Log Out
            </button>
        </form>
    </div>
</nav>

<script>
    // Pure JavaScript dropdown handler (works immediately, doesn't wait for Alpine)
    document.addEventListener('DOMContentLoaded', function() {
        const userMenuContainer = document.getElementById('userMenuContainer');
        const userMenuButton = document.getElementById('userMenuButton');
        const userDropdownMenu = document.getElementById('userDropdownMenu');
        const userMenuChevron = document.getElementById('userMenuChevron');
        
        if (!userMenuButton || !userMenuContainer || !userDropdownMenu) {
            console.error('User menu elements not found');
            return;
        }
        
        let isOpen = false;
        
        // Toggle dropdown
        userMenuButton.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            isOpen = !isOpen;
            
            console.log('Dropdown toggled:', isOpen);
            
            if (isOpen) {
                userMenuContainer.classList.add('open');
                userMenuContainer.setAttribute('data-open', 'true');
                userDropdownMenu.classList.add('show');
                if (userMenuChevron) {
                    userMenuChevron.style.transform = 'rotate(180deg)';
                }
            } else {
                userMenuContainer.classList.remove('open');
                userMenuContainer.removeAttribute('data-open');
                userDropdownMenu.classList.remove('show');
                if (userMenuChevron) {
                    userMenuChevron.style.transform = 'rotate(0deg)';
                }
            }
        });
        
        // Close when clicking outside
        document.addEventListener('click', function(e) {
            if (!userMenuContainer.contains(e.target) && isOpen) {
                isOpen = false;
                userMenuContainer.classList.remove('open');
                userMenuContainer.removeAttribute('data-open');
                userDropdownMenu.classList.remove('show');
                if (userMenuChevron) {
                    userMenuChevron.style.transform = 'rotate(0deg)';
                }
            }
        });
        
        // Mobile menu toggle
        const mobileMenuButton = document.querySelector('.mobile-menu-button');
        const mobileMenu = document.querySelector('.mobile-menu');
        
        if (mobileMenuButton && mobileMenu) {
            let mobileOpen = false;
            
            mobileMenuButton.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                mobileOpen = !mobileOpen;
                
                if (mobileOpen) {
                    mobileMenu.classList.add('open');
                } else {
                    mobileMenu.classList.remove('open');
                }
            });
        }
        
        console.log('Navbar dropdown initialized successfully');
    });
</script>
