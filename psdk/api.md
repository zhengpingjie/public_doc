# API列表

## 登录接口
用户登录的过程，需要请求该接口，返回数据以供厂商进行验证。
订单创建过程需要请求该接口，以验证请求的合法性，并提供给厂商进行订单创建。
- 接口名: `login/{appId}/{agentId}`
- 请求参数：
```
以渠道提供的文档为准
```
- 返回参数
```
{
    code:
    msg:
    data:{
        user_id: 平台用户ID
        timestamp: 时间戳
        sign: 签名
    }
}
```

## 订单创建接口
- 接口名: `order/{appId}/{agentId}`
- 请求参数：
```
以渠道提供的文档为准
```
- 返回参数
```
{
    code:
    msg:
    data:{
        order_sn: 平台订单号
        server：游戏区服
        role：角色ID
    }
}
```

## 支付成功回调接口
由于该接口直接与渠道服务器通讯，故请求参数与返回参数格式都以渠道提供的文档为准。
- 接口名 `notify/{appId}/{agentId}`
- 请求参数：
```
以渠道提供的文档为准
```
- 返回参数
```
`以渠道提供的文档为准`
```

附：[渠道SDK规范](https://github.com/slpi1/public_doc/blob/master/psdk/agent-sdk.md)