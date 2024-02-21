<div class="settings-section">
    <a href="{{ route('departements.index') }}" class="settings-box">
        <div class="edit-icon">
            <i class="lnil lnil-plus"></i>
        </div>
        <div class="icon-wrap">
            <i class="lnil lnil-thumbnail"></i>
        </div>
        <span style="color:{{$setting->companycolor ?? 'orange'}} !important;"><strong>Départements</strong></span>
        <h3>Gestion des départements</h3>
    </a>
    <a href="{{ route('employes.index') }}" class="settings-box">
        <div class="edit-icon">
            <i class="lnil lnil-plus"></i>
        </div>
        <div class="icon-wrap">
            <i class="lnil lnil-users"></i>
        </div>
        <span style="color:{{$setting->companycolor ?? 'orange'}} !important;"><strong>Employés</strong></span>
        <h3>Gestion des employé</h3>
    </a>
    <a href="{{ route('presences.index') }}" class="settings-box">
        <div class="edit-icon">
            <i class="lnil lnil-plus"></i>
        </div>
        <div class="icon-wrap">
            <i class="lnil lnil-calender-alt-2"></i>
        </div>
        <span style="color:{{$setting->companycolor ?? 'orange'}} !important;"><strong>Présences</strong></span>
        <h3>Gestion des présences</h3>
    </a>
    <a href="{{ route('permissions.index') }}" class="settings-box">
        <div class="edit-icon">
            <i class="lnil lnil-plus"></i>
        </div>
        <div class="icon-wrap">
            <i class="lnil lnil-briefcase-alt"></i>
        </div>
        <span style="color:{{$setting->companycolor ?? 'orange'}} !important;"><strong>Permissions</strong></span>
        <h3>Gestions des permissions</h3>
    </a>
</div>
