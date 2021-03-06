<?php

// mix-httpd 下运行的 HTTP 服务配置（常驻协程模式）
return [

    // 应用调试
    'appDebug'       => env('APP_DEBUG'),

    // 初始化
    'initialization' => [],

    // 基础路径
    'basePath'       => dirname(__DIR__),

    // 组件配置
    'components'     => [

        // 路由
        'route'     => [
            // 依赖引用
            'ref' => beanname(Mix\Http\Route::class),
        ],

        // 请求
        'request'   => [
            // 依赖引用
            'ref' => beanname(Mix\Http\Message\Request::class),
        ],

        // 响应
        'response'  => [
            // 依赖引用
            'ref' => beanname(Mix\Http\Message\Response::class),
        ],

        // 错误
        'error'     => [
            // 依赖引用
            'ref' => beanname(Mix\Http\Error::class),
        ],

        // 日志
        'log'       => [
            // 依赖引用
            'ref' => beanname(Mix\Log\Logger::class),
        ],

        // Auth
        'auth'      => [
            // 依赖引用
            'ref' => beanname(Mix\Auth\Authorization::class),
        ],

        // Session
        'session'   => [
            // 依赖引用
            'ref' => beanname(Mix\Http\Session\HttpSession::class),
        ],

        // 连接池
        'pdoPool'   => [
            // 依赖引用
            'ref' => beanname(Mix\Database\Pool\ConnectionPool::class),
        ],

        // 连接池
        'redisPool' => [
            // 依赖引用
            'ref' => beanname(Mix\Redis\Pool\ConnectionPool::class),
        ],

    ],

    // 依赖配置
    'beans'          => [

        // 路由
        [
            // 类路径
            'class'      => Mix\Http\Route::class,
            // 属性
            'properties' => [
                // 控制器命名空间
                'controllerNamespace' => 'Http\Controllers',
                // 中间件命名空间
                'middlewareNamespace' => 'Http\Middleware',
                // 默认变量规则
                'defaultPattern'      => '[\w-]+',
                // 路由变量规则
                'patterns'            => [
                    'id' => '\d+',
                ],
                // 全局中间件
                'middleware'          => [],
                // 路由规则
                'rules'               => [
                    // 一级路由
                    '/{controller}/{action}' => ['{controller}', '{action}', 'middleware' => ['Before']],
                ],
            ],
        ],

        // 请求
        [
            // 类路径
            'class' => Mix\Http\Message\Request::class,
        ],

        // 响应
        [
            // 类路径
            'class'      => Mix\Http\Message\Response::class,
            // 属性
            'properties' => [
                // 默认输出格式
                'defaultFormat' => Mix\Http\Message\Response::FORMAT_HTML,
                // json
                'json'          => [
                    // 依赖引用
                    'ref' => beanname(Mix\Http\Message\Json::class),
                ],
                // jsonp
                'jsonp'         => [
                    // 依赖引用
                    'ref' => beanname(Mix\Http\Message\Jsonp::class),
                ],
                // xml
                'xml'           => [
                    // 依赖引用
                    'ref' => beanname(Mix\Http\Message\Xml::class),
                ],
            ],
        ],

        // json
        [
            // 类路径
            'class' => Mix\Http\Message\Json::class,
        ],

        // jsonp
        [
            // 类路径
            'class'      => Mix\Http\Message\Jsonp::class,
            // 属性
            'properties' => [
                // callback键名
                'name' => 'callback',
            ],
        ],

        // xml
        [
            // 类路径
            'class' => Mix\Http\Message\Xml::class,
        ],

        // 错误
        [
            // 类路径
            'class'      => Mix\Http\Error::class,
            // 属性
            'properties' => [
                // 输出格式
                'format' => Mix\Http\Error::FORMAT_HTML,
                // 错误级别
                'level'  => E_ALL,
            ],
        ],

        // 日志
        [
            // 类路径
            'class'      => Mix\Log\Logger::class,
            // 属性
            'properties' => [
                // 日志记录级别
                'levels'  => ['emergency', 'alert', 'critical', 'error', 'warning', 'notice', 'info', 'debug'],
                // 处理者
                'handler' => [
                    // 依赖引用
                    'ref' => beanname(Mix\Log\FileHandler::class),
                ],
            ],
        ],

        // 日志处理者
        [
            // 类路径
            'class'      => Mix\Log\FileHandler::class,
            // 属性
            'properties' => [
                // 日志目录
                'dir'         => 'logs',
                // 日志轮转类型
                'rotate'      => Mix\Log\FileHandler::ROTATE_DAY,
                // 最大文件尺寸
                'maxFileSize' => 0,
            ],
        ],

        // Auth
        [
            // 类路径
            'class'      => Mix\Auth\Authorization::class,
            // 属性
            'properties' => [
                // BearerToken
                'bearerToken' => [
                    // 依赖引用
                    'ref' => beanname(Mix\Auth\BearerToken::class),
                ],
                // jwt
                'jwt'         => [
                    // 依赖引用
                    'ref' => beanname(Mix\Auth\JWT::class),
                ],
            ],
        ],

        // BearerToken
        [
            // 类路径
            'class' => Mix\Auth\BearerToken::class,
        ],

        // jwt
        [
            // 类路径
            'class'      => Mix\Auth\JWT::class,
            // 属性
            'properties' => [
                // 钥匙
                'key'       => 'example_key',
                // 签名算法
                'algorithm' => Mix\Auth\JWT::ALGORITHM_HS256,
            ],
        ],

        // Session
        [
            // 类路径
            'class'      => Mix\Http\Session\HttpSession::class,
            // 属性
            'properties' => [
                // 处理者
                'handler'        => [
                    // 依赖引用
                    'ref' => beanname(Mix\Http\Session\RedisHandler::class),
                ],
                // session键名
                'name'           => 'session_id',
                // 生存时间
                'maxLifetime'    => 7200,
                // 过期时间
                'cookieExpires'  => 0,
                // 有效的服务器路径
                'cookiePath'     => '/',
                // 有效域名/子域名
                'cookieDomain'   => '',
                // 仅通过安全的 HTTPS 连接传给客户端
                'cookieSecure'   => false,
                // 仅可通过 HTTP 协议访问
                'cookieHttpOnly' => false,
            ],
        ],

        // Session处理者
        [
            // 类路径
            'class'      => Mix\Http\Session\RedisHandler::class,
            // 属性
            'properties' => [
                // 连接池
                'pool'      => [
                    // 组件引用
                    'component' => 'redisPool',
                ],
                // Key前缀
                'keyPrefix' => 'SESSION:',
            ],
        ],

        // 连接池
        [
            // 类路径
            'class'      => Mix\Database\Pool\ConnectionPool::class,
            // 属性
            'properties' => [
                // 最多可空闲连接数
                'maxIdle'   => 5,
                // 最大连接数
                'maxActive' => 50,
                // 拨号
                'dial'      => [
                    // 依赖引用
                    'ref' => beanname(Mix\Database\Pool\Dial::class),
                ],
            ],
        ],

        // 连接池拨号
        [
            // 类路径
            'class' => Mix\Database\Pool\Dial::class,
        ],

        // 连接池
        [
            // 类路径
            'class'      => Mix\Redis\Pool\ConnectionPool::class,
            // 属性
            'properties' => [
                // 最多可空闲连接数
                'maxIdle'   => 5,
                // 最大连接数
                'maxActive' => 50,
                // 拨号
                'dial'      => [
                    // 依赖引用
                    'ref' => beanname(Mix\Redis\Pool\Dial::class),
                ],
            ],
        ],

        // 连接池拨号
        [
            // 类路径
            'class' => Mix\Redis\Pool\Dial::class,
        ],

        // 数据库
        [
            // 类路径
            'class'      => Mix\Database\Coroutine\PDOConnection::class,
            // 属性
            'properties' => [
                // 数据源格式
                'dsn'           => env('DATABASE_DSN'),
                // 数据库用户名
                'username'      => env('DATABASE_USERNAME'),
                // 数据库密码
                'password'      => env('DATABASE_PASSWORD'),
                // 驱动连接选项: http://php.net/manual/zh/pdo.setattribute.php
                'driverOptions' => [
                    // 设置默认的提取模式: \PDO::FETCH_OBJ | \PDO::FETCH_ASSOC
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                ],
            ],
        ],

        // redis
        [
            // 类路径
            'class'      => Mix\Redis\Coroutine\RedisConnection::class,
            // 属性
            'properties' => [
                // 主机
                'host'     => env('REDIS_HOST'),
                // 端口
                'port'     => env('REDIS_PORT'),
                // 数据库
                'database' => env('REDIS_DATABASE'),
                // 密码
                'password' => env('REDIS_PASSWORD'),
            ],
        ],

    ],

];
