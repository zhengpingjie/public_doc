# 聚合SDK相关过程时序图

<img src="./active.jpg" alt="Build Status">

## 过程说明
### 用户登录
- 用户执行登录，调用渠道SDK的登录方法
- 渠道SDK验证用户登录请求成功，调用聚合SDK的登录方法(@login)
- 聚合SDK根据接受的参数，请求聚合Serve的login接口进行验证
- 聚合SDK登录验证成功后，调用厂商SDK的登录方法完成登录

### 用户充值
- 用户进行充值，调用渠道SDK的订单创建方法。
- 渠道SDK调用聚合SDK的订单创建方法(@order)
- 聚合SDK请求聚合Server的login接口，验证请求的合法性
- 聚合SDK调用厂商SDK的订单创建方法，获取厂商订单号(attach)
- 聚合SDK请求聚合Serve的order接口，创建聚合平台订单
- 聚合SDK返回平台订单号给渠道SDK

### 充值成功回调
- 渠道Server收到第三方充值成功回调信息
- 渠道Server通知聚合Server充值成功消息
- 聚合Server通知厂商Server充值成功消息