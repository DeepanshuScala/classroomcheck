<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-warning elevation-4">
    <!-- Brand Logo -->
    <a href="{{ URL('admin/dashboard')}}" class="brand-link">
        <span class="brand-text font-weight-light">{{ auth()->user()->first_name }} {{ auth()->user()->surname }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ URL('admin/dashboard')}}" class="nav-link {{ (request()->segment(2) == 'dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ URL('admin/users/buyers')}}" class="nav-link {{ (request()->segment(2) == 'users' || request()->segment(2) == 'transaction-history') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ URL('admin/member-management')}}" class="nav-link {{ (request()->segment(2) == 'member-management') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Member Management</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ URL('admin/product-management')}}" class="nav-link {{ (request()->segment(2) == 'product-management') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>Product Management</p>
                    </a>
                </li>
                <li class="nav-item">

                    <a href="{{ URL('admin/subject/list')}}" class="nav-link {{ (request()->segment(2) == 'subject') ||(request()->segment(2) == 'type') || (request()->segment(2) == 'grade') || (request()->segment(2) == 'resource') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>Category Management</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ URL('admin/promo/list')}}" class="nav-link {{ (request()->segment(2) == 'promo') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-gift"></i>
                        <p>Promotion Management</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/selleroffer')}}" class="nav-link {{ (request()->segment(2) == 'selleroffer') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-gift"></i>
                        <p>Seller Offer</p> 
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ URL('admin/content/list')}}" class="nav-link {{ (request()->segment(2) == 'content' && (request()->segment(3) == 'list' || request()->segment(3) == 'update-content')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th-list"></i>
                        <p>Content Management</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ URL('admin/content/testimonials')}}" class="nav-link {{ (request()->segment(2) == 'content' && (request()->segment(3) == 'testimonials'||request()->segment(3) == 'add-testimonial'||request()->segment(3) == 'update-testimonial')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th-list"></i>
                        <p>Testimonials Management</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ URL('admin/seller-percentages')}}" class="nav-link {{request()->segment(2) == 'seller-percentage' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th-list"></i>
                        <p>Sellers Percentage</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ URL('admin/seller-payouts')}}" class="nav-link {{request()->segment(2) == 'seller-payouts' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th-list"></i>
                        <p>Sellers Payout</p>
                    </a>
                </li>
                
                <li class="nav-item has-treeview  ">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-cog"></i>
                        <p>
                          Marketing<i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ URL('admin/seller-social-media-marketing')}}" class="nav-link {{ (request()->segment(2) == 'seller-social-media-marketing') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-user"></i>
                                <p>Social Media Marketing</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL('admin/newsletter')}}" class="nav-link {{ (request()->segment(2) == 'newsletter') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-newspaper"></i>
                                <p>Newsletter Submissions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL('admin/featured-listing')}}" class="nav-link {{ (request()->segment(2) == 'featured-listing') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-newspaper"></i>
                                <p>Featured Listings</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ URL('admin/issue-report')}}" class="nav-link {{ (request()->segment(2) == 'issue-report') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-question-circle"></i>
                        <p>Product Issues Reported</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{ URL('admin/suggest-a-resource')}}" class="nav-link {{ (request()->segment(2) == 'suggest-a-resource') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-question-circle"></i>
                        <p>Suggest a Resource</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{ URL('admin/faq/list')}}" class="nav-link {{ (request()->segment(2) == 'faq') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-question-circle"></i>
                        <p>FAQ</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ URL('admin/blog/list')}}" class="nav-link {{ (request()->segment(2) == 'blog') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-blog"></i>
                        <p>Blog</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ URL('admin/content/about-us')}}" class="nav-link {{ (request()->segment(3) == 'about-us') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-info"></i>
                        <p>About Us</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ URL('admin/feedbacks')}}" class="nav-link {{ (request()->segment(2) == 'feedbacks') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-info"></i>
                        <p>Contact Us</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a id="logoutUser" data-url="{{ URL('admin/logout') }}" style="cursor: pointer" class="nav-link {{ (request()->segment(2) == 'logout') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-key"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>