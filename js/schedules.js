
window.onload = function() {
	getSchedules();
	getClients();
};
		
function getSchedules(){
	var filterClient = document.getElementById("filterAvailable").value;
	var filterWhen = document.getElementById("filterWhen").value;
	
	$.ajax({
		method: "POST",
		url: "./server/getSchedules.php",
		dataType: "json",
		data: {client_id: -1, when: filterWhen},
		statusCode: {
			200: function (response) {
				var schedules = document.getElementById("schedules");
				while (schedules.firstChild) {
					schedules.removeChild(schedules.firstChild);
				}
				
				var days = ["Mondays", "Tuesdays", "Wednesdays", "Thursdays", "Fridays", "Saturdays", "Sundays"];
				
				for(var i=0; i<response.length; i++){
					
					var new_schedule = document.createElement('div');
					new_schedule.className = "col-sm-4 col-md-4 col-lg-3";
					var new_schedule_block = document.createElement('div');
					new_schedule_block.className = "col-md-12 col-sm-12 col-xs-12 block client";
					var new_schedule_block_date = document.createElement('h3');
					new_schedule_block_date.className = "sectionTitle";
					new_schedule_block_date.innerHTML = response[i].day;
					
					var new_schedule_block_dayOfWeek = document.createElement('div');
					new_schedule_block_dayOfWeek.className = "col-md-12 col-sm-12 col-xs-12 form-group has-feedback no-margin-bottom";
					var new_schedule_block_dayOfWeek_font = document.createElement('font');
					new_schedule_block_dayOfWeek_font.className = "form-control has-feedback-left client";
					new_schedule_block_dayOfWeek_font.id = "dayOfWeek";
					new_schedule_block_dayOfWeek_font.innerHTML = response[i].dayOfWeek;
					var new_schedule_block_dayOfWeek_span = document.createElement('span');
					new_schedule_block_dayOfWeek_span.className = "fa fa-calendar form-control-feedback left";
					new_schedule_block_dayOfWeek_span.setAttribute("aria-hidden", "true");
					new_schedule_block_dayOfWeek.appendChild(new_schedule_block_dayOfWeek_font);
					new_schedule_block_dayOfWeek.appendChild(new_schedule_block_dayOfWeek_span);
					
					var new_schedule_block_hour = document.createElement('div');
					new_schedule_block_hour.className = "col-md-12 col-sm-12 col-xs-12 form-group has-feedback no-margin-bottom";
					var new_schedule_block_hour_font = document.createElement('font');
					new_schedule_block_hour_font.className = "form-control has-feedback-left client";
					new_schedule_block_hour_font.id = "hour";
					new_schedule_block_hour_font.innerHTML = response[i].hour;
					var new_schedule_block_hour_span = document.createElement('span');
					new_schedule_block_hour_span.className = "fa fa-clock-o form-control-feedback left";
					new_schedule_block_hour_span.setAttribute("aria-hidden", "true");
					new_schedule_block_hour.appendChild(new_schedule_block_hour_font);
					new_schedule_block_hour.appendChild(new_schedule_block_hour_span);
					
					var new_schedule_block_clientName = document.createElement('div');
					new_schedule_block_clientName.className = "col-md-12 col-sm-12 col-xs-12 form-group has-feedback no-margin-bottom";
					var new_schedule_block_clientName_font = document.createElement('font');
					new_schedule_block_clientName_font.className = "form-control has-feedback-left client";
					new_schedule_block_clientName_font.id = "hour";
					new_schedule_block_clientName_font.innerHTML = response[i].client_name;
					var new_schedule_block_clientName_span = document.createElement('span');
					new_schedule_block_clientName_span.className = "fa fa-users form-control-feedback left";
					new_schedule_block_clientName_span.setAttribute("aria-hidden", "true");
					new_schedule_block_clientName.appendChild(new_schedule_block_clientName_font);
					new_schedule_block_clientName.appendChild(new_schedule_block_clientName_span);
					
					var new_schedule_block_clientUser = document.createElement('div');
					new_schedule_block_clientUser.className = "col-md-12 col-sm-12 col-xs-12 form-group has-feedback no-margin-bottom";
					var new_schedule_block_clientUser_font = document.createElement('font');
					new_schedule_block_clientUser_font.className = "form-control has-feedback-left client";
					new_schedule_block_clientUser_font.id = "hour";
					new_schedule_block_clientUser_font.innerHTML = response[i].client_user;
					var new_schedule_block_clientUser_span = document.createElement('span');
					new_schedule_block_clientUser_span.className = "fa fa-user-circle-o form-control-feedback left";
					new_schedule_block_clientUser_span.setAttribute("aria-hidden", "true");
					new_schedule_block_clientUser.appendChild(new_schedule_block_clientUser_font);
					new_schedule_block_clientUser.appendChild(new_schedule_block_clientUser_span);
					
					var new_schedule_block_clientMail = document.createElement('div');
					new_schedule_block_clientMail.className = "col-md-12 col-sm-12 col-xs-12 form-group has-feedback no-margin-bottom";
					var new_schedule_block_clientMail_font = document.createElement('font');
					new_schedule_block_clientMail_font.className = "form-control has-feedback-left client";
					new_schedule_block_clientMail_font.id = "hour";
					new_schedule_block_clientMail_font.innerHTML = response[i].client_email;
					var new_schedule_block_clientMail_span = document.createElement('span');
					new_schedule_block_clientMail_span.className = "fa fa-envelope-o form-control-feedback left";
					new_schedule_block_clientMail_span.setAttribute("aria-hidden", "true");
					new_schedule_block_clientMail.appendChild(new_schedule_block_clientMail_font);
					new_schedule_block_clientMail.appendChild(new_schedule_block_clientMail_span);
					
					var new_schedule_block_clientPhone = document.createElement('div');
					new_schedule_block_clientPhone.className = "col-md-12 col-sm-12 col-xs-12 form-group has-feedback no-margin-bottom";
					var new_schedule_block_clientPhone_font = document.createElement('font');
					new_schedule_block_clientPhone_font.className = "form-control has-feedback-left client";
					new_schedule_block_clientPhone_font.id = "hour";
					new_schedule_block_clientPhone_font.innerHTML = response[i].client_phone;
					var new_schedule_block_clientPhone_span = document.createElement('span');
					new_schedule_block_clientPhone_span.className = "fa fa-phone form-control-feedback left";
					new_schedule_block_clientPhone_span.setAttribute("aria-hidden", "true");
					new_schedule_block_clientPhone.appendChild(new_schedule_block_clientPhone_font);
					new_schedule_block_clientPhone.appendChild(new_schedule_block_clientPhone_span);
					
					var new_schedule_block_clientObs = document.createElement('div');
					new_schedule_block_clientObs.className = "col-md-12 col-sm-12 col-xs-12 form-group has-feedback no-margin-bottom";
					var new_schedule_block_clientObs_font = document.createElement('font');
					new_schedule_block_clientObs_font.className = "form-control has-feedback-left client";
					new_schedule_block_clientObs_font.id = "hour";
					new_schedule_block_clientObs_font.innerHTML = response[i].obs;
					var new_schedule_block_clientObs_span = document.createElement('span');
					new_schedule_block_clientObs_span.className = "fa fa-pencil form-control-feedback left";
					new_schedule_block_clientObs_span.setAttribute("aria-hidden", "true");
					new_schedule_block_clientObs.appendChild(new_schedule_block_clientObs_font);
					new_schedule_block_clientObs.appendChild(new_schedule_block_clientObs_span);
					
					var new_schedule_block_done = document.createElement('div');
					new_schedule_block_done.className = "col-md-12 col-sm-12 col-xs-12 form-group has-feedback";
					var new_schedule_block_done_input = document.createElement('input');
					new_schedule_block_done_input.className = "form-control button sucess";
					new_schedule_block_done_input.type = "button";
					new_schedule_block_done_input.value = "Done";
					new_schedule_block_done_input.id = response[i].id;
					new_schedule_block_done_input.day = response[i].day;
					new_schedule_block_done_input.hour = response[i].hour;
					new_schedule_block_done_input.onclick = function() { markDoneConfirmation(this); };
					var new_schedule_block_done_span = document.createElement('span');
					new_schedule_block_done_span.className = "fa fa-check form-control-feedback left";
					new_schedule_block_done_span.setAttribute("aria-hidden", "true");
					new_schedule_block_done_span.style.color = "#fff";
					new_schedule_block_done.appendChild(new_schedule_block_done_input);
					new_schedule_block_done.appendChild(new_schedule_block_done_span);
					
					var new_schedule_block_delete = document.createElement('div');
					new_schedule_block_delete.className = "col-md-12 col-sm-12 col-xs-12 form-group has-feedback";
					var new_schedule_block_delete_input = document.createElement('input');
					new_schedule_block_delete_input.className = "form-control button delete";
					new_schedule_block_delete_input.type = "button";
					new_schedule_block_delete_input.value = "Delete this hour";
					new_schedule_block_delete_input.id = response[i].id;
					new_schedule_block_delete_input.day = response[i].day;
					new_schedule_block_delete_input.hour = response[i].hour;
					new_schedule_block_delete_input.client = response[i].client_name;
					new_schedule_block_delete_input.obsID = "obs_" + i;
					new_schedule_block_delete_input.onclick = function() { deleteHourConfirmation(this); };
					var new_schedule_block_delete_span = document.createElement('span');
					new_schedule_block_delete_span.className = "fa fa-trash-o form-control-feedback left";
					new_schedule_block_delete_span.setAttribute("aria-hidden", "true");
					new_schedule_block_delete_span.style.color = "#fff";
					new_schedule_block_delete.appendChild(new_schedule_block_delete_input);
					new_schedule_block_delete.appendChild(new_schedule_block_delete_span);
					
					new_schedule_block.appendChild(new_schedule_block_date);
					new_schedule_block.appendChild(new_schedule_block_dayOfWeek);
					new_schedule_block.appendChild(new_schedule_block_hour);
					new_schedule_block.appendChild(new_schedule_block_clientName);
					new_schedule_block.appendChild(new_schedule_block_clientUser);
					new_schedule_block.appendChild(new_schedule_block_clientMail);
					new_schedule_block.appendChild(new_schedule_block_clientPhone);
					new_schedule_block.appendChild(new_schedule_block_clientObs);
					new_schedule_block.appendChild(new_schedule_block_done);
					new_schedule_block.appendChild(new_schedule_block_delete);
					new_schedule.appendChild(new_schedule_block);
					schedules.appendChild(new_schedule);
				}
			},
			500: function (response) {
			}
		}
	});
}
	
