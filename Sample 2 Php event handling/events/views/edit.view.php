<script type="text/javascript">
	$(document).ready(function()
	{
		$("#step_wizard").edit_wizard()
		
		$("#step_wizard").datepicker_wizard("event_start_date", "event_end_date")
		
		$(function()
		{
			$(".info_btn").tipTip({maxWidth: "auto", edgeOffset: 10});
		});		
	});
</script>

<input id="sub" type="hidden" value="<?=SUB?>" />

<div class="content_left">

	<div class="sidebar">
	
		<div class="title">Progressie overzicht</div><br/>
		
		<center><button class="add_big progress_steps" id="hide_all_progress">Progressie verbergen</button>	
		
		<button class="add_big progress_steps" id="show_all_progress" style=" display: none;">Progressie weergeven</button></center><br/>
				
	</div>
	
	<div class="sidebar all_progress">
		
		<div class="title">
		
			1. Evenementgegevens
			<div class="float_right"><button class="add_tiny progress_steps" id="progress_step1">-</button></div>
			
		</div>
		
		<div class="toggle_progress" id="toggle_progress_step1"><b>
		
			<?=EventHelper::event_progress()?>
			
		</b></div>
		
	</div>
	
</div>	

<div class="content_mid">

	<div class="content_item">
		
		<div class="title">Evenement wijzigen:</div>
		
		<?=EventHelper::event_name_title( $event )?>
		
		<div class="wizard" id="main">
			
			<form id="step_wizard" method="post" action="/<?=SUB?>/events/edit/<?=$url['item1']?>">
				
				<input id="current_module" type="hidden" value="<?=$url['module']?>">
				
				<input id="current_action" type="hidden" value="<?=$url['action']?>">
				
				<input id="current_url" type="hidden" value="<?=$url['item1']?>">
				
				<fieldset>
				
					<legend>Evenementgegevens</legend>
					
					<label>Alle velden met een * zijn verplicht</label>
					
					<div class="combi">
					
						<label><b>Type evenement *</b></label>
						
						<select name="event_type" id="event_type">
						
							<option value=""></option>
							
							<option value="sports" <?=$set_sports?> >Sport</option>
							
							<option value="film" <?=$set_film?> >Film</option>
							
							<option value="theatre" <?=$set_theatre?> >Theater</option>
							
							<option value="music" <?=$set_music?> >Muziek</option>
							
						</select>
						
						<br/><span class="form_error"><?=$error['event_type']?></span>
					
					</div>
					
					<div class="combi">
							   
						<label class="combi_label">
							
							<b>Ook verkrijgbaar via entranz shop</b> 
						
							<input name="featured" id="featured" type="checkbox" <?=$set_featured?> value="yes"/>
		   
							<img src="<?=APP_BASE_URL?>/resources/images/info_btn.png" class="info_btn" id="info_btn" 
							title="<b>Dit houd in dat ook via de shop op <red>www.entranz.nl</red> <br/>
								   de tickets verkrijgbaar zijn.</b>"/>	
							   
						</label>

					</div>				
					
					<div class="float_left">
					
						<label><b>Naam evenement *</b></label>
						
							<input name="event_name" id="event_name" type="text" value="<?=$set_name?>" />
						
							<span id="event_name_error" class="form_error"><?=$error['event_name']?></span>	
						
						<label>
							
							<b>Url evenement *</b>
							
							<img src="<?=APP_BASE_URL?>/resources/images/info_btn.png" class="info_btn" id="info_btn" 
							title="<b>Voorbeeld : ( entranz.nl/events/<red>rocking_event</red> )<br/><br/>
								   <red>rocking_event</red> is hier de url van een evenement.</b>"/>
						
						</label>
						
							<input name="event_url_hash" id="event_url_hash" type="text" value="<?=$set_url_hash?>" />
						
							<span id="event_url_hash_error" class="form_error"><?=$error['event_url_hash']?></span>
						
						<label><b>Evenement begint op *</b></label>
						
							<input readonly="readonly" name="event_start_date_show" id="event_start_date_show" type="text" size="30" />
						
							<span id="event_start_date_error" class="form_error"><?=$error['event_start_date']?></span>
						
							<input name="event_start_date" id="event_start_date" type="hidden" value="<?=$set_start_date?>"/>
			
						<label><b>Evenement eindigt op *</b></label>
						
							<input readonly="readonly" name="event_end_date_show" id="event_end_date_show" type="text" size="30" />
						
							<span id="event_end_date_error" class="form_error"><?=$error['event_end_date']?></span>
						
							<input name="event_end_date" id="event_end_date" type="hidden" value="<?=$set_end_date?>" />
							
						<label><b>Locatie evenement *</b></label>
						
							<input name="venue" id="venue" type="text" value="<?=$set_venue?>" />
						
							<span id="venue_error" class="form_error"><?=$error['venue']?></span>					
					
						<label><b>Evenement beschrijving</b></label>
										
							<TEXTAREA name="event_description" id="event_description" maxlength="250"><?=$set_description?></TEXTAREA>
					
					</div>
					
				</fieldset>

			</form>
			
		</div>
		
	</div>

</div>