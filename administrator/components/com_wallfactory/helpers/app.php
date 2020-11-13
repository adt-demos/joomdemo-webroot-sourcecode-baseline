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

class WallFactoryApp
{
    private static $firewallRules = array(
        'section_enabled' => array(
            'newsfeed.*',
            'comment.*',
            'bookmark.*',
            'like.*',
        ),

        'logged_in' => array(
            'newsfeed.*',
            'like.submit',
            'like.remove',
            'notification.*',
            'profile.delete',
            'profile.update',
            'subscriber.*',
            'subscription.index',
            'avatar.*',
            'post.delete',
        ),

        'guest_comments_enabled' => array(
            'comment.form',
            'comment.submit',
        ),

        'guest_post_access_read' => array(
            'newsfeed.*',
            'wall.*',
            'post.index',
        ),

        'guest_post_access_write' => array(
            'post.form',
            'post.submit',
            'media.*',
        ),

        'profile_filled' => array(
            'like.submit',
            'like.remove',
            'newsfeed.index',
            'post.all',
            'wall.show',
        ),
    );

    public static function render(JInput $input, \Joomla\Registry\Registry $configuration)
    {
        $view = $input->getCmd('view');
        $task = $input->getCmd('task', $view);

        if (false === strpos($task, '.')) {
            $task .= '.index';
        }

        list($controller, $task) = explode('.', $task, 2);

        $class = '\\ThePhpFactory\\Wall\\Controller\\' . ucfirst($controller) . 'Controller';

        if (!class_exists($class)) {
            throw new Exception(sprintf('Controller "%s" not found!', $controller));
        }

        $class = new $class($input, $configuration);
        $callable = array($class, $task);

        if (!is_callable($callable)) {
            throw new Exception(sprintf('Controller "%s" does not have task "%s"!', $controller, $task));
        }

        JFactory::getLanguage()->load('com_wallfactory', JPATH_SITE);
        $user = JFactory::getUser();
        $app = JFactory::getApplication();
        $firewall = new ThePhpFactory\Wall\Firewall\Firewall(self::$firewallRules, $configuration, $user, $app, JDEBUG);

        try {
            $firewall->protect($controller, $task);

            $parameters = self::resolveParameters($class, $task, $input);
            $output = call_user_func_array($callable, $parameters);
        } catch (Exception $e) {
            $isXmlHttpRequest = self::isXmlHttpRequest($input);

            if ($configuration->get('profile.auto_fill', 0) && $e instanceof \ThePhpFactory\Wall\Firewall\ProfileNotFilledException) {
                $model = new WallFactoryFrontendModelProfile();
                $model->fillFromJoomla($user, $configuration->get('profile.auto_fill_name', 'name'));

                $app->redirect(JUri::current());
            }

            return $firewall->catchException($e, $isXmlHttpRequest);
        }

        return $output;
    }

    private static function resolveParameters($class, $task, JInput $input)
    {
        $parameters = array();
        $rClass = new ReflectionClass($class);
        $method = $rClass->getMethod($task);

        foreach ($method->getParameters() as $parameter) {
            if ($parameter->getClass() && in_array($parameter->getClass()->getName(), array('JUser', 'Joomla\CMS\User\User'), true)) {
                $parameters[] = JFactory::getUser();
            }
            else {
                $default = $parameter->isDefaultValueAvailable()
                    ? $parameter->getDefaultValue()
                    : null;

                $parameters[] = $input->get($parameter->getName(), $default);
            }
        }

        return $parameters;
    }

    private static function isXmlHttpRequest(JInput $input)
    {
        return 'XMLHttpRequest' === $input->server->get('HTTP_X_REQUESTED_WITH');
    }
}
