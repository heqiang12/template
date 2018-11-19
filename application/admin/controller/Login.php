<?php
/**
 * Created by PhpStorm.
 * User: heqiang
 * Date: 2018/9/29 0029
 * Time: 下午 2:52
 */

namespace app\admin\controller;

use think\captcha\Captcha;
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
            if(!captcha_check($post['verify'])){
             //验证失败
                return ajaxReturn('验证码错误！');
            };
            $where['phone'] = $post['phone'];
            $where['password'] = PasswordSelf($post['password']);
            $sel = Db::table('admin')->where($where)->find();
            if($sel){
                //账户密码存在且正确，则转入主页并记入session
                Db::table('admin')->where(['id'=>$sel['id']])->update(['last_login_time'=>time()]);
                Session::set('userInfo.userId',$sel['id']);
                Session::set('userInfo.nickname',$sel['nickname']);
                return ajaxReturn('登录成功！',1);
            }else{
                return ajaxReturn('账户密码不正确！');
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
            if(!captcha_check($post['verify'])){
             //验证失败
                return ajaxReturn('验证码错误！');
            };
            $sel = Db::table('admin')->where('phone',$post['phone'])->find();
            if($sel){
                return ajaxReturn('账号已存在!');
            }
            $post['password'] = PasswordSelf($post['password']);
            $post['add_time'] = time();//用户创建时间
            $ins = Db::table('admin')->insert($post);
            if($ins){
                //注册成功，则转入主页并记入session
                Session::set('userInfo.userId',$ins);
                Session::set('userInfo.nickname',$post['nickname']);
                return ajaxReturn('注册成功!',1,$ins);
            }else{
                return ajaxReturn('注册失败!');
            }
        }else{
            return $this->fetch('register');
        }
    }

    /**
     * @return \think\Response
     * 验证码
     */
    public function verify(){
        $config =    [
            'codeSet'     =>    "1234567890",
            // 验证码字体大小
            'fontSize'    =>    30,    
            // 验证码位数
            'length'      =>    4,   
            // 关闭验证码杂点
            'useNoise'    =>    false, 
        ];
        $captcha = new Captcha($config);
        return $captcha->entry();
    }

}