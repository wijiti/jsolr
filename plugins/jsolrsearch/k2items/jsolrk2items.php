<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
/**
 * Format a K2 item result to create a generic result.
 *
 * @version     $LastChangedBy: spauldingsmails $
 * @paackage	Wijiti
 * @subpackage	JSolr
 * @copyright   Copyright (C) 2011 inwardXpat Pty Ltd
 */

jimport('joomla.error.log');

require_once JPATH_ROOT.DS."components".DS."com_k2".DS."helpers".DS."route.php";

class plgJSolrSearchJSolrK2Items extends JPlugin 
{
	var $_plugin;
	
	var $_params;
		
	/**
	 * Constructor
	 *
	 * @param 	object $subject The object to observe
	 * @param 	array  $config  An array that holds the plugin configuration
	 * @since 1.5
	 */

	function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);
		
		$this->loadLanguage(null, JPATH_ADMINISTRATOR);
		
		// load plugin parameters
		$this->_plugin = & JPluginHelper::getPlugin('jsolrsearch', 'jsolrk2items');
		$this->_params = new JParameter($this->_plugin->params);	
	}

	function onAddQF()
	{
		$qf = array();

		foreach ($this->_params->toArray() as $key=>$value) {
				if (strpos($key, "jsolr_boost") === 0) {
					$qfKey = str_replace("jsolr_boost_", "", $key);
					$qf[$qfKey] = floatval($value);
				}
		}

		return $qf;
	}
	
	function onAddHL()
	{
		$hl = array("title", "content", "metadescription");
		
		return $hl;
	}	
	
	function onFilterOptions()
	{		
		static $options = array();
		$options['com_k2items'] = JText::_("PLG_JSOLRSEARCH_JSOLRK2ITEMS_COM_K2");
	
		return $options;
	}
	
	/**
	* Search method
	*
	* Format a com_content document and return a generic result item.
	* @param mixed $document
	* @param mixed $hl
	* @param int $hlFragSize
	* @param string $lang
	*/
	function onFormatResult($document, $hl, $hlFragSize, $lang) 
	{
		$result = null;
		
		$option = $this->onFilterOptions();
		$keys = array_keys($option);
		
		$id = $document->id;
		$title = "title$lang";
		$category = "category$lang";

		if ($document->option == JArrayHelper::getValue($keys, 0)) {
			$result = new stdClass();
			
			$parts = explode(".", $id);
			$itemId = JArrayHelper::getValue($parts, 1, 0);
			
			if (isset($hl->$id->$title)) {
        		$hlTitle = JArrayHelper::getValue($hl->$id->$title, 0);
			} else {
				$hlTitle = $document->$title;
			}
			
			$result->title = $hlTitle;			
			$result->href = JRoute::_(K2HelperRoute::getItemRoute($itemId));
			$result->text = $this->_getHlContent($document, $hl, $hlFragSize, $lang);
			$result->created = $document->created;
			$result->modified = $document->modified;
			$result->location = $document->$category;
		}
		
		return $result;
	}
	
	function _getHlContent($document, $highlighting, $fragSize, $lang)
	{
		$id = $document->id;
		$hlContent = null;

		$metadescription = "metadescription$lang";
		$content = "content$lang";

		if ($this->_params->get("jsolr_use_hl_metadescription") == 1 && 
			isset($highlighting->$id->$metadescription)) {
			$hlContent = JArrayHelper::getValue($highlighting->$id->$metadescription, 0);
		} else {
			if (isset($highlighting->$id->$content)) {
				foreach ($highlighting->$id->$content as $item) {
					$hlContent .= "<span class=\"jsolr-separator\">...</span>".$item;	
				}

				$hlContent .= "<span class=\"jsolr-separator\">...</span>";
			}
		}
		
		return $hlContent;
	}
}