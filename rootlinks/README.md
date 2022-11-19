## rootlinks
[emlog友链分类管理](https://jiangdesheng.com/emlog-link-sort.html)，基于emlog5.3.1（需更改源代码）

### 数据库改动

* 添加表`表前缀_sortlink`
```
CREATE TABLE `表前缀_sortlink` (
  `linksort_id` int(10) NOT NULL AUTO_INCREMENT,
  `linksort_name` varchar(30) NOT NULL,
  `taxis` int(10) UNSIGNED NOT NULL DEFAULT '0',
  primary key (`linksort_id`)
) ENGINE=MyISAM;
```

* 在原有的`表前缀_link`表中增加字段`linksortid`
```
ALTER TABLE `表前缀_link` ADD `linksortid` INT(10) NOT NULL AFTER `id`;
```

### 添加文件

* admin/sortlink.php
* admin/views/sortlink.php
* admin/views/sortlinkedit.php
* include/model/sortlink_model.php

### 修改文件

* admin/link.php
* admin/views/header.php
* admin/views/links.php
* admin/views/linkedit.php
* include/model/link_model.php
* include/lib/cache.php
