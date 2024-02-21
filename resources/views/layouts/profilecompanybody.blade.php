<div class="settings-section">
    <a href="{{route('clients.index')}}" class="settings-box">
        <div class="edit-icon">
            <i class="lnil lnil-plus"></i>
        </div>
        <div class="icon-wrap">
            <i class="lnil lnil-users"></i>
        </div>
        <span style="color:{{$setting->companycolor ?? ''}} !important;"><strong>Clients</strong></span>
        <h3>Gestion des clients</h3>
    </a>
    <a href="{{route('dossiers.index')}}" class="settings-box">
        <div class="edit-icon">
            <i class="lnil lnil-plus"></i>
        </div>
        <div class="icon-wrap">
            <i class="lnil lnil-briefcase-alt"></i>
        </div>
        <span style="color:{{$setting->companycolor ?? ''}} !important;"><strong>Dossiers</strong></span>
        <h3>Gestion des dossiers</h3>
    </a>
    <a href="{{route('conteneurs.index')}}" class="settings-box">
        <div class="edit-icon">
            <i class="lnil lnil-plus"></i>
        </div>
        <div class="icon-wrap">
            <i class="lnil lnil-thumbnail"></i>
        </div>
        <span style="color:{{$setting->companycolor ?? ''}} !important;"><strong>Conteneurs</strong></span>
        <h3>Gestion des conteneurs</h3>
    </a>
    <a href="{{route('plannings.index')}}" class="settings-box">
        <div class="edit-icon">
            <i class="lnil lnil-plus"></i>
        </div>
        <div class="icon-wrap">
            <i class="lnil lnil-calender-alt-2"></i>
        </div>
        <span style="color:{{$setting->companycolor ?? ''}} !important;"><strong>Plannings</strong></span>
        <h3>Gestions des plannings</h3>
    </a>
    <a href="{{route('debours.index')}}" class="settings-box">
        <div class="edit-icon">
            <i class="lnil lnil-plus"></i>
        </div>
        <div class="icon-wrap">
            <i class="lnil lnil-lock-alt-1"></i>
        </div>
        <span style="color:{{$setting->companycolor ?? ''}} !important;"><strong>Debours</strong></span>
        <h3>Gestion des debours</h3>
    </a>
    <a href="{{route('facturedouane.fdd.index')}}"class="settings-box">
        <div class="edit-icon">
            <i class="lnil lnil-plus"></i>
        </div>
        <div class="icon-wrap">
            <i class="lnil lnil-ticket-alt-2"></i>
        </div>
        <span style="color:{{$setting->companycolor ?? ''}} !important;"><strong>Facturation</strong></span>
        <h3>Gestions des factures</h3>
    </a>

    <a href="{{route('codes.index')}}"class="settings-box">
        <div class="edit-icon">
            <i class="lnil lnil-plus"></i>
        </div>
        <div class="icon-wrap">
            <i class="lnil lnil-lock is-dark-primary"></i>
        </div>
        <span style="color:{{$setting->companycolor ?? ''}} !important;"><strong>Codes facture</strong></span>
        <h3>Générer des codes de factures</h3>
    </a>

    <a href="{{route('reglements.index')}}"class="settings-box">
        <div class="edit-icon">
            <i class="lnil lnil-plus"></i>
        </div>
        <div class="icon-wrap">
            <i class="lnil lnil-page"></i>
        </div>
        <span style="color:{{$setting->companycolor ?? ''}} !important;"><strong>Reglement</strong></span>
        <h3>Gestions des reglements</h3>
    </a>

    <a class="settings-box" href="{{route('demandes.index')}}">
        <div class="edit-icon">
            <i class="lnil lnil-plus"></i>
        </div>
        <div class="icon-wrap">
            <i class="lnil lnil-dollar-down"></i>
        </div>
        <span style="color:{{$setting->companycolor ?? ''}} !important;"><strong>Demande de fonds</strong></span>
        <h3>Faire une demande de fonds</h3>
    </a>
    <a href="{{route('litiges.index')}}" class="settings-box">
        <div class="edit-icon">
            <i class="lnil lnil-plus"></i>
        </div>
        <div class="icon-wrap">
            <i class="lnil lnil-bolt"></i>
        </div>
        <span style="color:{{$setting->companycolor ?? ''}} !important;"><strong>Litiges</strong></span>
        <h3>Gestions des litiges</h3>
    </a>
    <a href="{{route('comptes.index')}}"class="settings-box">
        <div class="edit-icon">
            <i class="lnil lnil-plus"></i>
        </div>
        <div class="icon-wrap">
            <i class="lnil lnil-calculator-alt"></i>
        </div>
        <span style="color:{{$setting->companycolor ?? ''}} !important;"><strong>Comptabilité</strong></span>
        <h3>Gestion des finances</h3>
    </a>
    <a href="{{route('paiements.index')}}" class="settings-box">
        <div class="edit-icon">
            <i class="lnil lnil-plus"></i>
        </div>
        <div class="icon-wrap">
            <i class="lnil lnil-money-protection"></i>
        </div>
        <span style="color:{{$setting->companycolor ?? ''}} !important;"><strong>Paie</strong></span>
        <h3>Gestions des paies</h3>
    </a>
    <!--<a class="settings-box">
        <div class="edit-icon">
            <i class="lnil lnil-plus"></i>
        </div>
        <div class="icon-wrap">
            <i class="lnil lnil-shield"></i>
        </div>
        <span>Security</span>
        <h3>Security Settings</h3>
    </a>
    <a class="settings-box">
        <div class="edit-icon">
            <i class="lnil lnil-plus"></i>
        </div>
        <div class="icon-wrap">
            <i class="lnil lnil-cogs"></i>
        </div>
        <span>Preferences</span>
        <h3>General Settings</h3>
    </a>-->
</div>
