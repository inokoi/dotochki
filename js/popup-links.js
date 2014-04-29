// параметры всплывающего окна
var newWin = {};
var winWidth = 900;
var winHeight = 600;
var winLeft = 0;
var winTop = 0;
var params = '';

// перехватываем клики по ссылкам, которые должны открываться во всплывающем окне браузера
$(document).ready(function(){
	$('.popup-link, a[href*="client/card"], a[href*="object/card"]').live('click', function(){
		popupWindow($(this));
		return false;
	});
});

// обрабатываем popup-ссылку
function popupWindow($a) {
	// растягиваем почти на всю высоту экрана
	winHeight = screen.availHeight - 120;
	// центрируем относительно экрана
	winLeft = Math.round(screen.availWidth - winWidth) / 2;
	winTop = Math.round(screen.availHeight - winHeight) / 2;
	params = 'menubar=yes,location=yes,resizable=yes,scrollbars=yes,left=' + winLeft + ',top=' + winTop + ',width=' + winWidth + ',height=' + winHeight;
	newWin = window.open($a.attr('href'), '_blank', params);
	newWin.focus();
}