<!-- Add icons to the links using the .nav-icon class
with font-awesome or any other icon font library -->
<li class="nav-header"></li>
<li class="nav-item">
  <a href="{{ aurl('') }}" class="nav-link {{ active_link(null,'active') }}">
    <i class="nav-icon fas fa-home"></i>
    <p>
      {{ trans('admin.dashboard') }}
    </p>
  </a>
</li>
@if(admin()->user()->role('settings_show'))
<li class="nav-item">
  <a href="{{ aurl('settings') }}" class="nav-link  {{ active_link('settings','active') }}">
    <i class="nav-icon fas fa-cogs"></i>
    <p>
      {{ trans('admin.settings') }}
    </p>
  </a>
</li>
@endif
@if(admin()->user()->role("admins_show"))
<li class="nav-item {{ active_link('admins','menu-open') }}">
  <a href="#" class="nav-link  {{ active_link('admins','active') }}">
    <i class="nav-icon fas fa-users"></i>
    <p>
      {{trans('admin.admins')}}
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{aurl('admins')}}" class="nav-link {{ active_link('admins','active') }}">
        <i class="fas fa-users nav-icon"></i>
        <p>{{trans('admin.admins')}}</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ aurl('admins/create') }}" class="nav-link">
        <i class="fas fa-plus nav-icon"></i>
        <p>{{trans('admin.create')}}</p>
      </a>
    </li>
  </ul>
</li>
@endif
@if(admin()->user()->role("admingroups_show"))
<li class="nav-item {{ active_link('admingroups','menu-open') }}">
  <a href="#" class="nav-link  {{ active_link('admingroups','active') }}">
    <i class="nav-icon fas fa-users"></i>
    <p>
      {{trans('admin.admingroups')}}
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{aurl('admingroups')}}" class="nav-link {{ active_link('admingroups','active') }}">
        <i class="fas fa-users nav-icon"></i>
        <p>{{trans('admin.admingroups')}}</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ aurl('admingroups/create') }}" class="nav-link ">
        <i class="fas fa-plus nav-icon"></i>
        <p>{{trans('admin.create')}}</p>
      </a>
    </li>
  </ul>
</li>
@endif
<!--categories_start_route-->
@if(admin()->user()->role("categories_show"))
<li class="nav-item {{active_link('categories','menu-open')}} ">
  <a href="#" class="nav-link {{active_link('categories','active')}}">
    <i class="nav-icon fa fa-icons"></i>
    <p>
      {{trans('admin.categories')}} 
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{aurl('categories')}}" class="nav-link  {{active_link('categories','active')}}">
        <i class="fa fa-icons nav-icon"></i>
        <p>{{trans('admin.categories')}} </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ aurl('categories/create') }}" class="nav-link">
        <i class="fas fa-plus nav-icon"></i>
        <p>{{trans('admin.create')}} </p>
      </a>
    </li>
  </ul>
</li>
@endif
<!--categories_end_route-->

<!--questions_start_route-->
@if(admin()->user()->role("questions_show"))
<li class="nav-item {{active_link('questions','menu-open')}} ">
  <a href="#" class="nav-link {{active_link('questions','active')}}">
    <i class="nav-icon fa fa-icons"></i>
    <p>
      {{trans('admin.questions')}} 
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{aurl('questions')}}" class="nav-link  {{active_link('questions','active')}}">
        <i class="fa fa-icons nav-icon"></i>
        <p>{{trans('admin.questions')}} </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ aurl('questions/create') }}" class="nav-link">
        <i class="fas fa-plus nav-icon"></i>
        <p>{{trans('admin.create')}} </p>
      </a>
    </li>
  </ul>
</li>
@endif
<!--questions_end_route-->

<!--player_start_route-->
@if(admin()->user()->role("player_show"))
<li class="nav-item {{active_link('player','menu-open')}} ">
  <a href="#" class="nav-link {{active_link('player','active')}}">
    <i class="nav-icon fa fa-icons"></i>
    <p>
      {{trans('admin.player')}} 
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{aurl('player')}}" class="nav-link  {{active_link('player','active')}}">
        <i class="fa fa-icons nav-icon"></i>
        <p>{{trans('admin.player')}} </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ aurl('player/create') }}" class="nav-link">
        <i class="fas fa-plus nav-icon"></i>
        <p>{{trans('admin.create')}} </p>
      </a>
    </li>
  </ul>
</li>
@endif
<!--player_end_route-->

<!--online_start_route-->
@if(admin()->user()->role("online_show"))
<li class="nav-item {{active_link('online','menu-open')}} ">
  <a href="#" class="nav-link {{active_link('online','active')}}">
    <i class="nav-icon fa fa-icons"></i>
    <p>
      {{trans('admin.online')}} 
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{aurl('online')}}" class="nav-link  {{active_link('online','active')}}">
        <i class="fa fa-icons nav-icon"></i>
        <p>{{trans('admin.online')}} </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ aurl('online/create') }}" class="nav-link">
        <i class="fas fa-plus nav-icon"></i>
        <p>{{trans('admin.create')}} </p>
      </a>
    </li>
  </ul>
</li>
@endif
<!--online_end_route-->

<!--games_start_route-->
@if(admin()->user()->role("games_show"))
<li class="nav-item {{active_link('games','menu-open')}} ">
  <a href="#" class="nav-link {{active_link('games','active')}}">
    <i class="nav-icon fa fa-icons"></i>
    <p>
      {{trans('admin.games')}} 
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{aurl('games')}}" class="nav-link  {{active_link('games','active')}}">
        <i class="fa fa-icons nav-icon"></i>
        <p>{{trans('admin.games')}} </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ aurl('games/create') }}" class="nav-link">
        <i class="fas fa-plus nav-icon"></i>
        <p>{{trans('admin.create')}} </p>
      </a>
    </li>
  </ul>
</li>
@endif
<!--games_end_route-->
