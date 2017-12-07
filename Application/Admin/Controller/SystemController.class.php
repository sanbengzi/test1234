<?php
/**
 * Created by PhpStorm.
 * User: Chang
 * Date: 2017/6/4
 * Time: 18:44
 */
namespace Admin\Controller;

class SystemController extends CommonController
{
    public $roleModel;    //保存role模型实例化
    public $menuModel;    //保存menu模型实例化
    public $accessModel;  //保存access模型实例化
    /**
     * 构造实例化
     * SystemController constructor.
     */
    public function __construct()
    {
        //继承父类的构造函数
        parent::__construct();
        $this->roleModel = D('role');
        $this->menuModel = D('menu');
        $this->accessModel = D('access');
    }

    /**
     *用户角色列表
     */
    public function roleList()
    {
        //实例化role模型 查询出所有数据
        $data = $this->roleModel->select();
//        dump($data);die;
        //复制 模板变量
        $this->assign('data',$data);
        $this->display();
    }

    /**
     * 角色添加
     */
    public function roleAdd()
    {
        //判断post是否提交
        if (IS_POST) {
            //获取post提交数据
            $data = I('post.');
//            dump($data);die;
            //将数据添加到数据库中
            $res = $this->roleModel->add($data);
            //判断是否添加成功
            if ($res) {
                $this->success('添加成功！！',U('system/roleList'));die;
            } else {
                $this->error('添加失败');
            }
        }
        $this->display();
    }

    /**
     * 角色修改
     */
    public function roleUpdate()
    {
        if (IS_POST) {
            $data = I('post.');
            $res = $this->roleModel->save($data);
            if ($res) {
                $this->success('修改成功！！',U('system/roleList'));die;
            } else {
                $this->error('修改失败');
            }
        }
        //获取id
        $id = I('id');
        $data = $this->roleModel->find($id);
        $this->assign('data',$data);
        $this->display();
    }

    /**
     * 角色删除
     */
    public function roleDel()
    {
        //获取id
        $id = I('id');
//        dump($id);die;
        //查询获取数据
        $data = $this->roleModel->find($id);
        if ($id == 1 || $data['role_name'] == '超级管理员') {
            $this->error('超级管理员不可删除！！！');
        }
        $res = $this->roleModel->delete($id);
        if ($res) {
            $this->success('删除成功！！');
        } else {
            $this->roleModel('删除失败！！');
        }
    }
    /**
     * 菜单管理列表
     */
    public function menuList()
    {
        //实例化menu模型 获取所有数据
        $data = $this->menuModel->select();
        $data = getTree($data);
        //赋值模型变量
        $this->assign('data',$data);
        $this->display();
    }

    /**
     * 菜单添加
     */
    public function menuAdd()
    {
        //判断post是否提交
        if (IS_POST) {
            //获取post表单的数据
            $data = I('post.');
//            dump($data);die;
            //实例化menu模型将数据添加到数据库中
            $res = $this->menuModel->add($data);
            //判断是否添加成功
            if ($res) {
                $this->success('添加成功！！！',U('system/menuList'));die;
            } else {
                $this->error('添加失败！！！');
            }

        }
        //实例化menu模型 查询出所有数据，递归获取所有的菜单分类
        $data = $this->menuModel->select();
//        dump($data);die;
        //调用无极递归分类方法
        $data = getTree($data);
//        dump($data);die;
        //将数据传递到视图
        $this->assign('data',$data);
        $this->display();
    }

    /**
     * 菜单删除
     */
    public function menuDel()
    {
        //获取id
        $menu_id = I('id');
//        dump($menu_id);die;
        //获取所有的menu数据
        $datas = $this->menuModel->select();
        foreach ($datas as $value) {
            //判断要删除的id 是否为 其他的父id
            if ($value['pid'] == $menu_id) {
                $this->error('删除失败！！');
            }
        }
        $res = $this->menuModel->delete($menu_id);
        if ($res) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }

    /**
     * 菜单修改
     */
    public function menuUpdate()
    {
        if (IS_POST) {
            //获取post提交数据
            $datas = I('post.');
//            dump($datas);die;
            $res = $this->menuModel->save($datas);
            if ($res) {
                $this->success('修改成功！！',U('system/menuList'));die;
            } else {
                $this->error('修改失败！！');
            }
        }
        //实例化menu模型 查询出所有数据，递归获取所有的菜单分类
        $data = $this->menuModel->select();
//        dump($data);die;
        //调用无极递归分类方法
        $data = getTree($data);
//        dump($data);die;
        //将数据传递到视图
        $id = I('id');
        //查询数据
        $dataOne = $this->menuModel->find($id);
//        dump($dataOne);die;
        $this->assign('dataOne',$dataOne);
        $this->assign('data',$data);
        $this->display();
    }
    /**
     * 权限管理页面
     */
    public function accessList()
    {
        //判断post是否提交
        if (IS_POST) {
            $data = I('post.');
//            dump($data);die;
            foreach ($data['menu_id'] as $key => $value) {
                $addData[$key]['menu_id'] = $value;
                $addData[$key]['role_id'] = $data['role_id'];
            }
//            dump($addData);die;
            $role_id = $data['role_id'];
            $this->accessModel->where('role_id='.$role_id)->delete();
            if ($addData == '') {
                $this->error('没有设置任何权限！！！');
            }
            $res = $this->accessModel->addAll($addData);
            if ($res) {
                $this->success('权限设置成功！！',U('system/roleList'));die;
            } else {
                $this->error('权限设置失败！！');
            }
        }

        //根据id获取role的信息 实例化role
        //获取id
        $id = I('id');

        //查询数据
        $roleData = $this->roleModel->find($id);
//        dump($roleData);die;
        //实例化menu模型查询所有数据
        $menuData = $this->menuModel->select();
        //无极递归分类 调用函数get_tree
        $menuData = get_tree($menuData);
        //通过角色id 获取权限数据 实例化access模型
        $accessData = M('access')->field('menu_id')->where('role_id='.$id)->select();
//        dump($accessData);die;
        //二维数组降维  array_column
        $arr = array();
        foreach ($accessData as $value) {
            $arr[] = $value['menu_id'];
        }
//        dump($arr);die;
//        dump($menuData);die;
        //数据传递到视图
        $this->assign('roleData',$roleData);
        $this->assign('menuData',$menuData);
        $this->assign('arr',$arr);
        $this->display();
    }
}
