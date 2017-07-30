
window.onload = function() {
	getHours();
	getClients();
};

$( function() {
	$( "#day" ).datepicker();
	$( "#day" ).datepicker('option', 'dateFormat' , 'yy-mm-dd');
} );
		
function getHours(){
	var filterClient = document.getElementById("filterAvailable");
	filterClient = filterClient.options[filterClient.selectedIndex].value;
	var filterType = document.getElementById("filterType").selectedIndex;
	
	$.ajax({
		method: "POST",
		url: "./server/getHours.php",
		dataType: "json",
		data: {client_id: filterClient, type: filterType},
		statusCode: {
			200: function (response) {
				var hours = document.getElementById("hours");
				while (hours.firstChild) {
					hours.removeChild(hours.firstChild);
				}
				
				var days = ["Mondays", "Tuesdays", "Wednesdays", "Thursdays", "Fridays", "Saturdays", "Sundays"];
				
				for(var i=0; i<response.length; i++){
					
					var new_hour = document.createElement('div');
					new_hour.className = "col-sm-4 col-md-4 col-lg-3";
					var new_hour_block = document.createElement('div');
					new_hour_block.className = "col-md-12 col-sm-12 col-xs-12 block client";
					var new_hour_block_date = document.createElement('h3');
					new_hour_block_date.className = "sectionTitle";
					if(response[i].repeat == 0)
						new_hour_block_date.innerHTML = response[i].day;
					else
						new_hour_block_date.innerHTML = days[response[i].day];
					
					var new_hour_block_hour = document.createElement('div');
					new_hour_block_hour.className = "col-md-12 col-sm-12 col-xs-12 form-group has-feedback";
					var new_hour_block_hour_font = document.createElement('font');
					new_hour_block_hour_font.className = "form-control has-feedback-left client";
					new_hour_block_hour_font.id = "user";
					if(response[i].hour < 10)
						new_hour_block_hour_font.innerHTML = "0" + response[i].hour + "h00m";
					else
						new_hour_block_hour_font.innerHTML = response[i].hour + "h00m";
					var new_hour_block_hour_span = document.createElement('span');
					new_hour_block_hour_span.className = "fa fa-clock-o form-control-feedback left";
					new_hour_block_hour_span.setAttribute("aria-hidden", "true");
					new_hour_block_hour.appendChild(new_hour_block_hour_font);
					new_hour_block_hour.appendChild(new_hour_block_hour_span);
					
					var new_hour_block_client = document.createElement('div');
					new_hour_block_client.className = "col-md-12 col-sm-12 col-xs-12 form-group has-feedback";
					var new_hour_block_client_font = document.createElement('font');
					new_hour_block_client_font.className = "form-control has-feedback-left client";
					new_hour_block_client_font.id = "user";
					if(response[i].client == -1)
						new_hour_block_client_font.innerHTML = "Available for all";
					else
						new_hour_block_client_font.innerHTML = response[i].client;
					var new_hour_block_client_span = document.createElement('span');
					new_hour_block_client_span.className = "fa fa-user form-control-feedback left";
					new_hour_block_client_span.setAttribute("aria-hidden", "true");
					new_hour_block_client.appendChild(new_hour_block_client_font);
					new_hour_block_client.appendChild(new_hour_block_client_span);
					
					var new_hour_block_delete = document.createElement('div');
					new_hour_block_delete.className = "col-md-12 col-sm-12 col-xs-12 form-group has-feedback";
					var new_hour_block_delete_input = document.createElement('input');
					new_hour_block_delete_input.className = "form-control button delete";
					new_hour_block_delete_input.type = "button";
					new_hour_block_delete_input.value = "Delete Client";
					new_hour_block_delete_input.id = response[i].id;
					new_hour_block_delete_input.repeat = response[i].repeat;
					new_hour_block_delete_input.hour = response[i].hour;
					new_hour_block_delete_input.day = response[i].day;
					new_hour_block_delete_input.client = response[i].client;
					new_hour_block_delete_input.onclick = function() { deleteHourConfirmation(this); };
					var new_hour_block_delete_span = document.createElement('span');
					new_hour_block_delete_span.className = "fa fa-trash-o form-control-feedback left";
					new_hour_block_delete_span.setAttribute("aria-hidden", "true");
					new_hour_block_delete_span.style.color = "#fff";
					new_hour_block_delete.appendChild(new_hour_block_delete_input);
					new_hour_block_delete.appendChild(new_hour_block_delete_span);
					
					new_hour_block.appendChild(new_hour_block_date);
					new_hour_block.appendChild(new_hour_block_hour);
					new_hour_block.appendChild(new_hour_block_client);
					new_hour_block.appendChild(new_hour_block_delete);
					new_hour.appendChild(new_hour_block);
					hours.appendChild(new_hour);
				}
			},
			500: function (response) {
			}
		}
	});
}
	
