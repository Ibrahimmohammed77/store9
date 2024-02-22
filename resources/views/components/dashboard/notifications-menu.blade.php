<!-- Notifications Dropdown Menu -->
<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        @if ($newCount)
        <span class="badge badge-warning navbar-badge">{{$newCount}}</span>
    </a>
    @endif
    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
        <span class="dropdown-header">{{$newCount}} Notifications</span>
        <div class="dropdown-divider"></div>
        
        @foreach ($notifications as $notification )
        <a href="{{$notification->data['url']}}?notification_id={{$notification->id}}" class="dropdown-item
            @if($notification->unread())  text-bold      @endif ">
            <i class="fas {{ $notification->data['icon']}} mr-2"></i>
           
                 {{ $notification->data['body']}}
            {{-- Created At Like Carbon --}}
            {{-- <span class="float-right text-muted text-sm">{{ $notification->created_at->diffForHumans()}}</span> --}} {{--  3 minutes ago --}}
            {{-- <span class="float-right text-muted text-sm">{{ $notification->created_at->longAbsoluteDiffForHumans()}}</span> --}} {{--  3 minutes  --}}
            <span class="float-right text-muted text-sm">{{ $notification->created_at->diffForHumans()}}</span>{{--  3 min --}}
        </a>
        <div class="dropdown-divider"></div>
        @endforeach
        {{-- <div class="dropdown-divider"></div> --}}
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
    </div>
</li>
<!-- Notifications Dropdown Menu -->
{{-- <li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge">15</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header">15 Notifications</span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
    </div>
</li> --}}
