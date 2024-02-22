<!-- Sidebar Menu -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{asset('assets/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{config('app.name')}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('assets/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            @auth
            <div class="info">
                <a href="{{route('dashboard.profile.edit')}}" class="d-block">{{Auth::user()->name}}</a>
            </div>
            @endauth
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->
                @foreach ($items as $key=>$item )
                {{-- @can($item['ability'])      --}}
                <li class="nav-item">
                    <a href="{{route($item['route'])}}" class="nav-link {{Route::is($item['active'])==$active?'active':''}}">
                        <i class="{{$item['icon']}}"></i>
                        <p>
                            {{$item['title']}}
                            @if(isset($item['badge']))
                            <span class="right badge badge-danger">{{$item['badge']}}</span>
                            @endif
                        </p>
                    </a>
                    {{-- @endcan        --}}
                </li>
                @endforeach
                {{-- @for ($i=0;$i<count($items);$i++) <li class="nav-item">
                    <a href="{{route($items[$i]['route'])}}" class="nav-link">
                        <i class="{{$items[$i]['icon']}}"></i>
                        <p>
                            {{$items[$i]['title']}}
                            <span class="right badge badge-danger">New</span>
                        </p>
                    </a>
                    </li>
                @endfor --}}

            </ul>
        </nav>
    </div>
</aside>
<!-- /.sidebar-menu -->
