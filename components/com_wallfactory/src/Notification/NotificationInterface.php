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

namespace ThePhpFactory\Wall\Notification;

defined('_JEXEC') or die;

abstract class NotificationInterface
{
    protected $tokens = array(
        'receiver_username',
        'comment_content',
        'post_link',
    );
    protected $template = null;
    protected $user = null;
    protected $type = null;

    public function getTokens()
    {
        return $this->tokens;
    }

    public function setReceivingUser(\JUser $user)
    {
        $this->user = $user;

        $this->resetTemplate();
    }

    protected function resetTemplate()
    {
        $this->template = null;
    }

    public function getEmail()
    {
        return $this->getReceivingUser()->email;
    }

    public function getReceivingUser()
    {
        if (!$this->user instanceof \JUser) {
            throw new \Exception('Receiving user was not found or set!');
        }

        return $this->user;
    }

    public function getSubject()
    {
        $user = $this->getReceivingUser();

        return $this->replaceTokens(
            $this->getTemplate($user)->subject,
            $this->getParsedTokens()
        );
    }

    protected function replaceTokens($text, array $tokens = array())
    {
        $search = array();
        $replace = array();

        foreach ($tokens as $token => $value) {
            $search[] = '{{ ' . $token . ' }}';
            $replace[] = $value;
        }

        return str_replace($search, $replace, $text);
    }

    /**
     * @param \JUser $user
     * @return \WallFactoryTableNotification
     */
    protected function getTemplate(\JUser $user)
    {
        if (null === $this->template) {
            $this->template = $this->getTemplateFromDatabase(
                $user,
                $this->getType()
            );
        }

        return $this->template;
    }

    public function hasTemplate()
    {
        return null !== $this->getTemplate($this->getReceivingUser());
    }

    protected function getTemplateFromDatabase(\JUser $receiver, $type)
    {
        $dbo = \JFactory::getDbo();
        $notification = \WallFactoryTable::getInstance('Notification');

        $query = $dbo->getQuery(true)
            ->select('n.*')
            ->from($dbo->qn($notification->getTableName(), 'n'))
            ->where($dbo->qn('n.published') . ' = ' . $dbo->q(1))
            ->where($dbo->qn('n.type') . ' = ' . $dbo->q($type));

        $results = $dbo->setQuery($query)
            ->loadObjectList('language');

        $receiverLanguage = $receiver->getParam('language', '*');
        $notification = null;

        if (isset($results[$receiverLanguage])) {
            $notification = $results[$receiverLanguage];
        }
        elseif (isset($results['*'])) {
            $notification = $results['*'];
        }

        return $notification;
    }

    public function getType()
    {
        if (null === $this->type) {
            $this->type = strtolower((new \ReflectionClass($this))->getShortName());
        }

        return $this->type;
    }

    abstract public function getParsedTokens();

    public function getBody()
    {
        $user = $this->getReceivingUser();

        return $this->replaceTokens(
            $this->getTemplate($user)->body,
            $this->getParsedTokens()
        );
    }
}

