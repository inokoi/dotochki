<?
if(count($metro_array)>1){
        
             if(!is_array($metro)) $go_distance = $this->mdl_ajax->distance($res[$i]["point"],$geo_metro[$metro]);
			 else $go_distance = $this->mdl_ajax->distance($res[$i]["point"],$geo_metro[$id_metro]);
           /*   if($go_distance>1500){  
                $this->db->where('from',str_replace(',','%2C',$res[$i]["point"]));
                $this->db->where('to',$geo_metro[$metro]);
                $query = $this->db->get('cash');
                $res_cash = $query->result_array();
                if(count($res_cash) >0){

                 $go_time =  $res_cash[0]['time'];
                 $go_time = round($go_time/60);
                 if($res_cash[0]['distance']>1500){$go_type = 1;}else{$go_type = 0;$go_time = round($res_cash[0]['distance']/6000*60);}
                }else{

              $http = 'http://api-maps.yandex.ru/1.1.21/xml/Router/Router.xml?key='.$api_key.'&rll='.$res[$i]["point"].'~'.$geo_metro[$metro];
              $web =  iconv("UTF-8", "CP1251",file_get_contents($http));
              $web = explode(',boundedBy',$web);
              $web = str_replace('({duration:','',$web[0],$count_du);
              if($count_du==0)continue;
              $web = explode(',distance:',$web);
              $cash['from'] = str_replace(',','%2C',$res[$i]["point"]);
              $cash['to'] = $geo_metro[$metro];
              $cash['time'] = $web[0];
              $cash['distance'] = $web[1];
              $this->db->insert('cash',$cash);
              $go_time = $web[0];
              $go_distance = $web[1];
              $go_time = round($go_time/60);
              }}*/
              if($go_distance>1500){$go_type = 1;$go_time = round($go_distance/20000*60);}else{$go_type = 0;$go_time = round($go_distance/6000*60);}

                }else{
                  $go_type = $res[$i]['from_subway_type'];
                  $go_time = $res[$i]['from_subway_min'];
                }

             if($go_type==0){$to_metro = 'wtime="'.$go_time.'"';}else{$to_metro = 'ttime="'.$go_time.'"';}
?>