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

class WallFactoryFrontendController extends JControllerLegacy
{
    protected $default_view = 'newsfeed';

    public function display($cachable = false, $urlparams = array())
    {
        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = $this->input->get('view', $this->default_view);
        $viewLayout = $this->input->get('layout', 'default', 'string');

        $view = $this->getView($viewName, $viewType, '', array('base_path' => $this->basePath, 'layout' => $viewLayout));
        $view->document = $document;

        // Display the view
        if ($cachable && $viewType != 'feed' && JFactory::getConfig()->get('caching') >= 1) {
            $option = $this->input->get('option');

            /** @var JCacheControllerView $cache */
            $cache = JFactory::getCache($option, 'view');

            if (is_array($urlparams)) {
                $app = JFactory::getApplication();

                if (!empty($app->registeredurlparams)) {
                    $registeredurlparams = $app->registeredurlparams;
                }
                else {
                    $registeredurlparams = new stdClass;
                }

                foreach ($urlparams as $key => $value) {
                    // Add your safe url parameters with variable type as value {@see JFilterInput::clean()}.
                    $registeredurlparams->$key = $value;
                }

                $app->registeredurlparams = $registeredurlparams;
            }

            $cache->get($view, 'display');
        }
        else {
            $view->display();
        }

        return $this;
    }
}
