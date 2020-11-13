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

class JFormFieldReportResource extends JFormField
{
    protected function getInput()
    {
        $id = $this->form->getValue('id');

        /** @var WallFactoryTableReport $report */
        $report = WallFactoryTable::getInstance('Report');
        $report->load($id);

        $resourceType = $report->resource_type;
        $resourceId = $report->resource_id;
        $resourceTitle = $report->resource_title;
        $resourceExcerpt = $report->resource_excerpt;

        $url = $this->getResourceFrontendUrl($resourceType, $resourceId);

        $html = array();

        $html[] = '<h4><a href="' . $url . '" target="_blank">' . $resourceTitle . '</a></h4>';
        $html[] = '<div>' . $resourceExcerpt . '</div>';

        return implode($html);
    }

    private function getResourceFrontendUrl($type, $id)
    {
        if ('comment' === $type) {
            $url = WallFactoryRoute::task('comment.show&id=' . $id);
        }
        else {
            $url = WallFactoryRoute::task('post.show&id=' . $id);
        }

        $url = str_replace('/administrator', '', $url);

        return $url;
    }
}
