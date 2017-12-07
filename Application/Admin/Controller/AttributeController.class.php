<?php
/**
 * Created by PhpStorm.
 * User: Chang
 * Date: 2017/6/5
 * Time: 21:01
 */
namespace Admin\Controller;

class AttributeController extends CommonController
{
    public $cateModel;
    public $attrModel;
    public function __construct()
    {
        parent::__construct();
        $this->cateModel = D('cate');
        $this->attrModel = D('attribute');
    }

    /**
     * 属性列表展示
     */
    public function attrList()
    {
        //实例化attribute模型查询所有数据联表查询 attr表和 cate表
        $attrData = $this->attrModel->alias('a')->field('a.*,b.cate_name')->join('left join tp_cate as b on a.cate_id=b.id')->select();
//        $attrData = $this->attrModel->select();
        $this->assign('attrData',$attrData);
        $this->display();
    }

    /**
     * 添加属性列表
     */
    public function attrAdd()
    {
        //判断是否post提交
        if (IS_POST) {
            //获取post提交数据
            $postData = I('post.');
//            dump($postData);die;
            $postData['attr_value'] = str_replace('，',',',$postData['attr_value']);
            $res = $this->attrModel->add($postData);
            if ($res) {
                $this->success('添加成功！！',U('attrList'));die;
            } else {
                $this->error('添加失败！！');
            }
        }
        //实例化商品类型 获取商品类型的数据
        $cateData = $this->cateModel->select();
        $this->assign('cateData',$cateData);
        $this->display();
    }

    /**
     * 属性删除
     */
    public function attrDel(){
        //获取传递的id
        $id = I('id');
        //根据主键id删除attr信息
        $res = $this->attrModel->delete($id);
        if ($res) {
            $this->success('删除成功！！');
        } else {
            $this->error('删除失败！！');
        }
    }
    public function attrUpdate()
    {
        //判断是否post提交
        if (IS_POST) {
            //获取post提交的所有数据
            $postData = I('post.');
            $postData['attr_value'] = str_replace('，',',',$postData['attr_value']);
            //修改数据
            $res = $this->attrModel->save($postData);
            if ($res) {
                $this->success('修改成功！！',U('attrList'));die;
            } else {
                $this->error('修改失败！！');
            }
        }
        //获取id
        $id = I('id');
        //通过id查询出attr数据联表查询 获取一条数据
        $attrOne = $this->attrModel->alias('a')->field('a.*,b.cate_name')->join('left join tp_cate as b on a.cate_id=b.id')->where('a.id='.$id)->find();
        //查询所有商品类型数据
        $cateData = $this->cateModel->select();
        $this->assign('cateData',$cateData);
        $this->assign('attrOne',$attrOne);
        $this->display();
    }
}
