<?php
/**
 * Created by PhpStorm.
 * User: heqiang
 * Date: 2018/9/30 0030
 * Time: 下午 4:11
 */

/**
 * @param $data
 * @param string $info
 * @param int $status
 * @return array
 * @author heqiang
 * @date 2018年9月30日16:14:13
 * 返回信息
 */
function Msg($info='',$status=0,$data=''){
    return ['data'=>$data,'info'=>$info,'status'=>$status];
}

/**
 * @param $password
 * @return string
 * @author heqiang
 * @date 2018年9月30日16:49:42
 * 自定义密码
 */
function PasswordSelf($password){
    return md5('I'.md5($password).'U');
}

function Uploads($files,$filename){
    if(!$files){
        return Msg('请上传文件！');
    }
    foreach($files as $file){
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads' . DS . $filename);
        if($info){
            // 成功上传后 获取上传信息
            // 输出 jpg
//            echo $info->getExtension();
            // 输出路径名
//            echo $filename . DS . $info->getSaveName();
            // 输出 42a79759f284b767dfcb2a0197904287.jpg
//            echo $info->getFilename();die();
            $saveName = __ROOT__ . DS . 'public' . DS . 'uploads' . DS . $filename . DS . $info->getSaveName();
            return $saveName;
        }else{
            // 上传失败获取错误信息
//            echo $file->getError();
            return $file->getError();
        }
    }
}