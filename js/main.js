function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

async function Select(number) {
	var temp = document.getElementById("sct"+number);

	temp.style.background = "#A9A9A9";
	temp.style.borderTopLeftRadius  = "2px";
	temp.style.borderTopRightRadius  = "2px";

	await sleep(2000);
	
	document.location = "/exchange.php?pair="+number;
}

async function caclGet(deal,price) {
	while(true) {
		var b = 0;
		
		if(deal == "f-c") 
			b = 1*document.getElementById('cs').value/price;
		else 
			b = document.getElementById('cs').value*price/1;
		
		document.getElementById('getting').innerHTML = b;
		await sleep(1300);
	}
}