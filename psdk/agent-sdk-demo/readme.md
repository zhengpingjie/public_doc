# 渠道SDK对接文档示例

**角色**
- 用户
- 渠道 / 渠道SDK / 渠道后台
- 聚合平台 / 聚合SDK / 聚合后台

**对接参数**
- `app_id` : 渠道提供的游戏ID
- `app_key` ：渠道提供的游戏的秘钥值。
- `notify_url` : 聚合平台提供的充值回调地址

## 登录验证
- 过程描述

用户登录渠道SDK完成后，调用聚合SDK提供的登录方法 `login`，并返回登录结果。

- 参数列表
| KEY      | TYPE    | COMMENT |
| -------- | ------- | ------- |
| user_name | string     | 用户名      |
| timestamp | int     | 时间戳     |
| sign   | string     | 签名     |

- 返回值
```
登陆成功返回 true ，登录失败返回 false
```

- 签名验证
```
strtolower(md5($user_name . $timestamp . $app_key)) == $sign
```

## 订单创建
- 过程描述

用户点击游戏充值按钮，系统生成订单信息。聚合SDK获取到系统订单信息后，调用渠道SDK的订单创建方法 `order`，渠道SDK验证订单合法并创建订单。订单创建成功后，返回渠道订单号并唤起支付流程。

- 参数列表
| KEY      | TYPE    | COMMENT |
| -------- | ------- | ------- |
| user_name | string     | 渠道用户名      |
| order_sn | string     | 游戏订单号     |
| money   | int     | 订单金额（元整数）     |
| server | string     | 游戏区服     |
| role   | string     | 游戏角色     |
| ip | string     | 请求IP     |
| timestamp | int     | 时间戳     |
| sign   | string     | 签名     |

- 返回值
```
渠道SDK订单创建成功返回渠道订单号，创建失败返回 false
```

- 签名方法

聚合SDK将 `user_name/order_sn/money/server/role/ip/timestamp/app_key` 参数列表按照键值进行字典排序。参数与值用等于号(`=`)链接，参数之间用and符号(`&`)链接，形成如下格式的字符串`user_name=xxx&order_sn=xxx&money=xxx...&app_key=xxx`，对所得的字符串进行MD5加密后，字符串转为小写，最终得到签名`sign`的值。
去掉`app_key`参数后将`sign`值传入参数，最终形成参数列表。
```
$params = array(
    'user_name' => ...,
    'order_sn' => ...,
    'money' => ...,
    'server' => ...,
    'role' => ...,
    'ip' => ...,
    'timestamp' => ...,
    'app_key' => $app_key,
);

ksort($params);
$params['sign'] = strtolower(md5(http_build_query($params)));
unset($params['app_key']);

return $params;
```

## 充值成功回调
- 过程描述

用户支付成功后，渠道后台发送回调信息至聚合后台，聚合后台验证请求合法后通知游戏给用户发放物品。

- 请求方式
```
POST
```

- 参数列表
| KEY      | TYPE    | COMMENT |
| -------- | ------- | ------- |
| user_name | string     | 渠道用户名      |
| sn | string     | 渠道订单号     |
| order_sn | string     | 游戏订单号     |
| money   | int     | 订单金额（元整数）     |
| server | string     | 游戏区服     |
| role   | string     | 游戏角色     |
| ip | string     | 请求IP     |
| timestamp | int     | 时间戳     |
| sign   | string     | 签名     |

- 返回值

聚合后台订单验证成功，返回如下：
```
{"status":true}
```
聚合后台订单验证失败，返回如下：
```
{"status":false,"msg":"失败原因"}
```

- 验签方式

聚合后台收到回调请求后，将除 `sign` 以外的所有参数，加上 `app_key` 后按键值进行字典排序。参数与值用等于号(`=`)链接，参数之间用and符号(`&`)链接，形成如下格式的字符串`user_name=xxx&order_sn=xxx&money=xxx...&app_key=xxx`，对所得的字符串进行MD5加密后，字符串转为小写，最终得到签名`sign`的值。比较计算后的签名值与请求参数的签名是否一致。
```
$params = $_POST;

$sign = $params['sign'];

unset($params['sign']);
$params['app_key'] = $key;

ksort($params);

return strtolower(md5(http_build_query($params))) == $sign;
```