##数据模型定义

### 机器表

> 配置机器的属性 

### 预约的订单表

> 描述机器的预定详情

```sql
CREATE TABLE `termicals`{
  `id` INT NOT NULL auto_increment,
  `name` VARCHAR (64) NOT NULL comment '机器名称',
  `state` init not NULL DEFAULT 1 commont '机器状态 1：正常 2：故障',
  `create_time` timestamp not null default current_timestamp comment '创建时间',
  `update_time` timestamp not null default current_timestamp on update current_timestamp comment '修改时间',
  PRIMARY KEY (`id`)
}


```

### 机器信息配置信息管理表

```sql
CREATE TABLE `configuration_manage`{
  `id` INT NOT NULL auto_increment,
  `key` VARCHAR (64) NOT NULL comment '配置的主见',
  `label` init not NULL DEFAULT 1 commont '配置的名称',
  `state` init not NULL DEFAULT 1 commont '是否使用 1：使用 2：禁言',
  `order` init not NULL DEFAULT 1 commont '字段排序',
  `table_name` init not NULL DEFAULT 1 commont '关联的表名称',
  `create_time` timestamp not null default current_timestamp comment '创建时间',
  `update_time` timestamp not null default current_timestamp on update current_timestamp comment '修改时间',
  PRIMARY KEY (`id`),
}


```


### 时间配置表
> 配置不同时间端的时间数据  时间没有到之前可以修改 时间到了以后 就不能修改开始时间 只能修改结束时间 让其自动失效 然后创建一条新的时间段配置

```sql
CREATE TABLE `times`{
  `id` INT NOT NULL auto_increment,
  `termical_id` VARCHAR (64) NOT NULL comment '机器id',
  `user_id` init not NULL DEFAULT 1 commont '机器id',
  `start_time` VARCHAR (64) NOT NULL commont '预约的时间',
  `end_time` VARCHAR (64) NOT NULL commont '结束时间',
  `create_time` timestamp not null default current_timestamp comment '创建时间',
  `update_time` timestamp not null default current_timestamp on update current_timestamp comment '修改时间',
  PRIMARY KEY (`id`)
}


```

### 资源预约订单表

```sql
CREATE TABLE `termicals_booking`{
  `id` INT NOT NULL auto_increment,
  `start_time` VARCHAR (64) NOT NULL comment '开始时间',
  `end_time` init not NULL DEFAULT 1 commont '结束时间',
  `time` VARCHAR (64) NOT NULL commont '时间间隔',
  `code` VARCHAR (64) NOT NULL commont '预约码',
  `start_date` VARCHAR (64) NOT NULL commont '开始日期',
  `end_date` VARCHAR (64) NOT NULL commont '结束日期',
  `create_time` timestamp not null default current_timestamp comment '创建时间',
  `update_time` timestamp not null default current_timestamp on update current_timestamp comment '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY (`code`),
  KEY `code`
}


```

