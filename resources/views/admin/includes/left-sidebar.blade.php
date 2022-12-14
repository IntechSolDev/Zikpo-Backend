<!-- Sidebar -->
<ul class="sidebar navbar-nav">
    <li class="nav-item active">
        <a class="nav-link" href="{{url('/admin/')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('user.index')}}">
            <i class="fas fa-fw fa-users"></i>
            <span> Users </span></a>
    </li>
   <li class="nav-item">
        <a class="nav-link" href="{{route('expertise.index')}}">
            <i class="fas fa-fw fa-cogs"></i>
            <span> Expertise </span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('topic.index')}}">
            <i class="fas fa-fw fa-folder"></i>
            <span> Topic </span></a>
    </li>



</ul>
