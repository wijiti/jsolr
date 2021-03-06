<?php
/**
 * A script for intercepting calls to this component and handling them appropriately.
 *
 * @package    JSolr
 * @copyright  Copyright (C) 2012-2017 KnowledgeArc Ltd. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

JLoader::register('JSolrHelper', dirname(__FILE__).'/helpers/jsolr.php');

JLoader::registerNamespace('JSolr', JPATH_PLATFORM);

if (class_exists('JControllerLegacy')) {
    $JControllerName = 'JControllerLegacy';
} else {
    $JControllerName = 'JController';
}

$controller	= $JControllerName::getInstance('jsolr');

$controller->execute(JRequest::getCmd('task'));

$controller->redirect();
