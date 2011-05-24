-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the TYPOlight *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************


-- --------------------------------------------------------

--
-- Table `tl_catalog_hitcounter`
-- 

CREATE TABLE `tl_catalog_hitcounter` (
-- id for this entry
  `id` int(10) unsigned NOT NULL auto_increment,
-- id of the catalog
  `cat_id` int(10) unsigned NOT NULL default '0',
-- id of the item in the catalog 
  `item_id` int(10) unsigned NOT NULL default '0',
-- ip where this hit originated from
  `ip` varchar(255) NOT NULL default '',
-- time when this hit occured
  `time` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;