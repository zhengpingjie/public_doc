## 渠道SDK规范

**该文档是服务端渠道 SDK 的平台内部类的实现规范，依据渠道提供的相关文档实现具体接口。**

渠道SDK入口文件为: `./Api/Server/AgentSdk/Sdk_{agent_id}/Sdk.class.php`，类名为: `Sdk`；如果通过命名空间的方式，请使用该命名空间: `Api\Server\AgentSdk\Sdk_{agent_id}\Sdk`。

渠道SDK文件需要提供以下接口: 
- `params` 参数获取
- `valiLogin` 登录校验
- `valiNotify` 充值回调通知校验
- `notifyFailed` 通知失败返回信息
- `notifySuccess` 通知成功返回信息
- `formatAgentOrderParams` 渠道订单数据格式化
- `formatPlatformOrderParams` 聚合平台订单数据格式化

即需要实现 `Api\Server\AgentSdk\ISdk` 接口。

### 参数获取
```
$sdk->params();
```
返回数据格式，按照渠道对接文档定制。

### 登录校验
```
$sdk->valiLogin($key);
```
参数
- key: 与渠道约定的秘钥

返回
- username 登录验证成功，返回渠道用户名。此处用户名并不一定指用户名，而是一个凭证，渠道凭此凭证可以确定在平台上对应的唯一用户。
- false 登录验证失败

*在效验登录数据时，外部只需要传入秘钥即可，其他必要参数可以从内部获取。*

### 充值回调通知校验
```
$sdk->valiNotify($key);
```
参数
- key: 与渠道约定的秘钥

返回
- order_sn 充值回调验证成功，返回平台订单号
- false 充值回调验证失败

### 通知失败返回信息
```
$sdk->notifyFailed($msg);
```
参数
- msg: 失败原因

返回数据格式，按照渠道对接文档定制。

### 通知成功返回信息
```
$sdk->notifySuccess();
```
返回数据格式，按照渠道对接文档定制。

### 渠道订单数据格式化
```
$sdk->formatAgentOrderParams();
```
返回
```
{
    user_name: 渠道用户名 (必要参数)
    agent_order_sn: 渠道订单号 (必要参数)
    order_sn: 聚合平台订单号 (必要参数)
    money: 订单金额 (必要参数)
    serve: 服务器 ID
    role: 角色 ID
    ip: 用户 IP
}
```

### 聚合平台订单数据格式化
将聚合平台的订单数据格式化为渠道订单所需格式，方便SDK回调传参，是 `formatAgentOrderParams` 的逆过程。
```
$sdk->formatPlatformOrderParams($order, $key);
```
参数
- order: 平台订单详情
- key: 与渠道约定的秘钥

返回数据格式，按照渠道对接文档定制。


## 附
- [渠道SDK实现示例](./demo.php)