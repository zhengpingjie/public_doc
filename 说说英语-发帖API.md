# 接口列表
## 发起话题
- 接口名: topic/add
- 请求参数
```
{
    user_id: 发表人
    content: 话题内容
    type: 话题类型: 1,朋友圈；2，英语圈
    images: {
        0: 'http://xxx',
        1: 'http://xxx'
    },
    notice: {}
}
```
- 返回参数
```
{
    code: 0|1
    msg: 消息
    data: {
        id: 话题ID
        user_id: 发表人
        content: 话题内容
        images: {
            0: 'http://xxx',
            1: 'http://xxx'
        }
        notice: {}
        type: 话题类型
        flag: 话题标签
        sort: 排序
        follow_count: 回复数量
        agree_count: 点赞数量
        status: 话题状态
        add_time: 添加时间
    }
}
```

## 回复
- 接口名: topic/follow
- 请求参数
```
{
    user_id: 回复人
    topic_id: 话题ID
    follow_id: 0
    content: 回复内容
    notice: {} //
}
```
- 返回参数
```
{
    code: 0|1
    msg: 消息
    data: {
        id: 
        user_id: 回复人
        topic_id: 话题ID
        follow_id: 回复ID
        notice: {}
        status: 状态
        add_time: 回复时间
    }
}
```

## 点赞
- 接口名: topic/agree
- 请求参数
```
{
    user_id: 点赞人
    topic_id: 话题ID
}
```
- 返回参数
```
{
    code: 0|1
    msg: 消息
    data: {
        id: 
        user_id: 点赞人
        topic_id: 话题ID
        add_time: 点赞时间
    }
}
```

## 话题列表
- 接口名: topic/topiclist
- 请求参数
```
{
    type: 1: 热门; 2:朋友圈; 3:英语圈
    page: 页码
    limit: 每页数量
}
```
- 返回参数
```
{
    
    code: 0|1
    msg: 消息
    data: {
        page_count: 总页数
        list:[
            {
                id: 话题ID
                user_id: 发表人
                user_name: 昵称
                content: 话题内容
                images: {
                    0: 'http://xxx',
                    1: 'http://xxx'
                }
                notice: {}
                type: 话题类型
                flag: 话题标签
                sort: 排序
                follow_count: 回复数量
                agree_count: 点赞数量
                status: 话题状态
                add_time: 添加时间
            }
            ...
        ]
    }
}
```

## 话题回复列表
- 接口名: topic/followlist
- 请求参数
```
{
    topic_id: 话题ID
    page: 页码
    limit: 每页数量
}
```
- 返回参数
```
{
    
    code: 0|1
    msg: 消息
    data: {
        page_count: 总页数
        list:[
            {
                id: 
                user_id: 回复人
                user_name: 昵称
                topic_id: 话题ID
                follow_id: 0
                notice: {}
                status: 状态
                add_time: 回复时间
            }
            ...
        ]
    }
}
```

## 话题点赞列表
- 接口名 topic/agreelist
- 请求参数
```
{
    topic_id: 话题ID
    page: 页码
    limit: 每页数量
}
```
- 返回参数
```
{
    
    code: 0|1
    msg: 消息
    data: {
        page_count: 总页数
        list:[
            {
                id: 
                user_id: 点赞人
                user_name: 昵称
                topic_id: 话题ID
                add_time: 点赞时间
            }
            ...
        ]
    }
}
```

# 数据表结构

## 话题表[topic]

| KEY          | TYPE         | DEFAULT | COMMENT    |
| ------------ | ------------ | ------- | ---------- |
| id           | int          |         | 主键         |
| user_id      | int(10)      |         | 发表人ID      |
| content      | varchat(100) |         | 话题内容，30字以内 |
| images       | varchat(255) |         | 附图         |
| notice       | varchat(100) |         | @功能        |
| type         | tinyint(1)   | 1       | 话题类型       |
| flag         | tinyint(1)   |         | 标签         |
| sort         | int(10)      | 0       | 排序         |
| follow_count | int(10)      |         | 回复数        |
| agree_count  | int(10)      |         | 点赞数        |
| status       | tinyint(10)  |         | 状态         |
| add_time     | int(10)      |         | 发表时间       |

## 回复表[follow]
| KEY       | TYPE         | DEFAULT | COMMENT |
| --------- | ------------ | ------- | ------- |
| id        | int          |         | 主键      |
| user_id   | int(10)      |         | 回复人     |
| topic_id  | int(10)      |         | 话题ID    |
| follow_id | int(10)      |         | 回复ID    |
| notice    | varchat(100) |         | @功能     |
| status    | tinyint(10)  |         | 状态      |
| add_time  | int(10)      |         | 回复时间    |

## 点赞表[agree]
| KEY      | TYPE    | DEFAULT | COMMENT |
| -------- | ------- | ------- | ------- |
| id       | int     |         | 主键      |
| user_id  | int(10) |         | 点赞人     |
| topic_id | int(10) |         | 话题ID    |
| add_time | int(10) |         | 点赞时间    |

