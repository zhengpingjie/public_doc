## 渠道SDK

渠道SDK入口文件为：`./Api/Server/AgentSdk/{agent_id}/Sdk.class.php`，类名为：`Sdk`；如果通过命名空间的方式，请使用该命名空间：`Api\Server\AgentSdk\{agent_id}\Sdk`。

渠道SDK文件需要提供以下接口：
- `params`获取请求参数列表
- `valiLogin`登录校验
- `valiNotify`充值回调通知校验
- `formatOrderParams`订单数据格式化
即需要实现`Api\Server\AgentSdk\ISdk`接口。


### 请求参数列表
```
$sdk->params();
```
返回数据格式，按照渠道对接文档。

### 订单创建
```
$sdk->order();
```

### 登录校验
```
$sdk->valiLogin($key);
```
参数
- key：与渠道约定的秘钥
返回
- username 登录验证成功，返回渠道用户名，用以获取平台用户ID
- false 登录验证失败

### 充值回调通知校验
```
$sdk->valiPay($key);
```
参数
- key：与渠道约定的秘钥
返回
- true 充值验证成功
- false 充值验证失败

### 订单数据格式化
```
$sdk->formatOrderParams();
```
返回
```
{
    user_name: 渠道用户名
    agent_order_sn: 渠道订单号
    money：订单金额
    server：服务器ID
    role：用户角色ID
    ip：ip
    attache：厂商订单号
    agent_pay_time：渠道支付完成时间
}
```
