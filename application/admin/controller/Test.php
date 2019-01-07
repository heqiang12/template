<?php
/**
 * Created by PhpStorm.
 * User: heqiang
 * Date: 2018/9/29 0029
 * Time: 下午 2:28
 */

namespace app\admin\controller;

use think\Controller;
use think\Session;

class Test extends Controller {

    public function test(){
//     	$ch = curl_init(); 

//        // set url 

//        curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx19dffa4b721a3921&secret=309880e317999b4f15209f6c28f46ede"); 

//        //return the transfer as a string 

//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

//        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 

//        // $output contains the output string 

//        $output = curl_exec($ch); 
//        // var_dump($output);die();
//        $res = json_decode($output,1);
//        // var_dump($res);die();
//        Session::set('access_token',$res['access_token']);
//      //   var_dump(Session::get('access_token'));die();


//     	$ticket = $this->ticket(Session::get('access_token'));
//     	// // var_dump($ticket);die();
//     	Session::set('ticket',$ticket);
    	$signature = $this->signature();
//     	// var_dump($signature);die();
        return $this->fetch('test',['signature'=>$signature]);
// //        return $this->fetch('test2/test2');
//     }

    public function ticket($access_token){
    	$ch = curl_init(); 

       // set url 

       curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$access_token."&type=jsapi"); 

       //return the transfer as a string 

       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 

       // $output contains the output string 

       $output = curl_exec($ch); 
       $res = json_decode($output,1);
       return $res;
    }

    function signature(){
    	$noncestr = "abc";
    	$jsapi_ticket = Session::get('ticket');
    	$timestamp = time();
    	$url = "http://8.9.6.220/template/public/index.php/admin/test/test";
    	$signature = 'jsapi_ticket='.$jsapi_ticket['ticket'].'&noncestr='.$noncestr.'&timestamp='.$timestamp.'&url='.$url;
    	// var_dump($signature);die();
    	$signature = sha1($signature);
    	// return $signature;
    	return ['signature'=>$signature,'timestamp'=>$timestamp];
    }

    public function weixin(){

    }
}