CREATE TABLE IF NOT EXISTS `error_logs` (
  `id` int(11) NOT NULL auto_increment,
  `code` int(11) NOT NULL,
  `line_number` int(11) NOT NULL,
  `fpath` varchar(500) NOT NULL,
  `backtrace` longtext NOT NULL,
  `count` int(11) NOT NULL default '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `message` longtext NOT NULL,
  `token` varchar(64) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `key` (`token`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;