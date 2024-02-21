<div class="h-avatar is-xl">

	<img alt="Logo" class="avatar" src="{{ asset($setting->companylogo) }}"

		 data-demo-src="{{$setting->companylogo ?? ''}}" alt="Logo : {{$setting->companyname ?? ''}}" data-user-popover="3">

</div>

<h3 class="title is-4 is-narrow">{{ucfirst( html_entity_decode($setting->companyname) ?? '')}}</h3>

<p class="title light-text" style="color:#283252;">Bienvenue sur la console de gestion de {{ucfirst(html_entity_decode($setting->companyname) ?? '')}}</p>

<div class="title is-narrow">
	@include('layouts.flashmessage')
</div>

