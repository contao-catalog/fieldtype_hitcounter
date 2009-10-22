<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 *
 * The TYPOlight webCMS is an accessible web content management system that 
 * specializes in accessibility and generates W3C-compliant HTML code. It 
 * provides a wide range of functionality to develop professional websites 
 * including a built-in search engine, form generator, file and user manager, 
 * CSS engine, multi-language support and many more. For more information and 
 * additional TYPOlight applications like the TYPOlight MVC Framework please 
 * visit the project website http://www.typolight.org.
 *
 * This is the catalog cataloghitsfield extension file.
 *
 * PHP version 5
 * @copyright  Christian Schiffler 2009
 * @author     Christian Schiffler  <c.schiffler@cyberspectrum.de> 
 * @package    CatalogHitsField
 * @license    GPL 
 * @filesource
 */

// class to manipulate the field info to be as we want it to be, to render it and to make editing possible.
class CatalogHitsField extends Backend {

	public function parseValue($id, $k, $raw, $blnImageLink, $objCatalog, $objCatalogInstance)
	{
		// note the $raw will always be one smaller than the real amount in the db. We can not do anything about this as the raw is not a pointer.
		if($objCatalogInstance instanceof ModuleCatalogReader)
		{
			// allow only one hit per item and ip per day.
			$haveHit=$this->Database->prepare("SELECT id, ip FROM tl_catalog_hitcounter WHERE cat_id=? AND item_id=? AND ip=? AND time>=?")
								->execute($objCatalog->pid, $objCatalog->id, $_SERVER['REMOTE_ADDR'], (time()-(60*60*24)))
								->next();
			if(!$haveHit->numRows)
			{
				$objCatTable=$this->Database->prepare("SELECT tableName FROM tl_catalog_types WHERE id=?")
								->execute($objCatalog->pid);
				$this->Database->prepare("UPDATE " . $objCatTable->tableName . " SET " . $k . "=" . $k . "+1 WHERE id=?")
								->execute($objCatalog->id, $k);
				$this->Database->prepare("INSERT INTO tl_catalog_hitcounter (cat_id, item_id, ip, time) VALUES (?, ?, ?, ?)")
							   ->execute($objCatalog->pid, $objCatalog->id, $_SERVER['REMOTE_ADDR'], time());
							   // Would love to use $this->Environment->ip here but this is the internal IP of an network if behind NAT, therefore useless.
			}
		}
		$html="<span class=\"hitcounter\">" . sprintf($GLOBALS['TL_LANG']['cataloghitsfieldfield']['hitsvalue'], $raw) . "</span>";
		return array
				(
				 	'items'	=> array($html),
					'values' => false,
				 	'html'  => $html,
				);
	}
}
?>