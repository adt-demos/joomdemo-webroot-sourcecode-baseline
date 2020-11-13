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

/*
 * This file is part of the Imagine package.
 *
 * (c) Bulat Shakirzyanov <mallluhuct@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Imagine\Image\Fill\Gradient;

defined('_JEXEC') or die;

use Imagine\Image\Palette\Color\ColorInterface;
use Imagine\Image\Fill\FillInterface;
use Imagine\Image\PointInterface;

/**
 * Linear gradient fill
 */
abstract class Linear implements FillInterface
{
    /**
     * @var integer
     */
    private $length;

    /**
     * @var ColorInterface
     */
    private $start;

    /**
     * @var ColorInterface
     */
    private $end;

    /**
     * Constructs a linear gradient with overall gradient length, and start and
     * end shades, which default to 0 and 255 accordingly
     *
     * @param integer        $length
     * @param ColorInterface $start
     * @param ColorInterface $end
     */
    final public function __construct($length, ColorInterface $start, ColorInterface $end)
    {
        $this->length = $length;
        $this->start  = $start;
        $this->end    = $end;
    }

    /**
     * {@inheritdoc}
     */
    final public function getColor(PointInterface $position)
    {
        $l = $this->getDistance($position);

        if ($l >= $this->length) {
            return $this->end;
        }

        if ($l < 0) {
            return $this->start;
        }

        return $this->start->getPalette()->blend($this->start, $this->end, $l / $this->length);
    }

    /**
     * @return ColorInterface
     */
    final public function getStart()
    {
        return $this->start;
    }

    /**
     * @return ColorInterface
     */
    final public function getEnd()
    {
        return $this->end;
    }

    /**
     * Get the distance of the position relative to the beginning of the gradient
     *
     * @param PointInterface $position
     *
     * @return integer
     */
    abstract protected function getDistance(PointInterface $position);
}
