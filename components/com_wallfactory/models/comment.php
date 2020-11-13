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

class WallFactoryFrontendModelComment extends JModelLegacy
{
    protected $option = 'com_wallfactory';

    public function submit(array $data = array())
    {
        $form = $this->getForm();
        $data = WallFactoryForm::validate($form, $data);

        $data['content'] = WallFactoryHelper::filterBannedWords($data['content']);

        $comment = WallFactoryTable::getInstance('Comment');
        $comment->save($data);
    }

    public function getForm()
    {
        $user = JFactory::getUser();
        $config = JComponentHelper::getParams('com_wallfactory');

        JForm::addFormPath(__DIR__ . '/forms');
        JForm::addRulePath(__DIR__ . '/rules');

        $form = JForm::getInstance(
            $this->option . '.' . $this->getName(),
            $this->getName(),
            array(
                'control' => $this->getName(),
            )
        );

        if (!$user->guest) {
            $form->removeField('author_name');
            $form->removeField('author_email');
            $form->removeField('captcha');
        }
        else {
            if (!$config->get('comment.captcha', 0)) {
                $form->removeField('captcha');
            }
        }

        WallFactoryForm::addLabelsToForm($form);

        return $form;
    }

    public function delete(JUser $user, $id)
    {
        if ($user->guest) {
            throw new Exception('comment_delete_error_guest');
        }

        $comment = WallFactoryTable::getInstance('Comment');

        if (!$id || !$comment->load($id)) {
            throw new Exception('comment_delete_error_not_found');
        }

        if ($user->id != $comment->user_id) {
            throw new Exception('comment_delete_error_not_allowed');
        }

        $comment->delete();
    }
}
