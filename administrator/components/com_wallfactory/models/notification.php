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

class WallFactoryBackendModelNotification extends WallFactoryModelAdmin
{
    public function test($pks, $mail)
    {
        /** @var WallFactoryTableNotification $table */

        $table = $this->getTable();
        $pks = (array)$pks;

        foreach ($pks as $pk) {
            if (!$pk || !$table->load($pk)) {
                continue;
            }

            $body = preg_replace('/({{ .+ }})/', '<b>$1</b>', $table->body);

            WallFactoryNotification::mail(
                $mail,
                WallFactoryText::sprintf('notification_test_subject', $table->subject),
                $body
            );
        }

        return true;
    }
}
