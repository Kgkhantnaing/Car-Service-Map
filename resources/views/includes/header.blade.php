@inject('request', 'Illuminate\Http\Request')
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/home">
        <div class="sidebar-brand-icon">
            <img src="/img/logo.jpg" width="56px" height="56px" alt="logo" class="shadow-sm rounded-circle">
        </div>
        <div class="sidebar-brand-text mx-3">Indicator APP</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ $request->segment(1) == 'home' ? 'active' : '' }}">
        <a class="nav-link" href="/home">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Operation
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>User</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" >
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">User Components:</h6>
                <a class="collapse-item" href="/admin/users">All Users</a>
                <a class="collapse-item" href="/admin/users/create">New User</a>
            </div>
        </div>
    </li> -->

    <!-- Nav Item - Category Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategory" aria-expanded="true">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Category</span>
        </a>
        <div id="collapseCategory" class="collapse" aria-labelledby="headingUtilities">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Utilities:</h6>
                <a class="collapse-item" href="/categories">WorkShop Category</a>
                <a class="collapse-item" href="/city-categories">City Category</a>
            </div>
        </div>
    </li>

    <li class="nav-item {{ $request->segment(1) == 'emergency_contact' ? 'active' : '' }}">
        <a class="nav-link" href="/emergency_contact">
        <i class="fas fa-fw fa-ambulance"></i>
            <span>Emergency Contact</span>
        </a>
    </li>

    <!-- Nav Item - Shop Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseShop" aria-expanded="true" aria-controls="collapseShop">
            <i class="fas fa-fw fa-shopping-bag"></i>
            <span>Shop</span>
        </a>
        <div id="collapseShop" class="collapse" aria-labelledby="headingUtilities">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Shop</h6>
                <a class="collapse-item" href="/shops">All Shop</a>
                <a class="collapse-item" href="/shops/create">New Shop</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Shop Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePinCode" aria-expanded="true" aria-controls="collapsePinCode">
            <i class="fas fa-fw fa-code"></i>
            <span>Pin Code</span>
        </a>
        <div id="collapsePinCode" class="collapse" aria-labelledby="headingUtilities">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pin Code</h6>
                <a class="collapse-item" href="/pincodes">All Pin Codes</a>
                <a class="collapse-item" href="/pincodes/create">New Pin Codes</a>
            </div>
        </div>
    </li>

    <?php

    use App\Customer;
    $newCus = 0;
    if(session()->get('currentTime') != null){
        $newCus = Customer::where('created_at', '>', session()->get('currentTime'))->get()->count();
    }

    ?>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCustomer" aria-expanded="true" aria-controls="collapseCustomer">
            <i class="fas fa-fw fa-user"></i>
            <span>Customers</span><span style="margin-left:1em" class="badge badge-light">{{ $newCus }}</span>
        </a>
        <div id="collapseCustomer" class="collapse" aria-labelledby="headingUtilities">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Customer</h6>
                <a class="collapse-item" href="/customers">All Customers</a>
                <a class="collapse-item" href="/customers/create">New Customer</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFeedback" aria-expanded="true" aria-controls="collapseFeedback">
            <i class="fas fa-fw fa-user"></i>
            <span>Feedbacks</span>
        </a>
        <div id="collapseFeedback" class="collapse" aria-labelledby="headingUtilities">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Feedbacks</h6>
                <a class="collapse-item" href="/feedbacks">All Feedbacks</a>
                <!-- <a class="collapse-item" href="/customers/create">New Customer</a> -->
            </div>
        </div>
    </li>


    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdmin" aria-expanded="true" aria-controls="collapseAdmin">
            <i class="fas fa-fw fa-users"></i>
            <span>Admins</span>
        </a>
        <div id="collapseAdmin" class="collapse" aria-labelledby="headingUtilities">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Admin</h6>
                <a class="collapse-item" href="/admins">All Admins</a>
                <a class="collapse-item" href="/admins/create">New Admin</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="/customers/noti">
        <i class="fas fa-fw fa-bell"></i>
            <span>Push Notification</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/customer/history">
        <i class="fas fa-fw fa-list"></i>
            <span>Customer History</span>
        </a>
    </li>


    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePin" aria-expanded="true" aria-controls="collapsePin">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Pin</span>
        </a>
        <div id="collapsePin" class="collapse" aria-labelledby="headingUtilities" >
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pin</h6>
                <a class="collapse-item" href="/admin/pins">All Pin</a>
                <a class="collapse-item" href="/admin/pins/create">New Pin</a>
            </div>
        </div>
    </li> -->

    <!-- Divider -->
    <hr class="sidebar-divider">





</ul>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<!-- <div id="content-wrapper" class="d-flex flex-column">

  <div id="content">

    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
      </button>
      <ul class="navbar-nav ml-auto">
        <div class="topbar-divider d-none d-sm-block"></div>

        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
            <img class="img-profile rounded-circle" src="https://scontent.frgn5-1.fna.fbcdn.net/v/t1.0-9/46486360_780659548933071_551104575352864768_o.jpg?_nc_cat=107&_nc_oc=AQmku0x6uYqKia9bREzeFQfee0AZc96RTzDbvsiRPoeMxoPGO4AFYGRrAisArsrzpbk&_nc_ht=scontent.frgn5-1.fna&oh=3b08d2152f1aebc5d634632d2085c4c0&oe=5E1863D5">
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="#">
              <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
              Profile
            </a>
            <a class="dropdown-item" href="#">
              <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
              Settings
            </a>
            <a class="dropdown-item" href="#">
              <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
              Activity Log
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
              Logout
            </a>
          </div>
        </li>

      </ul>

    </nav>
  </div>
</div> -->