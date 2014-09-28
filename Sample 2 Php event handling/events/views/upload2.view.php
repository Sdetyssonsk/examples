<script>
	$(document).ready(function()
	{		
		$("#logo_file").customFileInput();
		
		$("#cancel").on("click", function(e)
		{
			e.preventDefault();
			window.location = '/<?=SUB?>/events/<?=$url['item1']?>';
		});
	});	
</script>

<div class="content_left">
	
	<div class="sidebar">

		<div class="title">Logo / afbeelding </div>
		
		<div class="current_images"><?=EventHelper::image_button( $event, $url['item1'] )?></div>
	
	</div>	

</div>

<div class="content_mid">

	<div class="content_item">
	
		<div class="title">Upload een logo</div>
		
		<?=EventHelper::event_name_title( $event )?>
		
		<div class="uploader" id="main">
		
			<form id="uploader_form" method="post" action="/<?=SUB?>/events/upload2/<?=$url['item1']?>" enctype="multipart/form-data">
				
				<fieldset>
					
					<label><b>Logo uploader:</b></label>
					
					<div class="fieldset_item">						
						
						<center>
							
							<input name="logo_file" type="file" id="logo_file"/>
							
							<span id="logo_file_error" class="form_error"><?=$error['logo_file']?></span>
							
						</center>
					
					</div>

					<button class="add_small float_left" id="cancel">Annuleren</button>
				
					<button class="add_small float_right" name="uploader" type="submit" >Uploaden</button>
					
				</fieldset>
				
				
			</form>
			
		</div>
		
	</div>
	
</div>