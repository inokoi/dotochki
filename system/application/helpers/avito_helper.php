<?php

/**
 * @author archlams
 * @copyright 2012
 */

class avito_metro{
    static private $metro_name_list = array(
        85=>'������������',
        13=>'�������������',
        97=>'�������������',
        53=>'��������������� ���',
        105=>'������������',
        135=>'���������',
        156=>'������',
        50=>'���������',
        5=>'��������',
        109=>'������������',
        57=>'���������������',
        71=>'�����������',
        47=>'����������',
        69=>'�������',
        7=>'�����������',
        93=>'�������',
        131=>'��������',
        207=>'��������',
        120=>'����������',
        107=>'������������ ���',
        145=>'�������������',
        195=>'��������� �����',
        16=>'����������',
        106=>'����',
        112=>'���������',
        2=>'������ �������',
        3=>'����������',
        77=>'������������� ��������',
        142=>'��������',
        203=>'�������������',
        198=>'�����������',
        81=>'������',
        6=>'������',
        115=>'�����������',
        132=>'������������',
        21=>'�������������',
        205=>'�����������',
        140=>'��������',
        209=>'���������',
        43=>'������������',
        94=>'���������',
        18=>'��������������',
        17=>'���������',
        15=>'���������',
        52=>'��������',
        74=>'�����-�����',
        144=>'�����������',
        14=>'�����������',
        35=>'�������������',
        92=>'��������',
        22=>'�����������������',
        133=>'�����������������',
        36=>'��������������',
        34=>'������� ������',
        139=>'������������ �������',
        29=>'�������������',
        62=>'����������',
        73=>'��������� ����',
        79=>'���������',
        60=>'����������',
        48=>'�������',
        55=>'�����������',
        98=>'��������� ��������',
        32=>'�������',
        143=>'�������',
        87=>'������������',
        146=>'�������',
        8=>'����������',
        110=>'����������',
        197=>'�������������',
        117=>'�������������',
        196=>'������',
        61=>'����������',
        202=>'��������',
        124=>'�����������',
        125=>'��������',
        126=>'����������� ��������',
        82=>'�����������',
        210=>'����������',
        11=>'�������������',
        134=>'��������������',
        89=>'��������������',
        95=>'����� ���������',
        100=>'�����������',
        67=>'����������� ����',
        20=>'�������',
        111=>'��������',
        12=>'����������',
        165=>'���� ������',
        44=>'������������',
        42=>'������������',
        83=>'������',
        113=>'���������-�����������',
        141=>'���������',
        59=>'����������',
        63=>'���������',
        86=>'������� ������',
        49=>'������� ���������',
        68=>'������������',
        121=>'�������',
        130=>'��������',
        38=>'�������������� �������',
        76=>'������������',
        136=>'�������� ����',
        96=>'�����������',
        72=>'����������',
        1=>'������ ������',
        104=>'�������',
        138=>'�������',
        80=>'��������� ��������',
        116=>'�����������',
        108=>'��������',
        127=>'���������������',
        45=>'�����������',
        122=>'������������',
        201=>'���������� �������',
        51=>'����������',
        4=>'�����',
        37=>'����������',
        26=>'����������',
        206=>'���������� �������',
        200=>'��������',
        54=>'������������',
        102=>'�����������',
        64=>'�����������',
        75=>'���������',
        9=>'��������',
        10=>'�����������',
        78=>'������������',
        91=>'������ ����',
        114=>'�������������',
        88=>'�������������',
        199=>'�������',
        123=>'��������',
        103=>'������������',
        65=>'���������',
        70=>'����� 1905 ����',
        194=>'����� ���������',
        40=>'����� ������������',
        25=>'�����������',
        58=>'��������� ����',
        56=>'����',
        27=>'�����������',
        19=>'��������',
        118=>'������� �������',
        39=>'������������',
        128=>'������������',
        119=>'���������',
        33=>'������ �����',
        137=>'����������',
        99=>'�����������',
        208=>'�����������',
        84=>'����� �����������',
        41=>'����������',
        66=>'���������',
        46=>'����������������',
        23=>'���-��������',
        129=>'�����',
        90=>'�������',
        30=>'���������� ��. ������',
        193=>'������� �������� �������',
        164=>'������� ������� ��������',
        157=>'��������� ����',
        204=>'������� ����',
        31=>'������� ���',
        28=>'���� ��������',
        24=>'�������� �����������',
        155=>'����� ��������� ������',
        192=>'����� ������������',
        212=>'����� ����������������',
        211=>'����� ������ �����������'
    );
    
    static public function get_metro_name($id){
        if(isset(avito_metro::$metro_name_list[$id])){
            return avito_metro::$metro_name_list[$id];
        }
        return FALSE;
    }
}

