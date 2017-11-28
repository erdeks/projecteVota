window.addEventListener('load', onLoad, true);

function onLoad(){
    var elementForm = document.getElementsByTagName('form')[0];
	animacionAdd(elementForm);
}

function animacionAdd(padre) {
	padre.style.overflow = "hidden";
	var height = 0;
	var totalHeight = padre.offsetHeight;
	var interval_id = setInterval(frame, 20);
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