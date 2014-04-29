<?php

/**
 *
 * Описание файла: контроллер API
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class acc extends Controller {
        // конструктор класса  
        function acc(){
            parent::Controller();
            $this->load->Model('mdl_acc');
            }
            
                //страничка по умолчанию  
        function index() {
            $this->lib_auth->check_login();
            $this->lib_help->check_acc(53);
            $data['res'] = $this->mdl_acc->list_acc();
            $ldata['content']=$this->load->view('acc_list',$data,true);
            $ldata["top_menu"] = $this->load->view('admin_top_menu','',TRUE);
            $this->load->view('content',$ldata);
              }
              
        function delete($id){
            $this->lib_auth->check_login();
            $this->lib_help->check_acc(53);
            $this->mdl_acc->delete($id);
            redirect(base_url().'acc');
        }


        function get_acc($pass=''){
          if($pass=='') $pass= $this->lib_help->post('acc_pass');
          $data['error']='';
          if($this->session->userdata('acc_code_timeout')>time()){
        $time = $this->session->userdata('acc_code_timeout')-time();
         if($time<(60*3-2))$data['error']='Дождитесь отправленного кода, новый вы сможите получить через '.$time.' секунд.';
        }
          if($pass!='') {
            $this->mdl_acc->get_acc($pass);
            $data['error']='Не верный код.';
          }
            $this->load->view('acc_get',$data);

        }
        
        function add($type){
            $this->lib_auth->check_login();
            $this->lib_help->check_acc(53);
          if($this->lib_help->post('add')=='add') {
            $this->mdl_acc->add();
            redirect(base_url().'acc');
          }else{
            $data['type']=$type;
            $ldata['content']=$this->load->view('acc_add',$data,true);
            $ldata["top_menu"] = $this->load->view('admin_top_menu','',TRUE);
            $this->load->view('content',$ldata);
          }
        }
        
        function edit($id){
            $this->lib_auth->check_login();
            $this->lib_help->check_acc(53);
          if($this->lib_help->post('edit')=='edit') {
            $this->mdl_acc->edit($id);
            redirect(base_url().'acc');
          }else{
            $data['res'] = $this->mdl_acc->info($id);
            if(count($data['res'])==0)redirect(base_url().'acc');
            $ldata['content']=$this->load->view('acc_edit',$data,true);
            $ldata["top_menu"] = $this->load->view('admin_top_menu','',TRUE);
            $this->load->view('content',$ldata);
          }
        }
        
        function no_acc(){
          if($this->lib_help->post('phone')=='')  $this->load->view('acc_phone','');else $return = $this->mdl_acc->check_phone();
          if(isset($return))$this->load->view('acc_phone_no','');
        }
        
        function check_phone(){
         $this->mdl_acc->check_phone();
         }
        
} 