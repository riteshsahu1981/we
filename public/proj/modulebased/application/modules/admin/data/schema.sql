CREATE TABLE IF NOT EXISTS `riteshssssssss` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `cover_image` varchar(255) default NULL,
  `description` text,
  `status` enum('publish','unpublish') NOT NULL default 'publish',
  `addedon` bigint(26) default NULL,
  `updatedon` bigint(24) default NULL,
  PRIMARY KEY  (`id`)
);

