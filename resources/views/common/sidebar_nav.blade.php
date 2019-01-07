<div class="sidebar-inner scrollable-sidebar">
  <div class="size-toggle">
    <a class="btn btn-sm" id="sizeToggle">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a>
  </div><!-- /size-toggle -->
  <div class="user-block clearfix">
    <div class="detail">
      <strong>AAAS</strong>
    </div>
  </div><!-- /user-block -->
  <div class="main-menu">
    <ul>
      <li class="active">
        <a href="{{ route('home') }}">
          <span class="menu-icon">
            <i class="fa fa-desktop fa-lg"></i>
          </span>
          <span class="text">
            Dashboard
          </span>
          <span class="menu-hover"></span>
        </a>
      </li>

      <li class="active">
        <a href="{{ route('float_data.upload') }}" title="Upload Float File">
          <span class="menu-icon">
            <i class="fa fa-upload" aria-hidden="true"></i>
          </span>
          <span class="text">
            Upload Float File
          </span>
          <span class="menu-hover"></span>
        </a>
      </li>


      <li class="active">
        <a href="{{ route('hospital.index') }}">
          <span class="menu-icon">
            <i class="fa fa-desktop fa-lg"></i>
          </span>
          <span class="text">
            Hospital List
          </span>
          <span class="menu-hover"></span>
        </a>
      </li>
    </ul>
  </div><!-- /main-menu -->
</div><!-- /sidebar-inner -->
