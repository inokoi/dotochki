// ������������� ����� �� �������, ������� ������ ����������� ������ �� ����������� ���������� ����
$(document).ready(function(){
	$(document).on('click', 'a.ajax-link', function(){
		//url = $(this).attr('href');
		ajaxDialog($(this));
		return false;
	});
});

// ������������ URL ����-������
function ajaxDialog($a) {
	if ($("#ajax-dialog-form").length == 0)
		$('<div id="ajax-dialog-form" />').appendTo('body');
	var $form = $("#ajax-dialog-form");
	var link = $a.attr('href');
	// ������ ��� �� ���������� ������
	var hash = link.substr(link.indexOf('#'));
	if ($form.html()=='')
		// �������� ������� ��� ����������� ����
		$.ajax({
			url: link,
			type: "POST",
			data: {mode: "ajax"},
			async: false,
			success: function (html){
				$form.html(html);
				// ��������� ����� ��� ��������� jQuery UI
				$(".tabs").tabs();
				$(".btn").button();
				// ����������� �������, ��������� ���
				$('a[href="' + hash + '"]').click();
				// ��� �������� ��������� JQ UI
				(function(){
					if ($('#ajax-dialog-form').parent('.ui-dialog').length == 0){
						setTimeout(arguments.callee,100); // ��������� ������� �������� ���� ���� ����� ������ 100 �����������
						return;
					}
					// ������� ������ ����� � ������ ������� � ������ ��� �� ���������
					$('#ajax-dialog-form .tabs>ul>li.ui-state-active>a').focus();
					// ��������� �����, ����������� �������� �������
					if (link.indexOf('object/card') != -1)
						$('#ajax-dialog-form').parent('.ui-dialog').addClass('object-card');
				})();
			},
			error: function (jqXHR, textStatus, errorThrown){
				console.log(textStatus + ' | ' + errorThrown);
			}
		});
	// � ����������� �� ��������� ������ ����������� title ��� ����������� ����
	title = $('#s-m-t-tooltip').text(); // ������� ����� title �� ������ ������������� ����������� ���������
	title = (title ? title : $a.text());
	// � ����������� �� ���� ������ ����� ��������� ������������ ����������� ����
	if (link.indexOf('client/card') != -1 || link.indexOf('object/card') != -1) {
		width = 900;
		//height = $(window).height();
		position = 'top';
		//title = '������ #' + title;
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
	// ������� ���� ����
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