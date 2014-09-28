/* Original by Stephan de Tyssonsk*/

(function($) 
{
	
$(document).ready(function()
{
	$(".progress_steps").click(function(event)
	{
		switch(event.target.id) // Toggle all progress boxes
		{			
			case "hide_all_progress":
				$(".all_progress").slideUp( 700 );
				$("#hide_all_progress").hide();
				$("#show_all_progress").show();
				break;				
			case "show_all_progress":
				$(".all_progress").slideDown( 700 );					
				$("#show_all_progress").hide();					
				$("#hide_all_progress").show();
				break;
		}
					
		$("#toggle_" + event.target.id).toggle( 700 ); // Toggle individual progress boxes
		
		if( $("#" + event.target.id).text() == "-" )
			$("#" + event.target.id).html( "+" );
		else if( $("#" + event.target.id).text() == "+" )
			$("#" + event.target.id).html( "-" );	
	});	
});

//
// Event Edit Wizard
//
	
	$.fn.edit_wizard = function() 
	{
		var sub = $("#sub").val();
		var url = $("#current_url").val();
		
		$("fieldset").wrap("<div id='step1'></div>");
		$("#step1").append("<p id='step1commands'></p>");
		
		$("#step1commands").append("<p id='cancel' class='cancel'>Annuleren</p>");
		$("#step1commands").append("<br/><button id='step1Next' class='next'>Opslaan</button>");
		
		$("#cancel").on("click", function()
		{
			if($("#current_module").val() == "user")
				window.location = sub + '/home';			
				
			if($("#current_module").val() == "events")
				window.location = sub + '/events/' + url;
		});
    }
	
//
// Event Add Wizard & Ticket Add / Edit Wizard
//
   
   $.fn.steps_wizard = function() 
	{
		var sub = $("#sub").val();
		
        var $element = $(this);
		
        var steps = $element.find("fieldset");
		
        var count = steps.size();
		
		var url = $("#current_url").val();
		
		var item = $("#current_item").val();
		
		setProgress();
		
        // Prepend steps to steps list.
        $element.prepend("<ul class='steps' id='steps'></ul>");
		
        steps.each(function(i) 
		{
			var stepName = "step" + i;
			
            $(this).wrap("<div id='step" + i + "'></div>");
            $("#" + stepName).append("<p id='step" + i + "commands'></p>");

            var name = $(this).find("legend").html();
            
			// If it is not the last step use the fieldset's legend as a stepname.
			if( $("#current_module").val() == "events" )
				if( (i + 1) != 5 )
					$("#steps").append("<li id='stepDesc" + i + "'>Stap " + (i + 1) + "<span id>" + name + "</span></li>");			
					
			if( $("#current_module").val() == "tickets" )
				if( (i + 1) != 4 )
					$("#steps").append("<li id='stepDesc" + i + "'>Stap " + (i + 1) + "<span id>" + name + "</span></li>");

			if( $("#current_module").val() == "user" )
				if( (i + 1) != 3 )
					$("#steps").append("<li id='stepDesc" + i + "'>Stap " + (i + 1) + "<span id>" + name + "</span></li>");
			
            if (i == 0) // If it is the first step append a cancel and next button.
			{
                createNextButton(i);
                selectStep(i);
				$("#step0commands").append("<p id='cancel' class='cancel'>Annuleren</p>");
            }
            else if (i == count - 1) // If it is the last step append a save and previous button.
			{
                $("#" + stepName).hide();
                createPrevButton(i);
				locationOptions();
				$("#step" + (count - 1) + "commands").append("<p id='step" + (count - 1) + "Next' class='next'>Opslaan</p>");
				
				$("#step" + (count - 1) + "Next").on("click", function(e) 
				{					
					if($("#current_action").val() == "add")
						setAddChecks(i);
					
					if($("#current_action").val() == "edit")
						setEditChecks(i);
						
					if($("#current_module").val() == "user")
						setProfileChecks(i);
				});
            }
            else // If it is any other step append a next and previous button.
			{
                $("#" + stepName).hide();
                createPrevButton(i);
                createNextButton(i);
            }
        });

        function createPrevButton(i) // Create the previous button and add an onclick event.
		{
            var stepName = "step" + i;
            $("#" + stepName + "commands").append("<p id='" + stepName + "Prev' class='prev'>< Vorige</p>");

            $("#" + stepName + "Prev").on("click", function(e) 
			{				
                $("#" + stepName).hide(); // Hide current step.
                $("#step" + (i - 1)).show(); // Show previous step.
                selectStep(i - 1); // Set selected step in the stepnames.
            });
        }

        function createNextButton(i) // Create the next button and add an onclick event.
		{
            var stepName = "step" + i;
	
            $("#" + stepName + "commands").append("<p id='" + stepName + "Next' class='next'>Volgende ></p>");

            $("#" + stepName + "Next").on("click", function(e) 
			{					
				if($("#current_action").val() == "add")
					setAddChecks(i); // Check the inputs for errors on the add action.
				
				if($("#current_action").val() == "edit")
					setEditChecks(i); // Check the inputs for errors on the edit action.
					
				if($("#current_module").val() == "user")
					setProfileChecks(i); // Check the inputs for errors on the profile module.
            });
        }			
		
		function goToNextStep(i, stepName) // Once checks return no error this is executed.
		{
			$("#" + stepName).hide(); // Hide current step.
			$("#step" + (i + 1)).show(); // Show previous step.
			selectStep(i + 1); // Set selected step in the stepnames.		
		}
		
        function selectStep(i) 
		{
            $("#steps li").removeClass("current"); // Remove the current step class.
            $("#stepDesc" + i).addClass("current"); // Set the current step class.
        }

		function setAddChecks(i) // Set the checks for the add action
		{
			// Place the values of single input fields in variables.
			var stepName = "step" + i;
			
			var form_has_errors = $("#form_has_errors").val();
			
			var first_name = $("#first_name").val(), last_name = $("#last_name").val(), phone_number = $("#phone_number").val(), 
				bank_accnumber = $("#bank_accnumber").val(), bank_accname = $("#bank_accname").val();			

			var event_type = $("#event_type option:selected").val(), event_name = $("#event_name").val(), event_url_hash = $("#event_url_hash").val(), 
				event_description = $("#event_description").val(), event_start_date = $("#event_start_date").val(), 
				event_end_date = $("#event_end_date").val(), venue = $("#venue").val();					
				
				
			var ticket_type = $("#ticket_type").val(), ticket_start_date = $("#ticket_start_date").val(), ticket_end_date = $("#ticket_end_date").val();
			
			var free_ticket = $("#free_ticket").val(), ticket_price = $("#ticket_price").val(), max_purchase = $("#max_purchase").val(), 
				availability = $("#availability").val(), sale_start_date = $("#sale_start_date").val(), sale_end_date = $("#sale_end_date").val(),
				sale_start_hour = $("#sale_start_hour option:selected").val(), sale_start_minute = $("#sale_start_minute option:selected").val(),
				sale_end_hour = $("#sale_end_hour option:selected").val(), sale_end_minute = $("#sale_end_minute option:selected").val();
			
			var image_loc = $("#image_loc").val(), info_loc = $("#info_loc").val(), barcode_loc = $("#barcode_loc").val(), description_loc = $("#description_loc").val();	
			
			// Place the values of every input field on the form in a variable.
			var data = $("#step_wizard").serialize();
			
			if($("#current_module").val() == "events") // Execute this part when the module is "events"
			{				
				switch(i)  
				{
					case 0:
						$.post(sub + '/events/add', 
						{form_has_errors: form_has_errors, event_type: event_type, event_name: event_name, event_url_hash: event_url_hash, 
						 event_description: event_description, event_start_date: event_start_date, event_end_date: event_end_date, venue: venue}, function(result)
						{
							// Post the fields of the current step.
							executeChecks(i, stepName, result);
							setProgress();
						});
						break;
					case 1:
						$.post(sub + '/events/add', 
						{form_has_errors: form_has_errors, ticket_type: ticket_type, ticket_start_date: ticket_start_date, ticket_end_date: ticket_end_date}, function(result)
						{
							// Post the fields of the current step.
							executeChecks(i, stepName, result);
							setProgress();
						});
						break;
					case 2:
						$.post(sub + '/events/add', 
						{form_has_errors: form_has_errors, free_ticket: free_ticket, ticket_price: ticket_price, max_purchase: max_purchase, 
						 availability: availability, sale_start_date: sale_start_date, sale_end_date: sale_end_date, sale_start_hour: sale_start_hour, 
						 sale_start_minute: sale_start_minute, sale_end_hour: sale_end_hour, sale_end_minute: sale_end_minute}, function(result)
						{
							// Post the fields of the current step.
							executeChecks(i, stepName, result);
							setProgress();
						});
						break;
					case 3:
						$.post(sub + '/events/add', 
						{form_has_errors: form_has_errors, image_loc: image_loc, info_loc: info_loc, barcode_loc: barcode_loc, description_loc: description_loc}, function(result)
						{
							// Post the fields of the current step.
							executeChecks(i, stepName, result);
							setProgress();
						});
						break;					
					case 4:
						$.post(sub + '/events/add', data, function(result)
						{
							// Post every field of the form.
							executeChecks(i, stepName, result);
						});
						break;
				}							
			}
			
			if($("#current_module").val() == "tickets") // Execute this part when the module is "tickets"
			{
				switch(i)
				{
					case 0:
						$.post(sub + '/tickets/add', 
						{form_has_errors: form_has_errors, ticket_type: ticket_type, ticket_start_date: ticket_start_date, ticket_end_date: ticket_end_date}, function(result)
						{
							// Post the fields of the current step.
							executeChecks(i, stepName, result);
							setProgress();
						});
						break;
					case 1:
						$.post(sub + '/tickets/add', 
						{form_has_errors: form_has_errors, free_ticket: free_ticket, ticket_price: ticket_price, max_purchase: max_purchase, 
						 availability: availability, sale_start_date: sale_start_date, sale_end_date: sale_end_date, sale_start_hour: sale_start_hour, 
						 sale_start_minute: sale_start_minute, sale_end_hour: sale_end_hour, sale_end_minute: sale_end_minute}, function(result)
						{
							// Post the fields of the current step.
							executeChecks(i, stepName, result);
							setProgress();
						});
						break;
					case 2:
						$.post(sub + '/tickets/add', 
						{form_has_errors: form_has_errors, image_loc: image_loc, info_loc: info_loc, barcode_loc: barcode_loc, description_loc: description_loc}, function(result)
						{
							// Post the fields of the current step.
							executeChecks(i, stepName, result);
							setProgress();
						});
						break;					
					case 3:
						$.post(sub + '/tickets/add', data, function(result)
						{
							// Post every field of the form.
							executeChecks(i, stepName, result);
						});
						break;
				}	
			}
		}

		function setEditChecks(i) // Set the checks for the edit action
		{
			// Place the values of single input fields in variables.		
			var stepName = "step" + i;

			var event_start_date = $("#event_start_date").val(), event_end_date = $("#event_end_date").val();
			
			var ticket_type = $("#ticket_type").val(), ticket_start_date = $("#ticket_start_date").val(), ticket_end_date = $("#ticket_end_date").val();			
			
			var free_ticket = $("#free_ticket").val(), ticket_price = $("#ticket_price").val(), max_purchase = $("#max_purchase").val(), 
				availability = $("#availability").val(), sale_start_date = $("#sale_start_date").val(), sale_end_date = $("#sale_end_date").val()
				sale_start_hour = $("#sale_start_hour option:selected").val(), sale_start_minute = $("#sale_start_minute option:selected").val(),
				sale_end_hour = $("#sale_end_hour option:selected").val(), sale_end_minute = $("#sale_end_minute option:selected").val();
			
			var image_loc = $("#image_loc").val(), info_loc = $("#info_loc").val(), barcode_loc = $("#barcode_loc").val(), description_loc = $("#description_loc").val();
			
			// Place the values of every input field on the form in a variable.
			var data = $("#step_wizard").serialize();			
				
			switch(i)
			{
				case 0:
					$.post(sub + "/tickets/edit/" + url + "/" + item, 
					{ticket_type: ticket_type, ticket_start_date: ticket_start_date, ticket_end_date: ticket_end_date, 
					event_start_date: event_start_date, event_end_date: event_end_date}, function(result)
					{
						// Post the fields of the current step.
						executeChecks(i, stepName, result);
						setProgress();
					});
					break;
				case 1:
					$.post(sub + "/tickets/edit/" + url + "/" + item, 
					{free_ticket: free_ticket, ticket_price: ticket_price, max_purchase: max_purchase, availability: availability,
					 sale_start_date: sale_start_date, sale_end_date: sale_end_date, sale_start_hour: sale_start_hour, 
					 sale_start_minute: sale_start_minute, sale_end_hour: sale_end_hour, sale_end_minute: sale_end_minute }, function(result)
					{
						// Post the fields of the current step.
						executeChecks(i, stepName, result);
						setProgress();
					});
					break;
				case 2:
					$.post(sub + "/tickets/edit/" + url + "/" + item, {image_loc: image_loc, info_loc: info_loc, barcode_loc: barcode_loc, description_loc: description_loc}, function(result)
					{
						// Post the fields of the current step.
						executeChecks(i, stepName, result);
						setProgress();
					});
					break;				
				case 3:
					$.post(sub + "/tickets/edit/" + url + "/" + item, data, function(result)
					{
						// Post every field of the form.
						executeChecks(i, stepName, result);
					});
					break;
			}	
		}		
		
		function setProfileChecks(i)
		{
			// Place the values of single input fields in variables.	
			var stepName = "step" + i;

			var first_name = $("#first_name").val(), last_name = $("#last_name").val(), phone_number = $("#phone_number").val(), bank_accnumber = $("#bank_accnumber").val(), bank_accname = $("#bank_accname").val();			
			var company_name = $("#company_name").val(), street = $("#street").val(), house_number = $("#house_number").val(), zipcode = $("#zipcode").val(), city = $("#city").val();
			
			// Place the values of every input field on the form in a variable.
			var data = $("#profile_wizard").serialize();				
				
			switch(i)
			{
				case 0:
					$.post(sub + '/user/profile', {first_name: first_name, last_name: last_name, phone_number: phone_number, bank_accnumber: bank_accnumber, bank_accname: bank_accname}, function(result)
					{
						// Post the fields of the current step.
						executeChecks(i, stepName, result);
						setProgress();
					});
					break;
				case 1:
					
					$.post(sub + '/user/profile', {company_name: company_name, street: street, house_number: house_number, zipcode: zipcode, city: city}, function(result)
					{
						// Post the fields of the current step.
						executeChecks(i, stepName, result);
						setProgress();						
					});
					break;				
				case 2:
					
					$.post(sub + '/user/profile', data, function(result)
					{
						// Post every field of the form.
						executeChecks(i, stepName, result);						
					});
					break;
			}	
		}

		
		function executeChecks(i, stepName, result) // Execute the checks.
		{
			var ajax_result = $.parseJSON(result); // Obtain post results and parse it through JSON.
			
			$("span.form_error").html(""); // Empty the error spans as a precaution.
			
			if(ajax_result.error == true) // When the results returns true show the errors.
			{				
				$.each(ajax_result, function(key, value) // Foreach result show an error below the correct input field.
				{
					$("span#"+key+"_error").html(value);
				});
			}
			else // When the results returns false continue to the next step or redirect after finishing.
			{
				if($("#current_module").val() == "events")
				{
					if(i == 4)
						window.location = sub + '/events/upload/' + ajax_result.event_url; // Redirect to event.
					else
						goToNextStep(i, stepName); // Go to the next step.
				}
			
				if($("#current_module").val() == "tickets")
				{	
					if($("#current_action").val() == "add")
					{					
						if(i == 3)
							window.location = sub + '/tickets/' + url + "/" + ajax_result.event_ticket_id; // Redirect to ticket.
						else
							goToNextStep(i, stepName); // Go to the next step.
					}
					
					if($("#current_action").val() == "edit")
					{
						if(i == 3)
							window.location = sub + '/tickets/' + url + "/" + item; // Redirect to ticket.
						else
							goToNextStep(i, stepName); // Go to the next step. 
					}
				}		
				
				if($("#current_module").val() == "user")
				{
					if( ajax_result.go_back )
						window.location = sub + '/cart/user_info';  // Redirect to cart.
					else
					{
						if(i == 2)
							window.location = sub + '/user/changed';  // Redirect to profile changed.
						else
							goToNextStep(i, stepName); // Go to the next step.
					}
				}
			}
		}
		
		$("#free_ticket").change(function () // On change toggle ticket price field.
		{
			var free_ticket = $("#free_ticket option:selected").val();
			
			if (free_ticket == "yes") 
			{
				$("#price").fadeOut(); // Hide the price input field
				
				$("#ticket_price").val("");  // Clear any value from the price field
				
				return;
			} 
			else 
			{
				$("#price").fadeIn(); // Show the price input field
				
				return;
			}
		});	


		// On change set the location options for the ticket layout.
		$("#barcode_loc").change(function(){ locationOptions(); });
		$("#description_loc").change(function(){ locationOptions(); });
		$("#image_loc").change(function(){ locationOptions(); });
		$("#info_loc").change(function(){ locationOptions(); });
	
		function locationOptions() // Execute location option toggle for the unchanged locations.
		{
			var barcode_loc = $("#barcode_loc option:selected").val();
			var description_loc = $("#description_loc option:selected").val();
			var image_loc = $("#image_loc option:selected").val();
			var info_loc = $("#info_loc option:selected").val();
				
			switch(barcode_loc)
			{
				case "upLeft":
					$("option.dlUpLeft").hide();
					$("option.ilUpLeft").hide();
					$("option.glUpLeft").hide();
					break;			
				case "upRight":
					$("option.dlUpRight").hide();
					$("option.ilUpRight").hide();
					$("option.glUpRight").hide();
					break;				
				case "downLeft":
					$("option.dlDownLeft").hide();
					$("option.ilDownLeft").hide();	
					$("option.glDownLeft").hide();	
					break;	
				case "downRight":
					$("option.dlDownRight").hide();
					$("option.ilDownRight").hide();
					$("option.glDownRight").hide();
					break;
			}

			switch(description_loc)
			{
				case "upLeft":
					$("option.blUpLeft").hide();
					$("option.ilUpLeft").hide();
					$("option.glUpLeft").hide();
					break;			
				case "upRight":
					$("option.blUpRight").hide();
					$("option.ilUpRight").hide();
					$("option.glUpRight").hide();
					break;				
				case "downLeft":
					$("option.blDownLeft").hide();
					$("option.ilDownLeft").hide();	
					$("option.glDownLeft").hide();	
					break;	
				case "downRight":
					$("option.blDownRight").hide();
					$("option.ilDownRight").hide();
					$("option.glDownRight").hide();
					break;
			}			
			
			switch(image_loc)
			{
				case "upLeft":
					$("option.blUpLeft").hide();
					$("option.dlUpLeft").hide();
					$("option.glUpLeft").hide();
					break;			
				case "upRight":
					$("option.blUpRight").hide();
					$("option.dlUpRight").hide();
					$("option.glUpRight").hide();
					break;				
				case "downLeft":
					$("option.blDownLeft").hide();
					$("option.dlDownLeft").hide();	
					$("option.glDownLeft").hide();	
					break;	
				case "downRight":
					$("option.blDownRight").hide();
					$("option.dlDownRight").hide();
					$("option.glDownRight").hide();
					break;
			}			
			
			switch(info_loc)
			{
				case "upLeft":
					$("option.blUpLeft").hide();
					$("option.dlUpLeft").hide();
					$("option.ilUpLeft").hide();
					break;			
				case "upRight":
					$("option.blUpRight").hide();
					$("option.dlUpRight").hide();
					$("option.ilUpRight").hide();
					break;				
				case "downLeft":
					$("option.blDownLeft").hide();
					$("option.dlDownLeft").hide();	
					$("option.ilDownLeft").hide();	
					break;	
				case "downRight":
					$("option.blDownRight").hide();
					$("option.dlDownRight").hide();
					$("option.ilDownRight").hide();
					break;
			}
			
			if(barcode_loc != "upLeft" && description_loc != "upLeft" && image_loc != "upLeft" && info_loc != "upLeft")
			{
				$("option.blUpLeft").show();
				$("option.dlUpLeft").show();
				$("option.ilUpLeft").show();
				$("option.glUpLeft").show();
			}			
			
			if(barcode_loc != "upRight" && description_loc != "upRight" && image_loc != "upRight" && info_loc != "upRight")
			{
				$("option.blUpRight").show();
				$("option.dlUpRight").show();
				$("option.ilUpRight").show();
				$("option.glUpRight").show();
			}			
			
			if(barcode_loc != "downLeft" && description_loc != "downLeft" && image_loc != "downLeft" && info_loc != "downLeft")
			{
				$("option.blDownLeft").show();
				$("option.dlDownLeft").show();
				$("option.ilDownLeft").show();
				$("option.glDownLeft").show();
			}			
			
			if(barcode_loc != "downRight" && description_loc != "downRight" && image_loc != "downRight" && info_loc != "downRight")
			{
				$("option.blDownRight").show();
				$("option.dlDownRight").show();
				$("option.ilDownRight").show();
				$("option.glDownRight").show();
			}
		}

		function setProgress() // Set the progression summary in the sidebar
		{
			// Profile Information Progress
			if($("#first_name").val() != "")
				$(".first_name_progress").html($("#first_name").val());
			else
				$(".first_name_progress").html("Leeg veld....");
				
			if($("#last_name").val() != "")	
				$(".last_name_progress").html($("#last_name").val());
			else
				$(".last_name_progress").html("Leeg veld....");		
				
			if($("#phone_number").val() != "")
				$(".phone_number_progress").html($("#phone_number").val());
			else
				$(".phone_number_progress").html("Leeg veld....");
				
			if($("#bank_accnumber").val() != "")
				$(".bank_accnumber_progress").html($("#bank_accnumber").val());
			else
				$(".bank_accnumber_progress").html("Leeg veld....");
				
			if($("#bank_accname").val() != "")
				$(".bank_accname_progress").html($("#bank_accname").val());
			else
				$(".bank_accname_progress").html("Leeg veld....");

			// Company Information Progress
			if($("#company_name").val() != "")
				$(".company_name_progress").html($("#company_name").val());
			else
				$(".company_name_progress").html("Leeg veld....");
				
			if($("#street").val() != "")
				$(".street_progress").html($("#street").val());
			else
				$(".street_progress").html("Leeg veld....");
				
			if($("#house_number").val() != "")	
				$(".house_number_progress").html($("#house_number").val());
			else
				$(".house_number_progress").html("Leeg veld....");
				
			if($("#zipcode").val() != "")			
				$(".zipcode_progress").html($("#zipcode").val());
			else
				$(".zipcode_progress").html("Leeg veld....");
				
			if($("#city").val() != "")			
				$(".city_progress").html($("#city").val());
			else
				$(".city_progress").html("Leeg veld....");				
			
			// Event Information Progress
			if( $("#current_module").val() == "events" )
			{	
				if($("#featured").attr("checked"))
					$(".featured_progress").html("Ja");
				else
					$(".featured_progress").html("Nee");
					
				switch($("#event_type option:selected").val())
				{
					case "theatre":
						$(".event_type_progress").html("Theater");	
						break;					
					case "music":
						$(".event_type_progress").html("Muziek");	
						break;					
					case "sports":
						$(".event_type_progress").html("Sport");	
						break;					
					case "film":
						$(".event_type_progress").html("Film");	
						break;
					case "":
						$(".event_type_progress").html("Leeg veld....");
						break
				}
					
				if($("#event_name").val() != "")
					$(".event_name_progress").html($("#event_name").val());
				else
					$(".event_name_progress").html("Leeg veld....");
					
				if($("#event_url_hash").val() != "")
					$(".url_hash_progress").html($("#event_url_hash").val());
				else
					$(".url_hash_progress").html("Leeg veld....");
					
				if($("#venue").val() != "")
					$(".venue_progress").html($("#venue").val());
				else
					$(".venue_progress").html("Leeg veld....");
					
				// Format Event Start Date Progress
				var set_start_date =  $("#event_start_date").val().split('-');
				
				var format_start_date = $.datepicker.formatDate('dd - MM - yy', new Date(set_start_date[0], set_start_date[1] - 1, set_start_date[2]));
				
				if($("#event_start_date").val() != "")
					$(".event_start_progress").html(format_start_date);
				else
					$(".event_start_progress").html("Leeg veld....");				
		
				// Format Event End Date Progress
				var set_end_date = $("#event_end_date").val().split('-');
				
				var format_end_date = $.datepicker.formatDate('dd - MM - yy', new Date(set_end_date[0], set_end_date[1] - 1, set_end_date[2]));
				
				if($("#event_end_date").val() != "")
					$(".event_end_progress").html(format_end_date);
				else
					$(".event_end_progress").html("Leeg veld....");
			}

			// Ticket Information Progress
			if( $("#current_module").val() == "tickets" || $("#current_module").val() == "events" )
			{
				
				if($("#ticket_type").val() != "")
					$(".ticket_type_progress").html($("#ticket_type").val());
				else
					$(".ticket_type_progress").html("Leeg veld....");

				// Format Ticket Start Date Progress
				var set_ticket_start_date =  $("#ticket_start_date").val().split('-');
					
				var format_ticket_start_date = $.datepicker.formatDate('dd MM yy', new Date(set_ticket_start_date[0], set_ticket_start_date[1] - 1, set_ticket_start_date[2]));
					
				if($("#ticket_start_date").val() != "")
					$(".ticket_start_progress").html(format_ticket_start_date);
				else
					$(".ticket_start_progress").html("Leeg veld....");

				// Format Ticket End Date Progress
				var set_ticket_end_date = $("#ticket_end_date").val().split('-');
					
				var format_ticket_end_date = $.datepicker.formatDate('dd MM yy', new Date(set_ticket_end_date[0], set_ticket_end_date[1] - 1, set_ticket_end_date[2]));
					
				if($("#ticket_end_date").val() != "")
					$(".ticket_end_progress").html(format_ticket_end_date);
				else
					$(".ticket_end_progress").html("Leeg veld....");

				// Price & Availability Progress
				if($("#ticket_price").val() != "")
				{
					if($("#ticket_price").val() == "0")
						$(".price_progress").html("Gratis");
					else
					{	
						var price = $("#ticket_price").val().replace(",", "."); // Precaution for when users enter , instead of . because toFixed() doesn't work with ,
						
						var unformatted_price = parseFloat(price).toFixed(2);
						
						var formatted_price = unformatted_price.replace(".", ",");
						
						$(".price_progress").html("&euro; " + formatted_price);
					}
				}
				else
					$(".price_progress").html("Leeg veld....");

				if($("#free_ticket option:selected").val() == "yes")			
					$(".price_progress").html("Gratis");

				if( $("#availability").val() <= 1 )
					var av_ticket_or_tickets = " ticket";
				else
					var av_ticket_or_tickets = " tickets";
					
				if($("#availability").val() != "")
					$(".available_progress").html($("#availability").val() + av_ticket_or_tickets);
				else
					$(".available_progress").html("Leeg veld....");			
				
				if( $("#max_purchase").val() <= 1 )
					var mp_ticket_or_tickets = " ticket";
				else
					var mp_ticket_or_tickets = " tickets";
				
				if($("#max_purchase").val() != "")			
					$(".max_progress").html($("#max_purchase").val() + mp_ticket_or_tickets);		
				else			
					$(".max_progress").html("Leeg veld....");				

				// Format Sale Start Date Progress
				var set_sale_start_date = $("#sale_start_date").val().split('-');
				
				var format_sale_start_date = $.datepicker.formatDate('dd MM yy', new Date(set_sale_start_date[0], set_sale_start_date[1] - 1, set_sale_start_date[2]));
				
				if($("#sale_start_date").val() != "")
					$(".sale_start_progress").html(format_sale_start_date);
				else
					$(".sale_start_progress").html("Leeg veld....");
			
				if($("#sale_start_hour option:selected").val() != "" && $("#sale_start_minute option:selected").val() != "")
					$(".sale_start_time_progress").html($("#sale_start_hour option:selected").val() + " : " + $("#sale_start_minute option:selected").val());
				else
					$(".sale_start_time_progress").html("Leeg veld....");	

				// Format Sale Start Date Progress
				var set_sale_end_date = $("#sale_end_date").val().split('-');
				
				var format_sale_end_date = $.datepicker.formatDate('dd MM yy', new Date(set_sale_end_date[0], set_sale_end_date[1] - 1, set_sale_end_date[2]));
				
				if($("#sale_end_date").val() != "")
					$(".sale_end_progress").html(format_sale_end_date);
				else
					$(".sale_end_progress").html("Leeg veld....");
					
				if($("#sale_end_hour option:selected").val() != "" && $("#sale_end_minute option:selected").val() != "")
					$(".sale_end_time_progress").html($("#sale_end_hour option:selected").val() + " : " + $("#sale_end_minute option:selected").val());
				else
					$(".sale_end_time_progress").html("Leeg veld....");	

				// Ticket Layout Progress
				loc_progress("image_loc");
				loc_progress("barcode_loc");
				loc_progress("description_loc");
				loc_progress("info_loc");
			}
		}
		
		function loc_progress(input_name) // Set the progress for the ticket layout
		{
			switch($("#" + input_name + " option:selected").val())
			{
				case "upLeft":
					$("." + input_name + "_progress").html("Linksboven");	
					break;					
				case "upRight":
					$("." + input_name + "_progress").html("Rechtsboven");	
					break;					
				case "downLeft":
					$("." + input_name + "_progress").html("Linksonder");	
					break;					
				case "downRight":
					$("." + input_name + "_progress").html("Rechtsonder");	
					break;
				case "":
					$("." + input_name + "_progress").html("Leeg veld....");
					break
			}			
		}

		$("#cancel").on("click", function()
		{			
			switch($("#current_module").val())
			{
				case "events":
					window.location = sub + '/events';
					break;
				case "tickets":
					if($("#current_action").val() == "add")
						window.location = sub + '/events/' + url;
					else
						window.location = sub + '/tickets/' + url + "/" + item;
					break;
				case "user":
					window.location = sub + '/home';
					break;
			}
		});
	}   	   	
})(jQuery); 