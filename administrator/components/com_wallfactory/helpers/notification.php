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

use ThePhpFactory\Wall\Notification\NotificationGroupInterface;
use ThePhpFactory\Wall\Notification\NotificationInterface;
use ThePhpFactory\Wall\Notification\NotificationSimpleInterface;

class WallFactoryNotification
{
    public static function sendNotification(NotificationInterface $notification)
    {
        $configuration = JComponentHelper::getParams('com_wallfactory');

        if (!$configuration->get('notifications.' . $notification->getType() . '.enabled', 1)) {
            return false;
        }

        if ($notification instanceof NotificationGroupInterface) {
            $type = $notification->getType();
            $groups = $configuration->get('notifications.' . $type . '.groups', []);

            $users = self::getUsersByGroups($groups);

            foreach ($users as $id) {
                $user = JFactory::getUser($id);
                $notification->setReceivingUser($user);

                self::send($notification);
            }
        }
        elseif ($notification instanceof NotificationSimpleInterface) {
            try {
                $user = $notification->findReceivingUser();

                if ($user instanceof JUser) {
                    $notification->setReceivingUser($user);

                    if (!$notification->hasTemplate()) {
                        return false;
                    }

                    self::send($notification);
                }
            }
            catch (Exception $e) {
                WallFactoryLogger::log(
                    sprintf('FAILED TO FIND RECEIVING USER (type: "%s", error: "%s")',
                        $notification->getType(),
                        $e->getMessage()
                    ),
                    'notification'
                );
            }
        }

        return true;
    }

    private static function getUsersByGroups(array $groups = [])
    {
        if (!$groups) {
            return [];
        }

        // Get a database object.
        $db = JFactory::getDbo();

        // First find the users contained in the group
        $query = $db->getQuery(true)
            ->select('DISTINCT(user_id)')
            ->from('#__usergroups as ug1')
            ->join('INNER', '#__usergroups AS ug2 ON ug2.lft = ug1.lft AND ug1.rgt = ug2.rgt')
            ->join('INNER', '#__user_usergroup_map AS m ON ug2.id=m.group_id')
            ->where('ug1.id IN (' . implode(',', $db->q($groups)) . ')');

        $result = $db->setQuery($query)
            ->loadColumn();

        return $result;
    }

    private static function send(NotificationInterface $notification)
    {
        try {
            self::assertNotificationEnabled(
                $notification->getReceivingUser()->id,
                $notification->getType()
            );

            $result = WallFactoryNotification::mail(
                $notification->getEmail(),
                $notification->getSubject(),
                $notification->getBody()
            );

            WallFactoryLogger::log(
                sprintf('%s (type: "%s", email "%s")',
                    $result ? 'SENT' : 'FAILED TO SEND',
                    $notification->getType(),
                    $notification->getEmail()
                ),
                'notification'
            );
        }
        catch (Exception $e) {
            WallFactoryLogger::log(
                sprintf('FAILED TO INITIALIZE (type: "%s", error "%s")',
                    $notification->getType(),
                    $e->getMessage()
                ),
                'notification'
            );
        }
    }

    private static function assertNotificationEnabled($userId, $notification)
    {
        $profile = WallFactoryTable::getInstance('Profile');
        $profile->load($userId);

        $notifications = new \Joomla\Registry\Registry($profile->notifications);

        if (!$notifications->get($notification, 1)) {
            throw new Exception('User has disabled this notification!');
        }
    }

    public static function mail($email, $subject, $body)
    {
        $mail = JFactory::getMailer();
        $config = JFactory::getConfig();

        $mail->addAddress($email);
        $mail->setBody($body);
        $mail->setSubject($subject);
        $mail->isHtml(true);
        $mail->setSender([
            $config->get('mailfrom'),
            $config->get('fromname'),
        ]);

        $result = $mail->send();

        return $result;
    }

    public static function getTypes()
    {
        static $types = null;

        if (null === $types) {
            $types = [];

            jimport('joomla.filesystem.folder');

            $files = JFolder::files(
                JPATH_SITE . '/components/com_wallfactory/src/Notification',
                '.php',
                false,
                false,
                [],
                ['.Interface.php']
            );

            foreach ($files as $file) {
                $filename = strtolower(pathinfo($file, PATHINFO_FILENAME));
                $types[$filename] = WallFactoryText::_('notification_' . $filename);
            }
        }

        return $types;
    }

    public static function getTokens($type)
    {
        $filenames = [
            'commentnew'      => 'CommentNew',
            'commentnewgroup' => 'CommentNewGroup',
            'postnewgroup'    => 'PostNewGroup',
        ];

        if (!$type) {
            return [];
        }

        if (isset($filenames[$type])) {
            $type = $filenames[$type];
        }

        $class = '\\ThePhpFactory\\Wall\\Notification\\' . $type;

        if (class_exists($class)) {
            $class = new $class;

            if ($class instanceof NotificationInterface) {
                return $class->getTokens();
            }
        }

        return [];
    }

    public static function getNotifications()
    {
        static $notifications = null;

        if (null === $notifications) {
            $notifications = [];

            jimport('joomla.filesystem.folder');

            $files = JFolder::files(
                JPATH_SITE . '/components/com_wallfactory/src/Notification',
                '.php',
                false,
                false,
                [],
                ['.Interface.php']
            );

            foreach ($files as $file) {
                $filename = pathinfo($file, PATHINFO_FILENAME);
                $class = '\\ThePhpFactory\\Wall\\Notification\\' . $filename;

                if (!$class = new $class) {
                    continue;
                }

                $notification = [
                    'type'     => strtolower($filename),
                    'is_group' => false,
                ];

                if ($class instanceof NotificationGroupInterface) {
                    $notification['is_group'] = true;
                }

                $notifications[] = $notification;
            }
        }

        return $notifications;
    }

    public static function getGroupNotifications()
    {
        static $notifications = null;

        if (null === $notifications) {
            $notifications = [];

            jimport('joomla.filesystem.folder');

            $files = JFolder::files(
                JPATH_SITE . '/components/com_wallfactory/src/Notification',
                '.php',
                false,
                false,
                [],
                ['.Interface.php']
            );

            foreach ($files as $file) {
                $filename = pathinfo($file, PATHINFO_FILENAME);
                $class = '\\ThePhpFactory\\Wall\\Notification\\' . $filename;

                if (!$class = new $class) {
                    continue;
                }

                if (!$class instanceof NotificationGroupInterface) {
                    continue;
                }

                $notifications[] = strtolower($filename);
            }
        }

        return $notifications;
    }

    public static function getSimpleNotifications()
    {
        static $notifications = null;

        if (null === $notifications) {
            $notifications = [];

            jimport('joomla.filesystem.folder');

            $files = JFolder::files(
                JPATH_SITE . '/components/com_wallfactory/src/Notification',
                '.php',
                false,
                false,
                [],
                ['.Interface.php']
            );

            foreach ($files as $file) {
                $filename = pathinfo($file, PATHINFO_FILENAME);
                $class = '\\ThePhpFactory\\Wall\\Notification\\' . $filename;

                if (!$class = new $class) {
                    continue;
                }

                if (!$class instanceof NotificationSimpleInterface) {
                    continue;
                }

                $notifications[] = strtolower($filename);
            }
        }

        return $notifications;
    }
}
