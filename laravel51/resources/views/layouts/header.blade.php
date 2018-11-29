<!--header start-->
  <header class="header fixed-top clearfix">

    <!--logo start-->
    <div class="brand">
        <a href="/" class="logo">
            <img src="/static/images/gege_village.png" alt="" width="100px">
        </a>
        <div class="sidebar-toggle-box">
            <div class="fa fa-bars"></div>
        </div>
    </div>
    <!--logo end-->


    <div class="top-nav hidden-xs clearfix">
        <!--search & user info start-->
        <ul class="nav pull-right top-menu">

            <!-- user login dropdown start-->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <img alt="" src="/static/images/avatar1_small.jpg">
                    <span class="username">{{ auth()->user()->realname }}</span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <li><a href="/auth/password"><i class="fa fa-cog"></i> 修改密码</a></li>
                    <li><a href="/auth/logout"><i class="fa fa-sign-out"></i> 退出</a></li>
                </ul>
            </li>
            <!-- user login dropdown end -->

        </ul>
        <!--search & user info end-->
    </div>
</header>
<!--header end-->
