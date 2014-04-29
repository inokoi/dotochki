<?php

/**
 *
 * ќписание файла: ’елпер.
 * ќпределение доступа, валидаци€ пост данных.
 *
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');


class lib_help {
    //единична€ проверка доступа с выводом страницы ограничени€ доступа
    	function check_acc ($type) {
    	   $CI = &get_instance();
           if(!is_array($type)){
            $type = array($type);
           }
           foreach($type as $acc_type){
            if($this->bool_check_acc($acc_type)){
        	   return true;
        	}
           }
           $this->error($acc_type);
    	}
        
        
        //множественна€ проверка доступа с выводом страницы ограничени€ доступа
    	function multi_check_acc ($type1,$type2='x',$type3='x',$type4='x',$type5='x') {
    	   $CI = &get_instance();
           $type1 = $this->simple_check($type1);
           $type2 = $this->simple_check($type2);
           $type3 = $this->simple_check($type3);
           $type4 = $this->simple_check($type4);
           $type5 = $this->simple_check($type5);
           if($type1 or $type2 or $type3 or $type4 or $type5){
    	       return true;
    	   }
           else{
               return false;
           }
    	}
       
       
       // запись в лог и вывод страницы ограничени€ доступа
       function error($type='none'){
         $CI = &get_instance();
         $CI->load->Model('mdl_acc');
         $acc_array = $CI->mdl_acc->acc_list();
         if($type!='none') $acc=$acc_array[$type][0];
            $ldata["content"] ="” вас недостаточно прав.(".$acc.')';
            echo $CI->load->view('content',$ldata,TRUE);
            die();
        
       }
       // проста€ проверка доступа
        function simple_check($type){
            if($type==='x')return false; 
             $CI = &get_instance();
            if(substr($CI->session->userdata('acc'),$type,1)!=0){
    	      return substr($CI->session->userdata('acc'),$type,1);
    	   }else{
    	      return false; 
    	   }
       }
       
       function bool_check_acc($type){
            $CI = &get_instance();
            if(!is_array($type)){
                $type = array($type);
            }
            foreach($type as $acc_type){
                if(substr($CI->session->userdata('acc'),$acc_type,1)!=0){
        	       return true;
                }
            }
            return false; 
       }
       
      function hard_check($type){
             $CI = &get_instance();
    	      return substr($CI->session->userdata('acc'),$type,1);
       }
       

       
       
       // чистка поста спешалчарсами    
        function post($name) {
          $CI = &get_instance();
          $str = $CI->input->post($name);
          if(!is_array($str))$str = trim(htmlspecialchars($str,ENT_QUOTES));
          if($str == 1)$str =='1';
          if($str == 0)$str =='0';
          return $str;
          }
          
          function back(){
            $url = explode('/',$_SERVER['REQUEST_URI']);
            if(is_numeric($url[(count($url)-1)])){$place="#place_".$url[(count($url)-1)];}else{$place="";}
            redirect(getenv("HTTP_REFERER").$place);
            
          }
          
          function boolen($what,$yes = "ƒа"){
            if($what == 1) return $yes;
            if($what == 0) return "Ќет";
          }
          
          function submenu_in($what){
        $CI = &get_instance();    
        $ses['submenu_in'] = $what;
	    $CI->session->set_userdata($ses);
          }
          
        function third_menu_in($what){
        $CI = &get_instance();    
        $ses['third_menu_in'] = $what;
	    $CI->session->set_userdata($ses);
          }
          
          function work($type,$id,$i='1'){
            $CI = &get_instance();
            if($type=='o'){
        $ses['work_o'] =':'.$id.':';
        $ses['work_o_i'] =($i+1);
        }else{
        $ses['work_c'] =':'.$id.':';
        $ses['work_c_i'] =($i+1);   
        }
        $CI->session->set_userdata($ses);
          }
          
          
        function filtr_drop(){
  /*
            str_replace(array('edit','add'),'',$_SERVER['REQUEST_URI'],$count);
            if($count!=0)return;
            $CI = &get_instance();
            $CI->load->Model('mdl_object');
        $url = explode('/',str_replace(base_url(),'',getenv("HTTP_REFERER")));
        $url2 = explode('/',$_SERVER['REQUEST_URI']);
        if($url[0]!=$url2[1] and $CI->session->userdata('dep_id')!=2) $CI->mdl_object->drop_filtr();
        */
       }
       
       function back_url(){
            $url = explode('/',$_SERVER['REQUEST_URI']);
            if(is_numeric($url[(count($url)-1)])){$place="#place_".$url[(count($url)-1)];}else{$place="";}
            return(getenv("HTTP_REFERER").$place);
       }
       
       function filtr_cheange($type){
        $CI = &get_instance();
        $ses['ses'] = time();
        if($type=='list' and $CI->session->userdata('user_temp')=='z' and $CI->session->userdata('otdel_temp')=='z'){
          $ses['user'] = '';
          $ses['otdel']  = '';
          $ses['user_temp'] = $CI->session->userdata('user');
          $ses['otdel_temp']  = $CI->session->userdata('otdel');
        }
        if($type=='return_list' and $CI->session->userdata('user_temp')!='z' and  $CI->session->userdata('otdel_temp')!='z'){
          $ses['user'] = $CI->session->userdata('user_temp');
          $ses['otdel']  = $CI->session->userdata('otdel_temp');
          $ses['user_temp'] = 'z';
          $ses['otdel_temp']  = 'z';
        }
        
        
        $CI->session->set_userdata($ses);
       }
          

     
       function desterbut($id,$dep_id,$table){
        $CI = &get_instance();
        $CI->db->where('id',$id);
        /*
        $otdel['1']='1';
        if($table=='clients')$otdel['2']='2'; else $otdel['2']='11';
        $otdel['3']='11';
        $otdel['4']='18';
        
        $otdel['5']='4';
        $otdel['6']='5';
        $otdel['7']='6';
        $otdel['8']='10';
        if($dep_id==1)$des_data['otdel_id'] = $otdel[rand(1,3)]; 
        if($dep_id==2)$des_data['otdel_id'] = $otdel[rand(5,8)];
        */
        $des_data['dep_id'] = $dep_id;
        $des_data['otdel_id'] = 0;
        $des_data['owned'] = 0;
        $des_data['status'] = 1;
        if($CI->session->userdata('loginid')!='')$des_data['who_desterbut'] = $CI->session->userdata('loginid'); else $des_data['who_desterbut'] = 999;
        $CI->db->update($table, $des_data);
        
        $CI->load->Model('mdl_robot');
        $CI->mdl_robot->ivan_fix();
       }
       
       function check_favorite_join($client,$object){
        $CI = &get_instance();
        $CI->db->where('client',$client);
        $CI->db->where('object',$object);
        $query = $CI->db->get('autojoin');
        $res = $query->result_array();
        if(count($res)){
            if($res[0]['favorite']==1) return true; else return false;
        }else{
            return false;
        }
       }
       
       
       function other_menu(){
        $CI = &get_instance();
        $CI->db->where('to',$CI->session->userdata('loginid'));
        $CI->db->where('type >=',5);
        $CI->db->where('type <=',15);
        $query = $CI->db->get('msg');
        return $query->result_array();
       }
       
       
       function load_settings_arenda_price_proc(){
        $CI = &get_instance();
        $CI->db->where('id','1');
        $query = $CI->db->get('autojoin');
        $res = $query->result_array();
        if(!count($res)) die('Ќет настроек по процентам аренды в автостыковках.');
        $return[0]=(100+$res[0]['client'])/100;
        $return[1]=(100-$res[0]['object'])/100;
        return $return;
        
       }
       
       
       function form_phone($phone){
        $phone =preg_replace("/[^0-9]/", "", $phone);
                    if(strlen($phone)==10)$phone = '7'.$phone;
                    if(strlen($phone)==11)return  $phone = '+'.substr($phone,0,1).' ('.substr($phone,1,3).') '.substr($phone,4,3).'-'.substr($phone,7,2).'-'.substr($phone,9,2);   else return $phone;
        }
        
        
        function refresh_protect(){
            $CI = &get_instance();
          $refresh_protect = $this->post('title').$this->post('comment').$this->post('value').$this->post('to_user').$this->post('type').$this->post('no_refrech');
          if($CI->session->userdata('refresh_protect')==$refresh_protect) redirect(base_url().$_SERVER['REQUEST_URI'].'/no_refresh');
          $ses['refresh_protect'] = $refresh_protect;
          $CI->session->set_userdata($ses);
        }
        
        function spam_block(){
            $CI = &get_instance();
            $result = false;
            if($CI->session->userdata('spamblock')>time())$result = true;
            $CI->session->set_userdata('spamblock',time()+10);
            return $result;
        }
        
        function ip_auth_code_generation(){
            $iparr = explode('.', $_SERVER['REMOTE_ADDR']);
            $auth_code = '';
            $iter = 1;
            foreach($iparr as $segment){
                $auth_code .= chr( (int)$segment );
                if($iter++>=4){
                    break;
                }
            }
            return $auth_code;
        }
        
        function auth_code_generation(){
            $auth_code = $this->ip_auth_code_generation();
            $time = time();
            while($time>0){
                $auth_code .= chr($time%256);
                $time = floor($time/256);
            }
            $auth_code .= chr(rand(0,255));
            return $auth_code;
        }


        function generate_csv(&$db_input_arr){
            if(sizeOf($db_input_arr)==0 OR !is_array($db_input_arr)){
                return FALSE;
            }
            $keys = array_keys($db_input_arr[0]);
            $output_str = '';
            foreach($keys as $arr_key=>$key){
                $output_str .= $key;
                if($arr_key<sizeOf($keys)-1){
                    $output_str .= ';';
                }
            }
            foreach($db_input_arr as $row){
                $output_str .= "\r\n";
                foreach($keys as $arr_key=>$key){
                    $str_to_add = $row[$key];
                    if((strlen($str_to_add)>0)AND((substr($str_to_add,0,1)=='"')OR(strpos($str_to_add, ';')!==FALSE)OR(strpos($str_to_add, "\n")!==FALSE))){
                        $str_to_add = '"'.str_replace('"', '""', $str_to_add).'"';
                    }
                    if($arr_key<sizeOf($keys)-1){
                        $str_to_add .= ';';
                    }
                    $output_str .= $str_to_add;
                }
            }
            return $output_str;
        }
        
        function parse_csv(&$input_str){
            $buffer_size = 8192;
            $input_str .= "\r\n";
            $result_arr = array();
            $cur_key = 0;
            $keys = array();
            $keys_filled = FALSE;
            $input_length = strlen($input_str);
            $input_pos = 0;
            $buffer = '';
            $escaped = FALSE;
            $row = array();
            $curdata = '';
            while($input_pos <= $input_length){
                $buffer = substr($input_str, $input_pos, $buffer_size);
                $input_pos+=$buffer_size-1;
                $buffer_length = strlen($buffer)-1;
                for($i=0;$i<$buffer_length;$i++){
                    $char = substr($buffer, $i, 1);
                    if((!$escaped)AND($char=="\r")AND(substr($buffer, $i+1, 1)=="\n")){
                        $row[] = $curdata;
                        $curdata = '';
                        $i++;
                        //end of row
                        if(!$keys_filled){
                            $keys = $row;
                            $row = array();
                            $keys_filled = TRUE;
                            continue;
                        }
                        if(sizeOf($row)!==sizeOf($keys)){
                            return FALSE;
                        }
                        foreach($keys as $arr_key=>$key){
                            $result_arr[$cur_key][$key] = $row[$arr_key];
                        }
                        $row = array();
                        $cur_key++;
                        continue;
                    }
                    if((!$escaped)AND($char==';')){
                        //end of str
                        $row[] = $curdata;
                        $curdata = '';
                        continue;
                    }
                    if((!$escaped)AND($char=='"')AND(strlen($curdata)==0)){
                        $escaped = TRUE;
                        continue;
                    }
                    if(($escaped)AND($char=='"')){
                        if(substr($buffer, $i+1, 1)!='"'){
                            $escaped = FALSE;
                            continue;
                        } else {
                            $i++;
                        }
                        
                    }
                    $curdata .= $char;
                }
            }
            return $result_arr;
        }        
        
}
    
    
    