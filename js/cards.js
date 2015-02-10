
function setModalLabel(cardName, cardImgSrc, textToShow)
{
	document.getElementById("cardModalLabel").innerHTML = cardName;
	document.getElementById("cardModalImg").src = cardImgSrc;
	document.getElementById("cardModalText").innerHTML = textToShow;
}
