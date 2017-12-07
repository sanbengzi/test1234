<?php

namespace Home\Controller;

use Think\Controller;

class CartController extends Controller
{
    public $cartModel;
    public function __construct()
    {
        parent::__construct();
        $this->cartModel = M('cart');
    }

    /**
     * 购物车商品添加
     */
    public function cartAdd()
    {
        $data = I('post.');
        //实例化cart表
//        $cartModel = M('cart');
        //判断验证用户是否登录
        if (session('?uid')) {
            $res = $this->cartModel->where('goods_id='.$data['goods_id'])->find();
            if ($res) {
                $this->cartModel->where('goods_id='.$data['goods_id'])->setInc('number',1);
            } else {
                $data['user_id'] = session('uid');
                $data['goods_attr'] = json_encode($data['goods_attr']);
                $this->cartModel->add($data);
            }

//            dump($data);die;
        } else {
            //判断cookie中是否保存了goods_cart
            $cartData = unserialize(cookie('goods_cart'));
//            dump($cartData);die;
            if ($cartData[$data['goods_id']]) {
                $cartData[$data['goods_id']]['number']++;
            } else {
                $cartData[$data['goods_id']] = $data;
            }


            //将数组序列化
            $cart_str = serialize($cartData);
            //将序列化的数据存储到cookie中
            cookie('goods_cart',$cart_str);
            $datas = unserialize(cookie('goods_cart'));
//            dump($datas);die;
        }
        $this->redirect('cart/cartList');
    }

    /**
     * 购物车列表显示
     */
    public function cartList()
    {
        //判断用户是否登录
        if (session('?uid')) {
            //根据用户的uid获取用户的购物车信息
            $cartData = $this->cartModel->where('user_id='.session('uid'))->select();
            //foreach 循环遍历 通过goods_id查询出商品的goods_name goods_smallpic goods_mprice
            foreach ($cartData as $key => $value) {
                $goodsModel = M('goods');
                $goodsData = $goodsModel->find($value['goods_id']);
                $cartData[$key]['goods_name'] = $goodsData['goods_name'];
                $cartData[$key]['goods_attr'] = json_decode($cartData[$key]['goods_attr'],true);
                $cartData[$key]['goods_smallpic'] = $goodsData['goods_smallpic'];
                $cartData[$key]['goods_mprice'] = $goodsData['goods_mprice'];
//                dump($goodsData);
            }
//            dump($cartData);
//            die;
        } else {
            $cartData = unserialize(cookie('goods_cart'));
//            dump($cartData);die;
            //foreach 循环遍历 通过goods_id查询出商品的goods_name goods_smallpic goods_mprice
            foreach ($cartData as $key => $value) {
                $goodsModel = M('goods');
                $goodsData = $goodsModel->find($value['goods_id']);
                $cartData[$value['goods_id']]['goods_name'] = $goodsData['goods_name'];
                $cartData[$value['goods_id']]['goods_smallpic'] = $goodsData['goods_smallpic'];
                $cartData[$value['goods_id']]['goods_mprice'] = $goodsData['goods_mprice'];
//                dump($goodsData);
            }
//            dump($cartData);
//            die;
        }
        $this->assign('cartData',$cartData);
        $this->display();
    }

    /**
     * 删除商品
     */
    public function cartDel()
    {
        //判断用户是否存在
        if (session('?uid')) {
            $id = I('id');
            $res = $this->cartModel->delete($id);
            if ($res) {
                $this->success('删除成功');
            } else {
                $this->error('删除失败');
            }
        } else {
            $goods_id=I('goods_id');
            $cart_str = cookie('goods_cart');
            //反序列化
            $cartData = unserialize($cart_str);
            unset($cartData[$goods_id]);
            if (!$cartData[$goods_id]) {
                cookie('goods_cart',serialize($cartData));
                $this->success('删除成功');
                //将新的数据序列化重新保存到cookie中
            } else {
                $this->error('删除失败');
            }
//            dump($cartData);die;
        }
    }

    /**
     * 购物车更新
     */
    public function cartUpdate()
    {
        //获取post提交的number、goods_id
        $number = I('number');
        $goods_id= I('goods_id');
        //判断用户是否登录
        if (session('?uid')) {
            //获取用户id
            $uid = session('uid');
            $this->cartModel->where(array('uid'=>$uid,'goods_id'=>$goods_id))->save(array('number'=>$number));
        } else {
            $cart_str = cookie('goods_cart');
            //反序列化
            $cartData = unserialize($cart_str);
            //修改goods_id对应的商品的数量
            $cartData[$goods_id]['number'] = $number;
            //序列化
//            dump($cartData);die;
            $cart_str = serialize($cartData);
            //保存在cookie中
            cookie('goods_cart',$cart_str);
        }
    }
}
