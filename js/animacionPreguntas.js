window.onload = function() {
  inicializar();
};

function inicializar(){
	var elementForm = document.getElementsByTagName['form'][0];
	animacionAdd(elementForm);
}
function animacionAdd(padre) {
	alert("a")
	var height = padre.offsetHeight;
	var totalHeight = getHeightContenedorRespuestas(padre);
	setInterval(frame, 1);
	padre.style.overflow = "hidden";
	function frame() {
		if (height >= totalHeight) {
			padre.style.overflow = "";
		} else {
			height++;
			padre.style.height = height + 'px';
		}
	}
}
function getHeightTotalContenedor(padre){
	var totalHeight = 0;
	for(var i = 0; i < padre.children.length; i++){
		totalHeight += padre.children[i].offsetHeight;
	}
	return totalHeight;
}