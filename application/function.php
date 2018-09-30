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