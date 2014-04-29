// перехватываем клики по ссылкам, которые должны открыватьс€ а€ксом во всплывающем диалоговом окне
$(document).ready(function(){
	$(document).on('click', 'a.ajax-link', function(){
		//url = $(this).attr('href');
		ajaxDialog($(this));
		return false;
	});
});

// обрабатываем URL а€кс-ссылок
function ajaxDialog($a) {
	if ($("#ajax-dialog-form").length == 0)
		$('<div id="ajax-dialog-form" />').appendTo('body');
	var $form = $("#ajax-dialog-form");
	var link = $a.attr('href');
	// достаЄм хэш из полученной ссылки
	var hash = link.substr(link.indexOf('#'));
	if ($form.html()=='')
		// получаем контент дл€ диалогового окна
		$.ajax({
			url: link,
			type: "POST",
			data: {mode: "ajax"},
			async: false,
			success: function (html){
				$form.html(html);
				// добавл€ем стили дл€ элементов jQuery UI
				$(".tabs").tabs();
				$(".btn").button();
				// переключаем вкладку, использу€ хэш
				$('a[href="' + hash + '"]').click();
				// ждЄм загрузки элементов JQ UI
				(function(){
					if ($('#ajax-dialog-form').parent('.ui-dialog').length == 0){
						setTimeout(arguments.callee,100); // анонимна€ функци€ вызывает саму себ€ через каждые 100 миллисекунд
						return;
					}
					// удал€ем лишний фокус с первой вкладки и ставим его на выбранной
					$('#ajax-dialog-form .tabs>ul>li.ui-state-active>a').focus();
					// добавл€ем класс, стилизующий карточку объекта
					if (link.indexOf('object/card') != -1)
						$('#ajax-dialog-form').parent('.ui-dialog').addClass('object-card');
				})();
			},
			error: function (jqXHR, textStatus, errorThrown){
				console.log(textStatus + ' | ' + errorThrown);
			}
		});
	// в зависимости от атрибутов ссылки прописываем title дл€ диалогового окна
	title = $('#s-m-t-tooltip').text(); // пробуем вз€ть title из текста стилизованной всплывающей подсказки
	title = (title ? title : $a.text());
	// в зависимости от типа ссылки задаЄм параметры расположени€ диалогового окна
	if (link.indexOf('client/card') != -1 || link.indexOf('object/card') != -1) {
		width = 900;
		//height = $(window).height();
		position = 'top';
		//title = ' лиент #' + title;
	}
	else {
        if (link.indexOf('clients_list') != -1 || link.indexOf('objects_list') != -1) {
            width = 1200;
    		//height = 'auto';
    		position = 'center';
        } else {
    		width = 650;
    		//height = 'auto';
    		position = 'center';
        }
	}
	height = 'auto';
	// выводим само окно
	$form.dialog({
		modal: true,  
		title: title,
		width: width,
		height: height,
		position: position,
		close: function (event, ui){
			$form.html('');
		}
	});
        $('#s-m-t-tooltip').css('top',9000);
}