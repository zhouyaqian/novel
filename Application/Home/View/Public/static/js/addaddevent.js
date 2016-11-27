//兼容浏览器
function addEvent(ele, type, hander) {
	if (ele.addEventListener) {
		ele.addEventListener(type, hander, false);
	} else if (ele.attachEvent) {
		ele.attachEvent('on' + type, hander);
	} else {
		ele['on' + type] = hander;
	}
}
