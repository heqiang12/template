<?php

ini_set('max_execution_time', '0');
$db = new MySQLi("localhost","root","","doubanbook");
$db->query('set names utf8');
$sql = "select url from book_url limit 10001,50000";
$urls = $db->query($sql);
// $ips = [
//    '1' => [
//       'ip' => '134.196.245.109',
//       'prot' => '60622',
//    ],
//    '2' => [
//       'ip' => '103.38.5.246',
//       'prot' => '53281',
//    ],
//    '3' => [
//       'ip' => '117.114.149.66',
//       'prot' => '53281',
//    ],
//    '4' => [
//       'ip' => '101.236.55.145',
//       'prot' => '8866',
//    ],
//    '5' => [
//       'ip' => '58.53.128.83',
//       'prot' => '3128',
//    ],
//    '6' => [
//       'ip' => '182.101.13.15',
//       'prot' => '808',
//    ],
//    '7' => [
//       'ip' => '14.118.135.10',
//       'prot' => '808',
//    ],
//    '8' => [
//       'ip' => '111.224.136.198',
//       'prot' => '80',
//    ],
//    '9' => [
//       'ip' => '125.40.29.100',
//       'prot' => '8118',
//    ],
//    '10' => [
//       'ip' => '183.63.123.3',
//       'prot' => '56489',
//    ],
// ];
while($attr = $urls->fetch_row()){
   sleep(mt_rand(1,3));
   //每次随机选择一个ip
	// $k = mt_rand(1,10);
	// $k = 4;
   $ch = curl_init(); 

   // set url 
   curl_setopt($ch, CURLOPT_URL, $attr[0]); 
   // curl_setopt($ch, CURLOPT_URL, "https://www.baidu.com"); 

   //return the transfer as a string 

   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	// curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC); //代理认证模式
	// curl_setopt($ch, CURLOPT_PROXY, $ips[$k]['ip']); //代理服务器地址
	// curl_setopt($ch, CURLOPT_PROXYPORT, $ips[$k]['prot']); //代理服务器端口

   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 

   // $output contains the output string 

   $output = curl_exec($ch); 

    //echo output

   if($output === FALSE ){

    echo "CURL Error:".curl_error($ch);
    continue;

   }

   // echo $output;die(); //输出页面

   //小说名
   $p_name = "/<span property=\"v:itemreviewed\">(.*)<\/span>/";
   preg_match($p_name, $output, $name_arr);
   $name = remove_s($name_arr[1]);
   //作者
   $p_author = "/<a href=\"https:\/\/book\.douban\.com\/author\/.*\">([\s\S]*?)<\/a>/";
   $p_author2 = "/<a class=\"\" href=\"\/search\/.*\">(.*)<\/a>/";
   preg_match($p_author, $output, $author_arr);
   if(!$author_arr){
   	preg_match($p_author2, $output, $author_arr);
   }
   $author = remove_s($author_arr[1]);
   //出版社
   $p_press = "/<span class=\"pl\">出版社:<\/span>([\s\S]*?)<br\/>/";
   preg_match($p_press, $output , $press_arr);
   $press = remove_s($press_arr[1]);
   //评分
   $p_store = "/<strong class=\"ll rating_num \" property=\"v:average\">(.*)<\/strong>/";
   preg_match($p_store, $output , $store_arr);
   $store = remove_s($store_arr[1]);
   //评价人数
   $p_evaluator = "/<span property=\"v:votes\">(.*)<\/span>/";
   preg_match($p_evaluator, $output,$evaluator_arr);
   $evaluator = remove_s($evaluator_arr[1]);
   //ISBN
   $p_isbn = "/<span class=\"pl\">ISBN:<\/span>([\s\S]*?)<br\/>/";
   preg_match($p_isbn, $output,$isbn_arr);
   $isbn = remove_s($isbn_arr[1]);
   $sql = "select * from book_info where name={$name}";
   $res = $db->query($sql);
   if($res)continue;
   $sql = "insert into book_info (name,author,press,store,evaluator,isbn,url) values ('{$name}','{$author}','{$press}','{$store}','{$evaluator}','{$isbn}','{$attr[0]}')";
   $result = $db->query($sql);
}
echo "ok";

//去除空格
function remove_s($str){
   $str = preg_replace("/\r\n/","",$str); 
   $str = preg_replace("/\r/","",$str); 
   $str = preg_replace("/\n/","",$str); 
   $str = preg_replace('/ /', '', $str);
   return $str;
}
