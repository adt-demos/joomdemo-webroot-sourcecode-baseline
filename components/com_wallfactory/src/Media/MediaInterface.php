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

namespace ThePhpFactory\Wall\Media;

defined('_JEXEC') or die;

use Joomla\Registry\Registry;

abstract class MediaInterface
{
    protected $options;
    protected $type = null;

    public function __construct(Registry $options)
    {
        $this->options = $options;
    }

    abstract public function submit($postId, $data);

    abstract public function preview($data);

    public function renderUpload()
    {
        $layout = new \JLayoutFile(
            'upload',
            __DIR__ . '/' . $this->getType() . '/layout'
        );

        return $layout->render(array(
            'configuration' => $this->getConfiguration(),
        ));
    }

    protected function getType()
    {
        if (null === $this->type) {
            $rClass = new \ReflectionClass($this);
            $this->type = str_replace('Media', '', $rClass->getShortName());
        }

        return $this->type;
    }

    protected function getConfiguration()
    {
        $configuration = $this->options;

        $configuration->set('button', array(
            'tooltip' => \WallFactoryText::_('submit_post_button_tooltip_' . $this->getType()),
            'icon'    => \WallFactoryText::_('submit_post_button_icon_' . $this->getType()),
        ));

        return $configuration;
    }

    public function renderMedia($media)
    {
        $layout = new \JLayoutFile(
            'media',
            __DIR__ . '/' . $this->getType() . '/layout'
        );

        return $layout->render(array(
            'media'         => (array)$media,
            'configuration' => $this->getConfiguration(),
        ));
    }
}
