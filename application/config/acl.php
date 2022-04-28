<?php
    // 游客
    $config['acl']['visitor'] = array(
        '' => array('index'),//首页
        'about' => array('index'),
        'categories'=> array('index'),
    );
     // 普通用戶
    $config['acl']['guest'] = array(
        '' => array('index'),//首页
        'about' => array('index'),
        'posts'=> array('index','view','create'),
        'categories'=> array(),
        'comments'=>array(),
    );
//-------------配置权限不够的提示信息及跳转url------------------//

$config['acl_info']['visitor'] = array(
    'info' => '须要登录以继续',
    'return_url' => 'users/login'
);

$config['acl_info']['guest'] = array(
    'info' => '你没有权限这样干',
    'return_url' => 'posts'
);