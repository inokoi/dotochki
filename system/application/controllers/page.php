<?php

/**
 *
 * Описание файла: контроллер API
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class page extends Controller {
        // конструктор класса  
        function page(){
            parent::Controller();
            }
            
        //страничка по умолчанию  
        function index() {
            $this->show(1);
        }
              
         function show( $page = 1 ) {
            $array['admin'] ='dsfdsfdsfdsfdsf';
            $data['content'] = 'Страничка №'.$page.'.';
            $data['menu'] = range(1,7);
            $this->load->view('page1', $data);
        }
} 