<?php
/**
 * Created by PhpStorm.
 * User: heqiang
 * Date: 2018/10/8 0008
 * Time: 上午 9:13
 */

namespace app\admin\controller;

use app\admin\controller\Base;
use think\Db;
use think\Session;

class Index extends Base{
    //主页
    public function index(){
        $userInfo = Session::get('userInfo');
        $this->assign('userInfo',$userInfo);
        $menuInfo = Db::table('menu')->where(['pid'=>0,'status'=>1])->select();
        $data = [];
        foreach ($menuInfo as $k => $v) {
        	$childInfo = Db::table('menu')->where(['pid'=>$v['id'],'status'=>1])->select();
        	$data[$k]['first'] = $v['name'];
        	$data[$k]['child'] = $childInfo;
        }
        $this->assign('menuInfo',$data);
        return $this->fetch('index');
    }

    public function welcome(){
        return $this->fetch('index/welcome');
    }

    //退出
    public function quit(){
    	Session::clear();
        $this->redirect('Login/login');
    }
}