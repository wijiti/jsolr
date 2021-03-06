<?php
/**
 * Provides the base for the search results display.
 *
 * Loads the form, facet filters, facets, results and pagination templates.
 *
 * @package     JSolr.Search
 * @subpackage  View
 * @copyright   Copyright (C) 2012-2017 KnowledgeArc Ltd. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die('Restricted access');

JHtml::_('bootstrap.framework');
JHtml::_('behavior.framework');
JHtml::_('behavior.calendar');

$document = JFactory::getDocument();

$document->addStyleSheet(JURI::base().'media/com_jsolr/css/jsolr.css');
?>

<!-- This is not well styled but rather provides the functionality for

integrating faceting within the component. Use template overrides to improve. -->

<?php if ((bool)$this->params->get('embedfacets', true)) : ?>

<section id="jsolrFacetFilters">

    <?php
    if ($module = JModuleHelper::getModule('mod_jsolr_filter')) :
        $renderer = $document->loadRenderer('module');

        echo $renderer->render($module);
    endif;
    ?>

</section>

<?php endif; ?>

<section id="jsolrResults">

    <header>
        <?php echo $this->loadTemplate('form'); ?>
    </header>

    <?php if (!is_null($this->items)): ?>
        <?php echo $this->loadTemplate($this->get("DimensionTemplate")); ?>

    <footer>
        <div class="pagination">

        <?php echo $this->get('Pagination')->getPagesLinks(); ?>

        </div>
    </footer>

    <?php endif ?>

</section>
