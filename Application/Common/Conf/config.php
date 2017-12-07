<?php
return array(
	//'配置项'=>'配置值'
    'TMPL_PARSE_STRING'=>array(
        '__HOME__'=> __ROOT__.'/Public/Home/',
        '__ADMIN__'=>__ROOT__.'/Public/Admin/',
        '__UPLOAD__'=>__ROOT__.'/Public/Uploads/'
    ),
    /* 数据库设置 */
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'bdm292406151.my3w.com', // 服务器地址
    'DB_NAME'               =>  'bdm292406151_db',          // 数据库名
    'DB_USER'               =>  'bdm292406151',      // 用户名
    'DB_PWD'                =>  'susu111322',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'tp_',    // 数据库表前缀
    'SHOW_PAGE_TRACE' => true,
    'DEFAULT_FILTER'        =>  'htmlpurifier', // 默认参数过滤方法 用于I函数...
    //短信验证配置
    'SEND_MSG'          => array(
        //主帐号,对应开官网发者主账号下的 ACCOUNT SID
        'accountSid'   => '8a216da85c62c9ad015c9723dfc2129d',
        //主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
        'accountToken' => '2a70cee00c9c40a49e0b7c476146fca9',
        //应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
        //在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
        'appId'        => '8a216da85c62c9ad015c9723dff512a1',
        //请求地址
        //沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
        //生产环境（用户应用上线使用）：app.cloopen.com
        'serverIP'     => 'sandboxapp.cloopen.com',
        //请求端口，生产环境和沙盒环境一致
        'serverPort'   => '8883',
        //REST版本号，在官网文档REST介绍中获得。
        'softVersion'  => '2013-12-26',
    ),
    'URL_MODEL'             =>  2,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
    // 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式
);