<?php
// +----------------------------------------------------------------------
// | 消息中间件
// +----------------------------------------------------------------------
// | 处理发送消息
// +----------------------------------------------------------------------
// | 错误编码头 201xxx
// +----------------------------------------------------------------------

namespace Common\Middleware;

use Think\Hook;

class MessageMiddleware
{
    /**
     * @param $param
     */
    static public function register($param)
    {
        Hook::listen("message", $param);
    }
}