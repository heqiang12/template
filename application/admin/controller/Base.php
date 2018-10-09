<?php
/**
 * Created by PhpStorm.
 * User: heqiang
 * Date: 2018/9/30 0030
 * Time: 下午 3:46
 */

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Session;

class Base extends Controller{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->checkLogin();//检测是否登录
    }

    /**
     * @author heqiang
     * @date 2018年9月30日15:52:55
     * 检测是否登录
     */
    public function checkLogin(){
        if(!Session::has('userInfo.userId')){
            $this->error('您尚未登录！','Login/login');
        }
    }
}