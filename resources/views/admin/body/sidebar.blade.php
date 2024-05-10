<nav class="sidebar barr">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            Goo<span>Lancer</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
                <a href="{{route('admin.dashboard')}}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item nav-category">User Management</li>
            {{-- <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#emails" role="button" aria-expanded="false"
                    aria-controls="emails">
                    <i class="link-icon" data-feather="mail"></i>
                    <span class="link-title">Email</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="emails">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="pages/email/inbox.html" class="nav-link">Inbox</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/email/read.html" class="nav-link">Read</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/email/compose.html" class="nav-link">Compose</a>
                        </li>
                    </ul>
                </div>
            </li> --}}
            <li class="nav-item">
                <a href="{{route('admin.userAccountInfo')}}" class="nav-link">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="link-title">User Account</span>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a href="pages/apps/calendar.html" class="nav-link">
                    <i class="link-icon" data-feather="calendar"></i>
                    <span class="link-title">Calendar</span>
                </a>
            </li> --}}
            <li class="nav-item nav-category">Main</li>

            {{-- Approval --}}
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI" role="button"
                    aria-expanded="false" aria-controls="advancedUI">
                    <i class="link-icon" data-feather="check-circle"></i>
                    <span class="link-title">Approval</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="advancedUI">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{route('admin.approval.service_approval')}}" class="nav-link">Service</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.approval.certificate_approval')}}" class="nav-link">Certificate</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.approval.post_approval')}}" class="nav-link">Post</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.approval.payment_approval')}}" class="nav-link">Order Payment</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a href="pages/apps/chat.html" class="nav-link">
                    <i class="link-icon" data-feather="dollar-sign"></i>
                    <span class="link-title">Transaction History</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="pages/apps/chat.html" class="nav-link">
                    <i class="link-icon" data-feather="dollar-sign"></i>
                    <span class="link-title">Refund</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{route('admin.viewAllServiceInfo')}}" class="nav-link">
                    <i class="link-icon" data-feather="briefcase"></i>
                    <span class="link-title">Services</span>
                </a>
            </li>



            <li class="nav-item">
                <a href="{{route('admin.viewAllPostsInfo')}}" class="nav-link">
                    <i class="link-icon" data-feather="image"></i>
                    <span class="link-title">Posts</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#forms" role="button" aria-expanded="false"
                    aria-controls="forms">
                    <i class="link-icon" data-feather="shopping-bag"></i>
                    <span class="link-title">Purchase Order</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>

                <div class="collapse" id="forms">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="pages/forms/basic-elements.html" class="nav-link">Requested</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/forms/advanced-elements.html" class="nav-link">Ongoing</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/forms/editors.html" class="nav-link">Delivered</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/forms/wizard.html" class="nav-link">Rejected</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item nav-category">Admin Extensions</li>
            <li class="nav-item">
                <a href="pages/apps/chat.html" class="nav-link">
                    <i class="link-icon" data-feather="file-text"></i>
                    <span class="link-title">Media Manager</span>
                </a>
            </li>

            {{-- <li class="nav-item nav-category">Docs</li>
            <li class="nav-item">
                <a href="https://www.nobleui.com/html/documentation/docs.html" target="_blank" class="nav-link">
                    <i class="link-icon" data-feather="hash"></i>
                    <span class="link-title">Documentation</span>
                </a>
            </li> --}}
        </ul>
    </div>
</nav>


