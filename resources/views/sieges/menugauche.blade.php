<div class="account-box is-navigation">
    <div class="account-menu">
        <a href="{{ route('sieges.create') }}" class="account-menu-item {{request()->routeIs('sieges.create') ? 'is-active' : ''}}" >
            <i class="lnil lnil-plus"></i>
            <span>Ajouter un siège</span>
            <span class="end">
                <i aria-hidden="true" class="fas fa-arrow-right"></i>
            </span>
        </a>
        <a href="{{route('sieges.index')}}" class="account-menu-item {{request()->routeIs('sieges.index') ? 'is-active' : ''}}" >
            <i class="lnil lnil-list-alt"></i>

            <span>Liste des sièges</span>
            <span class="end">
                <i aria-hidden="true" class="fas fa-arrow-right"></i>
            </span>
        </a>
        <a href="{{ route('agences.create') }}" class="account-menu-item {{request()->routeIs('agences.create') ? 'is-active' : ''}}" >
            <i class="lnil lnil-plus"></i>
            <span>Ajouter une agence</span>
            <span class="end">
                <i aria-hidden="true" class="fas fa-arrow-right"></i>
            </span>
        </a>
        <a href="{{route('agences.index')}}" class="account-menu-item {{request()->routeIs('agences.index') ? 'is-active' : ''}}" >
            <i class="lnil lnil-list-alt"></i>

            <span>Liste des agences</span>
            <span class="end">
                <i aria-hidden="true" class="fas fa-arrow-right"></i>
            </span>
        </a>
        <a href="{{ route('typepreavis.index') }}" class="account-menu-item {{request()->routeIs('typepreavis.index') ? 'is-active' : ''}}" >
            <i class="lnil lnil-list-alt"></i>
            <span>Type préavis</span>
            <span class="end">
                <i aria-hidden="true" class="fas fa-arrow-right"></i>
            </span>
        </a>
        <a href="{{ route('typeconges.index') }}" class="account-menu-item {{request()->routeIs('typeconges.index') ? 'is-active' : ''}}" >
            <i class="lnil lnil-list-alt"></i>
            <span>Type congés</span>
            <span class="end">
                <i aria-hidden="true" class="fas fa-arrow-right"></i>
            </span>
        </a>
    </div>
</div>

@include('typeconges.create')
@include('typepreavis.create')
