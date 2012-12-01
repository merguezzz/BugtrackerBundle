function notification(text, type, position) {

	if(!position) { position = "top-right"; }
	if(!type) {type = "st-success"; }

	$.sticky(text, {autoclose : 5000, position: position, type: type });
}
