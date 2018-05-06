var first = null;
var two = null;

function Select(number, elm) {
	var temp = document.getElementById(elm);
	
	if (first == null) {
		first = number;
		temp.innerHTML = "(You give) " + temp.textContent;
		temp.style.background = "white";
	}
	
	else if(number == first)
		alert("Select another method of obtaining, please");
	
	else if (two == null) {
		two = number;
		temp.innerHTML = "(You get) " + temp.textContent;
		temp.style.background = "white";
	}
	
	if(first != null && two != null)
		document.location = "127.0.0.1/exchange.php?give="+first+"&get="+two;
}