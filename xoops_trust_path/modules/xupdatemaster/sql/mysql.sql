CREATE TABLE `{prefix}_{dirname}_store` (
  `store_id` int(11) unsigned NOT NULL  auto_increment,
  `title` varchar(255) NOT NULL,
  `contents` int(11) unsigned NOT NULL,
  `addon_url` varchar(255) NOT NULL,
  `uid` mediumint(8) unsigned NOT NULL,
  `posttime` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`store_id`)) ENGINE=MyISAM;

CREATE TABLE `{prefix}_{dirname}_item` (
  `item_id` int(11) unsigned NOT NULL  auto_increment,
  `title` varchar(255) NOT NULL,
  `store_id` int(11) unsigned NOT NULL,
  `uid` mediumint(8) unsigned NOT NULL,
  `category_id` mediumint(8) unsigned NOT NULL,
  `target_key` varchar(60) NOT NULL,
  `addon_url` varchar(255) NOT NULL,
  `approval` int(0) unsigned NOT NULL,
  `posttime` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`item_id`)) ENGINE=MyISAM;

