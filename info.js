<!--
	var posX = 15;
	var posY= -13;
	var allSupport = (document.all!=null || window.sidebar!=null);

	var image_path = "";

	function getElement(elName) {
		// Get an element from its ID
		if (allSupport)
			return document.getElementById(elName);
		else
			return document.layers[elName];
	}

	function writeContents(el, content) {
		// Replace the contents of the tooltip
		if (allSupport)
			el.innerHTML = content;
		else {
			// In NS, insert a table to work around
			// stylesheet rendering bug.
			// NS fails to apply style sheets when writing
			// contents into a positioned element.
			el.document.open();
			el.document.write("<TABLE BORDER=1 bordercolor=black width='100%' cellpadding=0 cellspacing=0><TR><TD BGCOLOR=#000000>");
			el.document.write(content);
			el.document.write("</TD></TR></TABLE>");
			el.document.close();
		}
	}

	function getOffset(el, which) {
		// Function for IE to calculate position 
		// of an element.
		var amount = el["offset"+which]; 
		if (which=="Top")
			amount+=el.offsetHeight;
		el = el.offsetParent;
		while (el!=null) {
			amount+=el["offset"+which];
			el = el.offsetParent;
		}
		return amount;
	}

	function setPosition(el, src, hpos) {
		if (hpos=="l")
			xOffset = -220;
		else
			xOffset = 0;

		if (allSupport) {
			var x = getOffset(src, "Left") + posX + xOffset;
			var y = getOffset(src, "Top") + posY;
			if (document.body.clientHeight + document.body.scrollTop < y + el.offsetHeight)
				y = y - el.offsetHeight;

			el.style.pixelTop = y;
			el.style.pixelLeft = x;
			//mozilla
			el.style.top = y + "px";
			el.style.left = x + "px";
		} else {
			el.top = src.y + 20 + posY;
			el.left = src.x + posX + xOffset;
		}
	}

	function setVisibility(el, bDisplay) {
		if (bDisplay)
			if (allSupport)
				el.style.visibility = "visible"; 
			else
				el.visibility = "show";
		else
			if (allSupport)
				el.style.visibility = "hidden";
			else
				el.visibility = "hidden";
	}

	function wrapContent(title, footer, content) {
		var result =
			"<table width='100%' class='messagestyle' background='" + image_path + "bgd.gif' cellspacing='0' cellpadding='3'>" +
			"	<tr>" +
			"		<td bgcolor='#000000'><b>" + title + "</b></td>" +
			"   </tr>"  +
			"   <tr>" +
			"   	<td>" + content + "</td>" +
			"   </tr>" +
			"   <tr>" +
			"   	<td height='5'><spacer type='block' width='1' height='1'></td>" +
			"   </tr>";
		if (footer)
			result +=
			"   <tr>" +
			"   	<td align='right' bgcolor='#31313A'><b>" + footer + "</b></td>" +
			"   </tr>";
		result += "</table>";

		return result;
	}

 	function tip(srcObj, title, footer, content, hpos) {
		var el = getElement("tipBox");
		writeContents(el, wrapContent(title, footer, content));
		setPosition(el, srcObj, hpos);
		setVisibility(el, true);
	}

	function nukeTip() {
		setVisibility(getElement("tipBox"), false);
	}
//-->
