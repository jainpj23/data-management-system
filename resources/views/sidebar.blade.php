<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ url('/home') }}" class="brand-link">
    <img src="{{ asset('public/assets/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">DMS</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('public/assets/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Name : {{auth()->user()->first_name.' '.auth()->user()->last_name}} <br>
          Role : {{ Auth::user()->roles->pluck('name')[0] }}
         </a>
      </div>
    </div>

   
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

       <li class="nav-item">
        <a href="{{ url('/home') }}" class="nav-link">
          <i class="nav-icon far fa-circle text-info"></i>
          <p>Dashboard</p>
        </a>
      </li>

      @if(auth()->user()->can('role-list'))

       <li class="nav-item">
        <a href="{{ route('roles.index') }}" class="nav-link">
          <i class="nav-icon far fa-circle text-info"></i>
          <p>Roles</p>
        </a>
      </li>
      @endif

      @if(auth()->user()->can('user-list'))

       <li class="nav-item">
        <a href="{{ route('users.index') }}" class="nav-link">
          <i class="nav-icon far fa-circle text-info"></i>
          <p>Users</p>
        </a>
      </li>
      @endif
      

      @if(auth()->user()->can('category-list'))
       <li class="nav-item">
        <a href="{{ route('category.index') }}" class="nav-link">
          <i class="nav-icon far fa-circle text-info"></i>
          <p>Category</p>
        </a>
      </li>
      @endif
      
      @if(auth()->user()->can('product-list'))
      <li class="nav-item">
        <a href="{{ route('products.index') }}" class="nav-link">
          <i class="nav-icon far fa-circle text-info"></i>
          <p>Products</p>
        </a>
      </li>
     @endif


      <li class="nav-item">
        <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();document.getElementById('logout-form').submit();">               
          <i class="nav-icon far fa-circle text-danger"></i>
          <p>Logout</p>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </li>

    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>
