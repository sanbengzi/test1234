<?php
namespace Admin\Controller;

use Think\Controller;
use Think\Verify;

class LoginController extends Controller {

    public function login()
    {
        if (IS_POST) {
            //获取表单提价的数据
            $data = I('post.');
            //验证验证码是否正确
            //实例化验证码类
            $verify = new Verify();
            //check检测验证码是否正确
            if ($verify->check($data['captcha'])) {
                //实例化模型
                $adminModel = M('admin');
                //查询  用户名和登录密码 是否存在
                $res = $adminModel->where(array('username'=>$data['admin_user'],'password'=>md5($data['admin_psd'])))->find();
//                dump($res);die;
                //验证用户名或者密码是否正确
                if ($res) {
                    //登录成功，将用户信息存储到session中
                    session('uid',$res['id']);
                    session('username',$res['username']);
                    session('rid',$res['role_id']);
//                    dump(session());die;
                    $this->success('登录成功！！',U('index/index'));
                } else {
                    $this->error('用户名或密码错误！');
                }
            } else {
                $this->error('验证码错误');
            }
        } else {
            $this->display();
        }

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
            'imageW'    =>  80,               // 验证码图片宽度
            'fontSize'  =>  12,
            'length'    =>  3,
            'fontttf'   =>  '4.ttf'

        );
        //实例化验证码
        $verify = new Verify($config);
        $verify->entry();
    }
    public function loginOut()
    {
        //销毁session中存储的数据
        session(null);
        if (!session('?username')) {
            $this->success('退出成功！！',U('login/login'));
        }
    }
}