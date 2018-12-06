<?php 

   ini_set('max_execution_time', '0');
   // create curl resource 
   $db = new MySQLi("localhost","root","","doubanbook");
   $sql = "select * from tag";
   $db->query('set names utf8');
   $tags = $db->query($sql);
   if($tags){
    $index = 0;
    while($attr = $tags->fetch_row()){
      // 开始循环 通过每个标签获取标签下书籍 url

      // var_dump("https://book.douban.com/tag/".$attr[1]."?start=".$i*20."&type=T");die();
       for ($i=0; $i <= 100; $i++) { 
        
       $ch = curl_init(); 

       // set url 

       curl_setopt($ch, CURLOPT_URL, "https://book.douban.com/tag/".$attr[1]."?start=".($i*20)."&type=T"); 

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

       $db = new MySQLi("localhost","root","","doubanbook");
       // 获取url
       $p_url = "/<a href=\"(.*)\" title=/";
       preg_match_all($p_url, $output, $url);

       foreach ($url[1] as $k => $v) {
         $sql = "insert into tag_book_url (tag_id,url) values ('{$attr[0]}','{$v}')";
         $result =$db->query($sql);
       }

       // close curl resource to free up system resources 

       curl_close($ch);    
       // die();
    }  
    echo $index;
    echo "<br>";
    $index++;

   }
  
   
   }

?>