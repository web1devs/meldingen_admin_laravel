@include('Admin.includes.head')
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition sidebar-mini">
<div class="wrapper">


    @if(\Illuminate\Support\Facades\Auth::check())

    @include('Admin.includes.navbar')
    @include('Admin.includes.sidebar')

    @endif

        @yield('content')


    <!-- Main Footer -->
{{--        @if(\Illuminate\Support\Facades\Auth::check())--}}
{{--            @include('Admin.includes.footer')--}}

{{--        @endif--}}
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

  @include('Admin.includes.scripts')
</body>
</html>
