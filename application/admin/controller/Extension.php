<?php
/**
 * Created by PhpStorm.
 * User: heqiang
 * Date: 2018/10/8 0008
 * Time: 上午 10:36
 */

namespace app\admin\controller;

use app\admin\controller\Base;
use think\Request;

class extension extends Base {
    public function upload(){
        if(Request::instance()->isPost()){
            $files = Request::instance()->file();
            $saveName = Uploads($files,'Test');
            return Msg('上传成功！',1,$saveName);
        }else{
            return $this->fetch('upload');
        }
    }
}