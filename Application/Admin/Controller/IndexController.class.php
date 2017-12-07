<?php
namespace Admin\Controller;


class IndexController extends CommonController
{

    public function index()
    {
        $this->display();
    }
    public function head()
    {
        $this->display();
    }
    public function left()
    {
        //查询获取权限表的数据和menu表的数据动态设置用户的权限
        //获取角色id
        $role_id = session('rid');
//        dump($role_id);die;
        //链表查询
        $accessData = M('access')->alias('a')->join('left join tp_menu as b on a.menu_id=b.id')->where(array('a.role_id'=>$role_id,'b.is_show'=>1))->select();

        //递归数据
        $accessData = get_tree($accessData);
        //数据传递到视图
//        dump($accessData);die;
        $this->assign('accessData',$accessData);
        $this->display();
    }
    public function right()
    {
        $this->display();
    }
}