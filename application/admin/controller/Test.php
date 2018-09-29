<?php
/**
 * Created by PhpStorm.
 * User: heqiang
 * Date: 2018/9/29 0029
 * Time: 下午 2:28
 */

namespace app\admin\controller;

use think\Controller;

class Test extends Controller {

    public function test(){
        return $this->fetch('test');
//        return $this->fetch('test2/test2');
    }
}