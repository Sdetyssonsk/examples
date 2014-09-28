<script>
	$(document).ready(function()
	{
		$("#cancel").on("click", function(e)
		{
			e.preventDefault();
			window.location = '/<?=SUB?>/events/<?=$url['item1']?>';
		});		
	});
</script>

<div class="content_left">

	<div class="sidebar">
	
		<div class="title">Tickets</div>
		
		<ul class="sidebar_menu">

			<?=EventHelper::ticket_links( $event )?>
		
		</ul>
		
	</div>
	
</div>
	
<form name="delete_event_form" id="delete_event_form" method="post">

	<div class="content_mid">
		
		<div class="content_item">
	
			<div class="title">Evenement afzeggen</div>	
		
			<?=EventHelper::event_content( $event, $url['action'] )?>
			
		</div>
	
	</div>

</form>