function deleteHourConfirmation(ele){
	document.getElementById("modalYesTitle").innerHTML = "Delete Hour";
	
	var textModal = document.getElementById("modalYesText");
	
	textModal.innerHTML = "Are you sure you want to delete ";
	if(ele.hour < 10)
		textModal.innerHTML += "0" + ele.hour + "h00m of ";
	else
		textModal.innerHTML += ele.hour + "h00m of ";
	if(ele.repeat == 0)
		textModal.innerHTML += "day " + ele.day;
	else
		textModal.innerHTML += ele.day;
	textModal.innerHTML += " available ";
	if(ele.client == -1)
		textModal.innerHTML += "to all the clients?";
	else
		textModal.innerHTML += "for " + ele.client + "?";
	
	document.getElementById("modalYesButton").onclick = function() { deleteHour(ele.id); };
	
	document.getElementById("modalYes").style.display = "block";
}

function deleteHour(schedule_id_ui){
	document.getElementById("modalYes").style.display = "none";

	$.ajax({
		method: "POST",
		url: "./server/deleteScheduleHour.php",
		dataType: "json",
		data: {schedule_id: schedule_id_ui},
		statusCode: {
			200: function (response) {
				getSchedules();
			},
			500: function (response) {
				document.getElementById("modalCloseTitle").innerHTML = "Delete Hour";
				document.getElementById("modalCloseText").innerHTML = "An error occurred. Please try again later.";
				document.getElementById("modalClose").style.display = "block";
			}
		}
	});
}

