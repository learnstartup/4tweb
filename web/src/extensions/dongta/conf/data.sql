CREATE TABLE `pw_app_dongta` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `act` tinyint(1) unsigned NOT NULL default '0',
  `touid` int(10) unsigned NOT NULL default '0',
  `created_userid` int(10) unsigned NOT NULL default '0',
  `creaed_username` varchar(15) NOT NULL default '',
  `created_time` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `idx_touid_createdtime` (`touid`,`created_time`)
) ENGINE=MyISAM;