<?php

/**
 *
 * �������� �����: ������.
 * ����������� ����� ������ ���������.
 *
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');


class lib_valid {
    function add_user(){
        return  array(
            array(
            'field' => 'login',
            'label' => '�����',
            'rules' => 'required|alpha2_numeric|max_langht[40]',
            ),
            array(
            'field' => 'pass',
            'label' => '������',
            'rules' => 'required|az_numeric|max_langht[20]',
            ),
            array(
            'field' => 'email',
            'label' => '������',
            'rules' => 'required|Email|max_langht[40]',
            ),
            array(
            'field' => 'phone',
            'label' => '������',
            'rules' => 'required|numeric|max_langht[11]|min_langht[11]',
            ),
            array(
            'field' => 'name',
            'label' => '������',
            'rules' => 'required|alpha2|max_langht[30]',
            ),
            array(
            'field' => 'soname',
            'label' => '������',
            'rules' => 'required|alpha2|max_langht[30]',
            ),
            array(
            'field' => 'midlename',
            'label' => '������',
            'rules' => 'required|alpha2|max_langht[30]',
            ),
            array(
            'field' => 'dep_id',
            'label' => '������',
            'rules' => 'required|numeric|max_langht[30]',
            ),
            array(
            'field' => 'otdel_id',
            'label' => '������',
            'rules' => 'required|numeric|max_langht[30]',
            ),
        );
        }
    
    }