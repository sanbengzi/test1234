<?php
/**
 * Created by PhpStorm.
 * User: Chang
 * Date: 2017/6/10
 * Time: 20:02
 */
namespace Home\Controller;

use Think\Controller;

class OrderController extends Controller
{
    public function orderBuy()
    {

            $data = I('post.');
            $datas[] = $data;
            //根据goods_id 获取商品信息
            $total = 0;
            foreach ($datas as $key => $value) {
                $goodsData = M('goods')->find($data['goods_id']);
//            dump($goodsData);die;
                $datas[$key]['goods_name'] = $goodsData['goods_name'];
                $datas[$key]['goods_mprice'] = $goodsData['goods_mprice'];
                $datas[$key]['subtotal'] = $datas[$key]['number']*$datas[$key]['goods_price'];
                $total += $datas[$key]['subtotal'];
            }
            //序列化$datas
            $buyData = serialize($datas);
            $this->assign('buy_datas',$buyData);
            $this->assign('total',$total);
            $this->assign('order_data',$datas);
//            dump($datas);die;
        $location = M('location')->where('user_id='.session('uid'))->select();
        $this->assign('location',$location);
        $this->display();
    }
    public function orderAdd()
    {
        $data = I('post.');
        $data['buy_datas']=unserialize($data['buy_datas']);
        //数据重组 order表添加的数据
        $orderData['order_number'] = date('YmdHis').session('uid');
        $orderData['user_id'] = session('uid');
        $orderData['order_addtime'] = time();
        $orderData['order_price'] = $data['total'];
        $orderData['order_pay']= $data['order_pay'];
        $orderData['location_id'] = $data['location_id'];
        $orderData['order_exp'] = $data['order_exp'];
        //实例化order表将数据添加到order表中
        $order_id = M('order') ->add($orderData);
        //数据重组 goods_order表添加的数据 多组数据形式添加
        foreach ($data['buy_datas'] as $key=>$value) {
            $ogData[$key]['order_id'] = $order_id;
            $ogData[$key]['user_id'] = session('uid');
            $ogData[$key]['og_price'] = $value['goods_price'];
            $ogData[$key]['og_number'] = $value['number'];
            $ogData[$key]['og_goods_id'] = $value['goods_id'];
            $ogData[$key]['og_total_price'] = $value['subtotal'];
            $ogData[$key]['og_goods_attr'] = serialize($value['goods_attr']);
        }
//        dump($ogData);die;
//        dump($orderData);die;
//        dump($data);die;
        //实例化goods_order表 添加数据
        M('goodsOrder')->addAll($ogData);
        $this->redirect('order/orderList','order_id='.$order_id);
    }
    public function orderList()
    {
        //获取传递的order_id
        $order_id = I('order_id');
        //根据order_id uid 查询订单资料
        $orderData = M('order')->where(array('id'=>$order_id,'user_id'=>session('uid')))->find();

//        dump($orderData);die;
        $this->assign('orderData',$orderData);
        $this->display();
    }
    public function orderPay()
    {
        //获取传递过来的oid
        $oid = I('oid');
        //获取订单数据
        $orderData = M('order')->find($oid);
//        dump($orderData);die;
        //引进支付宝支付
        vendor('alipay.alipay_submit#class');
        $alipay_config = C('PAY_ALIPAY');
        //构造要请求的参数数组，无需改动
        $parameter = array(
            "service"        => $alipay_config['service'],
            "partner"        => $alipay_config['partner'],
            "seller_id"      => $alipay_config['seller_id'],
            "payment_type"   => $alipay_config['payment_type'],
            "notify_url"     => $alipay_config['notify_url'],
            "return_url"     => $alipay_config['return_url'],

            "out_trade_no"   => $orderData['order_number'],
            "subject"        => 'XXXX商城-商品购买',
            "total_fee"      => $orderData['order_price'], //订单价格
            "body"           => '商城内部购买的商品',
            "_input_charset" => trim(strtolower($alipay_config['input_charset'])), //防止提交乱码

        );
        //建立请求
        $alipaySubmit = new \AlipaySubmit($alipay_config);
        $html_text    = $alipaySubmit->buildRequestForm($parameter, "get", "确认");
        echo $html_text;
    }
}
