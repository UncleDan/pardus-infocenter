-- phpMyAdmin SQL Dump
-- version 2.7.0-pl2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Feb 15, 2010 at 09:00 PM
-- Server version: 5.0.89
-- PHP Version: 5.2.12
-- 
-- Pardus Infocenter 1.5b2.004 SQL Install File
-- 

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `pardus_info_center`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `account`
-- 

CREATE TABLE IF NOT EXISTS `account` (
  `id` bigint(20) NOT NULL auto_increment,
  `universe` varchar(10) NOT NULL,
  `name` varchar(32) NOT NULL,
  `password` varchar(32) default NULL,
  `permissions` tinyint(2) NOT NULL,  
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `universe`, `name`, `password`, `permissions`) VALUES
(1, 'Orion', 'Orion-Send', '986d76480b0b202c14f23ffd3b977f68', 1),
(2, 'Artemis', 'Artemis-Send', '986d76480b0b202c14f23ffd3b977f68', 1),
(3, 'Pegasus', 'Pegasus-Send', '986d76480b0b202c14f23ffd3b977f68', 1),
(4, 'Orion', 'Orion-View', '986d76480b0b202c14f23ffd3b977f68', 2),
(5, 'Artemis', 'Artemis-View', '986d76480b0b202c14f23ffd3b977f68', 2),
(6, 'Pegasus', 'Pegasus-View', '986d76480b0b202c14f23ffd3b977f68', 2),
(7, 'Orion', 'Orion-Admin', '986d76480b0b202c14f23ffd3b977f68', 15),
(8, 'Artemis', 'Artemis-Admin', '986d76480b0b202c14f23ffd3b977f68', 15),
(9, 'Pegasus', 'Pegasus-Admin', '986d76480b0b202c14f23ffd3b977f68', 15);

-- --------------------------------------------------------

-- 
-- Table structure for table `combat`
-- 

