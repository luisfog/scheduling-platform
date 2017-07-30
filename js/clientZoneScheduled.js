
window.onload = function() {
	getSchedules();
};
	
function getSchedules(){
	$.ajax({
		method: "POST",
		url: "./server/getSchedulesPerClient.php",
		dataType: "json",
		statusCode: {
			200: function (response) {
				var hours = document.getElementById("hours");
				while (hours.firstChild) {
					hours.removeChild(hours.firstChild);
				}
				
				var days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
				
				for(var i=0; i<response.length; i++){
					
					var new_hour = document.createElement('div');
					new_hour.className = "col-sm-4 col-md-4 col-lg-3";
					var new_hour_block = document.createElement('div');
					new_hour_block.className = "col-md-12 col-sm-12 col-xs-12 block client";
					var new_hour_block_date = document.createElement('h3');
					new_hour_block_date.className = "sectionTitle";
					new_hour_block_date.innerHTML = response[i].day;
					
					var new_hour_block_dayOfWeek = document.createElement('div');
					new_hour_block_dayOfWeek.className = "col-md-12 col-sm-12 col-xs-12 form-group has-feedback";
					var new_hour_block_dayOfWeek_font = document.createElement('font');
					new_hour_block_dayOfWeek_font.className = "form-control has-feedback-left client";
					new_hour_block_dayOfWeek_font.id = "dayOfWeek";
					new_hour_block_dayOfWeek_font.innerHTML = response[i].dayOfWeek;
					var new_hour_block_dayOfWeek_span = document.createElement('span');
					new_hour_block_dayOfWeek_span.className = "fa fa-calendar form-control-feedback left";
					new_hour_block_dayOfWeek_span.setAttribute("aria-hidden", "true");
					new_hour_block_dayOfWeek.appendChild(new_hour_block_dayOfWeek_font);
					new_hour_block_dayOfWeek.appendChild(new_hour_block_dayOfWeek_span);
					
					var new_hour_block_hour = document.createElement('div');
					new_hour_block_hour.className = "col-md-12 col-sm-12 col-xs-12 form-group has-feedback";
					var new_hour_block_hour_font = document.createElement('font');
					new_hour_block_hour_font.className = "form-control has-feedback-left client";
					new_hour_block_hour_font.id = "hour";
					new_hour_block_hour_font.innerHTML = response[i].hour;
					var new_hour_block_hour_span = document.createElement('span');
					new_hour_block_hour_span.className = "fa fa-clock-o form-control-feedback left";
					new_hour_block_hour_span.setAttribute("aria-hidden", "true");
					new_hour_block_hour.appendChild(new_hour_block_hour_font);
					new_hour_block_hour.appendChild(new_hour_block_hour_span);
					
					var new_hour_block_obs = document.createElement('div');
					new_hour_block_obs.className = "col-md-12 col-sm-12 col-xs-12 form-group has-feedback";
					var new_hour_block_obs_font = document.createElement('font');
					new_hour_block_obs_font.className = "form-control has-feedback-left client";
					new_hour_block_obs_font.id = "hour";
					new_hour_block_obs_font.innerHTML = response[i].obs;
					var new_hour_block_obs_span = document.createElement('span');
					new_hour_block_obs_span.className = "fa fa-pencil form-control-feedback left";
					new_hour_block_obs_span.setAttribute("aria-hidden", "true");
					new_hour_block_obs.appendChild(new_hour_block_obs_font);
					new_hour_block_obs.appendChild(new_hour_block_obs_span);
					
					var new_hour_block_delete = document.createElement('div');
					new_hour_block_delete.className = "col-md-12 col-sm-12 col-xs-12 form-group has-feedback";
					var new_hour_block_delete_input = document.createElement('input');
					new_hour_block_delete_input.className = "form-control button delete";
					new_hour_block_delete_input.type = "button";
					new_hour_block_delete_input.value = "Delete";
					new_hour_block_delete_input.id = response[i].id;
					new_hour_block_delete_input.day = response[i].day;
					new_hour_block_delete_input.hour = response[i].hour;
					new_hour_block_delete_input.onclick = function() { deleteHourConfirmation(this); };
					var new_hour_block_delete_span = document.createElement('span');
					new_hour_block_delete_span.className = "fa fa-trash-o form-control-feedback left";
					new_hour_block_delete_span.setAttribute("aria-hidden", "true");
					new_hour_block_delete_span.style.color = "#fff";
					new_hour_block_delete.appendChild(new_hour_block_delete_input);
					new_hour_block_delete.appendChild(new_hour_block_delete_span);
					
					new_hour_block.appendChild(new_hour_block_date);
					new_hour_block.appendChild(new_hour_block_dayOfWeek);
					new_hour_block.appendChild(new_hour_block_hour);
					new_hour_block.appendChild(new_hour_block_obs);
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
	document.getElementById("modalYesTitle").innerHTML = "Delete";
	
	var textModal = document.getElementById("modalYesText");
	textModal.innerHTML = "Are you sure you want to delete: "
							+ ele.hour + "h00m of " + ele.day + "?";
	
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
				document.getElementById("modalCloseTitle").innerHTML = "Delete";
				document.getElementById("modalCloseText").innerHTML = "An error occurred. Please contact by phone: +351 987 654 321";
				document.getElementById("modalClose").style.display = "block";
			}
		}
	});
}

