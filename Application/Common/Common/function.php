<?php
/**
 * Created by PhpStorm.
 * User: Chang
 * Date: 2017/6/2
 * Time: 8:46
 */

/**
 * 放XSS攻击
 * @param $str string  要进行防止XSS攻击的数据
 * @return string 返回进行XSS攻击处理后的数据
 */
function htmlpurifier($str)
{
    //引入第三方插件
    vendor('htmlpurifier.library.HTMLPurifier#auto');
    //获取默认配置
    $config = HTMLPurifier_Config::createDefault();
    //实例化 根据配置设置
    $purifier = new HTMLPurifier($config);
    //过滤字符串
    $clean_html = $purifier->purify($str);
    return $clean_html;
}

/**
 * 图片上传
 * @return array 图片上传成功返回图片上传信息 上传失败返回错误信息
 */
function uploadPic()
{
    //设置图片上传配置
    $config = array(
        'maxSize' => 1024*1024*5,
        'rootPath' => UPLOAD,
        'exts'   => array('jpg', 'gif', 'png', 'jpeg'),
    );
    //实例化图片上传类
    $upload = new \Think\Upload($config);
    //调用上传方法
    $info = $upload->upload();
    //返回结果进行判断
    if (!$info) {
        $a = $upload->getError();
        echo "<script>alert('$a');window.history.back(-1)</script>";die;
    }
    return $info;
}

/**
 * 状态获取方法
 * @param int $key 获取状态对应的键值
 * @return mixed
 */
function getStatus($key = 0)
{
    $arr = array(
        '0' => '否',
        '1' => '是'
    );
    return $arr[$key];
}

/**
 * 获取类型方法
 * @param int $key  键值
 * @return mixed
 */
function get_type($key = 0)
{
    $arr = array(
        '0' => '输入框',
        '1' => '复选框'
    );
    return $arr[$key];
}

/**
 * 属性值录入方式
 * @param int $key
 * @return mixed
 */
function get_write($key = 0)
{
    $arr = array(
        '0' => '手动输入',
        '1' => '点击选取'
    );
    return $arr[$key];
}
/**
 * 递归分类 传递进来的数据重新组成一个数组
 * @param $data 传递进来的数组数据 二维数组
 * @param int $pid  父级id 默认顶级 0
 * @param int $level 区分等级 默认顶级 0
 * @return array 返回一个新的数组 二维数组
 */
function getTree($data, $pid = 0, $level = 0)
{
    //静态数据存储递归的数据
    static $arr = array();
    //循环遍历数组
    foreach ($data as $value) {
        //进行判断数据的pid 是否等于$pid
        if ($value['pid'] == $pid) {
            $value['level'] = $level;
            $arr[] = $value;
            //进行递归
            getTree($data, $value['id'], $level+1);
        }
    }
    return $arr;
}

/**
 * 无极递归分类，存在子类 返回多维数组
 * @param $data 要处理的数据 二维数组
 * @param int $pid 父级id 默认顶级 0
 * @param int $level 区分等级 默认顶级 0
 * @return array 返回处理的新数组 一个多维数组
 */
function get_tree($data, $pid = 0,$level = 0)
{
    $arr = array();
    foreach ($data as $value) {
        if ($value['pid'] == $pid) {
            $value['level'] = $level;
            $value['son'] = get_tree($data, $value['id'], $level + 1);
            $arr[] = $value;
        }
    }
    return $arr;
}
/**
 * 把返回的数据集转换成Tree
 * @access public
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 */
function list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0)
{
    // 创建Tree
    $tree = array();
    if (is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] = &$list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data[$pid];
            if ($root == $parentId) {
                $tree[] = &$list[$key];
            } else {
                if (isset($refer[$parentId])) {
                    $parent           = &$refer[$parentId];
                    $parent[$child][] = &$list[$key];
                }
            }
        }
    }
    return $tree;
}

function getPrice()
{
    $arr = array(
        '0-200' => '0-200',
        '200-500' => '200-500',
        '500-1000' => '500-1000',
        '1000-2000'=> '1000-2000',
        '2000-5000'=> '2000-5000',
        '5000-'=>'5000-'
    );
    return $arr;
}

/**
 * 获取付款方式
 * @param int $key
 * @return mixed
 */
function getPay($key = 1)
{
    $arr = array(
        '1' => '余额',
        '2' => '支付宝',
        '3' => '微信'
    );
    return $arr[$key];
}

/**
 * 获取物流类型
 * @param int $key
 * @return mixed
 */
function getLocation($key = 1)
{
    $arr = array(
        '1' => '圆通',
        '2' => '申通'
    );
    return $arr[$key];
}
/**
 * 发送模板短信
 * @param to 手机号码集合,用英文逗号分开
 * @param datas 内容数据 格式为数组 例如：array('Marry','Alon')，如不需替换请填 null
 * @param $tempId 模板Id,测试应用和未上线应用使用测试模板请填写1，正式应用上线后填写已申请审核通过的模板ID
 */
function sendTemplateSMS($to,$datas,$tempId)
{
    //引入发送类
    vendor('sendmsg.CCPRestSmsSDK');
    // 初始化REST SDK
    // $accountSid,$accountToken,$appId,$serverIP,$serverPort,$softVersion;
    $msg_conf = C('SEND_MSG');
    $accountSid = $msg_conf['accountSid'];
    $accountToken = $msg_conf['accountToken'];
    $appId = $msg_conf['appId'];
    $serverIP = $msg_conf['serverIP'];
    $serverPort = $msg_conf['serverPort'];
    $softVersion = $msg_conf['softVersion'];
    $rest = new REST($serverIP,$serverPort,$softVersion);
    $rest->setAccount($accountSid,$accountToken);
    $rest->setAppId($appId);

    // // 发送模板短信
    // echo "Sending TemplateSMS to $to <br/>";
    $result = $rest->sendTemplateSMS($to,$datas,$tempId);
    if($result == NULL ) {
        return array('code'=>111);
//        break;
    }
    if($result->statusCode!=0) {
        return  array('code' =>(string)$result->statusCode  , 'msg'=>(string)$result->statusMsg);
        // echo "error code :" . $result->statusCode . "<br>";
        // echo "error msg :" . $result->statusMsg . "<br>";
        //TODO 添加错误处理逻辑
    }else{
        return array('code'=>0,'msg'=>'success');
        // echo "Sendind TemplateSMS success!<br/>";
        // // 获取返回信息
        // $smsmessage = $result->TemplateSMS;
        // echo "dateCreated:".$smsmessage->dateCreated."<br/>";
        // echo "smsMessageSid:".$smsmessage->smsMessageSid."<br/>";
        //TODO 添加成功处理逻辑
    }

}