<?php
/**
 * Provides the search form within the search results display so that a user
 * can modify the current search without having to start over.
 *
 * Copy this file to override the layout and style of the search results form.
 *
 * @package     JSolr.Search
 * @subpackage  View
 * @copyright   Copyright (C) 2012-2016 KnowledgeArc Ltd. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.formvalidation');
?>
<form
    action="<?php echo JRoute::_("index.php"); ?>"
    method="get"
    name="adminForm"
    class="form-validate jsolr-search-result-form"
    id="jsolr-search-result-form">

    <?php if (JFactory::getApplication()->input->get('o', null)) : ?>
    <input type="hidden" name="o" value="<?php echo JFactory::getApplication()->input->get('o'); ?>"/>
    <?php endif; ?>

    <fieldset class="query">

        <?php
        // Output search fields (in almost all cases will be a single query field).
        foreach ($this->get('Form')->getFieldset('query') as $field):
            echo $this->form->getInput($field->fieldname);
        endforeach;
        ?>

        <?php
        // Output the hidden form fields for the various selected facet filters.
        foreach ($this->get('Form')->getFieldset('facets') as $field):
            if (trim($field->value)) :
                echo $this->form->getInput($field->fieldname);
            endif;
        endforeach;
        ?>

        <button type="submit" class="button"><?php echo JText::_("COM_JSOLR_SEARCH_BUTTON_SUBMIT"); ?></button>
    </fieldset>

    <a href="<?php echo JRoute::_(\JSolr\Search\Factory::getAdvancedSearchRoute()); ?>">Advanced search</a>

    <ul id="jsolrDimensions" class="nav nav-tabs">
        <?php
        foreach ($this->get('Dimensions') as $dimension) :
            echo "<li".($dimension->active ? " class=\"active\"" : "").">".JHTML::link($dimension->url, $dimension->name)."</li>";
        endforeach;
        ?>
    </ul>

    <div id="jsolrFacetfilters">
        <?php if (!is_null($this->get('Form'))): ?>
        <ul>

            <?php
            foreach ($this->get('AppliedFacetFilters') as $field) :
                $uri = clone JURI::getInstance();
                $uri->delVar($field->name);
            ?>

            <li>
                <span class="jsolr-label"><?php echo $field->label; ?></span>
                <span class="jsolr-value"><?php echo str_replace('|', ' | ', $field->value); ?></span>

                <?php echo JHTML::link((string)htmlentities($uri), '(clear)'); ?>
            </li>

            <?php
            endforeach;
            ?>

            <?php
            foreach ($this->get('AppliedAdvancedFilters') as $field) :
                $uri = clone JURI::getInstance();
                $uri->delVar($field->name);
            ?>

            <li>
                <span class="jsolr-label"><?php echo $field->label; ?></span>

                <?php echo JHTML::link((string)htmlentities($uri), '(clear)'); ?>
            </li>

            <?php
            endforeach;
            ?>

        </ul>

        <?php endif ?>
    </div>

    <div class="jsolr-searchtools btn-group">
        <?php foreach ($this->get('Form')->getFieldset('tools') as $field) : ?>
            <?php echo $this->form->getInput($field->name); ?>
        <?php endforeach;?>
    </div>

    <input type="hidden" name="option" value="com_jsolr"/>
    <input type="hidden" name="task" value="search"/>
    <?php echo JHTML::_('form.token'); ?>
</form>
