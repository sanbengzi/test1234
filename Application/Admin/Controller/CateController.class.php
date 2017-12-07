<?php
/**
 * Created by PhpStorm.
 * User: Chang
 * Date: 2017/6/1
 * Time: 23:52
 */
namespace Admin\Controller;


class CateController extends CommonController
{
    public $cateModel;
    public function __construct()
    {
        parent::__construct();
        $this->cateModel = D('cate');
    }

    /**
     * 商品类型列表
     */
    public function cateList()
    {
        //查询出所有分类
        $data = $this->cateModel->select();
        $this->assign('data',$data);
        $this->display();
    }

    /**
     * 商品类型添加
     */
    public function cateAdd()
    {
        if (IS_POST) {
            $data = $_POST;
//            dump($data);die;
            $res = $this->cateModel->add($data);
            if ($res) {
                $this->success('添加成功！！！',U('cateList'));die;
            } else {
                $this->error('添加失败！！！');
            }
        }
            $this->display();
    }

    /**
     * 商品类型修改
     */
    public function cateUpdate()
    {
        if (IS_POST) {
            $postData = I('post.');
            $res = $this->cateModel->save($postData);
            if ($res) {
                $this->success('修改成功！！',U('cate/cateList'));die;
            } else {
                $this->error('修改失败！！！');
            }
        }
        //获取id
        $id = I('id');
        $data = $this->cateModel->find($id);
        $this->assign('data',$data);
        $this->display();
    }
    public function cateDel()
    {
        //获取id
        $id = I('id');
        $res = $this->cateModel->delete($id);
        if ($res) {
            $this->success('删除成功！！');
        } else {
            $this->error('删除失败');
        }
    }
}
