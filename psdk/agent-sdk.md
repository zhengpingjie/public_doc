## 渠道SDK规范

**该文档是服务端渠道SDK的平台内部类的实现规范，依据渠道提供的相关文档实现具体接口。**

渠道SDK入口文件为: `./Api/Server/AgentSdk/{agent_id}/Sdk.class.php`，类名为: `Sdk`；如果通过命名空间的方式，请使用该命名空间: `Api\Server\AgentSdk\{agent_id}\Sdk`。

渠道SDK文件需要提供以下接口: 
- `valiLogin`登录校验
- `valiNotify`充值回调通知校验
- `notifyFailed`通知失败返回信息
- `notifySuccess`通知成功返回信息
- `formatPlatformOrderParams`聚合平台订单数据格式化

即需要实现`Api\Server\AgentSdk\ISdk`接口。

### 登录校验
```
$sdk->valiLogin($key);
```
参数
- key: 与渠道约定的秘钥
返回
- username 登录验证成功，返回渠道用户名
- false 登录验证失败

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

### 聚合平台订单数据格式化
将聚合平台的订单数据格式化为渠道订单所需格式，方便SDK回调传参，是`formatAgentOrderParams`的逆过程。
```
$sdk->formatPlatformOrderParams($order);
```
参数
- order: 平台订单详情
返回数据格式，按照渠道对接文档定制。


