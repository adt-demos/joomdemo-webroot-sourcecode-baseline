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

class WallFactoryBackendModelReport extends WallFactoryModelAdmin
{
    public function save($data)
    {
        $actions = new \Joomla\Registry\Registry($data['actions']);

        if (!parent::save($data)) {
            return false;
        }

        if (null !== $actions->get('delete', null)) {
            $report = WallFactoryTable::getInstance('Report');
            $report->load($data['id']);

            $this->removeReportedResource($report->resource_type, $report->resource_id);
        }

        return true;
    }

    private function removeReportedResource($type, $id)
    {
        if ('comment' === $type) {
            $comment = WallFactoryTable::getInstance('Comment');
            $comment->load($id);
            $comment->delete();
        }

        if ('post' === $type) {
            $post = WallFactoryTable::getInstance('Post');
            $post->load($id);
            $post->delete();
        }
    }

    public function resolve($id)
    {
        /** @var WallFactoryTableReport $table */
        $table = $this->getTable('Report');

        if (!$table->load($id)) {
            return false;
        }

        $table->save(array(
            'resolved' => 1,
        ));
    }

    public function unresolve($id)
    {
        /** @var WallFactoryTableReport $table */
        $table = $this->getTable('Report');

        if (!$table->load($id)) {
            return false;
        }

        $table->save(array(
            'resolved' => 0,
        ));
    }
}
