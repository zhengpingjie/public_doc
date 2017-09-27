# 聚合SDK - 游戏厂商接入文档

## 登录效验
- 参数列表

| KEY      | TYPE    | COMMENT |
| -------- | ------- | ------- |
| user_id | int     | 用户ID      |
| app_id   | int     | 应用ID     |
| isadult | int     | 是否成年 -1:未知 0:未成年 1:成年    |
| timestamp | int    | 登录时间    |
| sign | string   | 签名    |

`key`: 表示应用秘钥

- 验证方式
`用户ID`、`应用ID`、`是否成年`、`登录时间`、`应用秘钥`按顺序做字符串拼接，对所得的字符串进行MD5加密后，字符串转为小写，最终得到签名`sign`的值。通过与参数列表中的`sign`值作比较，得出效验结果。
```
$sign = strtolower(md5($user_id . $app_id . $isadult . $timestamp . $key));
```

## 创建订单
游戏厂商在接受到订单创建的请求并创建订单成功后，需要将订单相关信息按如下参数传递至回调函数中。
- 参数列表

| KEY      | TYPE    | COMMENT |
| -------- | ------- | ------- |
| user_id | int     | 用户ID      |
| app_id   | int     | 应用ID     |
| attach   | string     | 游戏订单号     |
| money   | int     | 订单金额（单位:元）     |
| server   | string     | 游戏区服     |
| role   | string     | 游戏角色     |
| ip   | string     | 用户IP     |

## 支付回调
- 参数列表

| KEY      | TYPE    | COMMENT |
| -------- | ------- | ------- |
| user_id | int     | 用户ID      |
| app_id   | int     | 应用ID     |
| order_sn   | string     | 聚合平台订单号     |
| attach   | string     | 游戏订单号     |
| money   | int     | 订单金额（单位:元）     |
| server   | string     | 游戏区服     |
| role   | string     | 游戏角色     |
| ip   | string     | 用户IP     |
| add_time   | string     | 聚合平台订单创建时间     |
| sign   | string     | 签名     |

- 验证方式
将**不**包括`sign`的所有其他参数、再加上参数`app_key`，值为应用秘钥形成参数列表。对参数列表按照键值进行字典排序。参数与值用等于号(`=`)链接，参数之间用and符号(`&`)链接，形成如下格式的字符串`user_id=xxx&app_id=xxx&order_sn=xxx...&app_key=xxx`，对所得的字符串进行MD5加密后，字符串转为小写，最终得到签名`sign`的值。通过与参数列表中的`sign`值作比较，得出效验结果。
```
$params = [
    'user_id' => ...,
    'app_id' => ...,
    'order_sn' => ...,
    'attach' => ...,
    'money' => ...,
    'server' => ...,
    'role' => ...,
    'ip' => ...,
    'add_time' => ...,
    'app_key' => ...,
];
ksrot($params);
$sign = strtolower(md5(http_build_query($params)));
```





