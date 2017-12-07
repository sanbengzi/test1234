<?php
/**
 * Created by PhpStorm.
 * User: Chang
 * Date: 2017/5/26
 * Time: 15:26
 */
namespace Home\Controller;

use Think\Controller;
use Think\Verify;

class LoginController extends Controller
{
    public $userModel;
    public function __construct()
    {
        parent::__construct();
        $this->userModel = D('user');
    }

    /**
     * 用户登录
     */
    public function login()
    {
        //判断是否提交
        if (IS_POST) {
            $user_name = I('user_name');     //获取用户名
            $user_pwd = I('user_pwd');       //获取登录密码
            //查询 用户名和密码是否在user表中
            $where = array('user_name'=>$user_name,'user_pwd'=>md5($user_pwd));
            $res = $this->userModel->where($where)->find();
            //返回结果进行判断
            if ($res) {
                //登录成功将 用户id 用户名 密码 保存在session
                session('uid',$res['id']);
                session('username',$res['user_name']);
                session('password',$res['user_pwd']);
                $this->success('登录成功',U('login/user'));die;
            } else {
                $this->error('登录失败,账号或密码错误');
            }
        }
        $this->display();
    }

    /**
     * 用户注册
     */
    public function reg()
    {
        //判断是否提交
        if (IS_POST) {
            $data = I('post.');
            //实例化user表
//            dump($data);die;
            $verify = new Verify();
            //验证码判断
            if ($verify->check($data['captcha'])) {
                $data = $this->userModel->create();
                if (!$data) {
                    $this->error($this->userModel->getError());
                }
//                dump($data);die;
                $res = $this->userModel->add();
                if ($res) {
                    $this->success('注册成功！！',U('login/login'));die;
                } else {
                    $this->error($this->userModel->getError());
                }
            } else {
                $this->error('验证码输入错误！！！');
            }

        }

        $this->display();
    }
    /**
     * 验证码设置
     */
    public function verify()
    {
        $config = array(
            'useCurve'  =>  false,
            'useNoise'  =>  false,
            'imageH'    =>  25,               // 验证码图片高度
            'imageW'    =>  100,               // 验证码图片宽度
            'fontSize'  =>  12,
            'length'    =>  4,
            'fontttf'   =>  '4.ttf'

        );
        //实例化验证码
        $verify = new Verify($config);
        $verify->entry();
    }
    public function loginOut()
    {
        session(null);
        if (!session('?uid')) {
            $this->success('退出成功',U('index/index'));
        } else {
            $this->error('退出失败');
        }
    }
    public function sendCode()
    {
        //获取传递过来的电话号码
        $phone = I('phone');
        //获取随机的验证码
        $code = rand(1000,9999);
        //Demo调用
        //**************************************举例说明***********************************************************************
        //*假设您用测试Demo的APP ID，则需使用默认模板ID 1，发送手机号是13800000000，传入参数为6532和5，则调用方式为           *
        //*result = sendTemplateSMS("13800000000" ,array('6532','5'),"1");                                                                        *
        //*则13800000000手机号收到的短信内容是：【云通讯】您使用的是云通讯短信模板，您的验证码是6532，请于5分钟内正确输入     *
        //*********************************************************************************************************************
        $result = sendTemplateSMS(".$phone.",array(".$code.",'5'),"1");//手机号码，替换内容数组，模板ID
        $arr = array('code'=>$code);
        dump($result);
        echo json_encode($arr);
    }
}
