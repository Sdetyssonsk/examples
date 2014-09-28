<div class="content_left">
	
	<div class="sidebar">
	
		<div class="title">Opties</div>
		
	</div>
	
</div>

<div class="content_mid">
	
	<div class="content_item">
		
		<div class="title">Mail(s) versturen</div>
	
		<?=EventHelper::event_name_title( $event )?>
		
		<form class="send_mail" method="post" action="/<?=SUB?>/events/mail/<?=$url['item1']?>" enctype="multipart/form-data">
		
			<label>
			
				<b>Verstuur naar:</b>
				
				<select class="mail_input" name="receivers">
				
					<option value="all">Klanten ( Alle )</option>
					
					<option value="success">Klanten ( Betaling compleet )</option>
					
					<option value="pending">Klanten ( Afwachting betaling )</option>
				
				</select>
				
			</label>
			
			<label><b>Onderwerp:</b> <input class="mail_input" name="subject" type="text"/></label>
			<span id="subject_error" class="form_error"><?=$error['subject']?></span>
										
			<TEXTAREA name="mail" id="mail" maxlength="500"></TEXTAREA>
			<span id="mail_error" class="form_error"><?=$error['mail']?></span>
	
			<br/><br/>
			
			<button class="add_small">Versturen</button>
			<span id="success_error" class="form_error"><?=$error['success']?></span>
			
		</form>
		
	</div>		
	
</div>