CREATE TABLE IF NOT EXISTS `combat` (
  `id` bigint(20) NOT NULL auto_increment,
  `pid` bigint(20) NOT NULL,
  `universe` varchar(10) NOT NULL,
  `type` varchar(20) NOT NULL,
  `when` datetime NOT NULL,
  `sector` varchar(20) NOT NULL,
  `coords` varchar(10) NOT NULL,
  `attacker` varchar(60) NOT NULL,
  `defender` varchar(60) NOT NULL,
  `outcome` varchar(20) NOT NULL,
  `additional` varchar(40) default NULL,
  `data` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6103 DEFAULT CHARSET=latin1 AUTO_INCREMENT=6103 ;

-- 
-- Dumping data for table `combat`
-- 

INSERT INTO `combat` (`id`, `pid`, `universe`, `type`, `when`, `sector`, `coords`, `attacker`, `defender`, `outcome`, `additional`, `data`) VALUES
(1, 44242082, 'Orion', 'Ship vs NPC', '2008-12-14 15:21:37', 'Heze', '8,36', 'Pio', 'Lucidi Squad', 'defeated', '', 'Pio;shadow_stealth_craft.png;90;397;0;Lucidi Squad;lucidi_squad.png;77;0;0;A;L;50|2;120 MT Magnetic Defractor;MTmd120.png;L;50|2;120 MT Magnetic Defractor;MTmd120.png;L;50|2;120 MT Magnetic Defractor;MTmd120.png;L;50|2;120 MT Magnetic Defractor;MTmd120.png;B;L;126|2;Lucidi Plasma Thrower;;L;126|2;Lucidi Plasma Thrower;;L;126|2;Lucidi Plasma Thrower;;R1;S1;50;53 hull damage;S2;R2;S1;50;24 hull damage;L;1;0;1;E;90;397;0;F;0;0;0;'),
(2, 62974545, 'Orion', 'Ship vs NPC', '2010-04-17 09:44:47', 'Aya', '22,21', 'Uncledan', 'Euryale', 'disengaged', '', 'Uncledan;nighthawk_deluxe.png;300;540;0;Euryale;euryale.png;2000;1386;600;A;L;32|1;10 MW Mining Laser;MWmin010.png;L;32|1;10 MW Mining Laser;MWmin010.png;L;32|1;10 MW Mining Laser;MWmin010.png;L;32|1;10 MW Mining Laser;MWmin010.png;B;L;90|2;Outer Tentacles;;L;91|3;Inner Tentacles;;L;91|3;Inner Tentacles;;R1;S1;32;6 shield damage;S2;E;300;540;0;F;2000;1386;594;'),
(3, 62987736, 'Orion', 'Ship vs NPC', '2010-04-17 18:11:03', 'Regulus', '7,10', 'Sobkou', 'Space Crystal', 'disengaged', '', 'Sobkou;lanner.png;375;390;0;Space Crystal;space_crystal.png;1050;1050;270;A;B;L;9|1;Ice Ray;;L;9|1;Ice Ray;;L;9|1;Ice Ray;;R1;S1;S2;9;68 armor damage (110% efficiency);9;79 armor damage (110% efficiency);E;375;243;0;F;1050;1050;270;'),
(4, 41833540, 'Artemis', 'Ship vs NPC', '2010-02-15 02:56:21', 'Oauress', '17,15', 'Wormhole Monster', 'Taurvi', 'was defeated by', '', 'Wormhole Monster;../foregrounds/wormhole.png;108;0;0;Taurvi;constrictor.png;570;285;0;A;L;60|1;Subspace Splitter;;B;L;42|2;4 MW Light-weight Particle Laser;MWlwpar004.png;L;42|2;4 MW Light-weight Particle Laser;MWlwpar004.png;R1;S1;S2;R2;S1;S2;42;46 hull damage;42;46 hull damage;42;16 hull damage;L;2;1;1;E;0;0;0;F;570;285;0;'),
(5, 41833526, 'Artemis', 'Ship vs NPC', '2010-02-15 02:56:01', 'Oauress', '14,13', 'Wormhole Monster', 'Taurvi', 'disengaged', '', 'Wormhole Monster;../foregrounds/wormhole.png;130;0;0;Taurvi;constrictor.png;570;285;0;A;L;60|1;Subspace Splitter;;B;L;42|2;4 MW Light-weight Particle Laser;MWlwpar004.png;L;42|2;4 MW Light-weight Particle Laser;MWlwpar004.png;R1;S1;S2;42;46 hull damage;R2;S1;S2;R3;S1;S2;R4;S1;S2;R5;S1;S2;42;46 hull damage;E;38;0;0;F;570;285;0;');

-- --------------------------------------------------------

-- 
-- Table structure for table `hack`
-- 

CREATE TABLE IF NOT EXISTS `hack` (
  `id` bigint(20) NOT NULL auto_increment,
  `universe` varchar(10) NOT NULL,
  `date` datetime NOT NULL,
  `method` varchar(10) NOT NULL,
  `location` varchar(30) default NULL,
  `pilotId` bigint(20) default NULL,
  `pilot` varchar(30) NOT NULL,
  `credits` bigint(20) NOT NULL,
  `reputation` bigint(20) NOT NULL,
  `buildingAmount` bigint(20) NOT NULL,
  `experience` bigint(20) default NULL,
  `cluster` varchar(50) default NULL,
  `sector` varchar(20) default NULL,
  `coords` varchar(10) default NULL,
  `shipStatus` text,
  `buildingPositions` text,
  `buildings` text,
  `foes` text,
  `friends` text,
  `foeAlliances` text,
  `friendAlliances` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

-- 
-- Dumping data for table `hack`
-- 

INSERT INTO `hack` (`id`, `universe`, `date`, `method`, `location`, `pilotId`, `pilot`, `credits`, `reputation`, `buildingAmount`, `experience`, `cluster`, `sector`, `coords`, `shipStatus`, `buildingPositions`, `buildings`, `foes`, `friends`, `foeAlliances`, `friendAlliances`) VALUES
(1, 'Orion', '2008-05-01 21:18:20', 'guru', 'Red Cell Enaness Base', 1376, 'Orsan', 1291374, 594, 5, 1512360, 'Federation Human Core', 'Andexa', '[12,6]', '<SHIP_STATUS><HULL><COLOR>green</COLOR><AMOUNT>134</AMOUNT></HULL><ARMOR><COLOR>green</COLOR><AMOUNT>192</AMOUNT></ARMOR></SHIP_STATUS>', '<BUILDING_POSITIONS collection="true"><BUILDING_POSITION><SECTOR>Anaam</SECTOR><COORDS>[3,7]  [3,3]  [4,3]  [10,11] </COORDS><CLUSTER>West Pardus Rim</CLUSTER><AMOUNT>4</AMOUNT></BUILDING_POSITION><BUILDING_POSITION><SECTOR>Beethti</SECTOR><COORDS>[8,15]</COORDS><CLUSTER>West Pardus Rim</CLUSTER><AMOUNT>1</AMOUNT></BUILDING_POSITION></BUILDING_POSITIONS>', '<BUILDINGS collection="true"><BUILDING><SECTOR>Anaam</SECTOR><COORDS>[3,7]</COORDS><CLUSTER>West Pardus Rim</CLUSTER><COMMODITIES collection="true"><COMMODITIE><IMG>droid_modules.png</IMG><AMOUNT>20</AMOUNT></COMMODITIE><COMMODITIE><IMG>exotic_crystal.png</IMG><AMOUNT>10</AMOUNT></COMMODITIE></COMMODITIES><STOCK collection="true"><STOC><IMG>food.png</IMG><AMOUNT>40</AMOUNT></STOC><STOC><IMG>energy.png</IMG><AMOUNT>110</AMOUNT></STOC><STOC><IMG>water.png</IMG><AMOUNT>38</AMOUNT></STOC><STOC><IMG>robots.png</IMG><AMOUNT>80</AMOUNT></STOC><STOC><IMG>radioactive_cells.png</IMG><AMOUNT>110</AMOUNT></STOC></STOCK></BUILDING><BUILDING><SECTOR>Anaam</SECTOR><COORDS>[3,3]</COORDS><CLUSTER>West Pardus Rim</CLUSTER><COMMODITIES collection="true"><COMMODITIE><IMG>liquor.png</IMG><AMOUNT>136</AMOUNT></COMMODITIE><COMMODITIE><IMG>exotic_crystal.png</IMG><AMOUNT>20</AMOUNT></COMMODITIE></COMMODITIES><STOCK collection="true"><STOC><IMG>food.png</IMG><AMOUNT>96</AMOUNT></STOC><STOC><IMG>energy.png</IMG><AMOUNT>96</AMOUNT></STOC><STOC><IMG>water.png</IMG><AMOUNT>96</AMOUNT></STOC><STOC><IMG>chemical-supplies.png</IMG><AMOUNT>13</AMOUNT></STOC></STOCK></BUILDING><BUILDING><SECTOR>Anaam</SECTOR><COORDS>[4,3]</COORDS><CLUSTER>West Pardus Rim</CLUSTER><COMMODITIES collection="true"><COMMODITIE><IMG>liquor.png</IMG><AMOUNT>189</AMOUNT></COMMODITIE><COMMODITIE><IMG>exotic_crystal.png</IMG><AMOUNT>10</AMOUNT></COMMODITIE></COMMODITIES><STOCK collection="true"><STOC><IMG>food.png</IMG><AMOUNT>43</AMOUNT></STOC><STOC><IMG>water.png</IMG><AMOUNT>36</AMOUNT></STOC><STOC><IMG>chemical-supplies.png</IMG><AMOUNT>20</AMOUNT></STOC></STOCK></BUILDING><BUILDING><SECTOR>Anaam</SECTOR><COORDS>[10,11]</COORDS><CLUSTER>West Pardus Rim</CLUSTER><COMMODITIES collection="true"><COMMODITIE><IMG>food.png</IMG><AMOUNT>238</AMOUNT></COMMODITIE><COMMODITIE><IMG>water.png</IMG><AMOUNT>23</AMOUNT></COMMODITIE></COMMODITIES><STOCK collection="true"><STOC><IMG>energy.png</IMG><AMOUNT>66</AMOUNT></STOC><STOC><IMG>chemical-supplies.png</IMG><AMOUNT>4</AMOUNT></STOC><STOC><IMG>biowaste.png</IMG><AMOUNT>44</AMOUNT></STOC></STOCK></BUILDING><BUILDING><SECTOR>Beethti</SECTOR><COORDS>[8,15]</COORDS><CLUSTER>West Pardus Rim</CLUSTER><COMMODITIES collection="true"><COMMODITIE><IMG>food.png</IMG><AMOUNT>56</AMOUNT></COMMODITIE><COMMODITIE><IMG>water.png</IMG><AMOUNT>14</AMOUNT></COMMODITIE><COMMODITIE><IMG>biowaste.png</IMG><AMOUNT>16</AMOUNT></COMMODITIE></COMMODITIES><STOCK collection="true"><STOC><IMG>energy.png</IMG><AMOUNT>72</AMOUNT></STOC><STOC><IMG>animal_embryos.png</IMG><AMOUNT>90</AMOUNT></STOC></STOCK></BUILDING></BUILDINGS>', '', 'Akhenaton,Bew,Blackstone,Caodalama,Clash,Death,Fire Devil,Gaia,Lerain,Littlepea,Skp,Sumknight', 'M.E.R.C.,Nemesis,Empire', 'Quinto Imperio,Red Cell,Extinction Agenda,Federal Guard'),
(2, 'Orion', '2008-02-22 02:29:48', 'guru', 'Hitchhikers Outpost', 24876, 'Firkin Tall', 9892662, 370, 1, 638607, 'Pardus Empire Contingent', 'Menkar', '[0,5]', '<SHIP_STATUS><HULL><COLOR>green</COLOR><AMOUNT>140</AMOUNT></HULL><ARMOR><COLOR>green</COLOR><AMOUNT>136</AMOUNT></ARMOR></SHIP_STATUS>', '<BUILDING_POSITIONS collection="true"><BUILDING_POSITION><SECTOR>Tau Ceti</SECTOR><COORDS>[13,7]</COORDS><CLUSTER>Federation Human Core</CLUSTER><AMOUNT>1</AMOUNT></BUILDING_POSITION></BUILDING_POSITIONS>', '<BUILDINGS collection="true"><BUILDING><SECTOR>Tau Ceti</SECTOR><COORDS>[13,7]</COORDS><CLUSTER>Federation Human Core</CLUSTER><COMMODITIES collection="true"><COMMODITIE><IMG>energy.png</IMG><AMOUNT>586</AMOUNT></COMMODITIE><COMMODITIE><IMG>nebula-gas.png</IMG><AMOUNT>32</AMOUNT></COMMODITIE><COMMODITIE><IMG>cybernetic_x993_parts.png</IMG><AMOUNT>7</AMOUNT></COMMODITIE></COMMODITIES><STOCK collection="true"><STOC><IMG>food.png</IMG><AMOUNT>3</AMOUNT></STOC><STOC><IMG>water.png</IMG><AMOUNT>3</AMOUNT></STOC><STOC><IMG>exotic_matter.png</IMG><AMOUNT>40</AMOUNT></STOC></STOCK></BUILDING></BUILDINGS>', 'Biks,Crazy Matty H,Lost,Scybeam,Swisstov,Trazlo Trevize', 'Colossus,Crashtest Mike,Kaela Angeles,Onizuka,Palkkipantteri,Paranoid Floyd,Russelc,The Irishman', '', ''),
(3, 'Artemis', '2010-02-15 19:31:52', 'guru', 'MantiCorp Star Palace', 14947, 'Humble Dexter', 117582845, 216, 3, 623725, 'Empire Keldon Core', 'Delta Pavonis', '[5,21]', '<SHIP_STATUS><HULL><COLOR>green</COLOR><AMOUNT>200</AMOUNT></HULL><ARMOR><COLOR>green</COLOR><AMOUNT>134</AMOUNT></ARMOR></SHIP_STATUS>', '<BUILDING_POSITIONS collection="true"><BUILDING_POSITION><SECTOR>Fomalhaut</SECTOR><COORDS>[8,6]  [7,3] </COORDS><CLUSTER>Empire Keldon Core</CLUSTER><AMOUNT>2</AMOUNT></BUILDING_POSITION><BUILDING_POSITION><SECTOR>Delta Pavonis</SECTOR><COORDS>[10,22]</COORDS><CLUSTER>Empire Keldon Core</CLUSTER><AMOUNT>1</AMOUNT></BUILDING_POSITION></BUILDING_POSITIONS>', '<BUILDINGS collection="true"><BUILDING><SECTOR>Delta Pavonis</SECTOR><COORDS>[10,22]</COORDS><CLUSTER>Empire Keldon Core</CLUSTER><COMMODITIES collection="true"><COMMODITIE><IMG>hand-weapons.png</IMG><AMOUNT>45</AMOUNT></COMMODITIE><COMMODITIE><IMG>medicines.png</IMG><AMOUNT>1</AMOUNT></COMMODITIE><COMMODITIE><IMG>liquor.png</IMG><AMOUNT>7</AMOUNT></COMMODITIE><COMMODITIE><IMG>exotic_matter.png</IMG><AMOUNT>12</AMOUNT></COMMODITIE><COMMODITIE><IMG>battleweapon_parts.png</IMG><AMOUNT>3</AMOUNT></COMMODITIE><COMMODITIE><IMG>explosives.png</IMG><AMOUNT>1</AMOUNT></COMMODITIE></COMMODITIES><STOCK collection="true"><STOC><IMG>energy.png</IMG><AMOUNT>176</AMOUNT></STOC><STOC><IMG>hydrogen-fuel.png</IMG><AMOUNT>66</AMOUNT></STOC></STOCK></BUILDING><BUILDING><SECTOR>Fomalhaut</SECTOR><COORDS>[8,6]</COORDS><CLUSTER>Empire Keldon Core</CLUSTER><COMMODITIES collection="true"><COMMODITIE><IMG>hydrogen-fuel.png</IMG><AMOUNT>1</AMOUNT></COMMODITIE><COMMODITIE><IMG>cybernetic_x993_parts.png</IMG><AMOUNT>96</AMOUNT></COMMODITIE><COMMODITIE><IMG>drugs.png</IMG><AMOUNT>13</AMOUNT></COMMODITIE></COMMODITIES><STOCK collection="true"><STOC><IMG>food.png</IMG><AMOUNT>89</AMOUNT></STOC><STOC><IMG>energy.png</IMG><AMOUNT>84</AMOUNT></STOC><STOC><IMG>water.png</IMG><AMOUNT>89</AMOUNT></STOC><STOC><IMG>metal.png</IMG><AMOUNT>609</AMOUNT></STOC><STOC><IMG>electronics.png</IMG><AMOUNT>91</AMOUNT></STOC><STOC><IMG>optical_components.png</IMG><AMOUNT>108</AMOUNT></STOC></STOCK></BUILDING><BUILDING><SECTOR>Fomalhaut</SECTOR><COORDS>[7,3]</COORDS><CLUSTER>Empire Keldon Core</CLUSTER><COMMODITIES collection="true"><COMMODITIE><IMG>hydrogen-fuel.png</IMG><AMOUNT>3</AMOUNT></COMMODITIE><COMMODITIE><IMG>leech_baby.png</IMG><AMOUNT>1</AMOUNT></COMMODITIE></COMMODITIES><STOCK collection="true"><STOC><IMG>food.png</IMG><AMOUNT>56</AMOUNT></STOC><STOC><IMG>energy.png</IMG><AMOUNT>165</AMOUNT></STOC><STOC><IMG>water.png</IMG><AMOUNT>56</AMOUNT></STOC><STOC><IMG>robots.png</IMG><AMOUNT>240</AMOUNT></STOC><STOC><IMG>radioactive_cells.png</IMG><AMOUNT>110</AMOUNT></STOC></STOCK></BUILDING></BUILDINGS>', 'Alexandrite,Archonian,Ares God of War,Artenovel I,Augustine,Bellarinia,Cali,Captaintinks,Chandler Bong,Chef,Chiroptera,Chryhon,Crunchlestilskin,Dagger,Doomlord,Fronk,Galatica,Grenhywe,Greyhound,Harland,J P Kellner,Jagerbarde,James T Butt,Kalar Whitewolf,Karsha,Kreigsmarine,Larry Legend,Lord North,Luana Llish,Marguzz,Mimi Le Haphrou,Phrea,Rainrouge,Sabbath,Screallyer,Sextus Pompeius,Sir Mcblob A Lot,Sir Percival,Smiles,Takhisis,Tarantula,The Enigma,Tokoloshe,Ulmo,Unnefer,Viper,Wackywill,Wizard', 'Alcar,Altair Ibn Laahad,Arckanis,Argus Raven,Atrox Zed,Capricorn,Ein Elend,Gnut,Gwyndion Fireclash,Halfling Jr,Hollander,Hynam Ka,Iana,Jikoku no Onegai,Parthos,Ponder,Rabid Duck,Sensqui Nalso,Shimokita Phoenix,Skeeve,Spirit of Hitman,Storm Rider Zero,Stratos,Vaelis,Vrykonik,Xani', 'The Imperial Navy,Guardians of Prosperity,Reavers,Res Publica,VISU,The Black Company,The Psychedelic Zeladas,Lions of Rashkan,Freelance,VII,Wheeeee,Shadow Inc.,Sherwood Defence Guild,The Brown Coats,Karma,Who Cares,The Paladins of Light,Black Scum,The Communist Party of Artemis,Federation,Union', '');

-- --------------------------------------------------------

-- 
-- Table structure for table `mission`
-- 

CREATE TABLE IF NOT EXISTS `mission` (
  `id` bigint(20) NOT NULL auto_increment,
  `pid` bigint(20) NOT NULL,
  `universe` varchar(10) NOT NULL,
  `source` varchar(30) NOT NULL,
  `when` datetime NOT NULL,
  `faction` varchar(9) default NULL,
  `type` varchar(30) NOT NULL,
  `timelimit` bigint(20) NOT NULL,
  `amount` bigint(20) default NULL,
  `opponent` varchar(20) default NULL,
  `destination` varchar(30) default NULL,
  `sector` varchar(20) default NULL,
  `coords` varchar(10) default NULL,
  `reward` bigint(20) NOT NULL,
  `deposit` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_pid_universe` (`pid`,`universe`)
) ENGINE=InnoDB AUTO_INCREMENT=144354 DEFAULT CHARSET=latin1 AUTO_INCREMENT=144354 ;

-- 
-- Dumping data for table `mission`
-- 

INSERT INTO `mission` (`id`, `pid`, `universe`, `source`, `when`, `faction`, `type`, `timelimit`, `amount`, `opponent`, `destination`, `sector`, `coords`, `reward`, `deposit`) VALUES
(1, 98597564, 'Orion', 'Paladin Round Table', '2008-12-09 08:33:48', 'emp', 'VIP Action Trip', 50, 1800, '', 'Paladin Round Table', 'Ska', '37,8', 61500, 23060),
(2, 87870070, 'Artemis', 'MantiCorp Star Palace', '2010-02-15 18:42:04', '', 'Assassination', 20, 0, 'pirate_experienced', '', 'PP 5-713', '5,4', 5070, 1900);
