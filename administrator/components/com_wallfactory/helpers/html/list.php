<?php

/**
-------------------------------------------------------------------------
wallfactory - Wall Factory 4.1.8
-------------------------------------------------------------------------
 * @author thePHPfactory
 * @copyright Copyright (C) 2011 SKEPSIS Consult SRL. All Rights Reserved.
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * Websites: http://www.thePHPfactory.com
 * Technical Support: Forum - http://www.thePHPfactory.com/forum/
-------------------------------------------------------------------------
*/

defined('_JEXEC') or die;

class JHtmlWallFactoryList
{
    public static function ordering($saveOrder, $ordering)
    {
        $iconClass = '';
        $html = array();

        if (!$saveOrder) {
            $iconClass = ' inactive tip-top hasTooltip" title="' . JHtml::tooltipText('JORDERINGDISABLED');
        }

        $html[] = '<span class="sortable-handler' . $iconClass . '">';
        $html[] = '<span class="icon-menu"></span>';
        $html[] = '</span>';

        if ($saveOrder) {
            $html[] = '<input type="text" style="display:none" name="order[]" size="5" value="' . $ordering . '" class="width-20 text-area-order " />';
        }

        return implode($html);
    }

    public static function filter($route, $title)
    {
        $html = array();

        $link = WallFactoryRoute::view($route);
        $title = WallFactoryText::_($title);

        $html[] = '<a href="' . $link . '" class="muted text-muted hasTooltip" title="' . $title . '">';
        $html[] = '<span class="fa fa-fw fa-filter"></span>';
        $html[] = '</a>';

        return implode($html);
    }

    public static function actionEdit($i, $name)
    {
        $inflector = \Joomla\String\Inflector::getInstance();
        $singularName = $inflector->toSingular($name);

        return JHtml::_(
            'jgrid.action',
            $i,
            $singularName . '.edit',
            '',
            '',
            WallFactoryText::_($name . '_edit_' . $singularName),
            '',
            true,
            'pencil-2'
        );
    }

    public static function actionResolveReport($resolved, $i, $name)
    {
        return JHtml::_('jgrid.action',
            $i,
            $name . '.' . ($resolved ? 'unresolve' : 'resolve'),
            '',
            '',
            WallFactoryText::_('report_' . ($resolved ? 'unresolve' : 'resolve') . '_report'),
            '',
            true,
            ($resolved ? 'publish' : 'unpublish'),
            ($resolved ? 'unpublish' : 'publish'),
            true
        );
    }
}
