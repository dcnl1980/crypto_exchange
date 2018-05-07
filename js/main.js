function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

async function Select(number) {
	var temp = document.getElementById("sct"+number);

	temp.style.background = "#A9A9A9";
	temp.style.borderTopLeftRadius  = "2px";
	temp.style.borderTopRightRadius  = "2px";

	await sleep(2000);
	
	document.location = "127.0.0.1/exchange.php?pair="+number;
}