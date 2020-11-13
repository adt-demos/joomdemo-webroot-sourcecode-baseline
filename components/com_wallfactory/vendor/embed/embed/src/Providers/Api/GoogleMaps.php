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

namespace Embed\Providers\Api;

defined('_JEXEC') or die;

use Embed\Utils;
use Embed\Providers\Provider;
use Embed\Providers\ProviderInterface;

/**
 * Provider to use the API of google.
 */
class GoogleMaps extends Provider implements ProviderInterface
{
    protected $mode;
    protected $config = [
        'key' => null,
    ];

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $mode = $this->request->getDirectoryPosition(1);

        switch ($mode) {
            case 'place':
            case 'dir':
            case 'search':
                $this->mode = $mode;
                break;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        if ($this->mode === 'place') {
            return $this->request->getDirectoryPosition(2);
        }

        if ($this->mode === 'dir') {
            return $this->request->getDirectoryPosition(2).' / '.$this->request->getDirectoryPosition(3);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCode()
    {
        if (empty($this->config['key'])) {
            return;
        }

        switch ($this->mode) {
            case 'place':
            case 'search':
                return Utils::iframe($this->request->createUrl()
                    ->withPath('maps/embed/v1/'.$this->mode)
                    ->withQueryParameters([
                        'q' => $this->request->getDirectoryPosition(2),
                        'key' => $this->config['key'],
                    ])
                );

            case 'dir':
                return Utils::iframe($this->request->createUrl()
                    ->withPath('maps/embed/v1/directions')
                    ->withQueryParameters([
                        'origin' => $this->request->getDirectoryPosition(2),
                        'destination' => $this->request->getDirectoryPosition(3),
                        'key' => $this->config['key'],
                    ])
                );
        }
    }
}
