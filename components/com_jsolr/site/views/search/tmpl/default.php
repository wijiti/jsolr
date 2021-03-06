<?php
/**
 * Default search page.
 *
 * Override to edit the JSolr Search home page.
 *
 * @package     JSolr
 * @subpackage  View
 * @copyright   Copyright (C) 2012-2017 KnowledgeArc Ltd. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

JHTML::_('behavior.formvalidation');

$form = $this->get('Form');

defined('_JEXEC') or die('Restricted access');

$document = JFactory::getDocument();

$document->addStyleSheet(JURI::base().'/media/com_jsolr/css/jsolr.css');
?>
<section id="jsolr">
    <form
        action="<?php echo JRoute::_("index.php"); ?>"
        method="get"
        name="adminForm"
        class="form-validate jsolr-search-result-form"
        id="jsolr-search-result-form">
        <div class="input-append">
            <?php foreach ($this->get('Form')->getFieldset('query') as $field): ?>
            <span><?php echo $form->getInput($field->fieldname); ?></span>
            <?php endforeach;?>

            <input type="hidden" name="option" value="com_jsolr"/>
            <input type="hidden" name="task" value="search"/>

            <button type="submit" class="btn"><i class="icon-search"></i></button>
        </div>

        <div class="jsolr-clear"></div>
    </form>
</section>
