<?php
return [
    'default_app'=>'index',
    'default_controller'=>'index',
    'default_method'=>'index',
    'debug'=>true,
    'logger'=>true,
    'pagesize'=>5,
    'format_suffix'=>'htm',
    'validata_error_page'=>'message/validataError.php',
    'success_page'=>'message/sysSuccess.php',
    'error_page'=>'message/sysError.php',
    'validata_code_session'=>'_validata_code_session_',//验证码的Session字段
    'db'=>[
        'diver'=>'mysqli',
        'db_host' => 'localhost',
        'db_port' => '3306',
        'db_username' => 'root',
        'db_password' => 'root',
        'db_name' => 'heecms',
        'table_prefix'=>'heecms_',
        'charset'=>'utf8',
        'timeformat'=>'Y-m-d H:i:s',
        'dateformat'=>'Y-m-d',

    ],

    'pagination'=>[
      'class'=>'pagination',
        'item_class'=>'page-item',
        'link_class'=>'page-link',
        'currt_class'=>'active',
    ],
    'lang'=>[
        'on'=>false,
        'default'=>'zh-cn'
    ],
    'cache'=>[
        'diver'=>'file',
        'exp_time'=>3600,
        'redis'=>[
            'host'=>'127.0.0.1',
            'port'=>'6379'
        ],
        'memcache'=>[
            'host'=>'127.0.0.1',
            'port'=>'11211'
        ]
    ],
    'mail'=>[
        'server'=>'',
        'username'=>'',
        'password'=>'',
        'form'=>''
    ]
];