function markDoneConfirmation(ele){
	document.getElementById("modalYesTitle").innerHTML = "Done";
	
	var textModal = document.getElementById("modalYesText");
	textModal.innerHTML = "Are you sure you want to delete "
	if(ele.hour < 10)
		textModal.innerHTML += "0" + ele.hour + "h00m of ";
	else
		textModal.innerHTML += ele.hour + "h00m of ";
	if(ele.repeat == 0)
		textModal.innerHTML += "day " + ele.day;
	else
		textModal.innerHTML += ele.day;
	textModal.innerHTML += " available ";
	if(ele.client == -1)
		textModal.innerHTML += "to all the clients?";
	else
		textModal.innerHTML += "for " + ele.client + "?";
	
	document.getElementById("modalYesButton").onclick = function() { markDone(ele.id); };
	document.getElementById("modalYes").style.display = "block";
}

function markDone(schedule_id_ui){
	document.getElementById("modalYes").style.display = "none";

	$.ajax({
		method: "POST",
		url: "./server/markScheduleHour.php",
		dataType: "json",
		data: {schedule_id: schedule_id_ui},
		statusCode: {
			200: function (response) {
				getSchedules();
			},
			500: function (response) {
				document.getElementById("modalCloseTitle").innerHTML = "Done";
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
				var filterClients = document.getElementById("filterAvailable");
				
				for(var i=0; i<response.length; i++){
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
	
	var hour_ui = document.getElementById("hour").value;
	var who_ui = document.getElementById("available").value;
	
	$.ajax({
		method: "POST",
		url: "./server/addHour.php",
		dataType: "json",
		data: {repeat: repeat_ui, day: day_ui, hour: hour_ui, who: who_ui},
		statusCode: {
			200: function (response) {
				getSchedules();
			},
			500: function (response) {
				document.getElementById("modalCloseTitle").innerHTML = "Add Hour";
				document.getElementById("modalCloseText").innerHTML = "An error occurred. Please try again later.";
				document.getElementById("modalClose").style.display = "block";
			}
		}
	});
}
