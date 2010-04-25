function rgb(color) {
	function numberToHex(number, length) {
		var num = new Number(number);
		var result = "";
		while (num) {
			var half = num & 0xF;
			num >>>= 4;
			var char = half < 10 ? new String(half) : String.fromCharCode("a".charCodeAt(0) + half - 10);
			result = char + result;
		}
		while (result.length < length)
			result = "0" + result;
		return result;
	}

	var rgbP = "rgb("
	if (color.substr(0, rgbP.length) != rgbP)
		return color;
	var colors = color.substring(rgbP.length, color.length - 1).split(", ");
	return "#" + numberToHex(colors[0], 2) + numberToHex(colors[1], 2) + numberToHex(colors[2], 2);
}

function formatDate(dateValue) {
	function n2(num) {
		return num < 10 ? "0" + num : num;
	}
	var date = new Date(dateValue);
	var result =
		date.getFullYear() + "-" + n2(date.getMonth() + 1) + "-" + n2(date.getDate()) + " " +
		n2(date.getHours()) + ":" + n2(date.getMinutes()) + ":" + n2(date.getSeconds());
	return result;
}

function chOn(el) {
    if (document.getElementById || (document.all && !(document.getElementById))) {
        if (rgb(el.style.backgroundColor) != "#142b54")
            el.style.backgroundColor = "#242b54";
    }
}

function chOut(el) {
    if (document.getElementById || (document.all && !(document.getElementById))) {
        if (rgb(el.style.backgroundColor) != "#142b54")
            el.style.backgroundColor = "#0b0b2f";
    }
}

function chClick(el) {
    if (document.getElementById || (document.all && !(document.getElementById))) {
        if (rgb(el.style.backgroundColor) == "#142b54")
            el.style.backgroundColor = "#0b0b2f";
        else
            el.style.backgroundColor = "#142b54";
    }
}