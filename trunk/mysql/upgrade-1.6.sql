ALTER TABLE `account` MODIFY COLUMN `permissions` int(11);
ALTER TABLE `account` ADD COLUMN `level` varchar(20) default 'Open' AFTER `permissions`;
ALTER TABLE `combat` ADD COLUMN `level` varchar(20) default 'Confidential' AFTER `data`;
ALTER TABLE `hack` ADD COLUMN `level` varchar(20) default 'Confidential' AFTER `friendAlliances`;

UPDATE `account` SET `permissions` = 1073741823 WHERE `permissions` = 0;
UPDATE `account` SET `permissions` = 715827882 WHERE `permissions` = 2;
UPDATE `account` SET `permissions` = 0 WHERE NOT `permissions` = 1073741823 AND NOT `permissions` = 715827882;

INSERT INTO `account` (`universe`, `name`, `password`, `permissions`, `level`) VALUES
('Orion', 'Orion-Admin', '986d76480b0b202c14f23ffd3b977f68', 0, 'Admin'),
('Artemis', 'Artemis-Admin', '986d76480b0b202c14f23ffd3b977f68', 0, 'Admin'),
('Pegasus', 'Pegasus-Admin', '986d76480b0b202c14f23ffd3b977f68', 0, 'Admin'),
('Orion', 'Orion-Public', '4c9184f37cff01bcdc32dc486ec36961', 715827882, 'Open'),
('Artemis', 'Artemis-Public', '4c9184f37cff01bcdc32dc486ec36961', 715827882, 'Open'),
('Pegasus', 'Pegasus-Public', '4c9184f37cff01bcdc32dc486ec36961', 715827882, 'Open');

CREATE TABLE IF NOT EXISTS `comment` (
  `id` bigint(20) NOT NULL auto_increment,
  `universe` varchar(10) NOT NULL,
  `table` varchar(20) NOT NULL,
  `table_id` bigint(20) NOT NULL,
  `name` varchar(20) default NULL,
  `when` datetime NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

CREATE TABLE IF NOT EXISTS `level` (
  `id` smallint(2) unsigned NOT NULL,
  `level` smallint(2) unsigned NOT NULL,
  `name` varchar(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `level` (`id`, `level`, `name`) VALUES
(1, 1, 'Open'),
(2, 2, 'Confidential'),
(3, 3, 'Admin');

CREATE TABLE IF NOT EXISTS `payment` (
  `id` bigint(20) NOT NULL auto_increment,
  `universe` varchar(10) default NULL,
  `when` datetime default NULL,
  `type` varchar(50) default NULL,
  `location` varchar(50) default NULL,
  `payer` varchar(60) default NULL,
  `receiver` varchar(60) default NULL,
  `credits` int(12) default NULL,
  `level` varchar(20) default 'Confidential',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=85 ;
