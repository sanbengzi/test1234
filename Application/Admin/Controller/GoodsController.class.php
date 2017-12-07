<?php
/**
 * Created by PhpStorm.
 * User: Chang
 * Date: 2017/5/28
 * Time: 20:33
 */
namespace Admin\Controller;


use Think\Image;

class GoodsController extends CommonController
{
    public $cateModel;
    public $attrModel;
    public $goodsattrModel;
    public function __construct()
    {
        parent::__construct();
        $this->cateModel = D('cate');
        $this->attrModel = D('attribute');
        $this->goodsattrModel = D('goodsattr');
    }

    /**
     * 商品列表页
     */
    public function goodsList()
    {
        //实例化商品模型 goods
        $goodsModel = M('goods');
        //查询所有商品的数量，status=1 count()
        $count = $goodsModel->count();
//        dump($count);die;
        //实例化分页类，传入总记录数和每页显示记录数
        $page = new \Think\Page($count,5);
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        //分页显示输出
        $show = $page->show();
        //查询商品的所有可以显示的信息
        $goodsData = $goodsModel->field('tp_goods.*,tp_brand.brand_name,tp_cate.cate_name')->join('left join tp_brand on tp_goods.brand_id=tp_brand.id')->join('left join tp_cate on tp_goods.cate_id=tp_cate.id')->limit($page->firstRow.','.$page->listRows)->select();
//        $goodsData = $goodsModel->field('a.*,b.brand_name')->alias('a')->join('left join tp_brand as b on a.brand_id=b.id')->where(array('a.goods_status=1'))->select();
//        dump($goodsData);die;
        //模型变量赋值 加载到视图中
        $this->assign('page',$show);
        $this->assign('goodsData',$goodsData);
        $this->display();
    }

    /**
     *添加商品
     */
    public function goodsAdd()
    {
//        dump($_FILES);die;
        if (IS_POST) {
            //防止XSS注入 获取post数据必须用post 不能用I()
            $data = $_POST;

//            dump($data['goods_attr']);die;
            //判断是否有上传文件
            if ($_FILES['goods_image']['name'] != '') {
                //调用封装的图片上传函数，获取返回的图片信息
                $info = uploadPic();
//                dump($info);die;
                $data['goods_bigpic'] = $info['goods_image']['savepath'].$info['goods_image']['savename'];
                //缩略图处理 实例化图片处理类
//                dump($data);die;
                $image = new Image();
                //添加需要处理的图片
                $image->open(UPLOAD.$info['goods_image']['savepath'].$info['goods_image']['savename']);
                //生成缩略图 设置尺寸 thump方法
                $image->thumb(100,100)->save(UPLOAD.$info['goods_image']['savepath'].'thump_'.$info['goods_image']['savename']);
                $data['goods_smallpic'] = $info['goods_image']['savepath'].'thump_'.$info['goods_image']['savename'];
            }
            $data['goods_addtime'] = time();

            //实例化商品模型
            $goodsModel = M('goods');
            //添加商品
            $res = $goodsModel->add($data);
            if ($res) {
                //数据重组
                foreach ($data['goods_attr'] as $key => $value) {
                        if (is_array($value)) {
                            $arr_data[] = array(
                                'goods_id' => $res,
                                'attr_id' => $key,
                                'goods_attr_val'=>implode(',',$value)
                            );
                        } else {
                            $arr_data[] = array(
                                'goods_id' => $res,
                                'attr_id' => $key,
                                'goods_attr_val'=>$value
                            );
                        }
                }
                //实例化 商品属性表 添加商品属性
                $this->goodsattrModel->addAll($arr_data);
                $this->success('添加商品成功！！！',U('goods/goodsList'));die;
            } else {
                $this->error('添加商品失败！！！');
            }
        }
            //商品添加页面加载的时候要加载 品牌
            //实例化品牌模型
            $brandModel = M('brand');
            //查询获取所有品牌数据
            $brandData = $brandModel->select();
            $cateData = $this->cateModel->select();
            //将变量赋值到视图中
            $this->assign('cateData',$cateData);
            $this->assign('brandData',$brandData);
            $this->display();
            if (I('id')) {
                $id = I('id');
                //实例化商品类型模型
                $cateData = $this->cateModel->find($id);
                dump($cateData);die;
            }

    }

