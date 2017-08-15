
window.onload = function() {
	getClients();
};

function createClient(){
	var name_ui = document.getElementById("name").value;
	var user_ui = document.getElementById("user").value;
	var email_ui = document.getElementById("email").value;
	var phone_ui = document.getElementById("phone").value;
	
	if(name_ui == "" || user_ui == "" || email_ui == ""){
		document.getElementById("modalCloseTitle").innerHTML = "Create Client";
		document.getElementById("modalCloseText").innerHTML = "You need to complete the client information.";
		document.getElementById("modalClose").style.display = "block";
		return;
	}
		
	$.ajax({
		method: "POST",
		url: "./server/registerClient.php",
		data: {name: name_ui, user_name: user_ui, email: email_ui, phone: phone_ui},
		statusCode: {
			200: function (response) {
				alert("password: " + response);
				getClients();
			},
			500: function (response) {
				document.getElementById("modalCloseTitle").innerHTML = "Create Client";
				document.getElementById("modalCloseText").innerHTML = "An error occurred. Please try again later.";
				document.getElementById("modalClose").style.display = "block";
			}
		}
	});
}

function deleteClientConfirmation(ele){
	document.getElementById("modalYesTitle").innerHTML = "Delete Client";
	document.getElementById("modalYesText").innerHTML = "Are you sure you want to delete \"" + ele.name + "\"?";
	document.getElementById("modalYesButton").onclick = function() { deleteClient(ele.username); };
	document.getElementById("modalYes").style.display = "block";
}

function deleteClient(username_ui){
	document.getElementById("modalYes").style.display = "none";

	$.ajax({
		method: "POST",
		url: "./server/deleteClient.php",
		dataType: "json",
		data: {user_name: username_ui},
		statusCode: {
			200: function (response) {
				getClients();
			},
			500: function (response) {
				document.getElementById("modalCloseTitle").innerHTML = "Delete Client";
				document.getElementById("modalCloseText").innerHTML = "An error occurred. Please try again later.";
				document.getElementById("modalClose").style.display = "block";
			}
		}
	});
}

function resetPasswordConfirmation(ele){
	document.getElementById("modalYesTitle").innerHTML = "Reset Password";
	document.getElementById("modalYesText").innerHTML = "Are you sure you want to reset \"" + ele.name + "\" password?";
	document.getElementById("modalYesButton").onclick = function() { resetPassword(ele.username, ele.email); };
	document.getElementById("modalYes").style.display = "block";
}

