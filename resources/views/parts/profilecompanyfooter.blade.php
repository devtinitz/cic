<div class="profile-stats">
	<div class="profile-stat">
		<span>{{$setting->companyname ?? '' }} {{date('Y')}} - Tous droits réservés</span>
	</div>

	@if($setting->facebook != null || $setting->twitter != null || $setting->linkedin != null)
		<div class="separator"></div>

		<div class="socials">
			@if($setting->facebook != null && $setting->facebook != '')
				<a href="{{$setting->facebook ?? '#'}}" target="_blank">
					<i aria-hidden="true" class="fab fa-facebook-f"></i>
				</a>
			@endif

			@if($setting->twitter != null && $setting->twitter != '')
				<a href="{{$setting->twitter ?? '#'}}" target="_blank">
					<i aria-hidden="true" class="fab fa-twitter"></i>
				</a>
			@endif

			@if($setting->linkedin != null && $setting->linkedin != '')
				<a href="{{$setting->linkedin ?? '#'}}" target="_blank">
					<i aria-hidden="true" class="fab fa-linkedin-in"></i>
				</a>
			@endif
		</div>
	@endif

	<div class="separator"></div>
	<div class="profile-stat">
		<i class="lnil lnil-checkmark-circle"></i>
		<span style="margin:0px 5px;">Conçu par <a href="https://www.tinitz.com/" target="_blank">Tinitz</a></span>
		<img class="light-image" style="width:70px;" src="/img/comodo-secure-seal.png" alt="Comodo" />
	</div>


</div>
