<?php

/**
 * 渠道SDK类 - demo
 */

class Demo implements \Api\Server\AgentSdk\ISdk
{
    public $method = 'POST';

    public function params()
    {
        return I('post.');
    }

    /**
     * 登录验证
     *
     *     post参数列表
     *         user_id: 渠道用户ID
     *         timestamp: 登录时间
     *         sign: 渠道签名
     *
     * @Author   slpi1
     * @Email    365625906@gmail.com
     * @DateTime 2017-09-27T11:49:44+0800
     * @param    [type]                   $key [description]
     * @return   [type]                        [description]
     */
    public function valiLogin($key)
    {
        $user_name = I('post.user_name');
        $timestamp = I('post.timestamp');
        $sign = I('post.sign');

        if (strtolower(md5($user_name . $timestamp . $key)) == $sign) {
            return $user_name;
        }
        return false;
    }

    /**
     * 支付回调验证
     *
     *     post参数列表
     *         user_id: 渠道用户ID
     *         sn: 渠道订单号
     *         order_sn: 平台订单号
     *         money: 订单金额
     *         ...
     *         sign: 渠道签名
     *
     * @Author   slpi1
     * @Email    365625906@gmail.com
     * @DateTime 2017-09-27T12:02:12+0800
     * @param    [type]                   $key [description]
     * @return   [type]                        [description]
     */
    public function valiNotify($key)
    {
        $post = $this->params();
        $sign = $post['sign'];

        unset($post['sign']);
        $post['app_key'] = $key;

        ksort($post);

        if (strtolower(md5(http_build_query($post))) == $sign) {
            return $post['order_sn'];
        }
        return false;
    }
    
    /**
     * 回调验证失败
     * 
     * @Author   slpi1
     * @Email    365625906@gmail.com
     * @DateTime 2017-10-26T10:04:28+0800
     * @param    [type]                   $msg [description]
     * @return   [type]                        [description]
     */
    public function notifyFailed($msg)
    {
        $failed = array('status' => false, 'msg' => $msg);
        exit(json_encode($failed));
    }
    
    /**
     * 回调验证成功
     * 
     * @Author   slpi1
     * @Email    365625906@gmail.com
     * @DateTime 2017-10-26T10:04:45+0800
     * @return   [type]                   [description]
     */
    public function notifySuccess()
    {
        $success = array('status' => true);
        exit(json_encode($success));
    }

    /**
     * 提取渠道回调信息中的订单信息
     * @Author   slpi1
     * @Email    365625906@gmail.com
     * @DateTime 2017-10-26T10:05:01+0800
     * @return   [type]                   [description]
     */
    public function formatAgentOrderParams()
    {
        $post = I('post.');

        return array(
            'user_name' => $post['user_name'],
            'agent_order_sn' => $post['sn'],
            'order_sn' => $post['order_sn'],
            'money' => $post['money'],
            'serve' => $post['serve'],
            'role' => $post['role'],
            'ip' => $post['ip'],
        );
    }

    /**
     * 将平台订单信息转化为渠道创建订单时所需信息
     * 
     *   为提高安全性，可以对信息签名，具体要求，依照渠道提供的对接文档。
     * 
     * @Author   slpi1
     * @Email    365625906@gmail.com
     * @DateTime 2017-10-26T10:06:22+0800
     * @param    [type]                   $order [description]
     * @param    [type]                   $key   [description]
     * @return   [type]                          [description]
     */
    public function formatPlatformOrderParams($order, $key)
    {
        $params = array(
            'user_name' => $order['user_name'],
            'order_sn' => $order['order_sn'],
            'money' => $order['money'],
            'server' => $order['server'],
            'role' => $order['role'],
            'ip' => $order['ip'],
            'timestamp' => time(),
            'app_key' => $key,
        );

        ksort($params);
        $params['sign'] = strtolower(md5(http_build_query($params)));
        unset($params['app_key']);

        return $params;
    }
}