function resetPassword(username_ui, email_ui){
	document.getElementById("modalYes").style.display = "none";

	$.ajax({
		method: "POST",
		url: "./server/resetClient.php",
		data: {user_name: username_ui, email: email_ui},
		statusCode: {
			200: function (response) {
				document.getElementById("modalCloseTitle").innerHTML = "Reset Password";
				document.getElementById("modalCloseText").innerHTML = "Password reseted. The client will receive an email with the new password."
				document.getElementById("modalClose").style.display = "block";
				alert("password: " + response);
			},
			500: function (response) {
				document.getElementById("modalCloseTitle").innerHTML = "Reset Password";
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
		dataType: "json",
		statusCode: {
			200: function (response) {
				var clients = document.getElementById("clients");
				while (clients.firstChild) {
					clients.removeChild(clients.firstChild);
				}
				for(var i=0; i<response.length; i++){
					
					var new_client = document.createElement('div');
					new_client.className = "col-md-4";
					var new_client_block = document.createElement('div');
					new_client_block.className = "col-md-12 col-sm-12 col-xs-12 block client";
					var new_client_block_name = document.createElement('h3');
					new_client_block_name.className = "sectionTitle";
					new_client_block_name.innerHTML = response[i].name;
					
					var new_client_block_username = document.createElement('div');
					new_client_block_username.className = "col-md-12 col-sm-12 col-xs-12 form-group has-feedback";
					var new_client_block_username_font = document.createElement('font');
					new_client_block_username_font.className = "form-control has-feedback-left client";
					new_client_block_username_font.id = "user";
					new_client_block_username_font.innerHTML = response[i].user_name;
					var new_client_block_username_span = document.createElement('span');
					new_client_block_username_span.className = "fa fa-user-circle-o form-control-feedback left";
					new_client_block_username_span.setAttribute("aria-hidden", "true");
					new_client_block_username.appendChild(new_client_block_username_font);
					new_client_block_username.appendChild(new_client_block_username_span);
					
					var new_client_block_pass = document.createElement('div');
					new_client_block_pass.className = "col-md-12 col-sm-12 col-xs-12 form-group has-feedback";
					var new_client_block_pass_font = document.createElement('font');
					new_client_block_pass_font.className = "form-control has-feedback-left client";
					new_client_block_pass_font.id = "user";
					new_client_block_pass_font.innerHTML = "*****";
					var new_client_block_pass_reset = document.createElement('button');
					new_client_block_pass_reset.className = "button reset";
					new_client_block_pass_reset.innerHTML = "reset";
					new_client_block_pass_reset.name = response[i].name;
					new_client_block_pass_reset.username = response[i].user_name;
					new_client_block_pass_reset.email = response[i].email;
					new_client_block_pass_reset.onclick = function() { resetPasswordConfirmation(this); };
					new_client_block_pass_font.appendChild(new_client_block_pass_reset);
					var new_client_block_pass_span = document.createElement('span');
					new_client_block_pass_span.className = "fa fa-unlock-alt form-control-feedback left";
					new_client_block_pass_span.setAttribute("aria-hidden", "true");
					new_client_block_pass.appendChild(new_client_block_pass_font);
					new_client_block_pass.appendChild(new_client_block_pass_span);
					
					var new_client_block_mail = document.createElement('div');
					new_client_block_mail.className = "col-md-12 col-sm-12 col-xs-12 form-group has-feedback";
					var new_client_block_mail_font = document.createElement('font');
					new_client_block_mail_font.className = "form-control has-feedback-left client";
					new_client_block_mail_font.id = "user";
					new_client_block_mail_font.innerHTML = response[i].email;
					var new_client_block_mail_span = document.createElement('span');
					new_client_block_mail_span.className = "fa fa-envelope-o form-control-feedback left";
					new_client_block_mail_span.setAttribute("aria-hidden", "true");
					new_client_block_mail.appendChild(new_client_block_mail_font);
					new_client_block_mail.appendChild(new_client_block_mail_span);
					
					var new_client_block_phone = document.createElement('div');
					new_client_block_phone.className = "col-md-12 col-sm-12 col-xs-12 form-group has-feedback";
					var new_client_block_phone_font = document.createElement('font');
					new_client_block_phone_font.className = "form-control has-feedback-left client";
					new_client_block_phone_font.id = "user";
					new_client_block_phone_font.innerHTML = response[i].phone;
					var new_client_block_phone_span = document.createElement('span');
					new_client_block_phone_span.className = "fa fa-phone form-control-feedback left";
					new_client_block_phone_span.setAttribute("aria-hidden", "true");
					new_client_block_phone.appendChild(new_client_block_phone_font);
					new_client_block_phone.appendChild(new_client_block_phone_span);
					
					var new_client_block_delete = document.createElement('div');
					new_client_block_delete.className = "col-md-12 col-sm-12 col-xs-12 form-group has-feedback";
					var new_client_block_delete_input = document.createElement('input');
					new_client_block_delete_input.className = "form-control button delete";
					new_client_block_delete_input.type = "button";
					new_client_block_delete_input.value = "Delete Client";
					new_client_block_delete_input.name = response[i].name;
					new_client_block_delete_input.username = response[i].user_name;
					new_client_block_delete_input.onclick = function() { deleteClientConfirmation(this); };
					var new_client_block_delete_span = document.createElement('span');
					new_client_block_delete_span.className = "fa fa-trash-o form-control-feedback left";
					new_client_block_delete_span.setAttribute("aria-hidden", "true");
					new_client_block_delete_span.style.color = "#fff";
					new_client_block_delete.appendChild(new_client_block_delete_input);
					new_client_block_delete.appendChild(new_client_block_delete_span);
					
					new_client_block.appendChild(new_client_block_name);
					new_client_block.appendChild(new_client_block_username);
					new_client_block.appendChild(new_client_block_pass);
					new_client_block.appendChild(new_client_block_mail);
					new_client_block.appendChild(new_client_block_phone);
					new_client_block.appendChild(new_client_block_delete);
					new_client.appendChild(new_client_block);
					clients.appendChild(new_client);
				}
			},
			500: function (response) {
				var clients = document.getElementById("clients");
				
				var error = document.createElement('div');
				error.className = "col-md-4";
					
				var error_text = document.createElement('h4');
				error_text.style.color = "#999";
				error_text.innerHTML = "Error in the server side";
				
				error.appendChild(error_text);
				clients.appendChild(error);
			}
		}
	});
}
