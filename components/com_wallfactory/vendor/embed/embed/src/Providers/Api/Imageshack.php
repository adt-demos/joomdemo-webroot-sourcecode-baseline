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

use Embed\Providers\Provider;
use Embed\Providers\ProviderInterface;

/**
 * Provider to use the API of imageshack.com.
 */
class Imageshack extends Provider implements ProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $id = $this->request->getDirectoryPosition(1);
        $api = $this->request->withUrl('https://api.imageshack.com/v2/images/'.$id);

        if (($json = $api->getJsonContent()) && !empty($json['result'])) {
            $this->bag->set($json['result']);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->bag->get('title');
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->bag->get('description');
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'photo';
    }

    /**
     * {@inheritdoc}
     */
    public function getPublishedTime()
    {
        return $this->bag->get('creation_date');
    }

    /**
     * {@inheritdoc}
     */
    public function getWidth()
    {
        return $this->bag->get('width');
    }

    /**
     * {@inheritdoc}
     */
    public function getHeight()
    {
        return $this->bag->get('height');
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthorName()
    {
        return $this->bag->get('owner[username]');
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthorUrl()
    {
        $username = $this->getAuthorName();

        if (!empty($username)) {
            return 'http://imageshack.com/user/'.$username;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getImagesUrls()
    {
        return (array) $this->bag->get('direct_link');
    }
}
