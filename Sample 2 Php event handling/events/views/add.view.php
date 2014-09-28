<script type="text/javascript">
	$(document).ready(function()
	{
		$("#step_wizard").steps_wizard()
		
		$("#step_wizard").datepicker_wizard("event_start_date", "event_end_date")
		
		$("#step_wizard").datepicker_wizard("ticket_start_date", "ticket_end_date")
		
		$("#step_wizard").datepicker_wizard("sale_start_date", "sale_end_date")
		
		$(function()
		{
			$(".info_btn").tipTip({maxWidth: "auto", edgeOffset: 10});
		});
	});
</script>

<input id="sub" type="hidden" value ="<?=SUB?>" />

<div class="content_left">

	<div class="sidebar">
	
		<div class="title">Progressie overzicht</div><br/>
		
		<center><button class="add_big progress_steps" id="hide_all_progress">Progressie verbergen</button>	
		
		<button class="add_big progress_steps" id="show_all_progress"  style=" display: none;">Progressie weergeven</button></center><br/>
				
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
	
	<div class="sidebar all_progress">
		
		<div class="title">
		
			2. Ticketgegevens
			<div class="float_right"><button class="add_tiny progress_steps" id="progress_step2">-</button></div>
			
		</div>
		
		<div class="toggle_progress" id="toggle_progress_step2"><b>
			
			<?=EventHelper::ticket_progress()?>

		</b></div>
		
	</div>	
	
	<div class="sidebar all_progress">

		<div class="title">
		
			3. Prijs & beschikbaarheid
			<div class="float_right"><button class="add_tiny progress_steps" id="progress_step3">-</button></div>
			
		</div>
		
		<div class="toggle_progress" id="toggle_progress_step3"><b>
			
			<?=EventHelper::price_progress()?>
			
		</b></div>
		
	</div>	
	
	<div class="sidebar all_progress">

		<div class="title">
		
			4. Ticket template
			<div class="float_right"><button class="add_tiny progress_steps" id="progress_step4">-</button></div>
			
		</div>
		
		<div class="toggle_progress" id="toggle_progress_step4"><b>
			
			<?=EventHelper::template_progress()?>
			
		</b></div>
		
	</div>
	
</div>

