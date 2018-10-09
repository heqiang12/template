<?php
/**
 * Created by PhpStorm.
 * User: heqiang
 * Date: 2018/10/8 0008
 * Time: 上午 9:13
 */

namespace app\admin\controller;

use app\admin\controller\Base;
use think\Session;

class Index extends Base{
    //主页
    public function index(){
        $userInfo = Session::get('userInfo');
        $this->assign('userInfo',$userInfo);
        return $this->fetch('index');
    }

    public function welcome(){
        return $this->fetch('index/welcome');
    }
}