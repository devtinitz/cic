<div class="account-box is-navigation">
    <div class="account-menu">
        
        
        <a href="{{route('espaces.create')}}" class="account-menu-item {{request()->routeIs('espaces.create') ? 'is-active' : ''}}">
            <i class="lnil lnil-layout-alt-2"></i>
            <span>Ajouter un espace</span>
            <span class="end">
                <i aria-hidden="true" class="fas fa-arrow-right"></i>
            </span>
        </a>
        <a href="{{route('espaces.index')}}" class="account-menu-item {{request()->routeIs('espaces.index') ? 'is-active' : ''}}">
            <i class="lnil lnil-layout-alt-2"></i>
            <span>Liste des espaces</span>
            <span class="end">
                <i aria-hidden="true" class="fas fa-arrow-right"></i>
            </span>
        </a>
		
		<a href="{{route('users.index')}}" class="account-menu-item {{request()->routeIs('users.index') ? 'is-active' : ''}}" >
            <i class="lnil lnil-users"></i>
            <span>Liste des utilisateurs</span>
            <span class="end">
                <i aria-hidden="true" class="fas fa-arrow-right"></i>
            </span>
        </a>
        
        <a href="{{route('users.create')}}" class="account-menu-item {{request()->routeIs('users.create') ? 'is-active' : ''}}" >
            <i class="lnil lnil-users"></i>
            <span>Ajouter un utilisateur</span>
            <span class="end">
                <i aria-hidden="true" class="fas fa-arrow-right"></i>
            </span>
        </a>
    </div>
</div>