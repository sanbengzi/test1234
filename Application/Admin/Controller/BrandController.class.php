<?php
/**
 * Created by PhpStorm.
 * User: Chang
 * Date: 2017/5/28
 * Time: 9:48
 */
namespace Admin\Controller;


use Think\Page;

class BrandController extends CommonController
{
    public $cateModel;  //保存cate对象
    public function __construct()
    {
        parent::__construct();
        $this->cateModel = D('cate');    //实例化cate模型
    }

    /**
     * 加载商品详情页
     */
    public function brandList()
    {
        //实例化模型
        $brandModel = M('brand');
        //获取总记录数
        $count = $brandModel->where('display=1')->count();
        //实例化分页模型
        $page = new Page($count,5);
        //配置分页
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        //查询数据联表查询 cate表和brand表
        $data = $brandModel->alias('a')->field('a.*,b.cate_name')->join('left join tp_cate as b on a.cate_id=b.id')->where('display=1')->limit($page->firstRow.','.$page->listRows)->select();
        $show = $page->show();
        $this->assign('page',$show);
        $this->assign('data',$data);
        $this->display();
    }

    /**
     * 加载和处理商品添加页
     */
    public function brandAdd()
    {
        if (IS_POST) {
            //获取表单提交的数据
//            $data = I('post.');
//        dump($data);die;
            //实例化模型
            $brandModel = D('brand');
            $datas = $brandModel-> create();
//            dump($datas);die;
            //进行验证 如果验证错误，返回错误信息
            if (!$datas) {
                $this->error($brandModel->getError());
            }
            //调用添加方法
            $res = $brandModel->add($datas);
            //返回结果进行判断
            if ($res) {
                $this->success('添加成功',U('brandList'),2);die;
            }else{
                $this->error('添加失败');
            }
        }

        //实例化cate模型获取cate所有数据
        $cateData = $this->cateModel->select();
        $this->assign('cateData',$cateData);
        $this->display();

    }

    /**
     * 修改商品
     */
    public function brandUpdate()
    {
        //实例化model
        $brandModel = M('brand');
        if (IS_POST) {
            $datas = I('post.');
            $res = $brandModel->save($datas);
            if ($res) {
                $this->success('修改成功',U('brandList'));die;
            } else {
                $this->error('修改失败');
            }
        }
            //获取id
            $id = I('id');
            //根据id查询数据
            $data = $brandModel->find($id);
            //模型变量赋值
            //实例化cate模型获取cate所有数据
            $cateData = $this->cateModel->select();
            $this->assign('cateData',$cateData);
            $this->assign('data',$data);
            $this->display();

    }

    /**
     * 删除商品显示页面
     */
    public function brandDel()
    {
        //获取id
        $id = I('id');
//        dump($id);die;
        $data = array(
            'id' => $id,
            'display' => 0
        );
        //实例化模型
        $brandModel = M('brand');
        $res = $brandModel->save($data);
        //判断跳转
        if ($res) {
            $this->success('删除成功',U('brandList'));
        } else {
            $this->error('删除失败');
        }
    }
}