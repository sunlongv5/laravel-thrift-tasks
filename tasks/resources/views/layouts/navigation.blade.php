<nav class="navbar-default navbar-static-side" role="navigation">
  <div class="sidebar-collapse">
    <ul class="nav metismenu" id="side-menu">
      <li class="nav-header">
        <div class="feed-element profile-element">
          <a class="pull-left">
            <img alt="image" class="img-circle" src="{{ $header }}" onerror="this.src='/img/missing_face.png';" style="width:40px;"/>
          </a>
          <div class="media-body">
            <strong class="font-bold" style="color:#FFF" >{{ $username }}</strong>
            <div class="actions">
              <a href="{{ Config::get('website.login')['logout'].'?redirect='.URL::current() }}" style="margin-right:10px;"><i class="fa fa-sign-out"></i><span class="nav-label">切换账号</span></a>
              <a href="{{ Config::get('website.login')['logout'] }}"><i class="fa fa-sign-out"></i><span class="nav-label">退出</span></a>
            </div>
          </div>
        </div>
      </li>
      
      <?php echo App\Http\Controllers\createMenu($menus, $uri); ?>
    </ul>
  </div>
</nav>
