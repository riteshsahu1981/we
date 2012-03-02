
CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(14) NOT NULL auto_increment,
  `identifire` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL default 'active',
  `addedon` int(24) NOT NULL,
  `updatedon` int(24) default NULL,
  `created_by` int(15) NOT NULL,
  `updated_by` int(15) NOT NULL,
  `row_guid` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `identifire`, `role`, `status`, `addedon`, `updatedon`, `created_by`, `updated_by`, `row_guid`) VALUES
(1, 'employee', 'Employee', 'active', 34234, 1279623199, 0, 0, ''),
(2, 'administrator', 'Administrator', 'active', 435345434, 1273133025, 0, 0, ''),
(3, 'human_resource', 'Human Resource', 'active', 1273133203, 1328610027, 0, 0, ''),
(4, 'project_manager', 'Project Manager', 'active', 432432, 3432432, 0, 0, ''),
(5, 'team_leader', 'Team Leader', 'active', 3453535, 3432423, 0, 0, '');