<div class="account-box is-navigation">
        <div class="account-menu">

            <a href="{{route('clients.index')}}" class="account-menu-item {{request()->routeIs('demandes.index') ? 'is-active' : ''}}">
                <i class="lnil lnil-menu-alt-3"></i>
                <span>Liste des clients</span>
                <span class="end">
                    <i aria-hidden="true" class="fas fa-arrow-right"></i>
                </span>
            </a>
			
			<a href="{{route('comptes.index')}}" class="account-menu-item {{request()->routeIs('demandes.index') ? 'is-active' : ''}}">
                <i class="lnil lnil-menu-alt-3"></i>
                <span>Liste des comptes</span>
                <span class="end">
                    <i aria-hidden="true" class="fas fa-arrow-right"></i>
                </span>
            </a>
			
			<a href="{{route('dossiers.index')}}" class="account-menu-item {{request()->routeIs('demandes.index') ? 'is-active' : ''}}">
                <i class="lnil lnil-menu-alt-3"></i>
                <span>Liste des dossiers</span>
                <span class="end">
                    <i aria-hidden="true" class="fas fa-arrow-right"></i>
                </span>
            </a>
			
			<a href="{{route('demandes.index')}}" class="account-menu-item {{request()->routeIs('demandes.index') ? 'is-active' : ''}}">
                <i class="lnil lnil-menu-alt-3"></i>
                <span>Liste des demandes de fonds</span>
                <span class="end">
                    <i aria-hidden="true" class="fas fa-arrow-right"></i>
                </span>
            </a>
			
			<a href="{{route('debours.index')}}" class="account-menu-item {{request()->routeIs('demandes.index') ? 'is-active' : ''}}">
                <i class="lnil lnil-menu-alt-3"></i>
                <span>Liste des debours</span>
                <span class="end">
                    <i aria-hidden="true" class="fas fa-arrow-right"></i>
                </span>
            </a>
            
        </div>
    </div>