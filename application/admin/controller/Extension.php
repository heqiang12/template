<?php
/**
 * Created by PhpStorm.
 * User: heqiang
 * Date: 2018/10/8 0008
 * Time: 上午 10:36
 */

namespace app\admin\controller;

use app\admin\controller\Base;
use think\Db;
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

    /**
     * @return array|mixed
     * @author heqiang
     */
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

    /**
     * @return mixed
     * @author heqiang
     * 树形图
     */
    public function tree(){
        $data = Db::table('tree')->where(['pid'=>0,'status'=>1])->select();
        $this->assign('data',$data);
        return $this->fetch('tree');
    }

    /**
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * @author heqiang
     * @date 2018年10月26日16:50:26
     * 树形图 增 改
     */
    public function tree_add_edit(){
        if(Request::instance()->isPost()){
            $pid = Request::instance()->post('id');
            $name = Request::instance()->post('name');
            $level = Request::instance()->post('level') ? Request::instance()->post('level')+1 : '';
            if($level){
                //level存在，进行新增
                $data['name'] = $name;
                $data['pid'] = $pid;
                $data['level'] = $level;
                $result = Db::table('tree')->insert($data);
                if($result){
                    return Msg('保存成功！',1,$result);
                }else{
                    return Msg('保存失败！');
                }
            }else{
                $result = Db::table('tree')->where(['id'=>$pid])->update(['name'=>$name]);
                if($result){
                    return Msg('保存成功！',1);
                }else{
                    return Msg('保存失败！');
                }
                //level不存在，进行修改
            }
        }else{
            return Msg('保存失败！');
        }
    }

    /**
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * @author heqiang
     * 删除
     */
    public function tree_delete(){
        if(Request::instance()->isPost()){
            $id = Request::instance()->post('id');
            $result = Db::table('tree')->where(['id'=>$id])->update(['status'=>0]);
            if(1){
                return Msg('删除成功！',1);
            }else{
                return Msg('删除失败！');
            }
        }else{
            return Msg('删除失败！');
        }
    }

    /**
     * @return array
     * @author heqiang
     * 获取下级数据
     */
    public function getChildren(){
        $pid = Request::instance()->post('pid');
        if ($pid){
            $children = Db::table('tree')->where(['pid'=>$pid,'status'=>1])->select();
            return Msg('下级菜单',1,$children);
        }else{
            return Msg('下级数据加载失败');
        }
    }

    public function map(){
        return $this->fetch('map');
    }

}