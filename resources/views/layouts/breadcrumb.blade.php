<!--Breadcrumb-->
<nav class="breadcrumb has-arrow-separator" aria-label="breadcrumbs">
    <ul>
        <li><a href="{{Auth::user()->espace_id == 2 && Auth::user()->role == 'admin' ? route('admin.dashboard') : '/'}}"><span>Tableau de bord</span></a></li>
        <li><a href="#"><span>{{ $section_title }}</span></a></li>
    </ul>
</nav>
