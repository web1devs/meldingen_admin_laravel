<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">

        <span class="brand-text font-weight-light">Meldingen NL</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{!\Illuminate\Support\Facades\Auth::user()->profile_pic ? "https://p.kindpng.com/picc/s/78-786207_user-avatar-png-user-avatar-icon-png-transparent.png": \Illuminate\Support\Facades\Auth::user()->profile_pic}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{\Illuminate\Support\Facades\Auth::user()->name}}</a>
            </div>
        </div>



        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->








                <li class="nav-item">
                    <a href="/meldingen" class="nav-link {{Request::segment(1) === 'meldingen' ? 'active':''}} ">

                        <p>Meldingen</p>
                    </a>
                </li>
{{--                <li class="nav-item">--}}
{{--                    <a href="/category" class="nav-link {{Request::segment(1) === 'category' ? 'active':''}} ">--}}

{{--                        <p>Category</p>--}}
{{--                    </a>--}}
{{--                </li>--}}

{{--                <li class="nav-item">--}}
{{--                    <a href="/regio" class="nav-link {{Request::segment(1) === 'regio' ? 'active':''}} ">--}}

{{--                        <p>Regio</p>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a href="/provincie" class="nav-link {{Request::segment(1) === 'provincie' ? 'active':''}} ">--}}

{{--                        <p>Provincie</p>--}}
{{--                    </a>--}}
{{--                </li>--}}

                <li class="nav-item">
                    <a href="/blog-category" class="nav-link {{Request::segment(1) === 'blog-category' ? 'active':''}} ">

                        <p>Blog Category</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/blogs" class="nav-link {{Request::segment(1) === 'blogs' ? 'active':''}} ">

                        <p>Blogs</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/nieuws" class="nav-link {{Request::segment(1) === 'nieuws' ? 'active':''}} ">

                        <p>Nieuws</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/comments" class="nav-link {{Request::segment(1) === 'comments' ? 'active':''}} ">

                        <p>Nieuws comments</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/partner-blogs" class="nav-link {{Request::segment(1) === 'partner-blogs' ? 'active':''}} ">

                        <p>Partner Blogs</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/seo-data" class="nav-link {{Request::segment(1) === 'seo-data' ? 'active':''}} ">

                        <p>SEO Data</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/dictionary" class="nav-link {{Request::segment(1) === 'dictionary' ? 'active':''}} ">

                        <p>Dictionary</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/ads" class="nav-link {{Request::segment(1) === 'ads' ? 'active':''}} ">

                        <p>ADS</p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="/user" class="nav-link {{Request::segment(1) === 'user' ? 'active':''}} ">

                        <p>User</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/privacybeleid" class="nav-link {{Request::segment(1) === 'privacybeleid' ? 'active':''}} ">

                        <p>Privacybeleid</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/cookiebeleid" class="nav-link {{Request::segment(1) === 'cookiebeleid' ? 'active':''}} ">

                        <p>Cookiebeleid</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/logout" class="nav-link">

                        <p>Logout</p>
                    </a>
                </li>





            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