function deleteHourConfirmation(ele){
	var days = ["Mondays", "Tuesdays", "Wednesdays", "Thursdays", "Fridays", "Saturdays", "Sundays"];
	
	document.getElementById("modalYesTitle").innerHTML = "Delete Hour";
	
	var textModal = document.getElementById("modalYesText");
	textModal.innerHTML = "Are you sure you want to delete "
	if(ele.hour < 10)
		textModal.innerHTML += "0" + ele.hour + "h00m of ";
	else
		textModal.innerHTML += ele.hour + "h00m of ";
	if(ele.repeat == 0)
		textModal.innerHTML += "day " + ele.day;
	else
		textModal.innerHTML += days[ele.day];
	textModal.innerHTML += " available ";
	if(ele.client == -1)
		textModal.innerHTML += "to all the clients?";
	else
		textModal.innerHTML += "for " + ele.client + "?";
	
	document.getElementById("modalYesButton").onclick = function() { deleteHour(ele.id); };
	document.getElementById("modalYes").style.display = "block";
}

function deleteHour(hour_id_ui){
	document.getElementById("modalYes").style.display = "none";

	$.ajax({
		method: "POST",
		url: "./server/deleteHour.php",
		dataType: "json",
		data: {hour_id: hour_id_ui},
		statusCode: {
			200: function (response) {
				getHours();
			},
			500: function (response) {
				document.getElementById("modalCloseTitle").innerHTML = "Delete Hour";
				document.getElementById("modalCloseText").innerHTML = "An error occurred. Please try again later.";
				document.getElementById("modalClose").style.display = "block";
			}
		}
	});
}

function getClients(){
	$.ajax({
		method: "POST",
		url: "./server/getClients.php",
		data: {type: "short"},
		dataType: "json",
		statusCode: {
			200: function (response) {
				var clients = document.getElementById("available");
				var filterClients = document.getElementById("filterAvailable");
				
				for(var i=0; i<response.length; i++){
					var opt = document.createElement('option');
					opt.value = response[i].id;
					opt.innerHTML = response[i].user_name;
					clients.appendChild(opt);
					
					var opt = document.createElement('option');
					opt.value = response[i].id;
					opt.innerHTML = response[i].user_name;
					filterClients.appendChild(opt);
				}
			},
			500: function (response) {
			}
		}
	});
}

function changeRepeat(){
	var selectRepeat = document.getElementById("selectRepeat");
	if(selectRepeat.selectedIndex == 1){
		document.getElementById("day").disabled = false;
		document.getElementById("days").disabled = true;
	}else{
		document.getElementById("day").disabled = true;
		document.getElementById("days").disabled = false;
	}
}

function addHour(){
	var repeat_ui = document.getElementById("selectRepeat").selectedIndex;
	if(repeat_ui == 0)
		repeat_ui = 1;
	else
		repeat_ui = 0;
	var day_ui;
	if(repeat_ui == 0)
		day_ui = document.getElementById("day").value;
	else
		day_ui = document.getElementById("days").selectedIndex;
	
	var hour_ui = document.getElementById("hour");
	hour_ui = hour_ui.options[hour_ui.selectedIndex].value;
	var who_ui = document.getElementById("available");
	who_ui = who_ui.options[who_ui.selectedIndex].value;
	
	$.ajax({
		method: "POST",
		url: "./server/addHour.php",
		dataType: "json",
		data: {repeat: repeat_ui, day: day_ui, hour: hour_ui, who: who_ui},
		statusCode: {
			200: function (response) {
				getHours();
			},
			500: function (response) {
				document.getElementById("modalCloseTitle").innerHTML = "Add Hour";
				document.getElementById("modalCloseText").innerHTML = "An error occurred. Please try again later.";
				document.getElementById("modalClose").style.display = "block";
			}
		}
	});
}
