// перехватываем клики по ссылкам, которые должны открываться через айфрейм во всплывающем диалоговом окне
$(document).ready(function(){
	$('.iframe-link').live('click', function(){
		iframeDialog($(this));
		return false;
	});
});

// обрабатываем айфрейм-ссылку
function iframeDialog($a) {
	if ($("#iframe-dialog-form").length == 0)
		$('<div id="iframe-dialog-form" />').appendTo('body');
	$form = $("#iframe-dialog-form");
	$form.html('<iframe class="resizable-iframe" style="border: 0px; width: 890px; height: 600px;" src="' + $a.attr('href') + '" />');
	// в зависимости от атрибутов ссылки прописываем title для диалогового окна
	title = $('#s-m-t-tooltip').text();
	title = (title ? title : $a.text());
	// выводим само окно
	$form.dialog({
		modal: true,
		title: title,
		width: 917,
		position: 'top',
		close: function (event, ui){
			$form.html('');
		}
	});
}