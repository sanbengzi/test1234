<?php
/**
 * Created by PhpStorm.
 * User: Chang
 * Date: 2017/6/4
 * Time: 17:54
 */
namespace Admin\Controller;

use Think\Controller;

class CommonController extends Controller
{
    //创建基础的构造函数
    public function __construct()
    {
        //集成父类的构造函数
        parent::__construct();
        //防止翻墙判断
        if (!session('?username')) {
            $this->error('请先登录再操作！！！',U('login/login'));
        }
        //查询用户拥有权限URL访问 防止翻墙
        //超级管理员访问权限
        if (session('username') != 'admin') {
            //联表查询获取用户权限数据
            $datas = M('access')->alias('a')->join('left join tp_menu as b on a.menu_id=b.id')->where(array('a.role_id'=>session('rid'),'b.pid'=>array('neq',0)))->select();
            $url = strtolower(CONTROLLER_NAME.ACTION_NAME);
//            echo $url;
            //循环遍历获取 controller 和action值
            foreach ($datas as $value) {
                $urlData[] = strtolower($value['menu_controller'].$value['menu_action']);
            }
            if (!in_array($url,$urlData)) {
                $this->error('用户没有权限访问，请申请更高权限！！！');die;
            }
        }
    }
}
