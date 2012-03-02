CREATE TABLE IF NOT EXISTS `system_master` (
  `id` int(9) NOT NULL auto_increment,
  `master_code` varchar(25) NOT NULL,
  `master_id` int(10) NOT NULL,
  `master_value` varchar(256) NOT NULL,
  `status` int(1) NOT NULL default '1',
  `intval1` int(10) NOT NULL default '0',
  `intval2` int(10) NOT NULL default '0',
  `strval1` varchar(256) NOT NULL default '',
  `strval2` varchar(256) NOT NULL default '',
  `blnval1` tinyint(1) NOT NULL default '0',
  `blnval2` tinyint(1) NOT NULL default '0',
  `dblval1` double NOT NULL default '0',
  `dblval2` double NOT NULL default '0',
  `created_on` bigint(28) NOT NULL,
  `created_by` int(10) NOT NULL,
  `updated_on` bigint(28) NOT NULL,
  `updated_by` bigint(28) NOT NULL,
  `row_guid` varchar(256) NOT NULL,
  PRIMARY KEY  (`id`)
)

