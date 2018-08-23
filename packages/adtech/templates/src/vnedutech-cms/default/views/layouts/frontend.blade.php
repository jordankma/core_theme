<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>
        @section('title')
            | {{ (!empty($SETTING['title'])) ? $SETTING['title'] : 'VNEdutech CMS' }}
        @show
    </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="icon" href="{{ (!empty($SETTING['favicon'])) ? asset($SETTING['favicon']) : '' }}" type="image/png" sizes="32x32">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{ asset('/js/html5shiv.js?t=').time() }}"></script>
    <script src="{{ asset('/js/respond.min.js?t=').time() }}"></script>
    <![endif]-->

    {{--CSRF Token--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- global css -->
    <link rel="stylesheet" href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/app.css?t=' . time()) }}"/>
    <link rel="stylesheet" href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/global.css?t=' . time()) }}"/>
    <!-- end of global css -->

    <!--page css-->
    @yield('header_styles')
    <!--end of page css-->

<body class="skin-josh">
<header class="header">
    <a href="/" class="logo">
        <img src="{{ (empty($SETTING['logo_mini'])) ? '' : asset($SETTING['logo_mini']) }}" alt="logo" style="height: 35px; max-width: 200px; margin-top: 10px">
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        {{--<div>--}}
            {{--<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">--}}
                {{--<div class="responsive_nav"></div>--}}
            {{--</a>--}}
        {{--</div>--}}

        <div class="navbar-right">
            <ul class="nav navbar-nav">
                {{--@include('includes._messages')--}}
                {{--@include('includes._notifications')--}}
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{!! asset('/vendor/' . $group_name . '/' . $skin . '/images/authors/no_avatar.jpg') !!}" alt="img" height="35px" width="35px"
                                 class="img-circle img-responsive pull-left"/>
                        <div class="riot">
                            <div>
                                <p class="user_name_max">{{ ($USER_LOGGED) ? $USER_LOGGED->name : 'Guest' }}</p>
                                <span>
                                    <i class="caret"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                            <img src="{!! asset('/vendor/' . $group_name . '/' . $skin . '/images/authors/no_avatar.jpg') !!}" alt="img" height="35px" width="35px"
                                 class="img-circle img-responsive pull-left"/>
                        </li>
                        <!-- Menu Body -->
                        {{--<li>--}}
                            {{--<a href="#">--}}
                                {{--<i class="livicon" data-name="user" data-s="18"></i>--}}
                                {{--My Profile--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li role="presentation"></li>--}}
                        {{--<li>--}}
                            {{--<a href="#">--}}
                                {{--<i class="livicon" data-name="gears" data-s="18"></i>--}}
                                {{--Account Settings--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            {{--<div class="pull-left">--}}
                                {{--<a href="{{ URL::route('adtech.core.auth.logout',$USER_LOGGED_ID) }}">--}}
                                    {{--<i class="livicon" data-name="lock" data-size="16" data-c="#555555" data-hc="#555555" data-loop="true"></i>--}}
                                    {{--Lock--}}
                                {{--</a>--}}
                            {{--</div>--}}
                            <div class="pull-right">
                                <a href="{{ URL::route('dhcd.member.auth.logout') }}">
                                    <i class="livicon" data-name="sign-out" data-s="15"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        {{--@include('includes._menu_top')--}}
    </nav>
</header>
<div class="wrapper ">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side ">
        <section class="sidebar ">
            <div class="page-sidebar  sidebar-nav">
                <!-- BEGIN SIDEBAR MENU -->
                @include('includes.frontend._left_menu')
                <!-- END SIDEBAR MENU -->
            </div>
        </section>
    </aside>
    <aside class="right-side">

        <!-- Notifications -->
        <div id="notific">
        @include('includes.notifications')
        </div>

        <!-- Content -->
        @yield('content')

    </aside>
    <!-- right-side -->
</div>
<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top"
   data-toggle="tooltip" data-placement="left">
    <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
</a>
<!-- global js -->
<script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/js/app.js?t=').time() }}"></script>
<!-- end of global js -->
<!-- begin page level js -->
@yield('footer_scripts')
@yield('footer_scripts_more')
<!-- end page level js -->
</body>
</html>
