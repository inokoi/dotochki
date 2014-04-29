// ��������� ������������ ����
var newWin = {};
var winWidth = 900;
var winHeight = 600;
var winLeft = 0;
var winTop = 0;
var params = '';

// ������������� ����� �� �������, ������� ������ ����������� �� ����������� ���� ��������
$(document).ready(function(){
	$('.popup-link, a[href*="client/card"], a[href*="object/card"]').live('click', function(){
		popupWindow($(this));
		return false;
	});
});

// ������������ popup-������
function popupWindow($a) {
	// ����������� ����� �� ��� ������ ������
	winHeight = screen.availHeight - 120;
	// ���������� ������������ ������
	winLeft = Math.round(screen.availWidth - winWidth) / 2;
	winTop = Math.round(screen.availHeight - winHeight) / 2;
	params = 'menubar=yes,location=yes,resizable=yes,scrollbars=yes,left=' + winLeft + ',top=' + winTop + ',width=' + winWidth + ',height=' + winHeight;
	newWin = window.open($a.attr('href'), '_blank', params);
	newWin.focus();
}