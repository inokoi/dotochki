// ������������� ����� �� �������, ������� ������ ����������� ����� ������� �� ����������� ���������� ����
$(document).ready(function(){
	$('.iframe-link').live('click', function(){
		iframeDialog($(this));
		return false;
	});
});

// ������������ �������-������
function iframeDialog($a) {
	if ($("#iframe-dialog-form").length == 0)
		$('<div id="iframe-dialog-form" />').appendTo('body');
	$form = $("#iframe-dialog-form");
	$form.html('<iframe class="resizable-iframe" style="border: 0px; width: 890px; height: 600px;" src="' + $a.attr('href') + '" />');
	// � ����������� �� ��������� ������ ����������� title ��� ����������� ����
	title = $('#s-m-t-tooltip').text();
	title = (title ? title : $a.text());
	// ������� ���� ����
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