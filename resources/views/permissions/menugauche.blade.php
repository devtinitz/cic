<div class="account-box is-navigation">
    <div class="account-menu">
        <a href="{{route('permissions.create')}}" class="account-menu-item {{request()->routeIs('permissions.create') ? 'is-active' : ''}}" >
            <i class="lnil lnil-users"></i>
            <span>Ajouter une permission</span>
            <span class="end">
                <i aria-hidden="true" class="fas fa-arrow-right"></i>
            </span>
        </a>
        <a href="{{route('permissions.index')}}" class="account-menu-item {{request()->routeIs('permissions.index') ? 'is-active' : ''}}" >
            <i class="lnil lnil-list-alt"></i>

            <span>Liste des permissions</span>
            <span class="end">
                <i aria-hidden="true" class="fas fa-arrow-right"></i>
            </span>
        </a>

    </div>
</div>