class avito_city{
    static private $city_list = array(
        '��������',
        '���������',
        '���������',
        '���������',
        '�������������',
        '��������',
        '��������',
        '������� ��',
        '��������',
        '�������',
        '�������� ��',
        '����������',
        '��������',
        '����� ������ ��',
        '������������',
        '�����������',
        '������� ��',
        '���������',
        '������� ������',
        '������� �����',
        '������� ��������',
        '��������',
        '������',
        '���������',
        '��������',
        '�����',
        '������',
        '������������ ���� ��',
        '������������',
        '�����������',
        '�����������',
        '����������',
        '���������',
        '��������',
        '����������',
        '��������',
        '�����-10',
        '�������-17',
        '��������',
        '��������',
        '�������',
        '��������',
        '�����������',
        '�������',
        '������������',
        '���� ������ "�����"',
        '����������',
        '�������� ��',
        '������',
        '������',
        '�����',
        '������� ����',
        '���������',
        '���������������',
        '�������',
        '���������',
        '������ ������',
        '������ "����������"',
        '����������� ��',
        '��������',
        '�������',
        '�������',
        '����������',
        '����� �������',
        '����������',
        '����',
        '���������',
        '���������',
        '�� ����������',
        '��. ��������',
        '�� ������',
        '�����',
        '���������',
        '������',
        '��������',
        '��������',
        '����',
        '������� ��',
        '��������� ��',
        '�������',
        '����������',
        '�������������',
        '��������',
        '�������',
        '����������',
        '�������� ��',
        '������� �����',
        '�������������',
        '�����������',
        '�������������',
        '��������������',
        '������� ����',
        '������� ��',
        '�������',
        '������� ��',
        '���������',
        '������',
        '������ �������',
        '������ ������',
        '������-������',
        '���',
        '�����',
        '�����������',
        '������-����������',
        '��������',
        '������� ��',
        '������',
        '��������',
        '���������',
        '���������',
        '�������',
        '��������',
        '���������',
        '������',
        '���������� ��',
        '�������',
        '����������',
        '��������',
        '�������',
        '�����������',
        '�������',
        '������',
        '����������',
        '������',
        '����-�������',
        '��������',
        '������������',
        '���������-�������������',
        '��������������',
        '��������������',
        '��������������',
        '������������',
        '�������',
        '��������',
        '�������',
        '��������',
        '��������',
        '����',
        '�����������',
        '������� ��',
        '�������-�����',
        '��������',
        '���������� �������',
        '���������� �����',
        '������������',
        '��������',
        '�����',
        '�����������',
        '�������� ��',
        '��������',
        '���������� ��������� "�������������"',
        '�����������',
        '�������������',
        '�������',
        '������������',
        '��������',
        '�������',
        '������',
        '��������',
        '���������',
        '������',
        '������',
        '������',
        '�����������',
        '������',
        '��������',
        '������� ��',
        '�����������',
        '������',
        '����',
        '���������� ��',
        '��������� ��. �������',
        '������������',
        '��������',
        '��������',
        '������� �����',
        '�����������',
        '���������� �����',
        '��������',
        '���������������',
        '������� ��',
        '������� ��. 1 ���',
        '������� ��. ������',
        '������� "���������"',
        '�������������',
        '�������',
        '������ �������',
        '������ �������',
        '���������',
        '�������',
        '������',
        '������',
        '������',
        '�����������',
        '��������',
        '������',
        '��������',
        '�������',
        '��������',
        '�������� ��',
        '�������',
        '������� ��. 1 ���',
        '�����������',
        '�������',
        '�������',
        '�����',
        '�������',
        '��������',
        '����������� ������� �������',
        '����������� ������� ������� "���"',
        '��������� ��',
        '������������',
        '������',
        '�������',
        '�����',
        '������',
        '���������',
        '���������',
        '��������������',
        '������ ���',
        '�����',
        '��������',
        'ٸ�����',
        '������������',
        '���������������',
        '������������',
        '�����������',
        '���������',
        '�����������',
        '��',
        '������',
        '������'
    );

    static public function check_city($str){
        $str = strtolower($str);
        foreach(avito_city::$city_list as $value){
            if(strpos($str, strtolower($value))!==FALSE){
                return $value;
            }
        }
        return FALSE;
    }
}

function avito_token_truncate($string, $len, $regexp='\.', $replace='.'){
	$string = strip_tags($string);
	if(strlen($string)<=$len){
		return $string;
	}
	return preg_replace('/['.$regexp.']+?[^'.$regexp.']*$/', $replace, substr($string, 0, $len));
}

?>