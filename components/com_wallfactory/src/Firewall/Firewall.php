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

namespace ThePhpFactory\Wall\Firewall;

defined('_JEXEC') or die;

use Joomla\Registry\Registry;

class Firewall
{
    private $rules;
    private $configuration;
    private $user;
    private $app;
    private $debug;

    public function __construct(array $rules = array(), Registry $configuration, \JUser $user, \JApplicationCms $app, $debug = false)
    {
        $this->rules = $rules;
        $this->configuration = $configuration;
        $this->user = $user;
        $this->app = $app;
        $this->debug = $debug;
    }

    public function setRules(array $rules = array())
    {
        $this->rules = $rules;
    }

    public function setConfiguration(Registry $configuration)
    {
        $this->configuration = $configuration;
    }

    public function protect($controller, $task)
    {
        foreach ($this->rules as $rule => $assets) {
            if (!in_array($controller . '.*', $assets) && !in_array($controller . '.' . $task, $assets)) {
                continue;
            }

            $resource = in_array($controller . '.*', $assets) ? $controller : $controller . '.' . $task;

            $this->checkRule($resource, $controller, $rule);
        }

        return true;
    }

    private function checkRule($resource, $controller, $rule)
    {
        switch ($rule) {
            case 'section_enabled':
                if (!$this->configuration->get($controller . '.enabled', 1)) {
                    $this->throwException('SectionNotEnabledException', $rule, $resource);
                }
                break;

            case 'logged_in':
                if ($this->user->guest) {
                    $this->throwException('GuestsNotAllowedException', $rule, $resource);
                }
                break;

            case 'guest_comments_enabled':
                if ($this->user->guest && !$this->configuration->get('comment.guest', 0)) {
                    $this->throwException('SectionNotEnabledException', $rule, $resource);
                }
                break;

            case 'guest_post_access_read':
                if ($this->user->guest && 'none' === $this->configuration->get('post.guest.access', 'none')) {
                    $this->throwException('GuestsNotAllowedException', $rule, $resource);
                }
                break;

            case 'guest_post_access_write':
                if ($this->user->guest && 'write' !== $this->configuration->get('post.guest.access', 'none')) {
                    $this->throwException('NotAllowedException', $rule, $resource);
                }
                break;

            case 'profile_filled':
                static $profiles = array();

                if ($this->user->guest) {
                    break;
                }

                if ('wall' === $controller &&
                    'wall.show' === $resource &&
                    (int)$this->user->id !== $this->app->input->getInt('user_id')
                ) {
                    break;
                }

                if (!isset($profiles[$this->user->id])) {
                    $profile = \WallFactoryTable::getInstance('Profile');
                    $profile->load($this->user->id);

                    $profiles[$this->user->id] = $profile;
                }

                if (!$profiles[$this->user->id]->user_id) {
                    $this->throwException('ProfileNotFilledException', $rule, $resource);
                }
                break;
        }
    }

    private function throwException($exception, $rule, $resource)
    {
        if ($this->debug) {
            $this->app->enqueueMessage(sprintf('Firewall matched rule "%s" for resource "%s"', $rule, $resource), 'warning');
        }

        $exception = '\\ThePhpFactory\\Wall\Firewall\\' . $exception;

        throw new $exception;
    }

    public function catchException(\Exception $exception, $isXmlHttpRequest = false)
    {
        try {
            throw $exception;
        } catch (SectionNotEnabledException $e) {
            $redirect = \WallFactoryRoute::task('error.section');

            if ($isXmlHttpRequest) {
                return json_encode(array(
                    '_redirect' => $redirect,
                ));
            }

            $this->app->redirect($redirect);
            return false;
        } catch (GuestsNotAllowedException $e) {
            $return = base64_encode(\JUri::getInstance()->toString());
            $redirect = \JRoute::_('index.php?option=com_users&view=login&return=' . $return, false);

            if ($isXmlHttpRequest) {
                return json_encode(array(
                    '_redirect' => $redirect,
                ));
            }

            $this->app->enqueueMessage(\WallFactoryText::_('error_guests_not_allowed'), 'error');

            $this->app->redirect($redirect);
            return false;
        } catch (NotAllowedException $e) {
            return false;
        } catch (ProfileNotFilledException $e) {
            $redirect = \WallFactoryRoute::task('profile.update');

            if ($isXmlHttpRequest) {
                return json_encode(array(
                    '_redirect' => \WallFactoryRoute::task('profile.update&notice=1'),
                ));
            }

            $this->app->enqueueMessage(\WallFactoryText::_('profile_update_profile_first'), 'warning');
            $this->app->redirect($redirect);
        }

        return false;
    }
}
