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

abstract class WallFactoryControllerForm extends JControllerForm
{
    protected $option;
    protected $text_prefix;

    public function __construct(array $config)
    {
        parent::__construct($config);

        preg_match('/(.*)BackendController(.*)/', get_class($this), $matches);

        $this->option = strtolower('com_' . $matches[1]);
        $this->text_prefix = strtoupper($this->option);
    }

    public function refresh()
    {
        // Check for request forgeries.
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $app = JFactory::getApplication();
        $data = $this->input->post->get('jform', array(), 'array');
        $context = $this->option . '.edit.' . $this->context;
        $recordId = $this->input->getInt('id');

        $app->setUserState($context . '.data', $data);

        // Redirect back to the edit screen.
        $this->setRedirect(JRoute::_(
            'index.php?option=' . $this->option . '&view=' . $this->view_item
            . $this->getRedirectToItemAppend($recordId, 'id'), false
        ));

        return true;
    }
}
