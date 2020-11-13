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

class WallFactoryFrontendModelProfile extends JModelLegacy
{
    protected $option = 'com_wallfactory';

    public function findOrCreate($id)
    {
        if (!$id) {
            return null;
        }

        $result = $this->find($id);

        if ($result) {
            return $result;
        }

        $profile = WallFactoryTable::getInstance('Profile');
        $user = JFactory::getUser($id);

        $profile->bind(array(
            'user_id'    => $user->id,
            'name'       => $user->name,
            'created_at' => JFactory::getDate()->toSql(),
        ));

        $dbo = JFactory::getDbo();
        $dbo->insertObject($profile->getTableName(), $profile);

        return $this->find($id);
    }

    public function find($id)
    {
        $dbo = JFactory::getDbo();
        $profile = WallFactoryTable::getInstance('Profile');

        $query = $dbo->getQuery(true)
            ->select('p.*')
            ->from($dbo->qn($profile->getTableName(), 'p'))
            ->where($dbo->qn('p.user_id') . ' = ' . $dbo->q($id));

        $result = $dbo->setQuery($query)
            ->loadObject();

        if ($result) {
            $result->notifications = new \Joomla\Registry\Registry($result->notifications);
        }

        return $result;
    }

    public function update($data)
    {
        $form = $this->getForm();
        $data = WallFactoryForm::validate($form, $data);

        $profile = WallFactoryTable::getInstance('Profile');
        $profile->load($data['user_id']);

        if ($profile->user_id) {
            $profile->save($data);
        }
        else {
            $profile->bind($data);
            $dbo = $this->getDbo();
            $dbo->insertObject($profile->getTableName(), $profile);
        }

        \Joomla\CMS\Factory::getApplication()->triggerEvent('onProfileUpdated', array(
            'com_wallfactory',
            $profile,
        ));
    }

    public function getForm()
    {
        JForm::addFormPath(__DIR__ . '/forms');
        JForm::addRulePath(__DIR__ . '/rules');
        JForm::addFieldPath(__DIR__ . '/fields');

        $form = JForm::getInstance(
            $this->option . '.' . $this->getName(),
            $this->getName(),
            array(
                'control' => $this->getName(),
            )
        );

        WallFactoryForm::addLabelsToForm($form);

        if (!WallFactoryAvatar::canChangeAvatarSource()) {
            $form->removeField('avatar_source');
        }

        return $form;
    }

    public function delete($userId)
    {
        if (!$userId || (int)JFactory::getUser()->id !== $userId) {
            throw new Exception('You are not allowed to perform this action!');
        }

        /** @var WallFactoryTableProfile $profile */
        $profile = WallFactoryTable::getInstance('Profile');
        $profile->load($userId);

        $profile->delete();
    }

    public function fillFromJoomla(JUser $user, $defaultName)
    {
        $profile = WallFactoryTable::getInstance('Profile');

        $profile->bind(array(
            'user_id'       => $user->id,
            'name'          => $user->$defaultName,
            'avatar_source' => 'none',
            'created_at'    => JFactory::getDate()->toSql(),
        ));

        $dbo = $this->getDbo();
        $dbo->insertObject($profile->getTableName(), $profile);
    }
}
