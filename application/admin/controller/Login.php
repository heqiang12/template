<?php
/**
 * Created by PhpStorm.
 * User: heqiang
 * Date: 2018/9/29 0029
 * Time: 下午 2:52
 */

namespace app\admin\controller;

use think\Controller;
//use app\admin\controller\Base;
use think\Request;
use think\Db;
use think\Session;

class Login extends Controller{

    /**
     * @return mixed
     * @author heqiang
     * @date 2018年9月29日16:25:48
     * 登录
     */
    public function login(){
        if(Request::instance()->isPost()) {
            $post = Request::instance()->post();
            $where['phone'] = $post['phone'];
            $where['password'] = PasswordSelf($post['password']);
            $sel = Db::table('admin')->where($where)->find();
            if($sel){
                //账户密码存在且正确，则转入主页并记入session
                Session::set('userInfo.userId',$sel['id']);
                Session::set('userInfo.nickname',$sel['nickname']);
                return Msg('登录成功！',1);
            }else{
                return Msg('账户密码不正确！',0);
            }
        }else{
            return $this->fetch('login');
        }
    }

    /**
     * @return array|mixed
     * @author heqiang
     * @date 2018年9月30日16:31:54
     * 注册
     */
    public function register(){
        if(Request::instance()->isPost()){
            $post = Request::instance()->post();
            $sel = Db::table('admin')->where('phone',$post['phone'])->find();
            if($sel){
                return Msg('账号已存在',1);
            }
            $post['password'] = PasswordSelf($post['password']);
            $post['add_time'] = strtotime('now');//用户创建时间
            $ins = Db::table('admin')->insert($post);
            if($ins){
                return Msg('注册成功',0,$ins);
            }else{
                return Msg('注册失败',0);
            }
        }else{
            return $this->fetch('register');
        }

    }

}