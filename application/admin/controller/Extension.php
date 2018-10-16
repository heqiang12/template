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
    /**
     * @return array|mixed
     * @author heqiang
     * @date 2018年10月10日09:14:02
     * 上传
     */
    public function upload(){
        if(Request::instance()->isPost()){
            $files = Request::instance()->file();
            //依据所需条件进行筛选拦截，这里就不写例了
            $saveName = Uploads($files,'Test');
            return Msg('上传成功！',1,$saveName);
        }else{
            return $this->fetch('upload');
        }
    }

    public function page(){
        if(Request::instance()->isPost()){
            //获取上一页及显示数
            $page = Request::instance()->post('page');
            $limit = Request::instance()->post('limit');
            //获取自定义的搜索条件
            $phone = Request::instance()->post('phone');
            $db = 'admin';
            $where = [];
            //此为自定义的搜索条件
            if($phone){
                $where['phone'] = ['like','%'.$phone.'%'];
            }
            $data = newPage($db,$where,$page,$limit);//newPage(数据表名，搜索条件，当前页，每页显示数)
            return $data;
        }else{
            return $this->fetch('page');
        }
    }
}