<div class="content_mid">

	<div class="content_item">
		
		<div class="title">Evenement Toevoegen:</div>
		
		<div class="wizard" id="main">
			
			<form id="step_wizard" method="post" action="/<?=SUB?>/events/add" enctype="multipart/form-data">
				
				<input id="current_module" type="hidden" value="<?=$url['module']?>">
				
				<input id="current_action" type="hidden" value="<?=$url['action']?>">
								
				<fieldset>
				
					<legend>Evenementgegevens</legend>
					
					<label>Alle velden met een * zijn verplicht</label>
					
					<div class="combi">
					
						<label><b>Type evenement *</b></label>
						
						<select name="event_type" id="event_type" style="width: 100px;">
						
							<option value=""></option>
							
							<option value="sports" <? if($_POST['event_type'] == "sports") { ?>selected<? } ?> >Sport</option>
							
							<option value="film" <? if($_POST['event_type'] == "film") { ?>selected<? } ?> >Film</option>
							
							<option value="theatre" <? if($_POST['event_type'] == "theatre") { ?>selected<? } ?> >Theater</option>
							
							<option value="music" <? if($_POST['event_type'] == "music") { ?>selected<? } ?> >Muziek</option>
							
						</select>
						
						<br/><span id="event_type_error" class="form_error"><?=$error['event_type']?></span>
					
					</div>
					
					<div class="combi">
								   
						<label class="combi_label">
							
							<b>Ook verkrijgbaar via entranz shop</b> 
						
							<input name="featured" id="featured" type="checkbox" value="yes"/>
								   					
							<img src="<?=APP_BASE_URL?>/resources/images/info_btn.png" class="info_btn" id="info_btn" 
							title="<b>Dit houd in dat ook via de shop op <red>www.entranz.nl</red> <br/>
								   de tickets verkrijgbaar zijn.</b>"/>	
						
						</label>						
						
					</div>					
					
					<div class="float_left">
					
						<label><b>Naam evenement *</b></label>
						
							<input name="event_name" id="event_name" type="text"/>
						
							<span id="event_name_error" class="form_error"><?=$error['event_name']?></span>					
							
						<label>
							
							<b>Url evenement *</b>
							
							<img src="<?=APP_BASE_URL?>/resources/images/info_btn.png" class="info_btn" id="info_btn" 
							title="<b>Voorbeeld : ( entranz.nl/events/<red>rocking_event</red> )<br/><br/>
								   <red>rocking_event</red> is hier de url van een evenement.</b>"/>
						
						</label>
						
							<input name="event_url_hash" id="event_url_hash" type="text"/>
						
							<span id="event_url_hash_error" class="form_error"><?=$error['event_url_hash']?></span>
						
						<label><b>Evenement begint op *</b></label>
						
							<input readonly="readonly" name="event_start_date_show" id="event_start_date_show" type="text" size="30"/>
						
							<span id="event_start_date_error" class="form_error"><?=$error['event_start_date']?></span>
						
							<input name="event_start_date" id="event_start_date" type="hidden"/>
			
						<label><b>Evenement eindigt op *</b></label>
						
							<input readonly="readonly" name="event_end_date_show" id="event_end_date_show" type="text" size="30"/>
						
							<span id="event_end_date_error" class="form_error"><?=$error['event_end_date']?></span>
						
							<input name="event_end_date" id="event_end_date" type="hidden"/>

						<label><b>Locatie evenement *</b></label>
						
							<input name="venue" id="venue" type="text"/>
						
							<span id="venue_error" class="form_error"><?=$error['venue']?></span>
							
						<label><b>Evenement beschrijving</b></label>
										
							<TEXTAREA name="event_description" id="event_description" maxlength="250"></TEXTAREA>
							
					</div>
					
				</fieldset>
				
				<fieldset>
				
					<legend>Ticketgegevens</legend>
	
					<label>Alle velden met een * zijn verplicht</label>
					
					<div class="float_left">
						
						<label>
						
							<b>Ticket soort *</b>
						
							<img src="<?=APP_BASE_URL?>/resources/images/info_btn.png" class="info_btn" id="info_btn" 
							title="<b>Voorbeeld: ( <red>Vip ticket</red>, Normale ticket, Gasten ticket )<br/><br/>
								   <red>Vip ticket</red> is hier het soort ticket van een evenement.</b>"/>
							
						</label>
										
							<input name="ticket_type" id="ticket_type" type="text"/>
						
							<span id="ticket_type_error" class="form_error"><?=$error['ticket_type']?></span>
							
						<label>
						
							<b>Ticket is geldig vanaf *</b>

							<img src="<?=APP_BASE_URL?>/resources/images/info_btn.png" class="info_btn" id="info_btn" 
							title="<b>Voorbeeld: ( <red>Maandag 15 april 2013</red> )<br/><br/>
								   De ticket mag pas vanaf <red>Maandag 15 april 2013</red> gebruikt worden .</b>"/>
								   
						</label>
						
							<input readonly="readonly" name="ticket_start_date_show" id="ticket_start_date_show" type="text" size="30"/>
						
							<span id="ticket_start_date_error" class="form_error"><?=$error['ticket_start_date']?></span>
						
							<input name="ticket_start_date" id="ticket_start_date" type="hidden" />

						<label><b>Ticket is geldig tot *</b></label>
						
							<input readonly="readonly" name="ticket_end_date_show" id="ticket_end_date_show" type="text" size="30"/>
						
							<span id="ticket_end_date_error" class="form_error"><?=$error['ticket_end_date']?></span>
						
							<input name="ticket_end_date" id="ticket_end_date" type="hidden"/>
							
						<label><b>Ticket beschrijving</b></label>
										
							<TEXTAREA name="ticket_description" id="ticket_description" maxlength="250"></TEXTAREA>
					
					</div>
					
				</fieldset>
				
				<fieldset>
				
					<legend>Prijs & beschikbaarheid</legend>
					
					<label>Alle velden met een * zijn verplicht</label>
					
					<label><b>Dit is een gratis ticket</b></label>
									
						<select name="free_ticket" id="free_ticket" style="width: 100px;">
						
							<option value="no">Nee</option>
							
							<option value="yes" <? if($_POST['free_ticket'] == "yes") { ?>selected<? } ?> >Ja</option>
							
						</select>
					
					<div id="price" <? if($_POST['free_ticket'] == "yes"){ ?> style="display: none;" <? } ?> >
					
						<label><b>Prijs ( in &euro; ) *</b></label>
										
							<input name="ticket_price" id="ticket_price" type="text" />
							
							<span id="ticket_price_error" class="form_error"><?=$error['ticket_price']?></span>
							
					</div>
					
					<label><b>Aantal tickets beschikbaar *</b></label> 
						
						<input name="availability" id="availability" type="text"/>
						
						<span id="availability_error" class="form_error"><?=$error['availability']?></span>

					<label><b>Aankoop limiet( per klant ) *</b></label> 
						
						<input name="max_purchase" id="max_purchase" type="text"/>
						
						<span id="max_purchase_error" class="form_error"><?=$error['max_purchase']?></span>	
						
					<label>
					
						<b>Ticket verkoop begint op *</b>

						<img src="<?=APP_BASE_URL?>/resources/images/info_btn.png" class="info_btn" id="info_btn" 
						title="<b>Voorbeeld: ( <red>Maandag 15 april 2013 om 13:30</red> )<br/><br/>
							   De ticketshop is pas vanaf <red>Maandag 15 april 2013 om 13:30</red> geopend.</b>"/>
							   
					</label>
					
						<input class="sale" readonly="readonly" name="sale_start_date_show" id="sale_start_date_show" type="text" size="30"/>
					
						<span id="sale_start_date_error" class="form_error"><?=$error['sale_start_date']?></span>
					
						<input name="sale_start_date" id="sale_start_date" type="hidden" />

						<div class="max">
							
							<?=EventHelper::sale_hours("sale_start_hour", "Van")?>
						
							<?=EventHelper::sale_minutes("sale_start_minute")?>
						
						</div>		
						
					<label><b>Ticket verkoop eindigt op *</b></label>
					
						<input class="sale" readonly="readonly" name="sale_end_date_show" id="sale_end_date_show" type="text" size="30"/>
	
						<span id="sale_end_date_error" class="form_error"><?=$error['sale_end_date']?></span>
					
						<input name="sale_end_date" id="sale_end_date" type="hidden"/>
					
						<div class="max">
							
							<?=EventHelper::sale_hours("sale_end_hour", "Tot")?>
						
							<?=EventHelper::sale_minutes("sale_end_minute")?>
						
						</div>
	
				</fieldset>
				
				<fieldset>
				
					<legend>Ticket template</legend>
					
					<label>Alle velden met een * zijn verplicht</label>
						
					<div class="combi">
					
						<label><b>Afbeelding locatie *</b></label> 
						
							<div class="loc_select">
							
								<select name="image_loc" id="image_loc" style="width: 120px;">
									
									<option value=""></option>
									
									<option class="ilUpLeft" value="upLeft" <? if($_POST['image_loc'] == "upLeft") { ?>selected<? } ?> >Linksboven</option>
									
									<option class="ilUpRight" value="upRight" <? if($_POST['image_loc'] == "upRight") { ?>selected<? } ?> >Rechtsboven</option>
									
									<option class="ilDownLeft" value="downLeft" <? if($_POST['image_loc'] == "downLeft") { ?>selected<? } ?> >Linksonder</option>
									
									<option class="ilDownRight" value="downRight" <? if($_POST['image_loc'] == "downRight") { ?>selected<? } ?> >Rechtsonder</option>
									
								</select>					
							
							</div>
							
						<span id="image_loc_error" class="form_error"><?=$error['image_loc']?></span>	

						<label><b>Barcode locatie *</b></label>
							
							<div class="loc_select">
							
								<select name="barcode_loc" id="barcode_loc" style="width: 120px;">
								
									<option value=""></option>
									
									<option class="blUpLeft" value="upLeft" <? if($_POST['barcode_loc'] == "upLeft") { ?>selected<? } ?> >Linksboven</option>
									
									<option class="blUpRight" value="upRight" <? if($_POST['barcode_loc'] == "upRight") { ?>selected<? } ?> >Rechtsboven</option>
									
									<option class="blDownLeft" value="downLeft" <? if($_POST['barcode_loc'] == "downLeft") { ?>selected<? } ?> >Linksonder</option>
									
									<option class="blDownRight" value="downRight" <? if($_POST['barcode_loc'] == "downRight") { ?>selected<? } ?> >Rechtsonder</option>
									
								</select>
							
							</div>
							
						<span id="barcode_loc_error" class="form_error"><?=$error['barcode_loc']?></span>	
						
					</div>
					
					<div class="combi">
													
						<label><b>Beschrijving locatie *</b></label> 
							
							<div class="loc_select">
							
								<select name="description_loc" id="description_loc" style="width: 120px;">
								
									<option value=""></option>
									
									<option class="dlUpLeft" value="upLeft" <? if($_POST['description_loc'] == "upLeft") { ?>selected<? } ?> >Linksboven</option>
					
									<option class="dlUpRight" value="upRight" <? if($_POST['description_loc'] == "upRight") { ?>selected<? } ?> >Rechtsboven</option>
					
									<option class="dlDownLeft" value="downLeft" <? if($_POST['description_loc'] == "downLeft") { ?>selected<? } ?> >Linksonder</option>
					
									<option class="dlDownRight" value="downRight" <? if($_POST['description_loc'] == "downRight") { ?>selected<? } ?> >Rechtsonder</option>
					
								</select>
							
							</div>
						
						<span id="description_loc_error" class="form_error"><?=$error['description_loc']?></span>						
						
						<label><b>Gegevens locatie *</b></label> 
							
							<div class="loc_select">
							
								<select name="info_loc" id="info_loc" style="width: 120px;">
								
									<option value=""></option>
									
									<option class="glUpLeft" value="upLeft" <? if($_POST['info_loc'] == "upLeft") { ?>selected<? } ?> >Linksboven</option>
					
									<option class="glUpRight" value="upRight" <? if($_POST['info_loc'] == "upRight") { ?>selected<? } ?> >Rechtsboven</option>
					
									<option class="glDownLeft" value="downLeft" <? if($_POST['info_loc'] == "downLeft") { ?>selected<? } ?> >Linksonder</option>
					
									<option class="glDownRight" value="downRight" <? if($_POST['info_loc'] == "downRight") { ?>selected<? } ?> >Rechtsonder</option>
					
								</select>
							
							</div>
						
						<span id="info_loc_error" class="form_error"><?=$error['info_loc']?></span>

					</div>

				</fieldset>
				
				<fieldset>
					
					<legend>Gegevens nakijken</legend>						
						
						<label><b>Stap 1 Evenementgegevens:</b></label>
						
							<div class="fieldset_item">
								
								<?=EventHelper::event_progress()?>
								
							</div>						
							
						<label><b>Stap 2 Ticketgegevens:</b></label>
						
							<div class="fieldset_item">
								
								<?=EventHelper::ticket_progress()?>
								
							</div>
						
						<label><b>Stap 3 Prijs & beschikbaarheid:</b></label>
						
							<div class="fieldset_item">
							
								<?=EventHelper::price_progress()?>
							
							</div>						
							
						<label><b>Stap 4 Ticket template:</b></label>
						
							<div class="fieldset_item">
							
								<?=EventHelper::template_progress()?>
							
							</div>

						<label class="combi_label">
						
							<b>Hierbij verklaar ik akkoord te gaan met de <a href="/<?=SUB?>/events/download/entranz" target="_blank">algemene voorwaarden</a> van Entranz.</b>
							
							<input name="terms_accept" id="terms_accept" type="checkbox" value="yes"/>
							
						</label>	
						
						<span id="terms_accept_error" class="form_error"><?=$error['terms_accept']?></span>
							
						<input name="final" id="final" type="hidden" value="final"/>
							
				</fieldset>				
					
			</form>
			
		</div>
		
	</div>

</div>