<div class="content_left">		

	<?=UserHelper::content_left( $current_user, $url['module'] )?>
	
</div>

<div class="content_mid">		
	
	<?=EventHelper::fill_events( $events )?>	

</div>