# Recruit
New recruit website for NJUPT

# 20150808更新
请把以下两行配置插入`recruit\Admin\Conf\config.php`和`recruit\Home\Conf\config.php`中：
```php
    'DB_PARAMS' => array(\PDO::ATTR_CASE => \PDO::CASE_NATURAL),
    'URL_CASE_INSENSITIVE' => false,
```

然后把数据库的`association_departments`表中的`departmentname`字段改为`departmentName`。
