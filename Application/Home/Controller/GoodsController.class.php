<?php
/**
 * Created by PhpStorm.
 * User: Chang
 * Date: 2017/6/1
 * Time: 21:12
 */
namespace Home\Controller;

use Think\Controller;

class GoodsController extends Controller
{
    public $goodsModel;    //实例化goods
    public $cateModel;     //实例化cate
    public $brandModel;    //实例化brand
    public $goodsAttrModel;
    public function __construct()
    {
        parent::__construct();
        $this->goodsModel = D('goods');  //实例化goods模型
        $this->cateModel = D('cate');    //实例化cate模型
        $this->brandModel = D('brand');  //实例化brand模型
        $this->goodsAttrModel = D('goodsattr'); //实例化goodsattr模型
    }

    public function goodsDetail()
    {
        //通过地址栏id 获取商品的详细信息
        $id = I('id');
//        dump($id);die;
//        if (file_exists('./goods_detail_'.$id.'.html') && filemtime('./goods_detail_'.$id.'.html') + 900 > time()) {
//            require 'goods_detail_'.$id.'.html';
//        } else {
//            ob_start();
//            //实例化 goods模型
//            $goodsModel = M('goods');
//            //根据id获取数据
//            $goodsModel->where('id='.$id)->setInc('goods_click',1);
////        $data = $goodsModel->field('tp_goods.*,tp_brand.brand_name')->join('left join tp_brand on tp_goods.brand_id=tp_brand.id')->where('tp_goods.id='.$id)->find();
//            $data = M('goods_view')->find($id);
//            $attrData = $this->goodsAttrModel->alias('a')->field('a.*,b.attr_type,b.attr_name')->join('left join tp_attribute as b on a.attr_id=b.id')->where('b.attr_type=1 and a.goods_id='.$id)->select();
////        echo $this->goodsModel->_sql();die;
////        dump($attrData);die;
//            foreach ($attrData as $key => $value) {
//                $attrData[$key]['goods_attr_val'] = explode(',',$value['goods_attr_val']);
//
//            }
//
////        dump($attrData);die;
//            $picData = M('pic')->where('goods_id='.$id)->select();
////        dump($picData);die;
//            //数据赋值给视图变量
//            $this->assign('picData',$picData);
//            $this->assign('attrData',$attrData);
//            $this->assign('goodsData',$data);
//            $this->display();
//            $contents = ob_get_contents();
//            ob_end_clean();
//            file_put_contents('./goods_detail_'.$id.'.html',$contents);
//            echo $contents;
//        }
            //实例化 goods模型
            $goodsModel = M('goods');
            //根据id获取数据
            $goodsModel->where('id='.$id)->setInc('goods_click',1);
//        $data = $goodsModel->field('tp_goods.*,tp_brand.brand_name')->join('left join tp_brand on tp_goods.brand_id=tp_brand.id')->where('tp_goods.id='.$id)->find();
            $data = M('goods_view')->find($id);
            $attrData = $this->goodsAttrModel->alias('a')->field('a.*,b.attr_type,b.attr_name')->join('left join tp_attribute as b on a.attr_id=b.id')->where('b.attr_type=1 and a.goods_id='.$id)->select();
//        echo $this->goodsModel->_sql();die;
//        dump($attrData);die;
            foreach ($attrData as $key => $value) {
                $attrData[$key]['goods_attr_val'] = explode(',',$value['goods_attr_val']);

            }

//        dump($attrData);die;
            $picData = M('pic')->where('goods_id='.$id)->select();
//        dump($picData);die;
            //数据赋值给视图变量
            $this->assign('picData',$picData);
            $this->assign('attrData',$attrData);
            $this->assign('goodsData',$data);
            $this->display();
    }
    public function goodsList()
    {
//        $brand_id = !empty(I('brand_id')) ? I('brand_id') : 0;
        $brand_id = I('brand_id');
        $price_id = I('price');
//        dump($price);die;
        $where = 'goods_status=1';
        if ($brand_id) {
            $where .= ' and brand_id='.$brand_id;
        }
        $price = explode('-',$price_id);
        if ($price[0]) {
            $where .= ' and goods_price>'.$price[0];
        }
        if ($price[1]) {
            $where .= ' and goods_price<'.$price[1];
        }
        $goodsDatas = $this->goodsModel->where($where)->select();
        $brandDatas = $this->brandModel->select();
        $this->assign('brand_id',$brand_id);
        $this->assign('priceData',getPrice());
        $this->assign('price',$price_id);
        $this->assign('brandData',$brandDatas);
        $this->assign('goodsData',$goodsDatas);
        $this->display();
    }
}
