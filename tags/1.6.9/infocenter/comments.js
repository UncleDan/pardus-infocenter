function comments_toggle() {
	var expander = document.getElementById("expander");
	var comments = document.getElementById("comments");
	if (expander.innerHTML == "+") {
		expander.innerHTML = "-";
		comments.style.display = "inline";
	} else {
		expander.innerHTML = "+";
		comments.style.display = "none";
	}
}