    /**
     * 获取商品类型的属性
     */
    public function goodsAttr()
    {
        $id = I('id');
        //根据cate_id查询属性表所有属性
        $cateData = $this->attrModel->where('cate_id='.$id)->select();
        $brandData = M('brand')->where('cate_id='.$id)->select();
//        dump($cateData);
        //重组数组
        $arr['cateData'] = $cateData;
        $arr['brandData'] = $brandData;
        echo json_encode($arr);die;

    }
    /**
     * 修改商品时获取attribute和goodsattr的值
     */
    public function getAttr()
    {
        //获取goods表中的cate_id 根据cate_id 查询 attribute表和 goods_id 查询 goodsattr表
        $id =I('id');
        $goods_id = I('goods_id');
//        dump($id);die;
        //获取attribute表格数据
        $brandData = M('brand')->where('cate_id='.$id)->select();
        $attrData = $this->attrModel->where('cate_id='.$id)->select();
        $goodsAttrData = $this->goodsattrModel->where('goods_id='.$goods_id)->select();
        //数据重组
        $arr['brandData'] = $brandData;
        $arr['attrData'] = $attrData;
        $arr['goodsAttrData'] = $goodsAttrData;
        echo json_encode($arr);die;
    }
    /**
     * 修改商品
     */
    public function goodsUpdate()
    {
        //判断表单是否提交
        if (IS_POST) {
            $data = $_POST;

//            dump($data);die;
            //实例化goods模型
            //判断是否有图片上传
//            dump($_FILES);die;
            if ($_FILES['goods_image']['name']) {
                //调用图片上传方法
                $info = uploadPic();
//                dump($info);die;
                //保存上传图片原图
                $data['goods_bigpic'] = $info['goods_image']['savepath'].$info['goods_image']['savename'];
                //缩略图处理
                //实例化 图片处理类
                $image = new Image();
                //打开需要处理的图片 绝对路径打开
                $image->open(UPLOAD.$info['goods_image']['savepath'].$info['goods_image']['savename']);
                //保存生成的缩略图 保存的路径以及名称
                $image->thumb(100,100)->save(UPLOAD.$info['goods_image']['savepath'].'thump_'.$info['goods_image']['savename']);
                //将缩略图 路径保存到数据库
                $data['goods_smallpic'] = $info['goods_image']['savepath'].'thump_'.$info['goods_image']['savename'];
            }
            $goodsModel = M('goods');
            //保存更改数据
            $res = $goodsModel->save($data);
//            dump($res);die;
            //结果判断
            if ($res) {
                //数据重组
                foreach ($data['goods_attr'] as $key => $value) {
                    if (is_array($value)) {
                        $arr_data[] = array(
                            'goods_id' => $data['id'],
                            'attr_id' => $key,
                            'goods_attr_val'=>implode(',',$value)
                        );
                    } else {
                        $arr_data[] = array(
                            'goods_id' => $data['id'],
                            'attr_id' => $key,
                            'goods_attr_val'=>$value
                        );
                    }
                }
//                    dump($arr_data);die;
                    $this->goodsattrModel->where('goods_id='.$data['id'])->delete();
                    $this->goodsattrModel->addAll($arr_data);
                $this->success('修改成功！！',U('goodsList'));die;
            } else {
                $this->error('修改失败！！');
            }
        }
        //获取地址栏id
        $id = I('id');
        //实例化 goods模型
        $goodsModel = M('goods');
        //根据id查询
        $data = $goodsModel->find($id);
//        dump($data);die;
        //实例化brand模型
        $brandModel = M('brand');
        //查询获取所有品牌数据
        $brandData = $brandModel->select();
        $cateData = $this->cateModel->select();
        //创建 模型变量
        $this->assign('cateData',$cateData);
        $this->assign('brandData',$brandData);
        $this->assign('goodsData',$data);
        $this->display();

    }
    /**
     * 商品上架下架操作
     */
    public function goodsDel()
    {
        //获取传递的id
        $id = I('id');
        //根据查找出对应id的数据并修改状态status
        //实例化模型
        $goodsModel = M('goods');
        $data = $goodsModel->where('id='.$id)->find();
//        dump($res);die;

        //判断status ==1 修改为0 ==0 修改为1
        if ($data['goods_status']==1) {
            $data['goods_status'] = 0;
            $status = '上架';
        } else {
            $data['goods_status'] = 1;
            $status = '下架';
        }
        $data['goods_updatetime'] = time();
        $res = $goodsModel->save($data);
        if ($res) {
            $this->success($status);
        } else {
            $this->error('失败');
        }
    }

    /**
     * 商品相册管理操作
     */
    public function goodsPic()
    {
        //判断是否传入文件
        if ($_FILES['image']['name'][0] != '') {
            //获取传递的id
            $data = $_POST;
            $goods_id = $data['goods_id'];
            $info = uploadPic();
//            dump($info);die;
            foreach ($info as $key => $value) {
                $datas[$key]['pic_big'] = $value['savepath'].$value['savename'];
                //缩略图处理 实例化 图片类
                $image = new Image();
                //选择处理的图片
                $image->open(UPLOAD.$value['savepath'].$value['savename']);
                //保存处理好的图片
                $image->thumb(100,100)->save(UPLOAD.$value['savepath'].'thump_'.$value['savename']);
                //将数据保存到数据库中
                $datas[$key]['pic_small'] = $value['savepath'].'thump_'.$value['savename'];
                //保存id
                $datas[$key]['goods_id'] = $goods_id;
            }
//            dump($datas);die;
            //实例化 模型pic  将数据保存在图集数据库中
            $goodsModel = M('pic');
            //添加多组数据 addAll
            $res = $goodsModel->addAll($datas);
            if ($res) {
                $this->success('上传成功！！！',U('admin/goods/goodsPic','id='.$goods_id));
            } else {
                $this->error('上传失败');
            }
        } else {
            //获取id
            if (IS_POST) {
                if ($_FILES['image']['name'][0] == ''){
                    echo "<script>alert('上传文件不能为空！！！');</script>";
                }
                $id = $_POST;
                $goods_id = $id['goods_id'];
            } else {
                $goods_id = I('id');
            }
//        dump($goods_id);die;
            //实例化模型
            $picModel = M('pic');
            //通过goods_id查找数据
            $data = $picModel->where('goods_id='.$goods_id)->select();
//            dump($data);die;
            //将数据赋值给视图变量
            $this->assign('datapic',$data);
            $this->display();
        }
    }

    /**
     * 商品相册集 图片删除
     */
    public function picDel()
    {
        //获取传递要删除的id
        $id = I('id');
//        dump($id);die;
        //实例化 pic模型
        $picModel = M('pic');
        $data = $picModel->find($id);
        //删除 传递id的一条数据
        $res = $picModel->delete($id);
        //判断是否删除
        if ($res) {
            //物理删除 在存放图片文件夹删除 源文件和缩略图文件
            unlink(UPLOAD.$data['pic_big']);  //删除原图
            unlink(UPLOAD.$data['pic_small']); //删除缩略图
            $this->success('删除成功！');
        } else {
            $this->error('删除失败');
        }
    }
}