window.addEventListener('load', onLoad, true);

function onLoad(){
    var elementForm = document.getElementsByClassName('animacionDesplegar')[0];
	animacionAdd(elementForm);
}

function animacionAdd(padre) {
	padre.style.overflow = "hidden";
	var totalHeight = padre.offsetHeight;
	padre.style.height = "0px";
	var height = 0;
	var interval_id = setInterval(frame, 15);
	function frame() {
		if (height >= totalHeight) {
			padre.removeAttribute("style");
			clearInterval(interval_id);
		} else {
			height++;
			padre.style.height = height + 'px';
		}
	}
}