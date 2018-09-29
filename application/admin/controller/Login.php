<?php
/**
 * Created by PhpStorm.
 * User: heqiang
 * Date: 2018/9/29 0029
 * Time: 下午 2:52
 */

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;

class Login extends Controller{

    /**
     * @return mixed
     * @author heqiang
     * @date 2018年9月29日16:25:48
     * 登录
     */
    public function login(){
        return $this->fetch('login');
    }

    public function register(){
        $find = Db::table('admin')->where('id',1)->select();
        var_dump($find);die();
        if(Request::instance()->isPost()){
            $post = Request::instance()->post();
//            $sel = Db::table('admin')->where('phone',$post['phone'])->find();

//            if($sel){
//
//            }
            $ins = Db::table('admin')->insert($post);
            var_dump($ins);die();
            if($ins){
                return 'success';
            }


        }else{
            return $this->fetch('register');
        }

    }

}