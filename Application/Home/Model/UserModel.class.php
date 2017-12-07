<?php
/**
 * Created by PhpStorm.
 * User: Chang
 * Date: 2017/6/8
 * Time: 9:02
 */
namespace Home\Model;

use Think\Model;

class UserModel extends Model
{
    protected $_validate = array(
        array('user_name','','帐号名称已经存在！',0,'unique',1), // 在新增的时候验证name字段是否唯一
        array('user_pwd','require','请填写密码'),
        array('user_pwd2','user_pwd','两次密码不一致',0,'confirm'),
        array('user_email','require','请填写正确的邮箱'),
    );
    protected function _before_insert(&$data,$options){
        $data['user_pwd'] = md5($data['user_pwd']);
    }
}
