<script>
	$(document).ready(function()
	{		
		$(".terms_file").customFileInput();	
		
		$("#cancel").on("click", function(e)
		{
			e.preventDefault();
			window.location = '/<?=SUB?>/events/<?=$url['item1']?>';
		});
	});	
</script>

<div class="content_left">

	<div class="sidebar">
		
		<div class="title">Download templates</div>
		
		<ul class="sidebar_menu">
				
			<div class="arrow-right"></div><li><a href="/<?=SUB?>/events/download/muziek">Muziek</a></li>
			
			<div class="arrow-right"></div><li><a href="/<?=SUB?>/events/download/theater">Theater</a></li>
			
			<div class="arrow-right"></div><li><a href="/<?=SUB?>/events/download/film">Film</a></li>
			
			<div class="arrow-right"></div><li><a href="/<?=SUB?>/events/download/sport">Sport</a></li>

		</ul>

	</div>
	
	<div class="sidebar">
		
		<div class="title">Download voorwaarden</div>
		
		<ul class="sidebar_menu">
				
			<div class="arrow-right"></div><li><a href="/<?=SUB?>/events/download/<?=$url['item1']?>">Voorwaarden</a></li>			

		</ul>

	</div>	

</div>

<div class="content_mid">

	<div class="content_item">
	
		<div class="title">Upload algemene voorwaarden</div>
		
		<?=EventHelper::event_name_title( $event )?>
	
		<div class="uploader" id="main">
		
			<form id="uploader_form" method="post" action="/<?=SUB?>/events/upload1/<?=$url['item1']?>" enctype="multipart/form-data">
				
				<input name="to_next_upload" type="hidden" id="to_next_upload" value="<?=$to_next_upload?>"/>
				
				<fieldset>					
					
					<label><b>Algemene voorwaarden uploader:</b></label>
					
					<div class="fieldset_item">
						
						<center>

							<input name="terms_file" type="file" class="terms_file"/>
							
							<span id="terms_file_error" class="form_error"><?=$error['terms_file']?></span>
									
						</center>
						
					</div>
					
					<button class="add_small float_left" id="cancel">Annuleren</button>
			
					<button class="add_small float_right" name="uploader" type="submit" >Uploaden</button>

				</fieldset>
				
			</form>
			
		</div>
		
	</div>
	
</div>