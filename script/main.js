function test() {
	console.log('Script folder included correct.');
};

function ajax(controller) {
	return "ajax/" + controller + '.php';
}

function validate(field_object) {
	var error = new Array();
	for(var i in field_object) {
		switch(field_object[i]['validate']) {
			case "password":
				if(! field_object[i]['text'].match(/^[\w]{5,}$/g))
					error[error.length] = field_object[i]['id'];
				break;
			case "text":
				if(! field_object[i]['text'].match(/^[\w]{3,}$/g))
					error[error.length] = field_object[i]['id'];
				break;
			case "email":
				if(! field_object[i]['text'].match(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/g))
					error[error.length] = field_object[i]['id'];
				break;
			break;
		}
	}
	if(error[0])
		return error;
	return false;
}

function validate_form(form) {
	var holder = new Array();
	$('#'+form+' input').each(function() {
		holder[holder.length] = {
			id: $(this).attr('id'),
			text: $(this).val(),
			validate: $(this).attr('validate')
		};
	});
	var error = validate(holder);
	if(error)
		return error;
	return false;
}

function validate_field(field) {
	var holder = [
	 field = {
			id: field,
			text: $('#'+field).val(),
			validate: $('#'+field).attr('validate')
		}
	];
	var error = validate(holder);
	if(error)
		return error;
	return false;
}