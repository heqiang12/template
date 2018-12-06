<?php 

   // create curl resource 

   $ch = curl_init(); 

   // set url 

   curl_setopt($ch, CURLOPT_URL, "https://book.douban.com/tag/?view=cloud"); 

   //return the transfer as a string 

   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 

   // $output contains the output string 

   $output = curl_exec($ch); 

    //echo output

   if($output === FALSE ){

    echo "CURL Error:".curl_error($ch);

   }
    // echo $output; //输出页面

   $pattern = "/<a href=\"\/tag\/.*\">(.*)<\/a>/";

   preg_match_all($pattern, $output, $matches);

   // var_dump($matches);die();

   // 连接数据库

   $db = new MySQLi("localhost","root","","doubanbook");
   $db->query('set names utf8');
   foreach ($matches[1] as $k => $v) {
     $sql = "insert into tag (tags) values ('{$v}')";
     $result =$db->query($sql);
     if($result){
      echo "ok";
      echo "<br>";
     }else{
      echo "no";
      echo "<br>";
     }
   }

   // close curl resource to free up system resources 

   curl_close($ch);      

?>