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

namespace ThePhpFactory\Wall\Media\Link;

defined('_JEXEC') or die;

use ThePhpFactory\Wall\Media\MediaInterface;

class LinkMedia extends MediaInterface
{
    public function submit($postId, $data)
    {
        if ('' === $data) {
            return null;
        }

        /** @var \WallFactoryTableMediaLink $link */
        $link = \WallFactoryTable::getInstance('MediaLink');

        $parsed = $this->parseUrl($data);

        $link->save(array_merge(
            array('post_id' => $postId),
            $parsed
        ));

        return $link->id;
    }

    private function parseUrl($url)
    {
        $url = $this->prepareUrl($url);

        $parser = new MetaParser();
        $parser->parseUrl($url);

        return array(
            'title'       => $parser->getTitle(),
            'description' => $parser->getDescription(),
            'url'         => $url,
        );
    }

    private function prepareUrl($url)
    {
        return null === parse_url($url, PHP_URL_SCHEME) ? 'http://' . $url : $url;
    }

    public function preview($data)
    {
        $media = $this->parseUrl($data);

        return array(
            'render' => $this->renderMedia($media),
        );
    }
}
