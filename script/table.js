function goToPage(url) {
	if (url != "") {
		open(url, "_self");
	}
}

function tickAll() {
	var allInputs = document.getElementsByTagName("input");
	var state;
	//Check if the first button is clicked
	if (allInputs[0].checked == true)
		state = true;
	else
		state = false;
	//Apply to the rest of the buttons
	for (var i = 1, max = allInputs.length; i < max; i++) {
		if (allInputs[i].type === 'checkbox')
			allInputs[i].checked = state;
	}
}