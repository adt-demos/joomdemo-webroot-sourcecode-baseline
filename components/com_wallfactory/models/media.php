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

class WallFactoryFrontendModelMedia extends JModelLegacy
{
    /**
     * @param $postId
     *
     * @return WallFactoryTableMedia[]
     */
    public function findByPost($postId)
    {
        $dbo = $this->getDbo();
        $media = WallFactoryTable::getInstance('Media');

        $query = $dbo->getQuery(true)
            ->select('m.*')
            ->from($dbo->qn($media->getTableName(), 'm'))
            ->where($dbo->qn('m.post_id') . ' = ' . $dbo->q($postId))
            ->order($dbo->qn('m.ordering') . ' ASC');

        $results = $dbo->setQuery($query)
            ->loadObjectList('id', get_class($media));

        return $results;
    }

    public function findForPosts(array $ids = array())
    {
        if (!$ids) {
            return array();
        }

        $mediaOrdered = $this->findForPostsOrdered($ids);
        $mediaGrouped = $this->groupMediaByType($mediaOrdered);

        $results = $this->parseMediaByType($mediaGrouped);

        return $results;
    }

    private function findForPostsOrdered(array $ids = array())
    {
        $dbo = $this->getDbo();
        $media = WallFactoryTable::getInstance('Media');

        $query = $dbo->getQuery(true)
            ->select('m.*')
            ->from($dbo->qn($media->getTableName(), 'm'))
            ->where($dbo->qn('m.post_id') . ' IN (' . implode(',', $dbo->q($ids)) . ')')
            ->order($dbo->qn('m.ordering') . ' ASC');

        $results = $dbo->setQuery($query)
            ->loadAssocList();

        return $results;
    }

    private function groupMediaByType($media)
    {
        $grouped = array();

        foreach ($media as $result) {
            if (!isset($grouped[$result['media_type']])) {
                $grouped[$result['media_type']] = array();
            }

            $grouped[$result['media_type']][$result['media_id']] = $result['ordering'];
        }

        return $grouped;
    }

    private function parseMediaByType($types)
    {
        $array = array();

        foreach ($types as $type => $ids) {
            $results = $this->findMediaItemsForTypeAndIds($type, array_keys($ids));

            foreach ($results as $result) {
                $ordering = $ids[$result->id];

                if (!isset($array[$result->post_id])) {
                    $array[$result->post_id] = array();
                }

                $result->type = $type;

                $array[$result->post_id][$ordering] = $result;
            }
        }

        foreach ($array as $postId => &$media) {
            ksort($media);
        }

        return $array;
    }

    private function findMediaItemsForTypeAndIds($type, array $ids = array())
    {
        if (!$ids) {
            return array();
        }

        $dbo = $this->getDbo();
        $table = WallFactoryTable::getInstance('Media' . ucfirst($type));

        $query = $dbo->getQuery(true)
            ->select('m.*')
            ->from($dbo->qn($table->getTableName(), 'm'))
            ->where($dbo->qn('m.id') . ' IN (' . implode(',', $dbo->q($ids)) . ')');

        $results = $dbo->setQuery($query)
            ->loadObjectList('id');

        return $results;
    }
}
