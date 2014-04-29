<?php

/**
 * @Автор: party3AH
 * @Создан: 3.9.2010
 */
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
    
if ( ! function_exists('make_content'))
{
	function make_content($res)
	{
	    if (count($res)==0){$data["all_content"] =br(5)."<p align='center'>На данной странице нету записей</p>";}
        else{
        $progon = 0;
        $data["all_content"] = '';
        do{   
 
           $all_specs ='';
           $specs = explode("::",$res[$progon]['spec']);
             foreach($specs as $spec){
                $all_specs = $all_specs."<li>".$spec."</li>";
             }
            $data["content"]  = '   <td><div class="preview">
            <span class="title"> '.$res[$progon]["title"].' </span>
            <a href="'.base_url().'view/key/'.$res[$progon]["id"].'" class="preview"><img src="'.base_url().'img/content/'.$res[$progon]["id"].'/preview.jpg" alt="превиев"></a>
            <ul>
            '.$all_specs.'
            </ul>
            </div></td>
            ';
         $data["all_content"] = $data["all_content"].$data["content"];
         if($progon == 2) {$data["all_content"] = $data["all_content"]."<tr></tr>";}
         $progon++;
         }
         while($progon != count($res));
         }
    return $data["all_content"];
	}
}


if ( ! function_exists('count_content'))
{
	function count_content($type)
	{
     $CI = &get_instance();
     $CI->db->where('type',$type);
     $query = $CI->db->get("data");
     $res = $query->result_array();
     return count($res);
    }
}
if ( ! function_exists('make_view'))
{
	function make_view($res)
	{
	 $imglib = $res[0]["imglib"];
     $speclib = explode("::",$res[0]["speclib"]);

    if ($imglib>0){
    $buttons = '';
    $browser = browser_chek();    
    $java = '
    <script type="text/javascript">
    <!-- 
    ';
    $counter = 1;
        do{
            $buttons = $buttons.'  <a onclick="setimg'.$counter.' ();" class="preview"><img src="'.base_url().'img/content/'.$res[0]["id"].'/preview/'.$counter.'.jpg" align="left" alt="Выберите слайд"></a>';
            
            $java = $java.'function setimg'.$counter.' () {
    document.getElementById("imgviews").src = "'.base_url().'img/content/'.$res[0]["id"].'/'.$counter.'.jpg";   
    document.getElementById("aviews").href = "'.base_url().'view/img/'.$res[0]["id"].'/'.$counter.'";
    document.getElementById("spec").innerHTML = "'.$speclib[$counter -1].'";
    }
    ';
        $counter++;
        }       
        while($counter < $imglib+1);  
    }  
    if ($browser != 'MSIE'){       
            $bigimg = ' <td valign="middle"  id="imgview"><div align="center">
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td id="bigimgul"></td>
    <td id="bigimgu"></td>
    <td id="bigimgur"></td>
  </tr>
  <tr>
    <td id="bigimgl"></td>
    <td id="bigimgm"><a href="" id="aviews" href=""><img id="imgviews" src="'.base_url().'img/blankview.gif" align="middle"  alt="превиев"></a></td>
    <td id="bigimgr"></td>
  </tr>
  <tr>
    <td id="bigimgdl"></td>
    <td id="bigimgd"></td>
    <td id="bigimgdr"></td>
  </tr>
</table>
</div><br><br><p id ="spec" ></p></td>';
    }
    else{
        $bigimg = ' <td valign="middle" id="imgview"><a href=""  id="aviews" href=""><img id="imgviews" src="'.base_url().'img/blankview.gif" align="middle"  alt="превиев"></a></td>';
        }
    $view = '<td id="imglib">'.$buttons.'         <br><br> <a  href="javascript:history.back ()"><img id="back"  src="'.base_url().'img/back.png"></a>'.$bigimg.$java.'//--> </script>';
  return $view;
    }
}

if ( ! function_exists('browser_chek'))
{
	function browser_chek()
	{
    if (strstr($_SERVER["HTTP_USER_AGENT"], "Nav")) $browser = "Netscape";
        elseif (strstr($_SERVER["HTTP_USER_AGENT"], "MSIE")) $browser = "MSIE";
        elseif (strstr($_SERVER["HTTP_USER_AGENT"], "Lynx")) $browser = "Lynx";
        elseif (strstr($_SERVER["HTTP_USER_AGENT"], "Opera")) $browser = "Opera";
        elseif (strstr($_SERVER["HTTP_USER_AGENT"], "WebTV")) $browser = "WebTV";
        elseif (strstr($_SERVER["HTTP_USER_AGENT"], "Konqueror")) $browser = "Konqueror";
        elseif (strstr($_SERVER["HTTP_USER_AGENT"], "Bot")) $browser = "Bot";
        else $browser = "Other";
    return $browser;
    }
    
  if ( ! function_exists('count_imglib'))
    {
	function count_imglib($type = 'speclib'){
            $CI = &get_instance();
            $spec = '0';
            $i=1;
            do{
            if($CI->input->post($type.$i)){$spec = $i;}
            $i++;
            }
            while($i != 11);
            if ($spec =='0'){die('Не обнаруженны записи особенностей или файлы галлереи.');}
            return $spec;
            }
    } 
      if ( ! function_exists('get_speclib'))
    {
	function get_speclib($volue){  
            $CI = &get_instance();
        $speclib = '';
        $counter = 1;
        do{
            if($counter>1){$spliter = '::';}else{$spliter='';}
            $speclib = $speclib.$spliter.$CI->input->post('speclib'.$counter);
         $counter++; 
        }
        while($counter != $volue+1 OR $counter < $volue+1);
        return $speclib;
        }
    }
      if ( ! function_exists('get_spec'))
    {
	function get_spec($volue){  
            $CI = &get_instance();
        $spec = '';
        $counter = 1;
        do{
            if($counter>1){$spliter = '::';}else{$spliter='';}
            $spec = $spec.$spliter.$CI->input->post('spec'.$counter);
         $counter++; 
        }
        while($counter != $volue+1 OR $counter < $volue+1);
        return $spec;
        }
    }

          if ( ! function_exists('save_imglib'))
    {
	function save_imglib($volue,$id){  
            $CI = &get_instance();

        }
    }
}


?>