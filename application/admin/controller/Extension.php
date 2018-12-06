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
     * @return mixed
     * @author heqiang
     * @date 2018年11月15日15:52:17
     * 菜单
     */
    public function menu(){
        if(Request::instance()->isPost()){

        }else{
            $data = Db::table('menu')->where(['pid'=>0,'status'=>1])->select();
            $this->assign('data',$data);
            return $this->fetch('menu');
        }
    }

    /**
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * @author heqiang
     * @date 2018年11月15日14:21:22
     * 菜单 增 改
     */
    public function menu_add_edit(){
        if(Request::instance()->isPost()){
            $pid = Request::instance()->post('id');
            $name = Request::instance()->post('name');
            $level = Request::instance()->post('level') !== '' ? Request::instance()->post('level')+1 : '';
            $path = Request::instance()->post('path');
            $sort = Request::instance()->post('sort');
            $pid = Request::instance()->post('id');
            if($level){
                //level存在，进行新增
                $data['name'] = $name;
                $data['pid'] = $pid;
                $data['level'] = $level;
                $data['path'] = $path;
                $data['sort'] = $sort;
                $data['add_time'] = time();
                $result = Db::table('menu')->insert($data);
                if($result){
                    return Msg('保存成功！',1,$result);
                }else{
                    return Msg('保存失败！');
                }
            }else{
                //level不存在，进行修改
                $result = Db::table('menu')->where(['id'=>$pid])->update(['name'=>$name,'sort'=>$sort,'update_time'=>time()]);
                if($result){
                    return Msg('保存成功！',1);
                }else{
                    return Msg('保存失败！');
                }
            }
        }else{
            return Msg('保存失败！');
        }
    }

    /**
     *@author heqiang
     *@date 2018年11月19日14:18:22
     *菜单排序
     */
    public function menu_sort(){
        if(Request::instance()->isPost()){
            $id = Request::instance()->post('id');
            $sort = Request::instance()->post('sort');
            $result = Db::table('menu')->where(['id'=>$id])->update(['sort'=>$sort,'update_time'=>time()]);
            if($result){
                return Msg('排序修改成功!',1);
            }else{
                return Mag('排序修改失败!');
            }
        }else{
            return Mag('排序修改失败!');
        }
    }

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
            $level = Request::instance()->post('level') !== '' ? Request::instance()->post('level')+1 : '';
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
        $table = Request::instance()->post('table');
        if ($pid && $table){
            $children = Db::table($table)->where(['pid'=>$pid,'status'=>1])->select();
            return Msg('下级菜单',1,$children);
        }else{
            return Msg('下级数据加载失败');
        }
    }

    /**
     *@author heqiang
     *@date 2018/11/26
     *接口列表
     */
    public function interf(){
        if(Request::instance()->isPost()){

        }else{
            $interfaceInfo = Db::table('interface')->where(['status'=>1])->select();
            $data = [];
            foreach ($interfaceInfo as $k => $v) {
                $id = $v['id'];
                $data[$k]['interfaceInfo']['id'] = $id;
                $data[$k]['interfaceInfo']['name'] = $v['name'];
                $data[$k]['interfaceInfo']['url'] = $v['url'];
                $data[$k]['interfaceInfo']['type'] = $v['type'] == 1 ? 'get' : 'post';
                $data[$k]['interfaceInfo']['note'] = $v['note'];
                $incomingInfo = Db::table('interface_detail')->where(['interface_id'=>$id,'status'=>1,'in_out_type'=>1])->select();
                foreach ($incomingInfo as $kk => $vv) {
                    $data[$k]['incomingInfo'][$kk]['id'] = $vv['id'];
                    $data[$k]['incomingInfo'][$kk]['incoming_field'] = $vv['incoming_field'];
                    $data[$k]['incomingInfo'][$kk]['incoming_note'] = $vv['incoming_note'];
                    $data[$k]['incomingInfo'][$kk]['type'] = $vv['type'];
                    $data[$k]['incomingInfo'][$kk]['necessity'] = $vv['necessity'] == 1 ? '是' : '否';
                }
                $outgoingInfo = Db::table('interface_detail')->where(['interface_id'=>$id,'status'=>1,'in_out_type'=>2])->select();
                $data[$k]['interfaceInfo']['outgoing_format'] = $outgoingInfo[0]['outgoing_format'] ? $outgoingInfo[0]['outgoing_format'] : '';
                $data[$k]['interfaceInfo']['outgoing_format_array'] = $outgoingInfo[0]['outgoing_format'] ? explode(',',$outgoingInfo[0]['outgoing_format']) : '';
                foreach ($outgoingInfo as $kkk => $vvv) {
                    $data[$k]['outgoingInfo'][$kkk]['id'] = $vvv['id'];
                    $data[$k]['outgoingInfo'][$kkk]['outgoing_field'] = $vvv['outgoing_field'];
                    $data[$k]['outgoingInfo'][$kkk]['outgoing_note'] = $vvv['outgoing_note'];
                }
            }
            // print_r($data);die();
            $this->assign('data',$data);
            return $this->fetch('interface');
        }
    }

    /**
     *@author heqiang
     *@date 2018/11/26
     *接口添加
     */
    public function interface_add(){
        if(Request::instance()->isPost()){
            Db::startTrans();
            try{
            $post = Request::instance()->post();
            $interfaceAdd = Db::table('interface')->insertGetId(['name'=>$post['name'],'url'=>$post['url'],'type'=>$post['type'],'add_time'=>time()]);
            if(!$interfaceAdd){
                return Msg('添加失败！');
            }
            for($i = 0;$i<count($post['incoming_field']);$i++){
                $incomingData = [];
                $incomingData['interface_id'] = $interfaceAdd;
                $incomingData['incoming_field'] = $post['incoming_field'][$i];
                $incomingData['type'] = $post['type'][$i];
                $incomingData['necessity'] = $post['necessity'][$i];
                $incomingData['incoming_note'] = $post['incoming_note'][$i];
                $incomingAdd = Db::table('interface_detail')->insert($incomingData);
                if(!$incomingAdd) return Msg('添加输入字段失败！');
            }
            for($j = 0;$j<count($post['outgoing_field']);$j++){
                $outgoingData = [];
                $outgoingData['interface_id'] = $interfaceAdd;
                $outgoingData['outgoing_field'] = $post['outgoing_field'][$j];
                $outgoingData['outgoing_note'] = $post['outgoing_note'][$j];
                $outgoingData['outgoing_format'] = $post['outgoing_format'];
                $outgoingData['in_out_type'] = 2;
                $outgoingAdd = Db::table('interface_detail')->insert($outgoingData);
                if(!$outgoingAdd) return Msg('添加返回字段失败！');
            }
            Db::commit();
            return Msg('添加成功！',1);
         }catch (\Exception $e) {
            Db::rollback();
            return Msg('添加失败！');
         }   
        }else{
            return $this->fetch('interface_add');
        }
    }

    public function map(){
        return $this->fetch('map');
    }

}