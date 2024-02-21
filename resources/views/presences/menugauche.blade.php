<div class="account-box is-navigation">
    <div class="account-menu">
        <a href="#" class="account-menu-item  h-modal-trigger" data-modal="importPointage">
            <i class="lnil lnil-download"></i>

            <span>Importer le pointage</span>
            <span class="end">
                <i aria-hidden="true" class="fas fa-arrow-right"></i>
            </span>
        </a>
        <a href="{{route('presences.index')}}" class="account-menu-item {{request()->routeIs('presences.index') ? 'is-active' : ''}}" >
            <i class="lnil lnil-list-alt"></i>

            <span>Liste des pointages</span>
            <span class="end">
                <i aria-hidden="true" class="fas fa-arrow-right"></i>
            </span>
        </a>
    </div>
</div>
@include('presences.modals.import')