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

namespace ThePhpFactory\Wall;

defined('_JEXEC') or die;

class Router
{
    public function __construct(array $routes = array())
    {
        $this->routes = $routes;
    }

    public function build(&$query)
    {
        if (!isset($query['task']) && !isset($query['view']) && isset($query['Itemid'])) {
            return array();
        }

        if (isset($query['view'])) {
            $query['task'] = $query['view'];
        }

        if (!isset($query['task'])) {
            return array();
        }

        foreach ($this->routes as $name => $route) {
            if ($route['task'] !== $query['task']) {
                continue;
            }

            $valid = true;
            if (isset($route['params'])) {
                foreach ($route['params'] as $param) {
                    if (!isset($query[$param['name']]) && !isset($param['optional'])) {
                        $valid = false;
                        continue;
                    }

                    if (isset($param['filter'])) {
                        if (!$this->matchFilter($query[$param['name']], $param['filter'])) {
                            $valid = false;
                            continue;
                        }
                    }
                }
            }

            if (!$valid) {
                continue;
            }

            $segments = array($name);
            unset($query['task']);

            if (isset($route['params'])) {
                foreach ($route['params'] as $param) {
                    if (isset($param['optional']) && !isset($query[$param['name']])) {
                        continue;
                    }

                    $segments[] = $query[$param['name']];
                    unset($query[$param['name']]);
                }
            }

            return $segments;
        }

        return array();
    }

    private function matchFilter($value, $filter)
    {
        switch ($filter) {
            case 'integer':
                if (!is_numeric($value)) {
                    return false;
                }
                break;
        }

        return true;
    }

    public function parse(&$segments)
    {
        foreach ($this->routes as $name => $route) {
            if ($name !== $segments[0]) {
                continue;
            }

            $valid = true;

            if (isset($route['params'])) {
                foreach ($route['params'] as $i => $param) {
                    if (!isset($segments[$i + 1]) && !isset($param['optional'])) {
                        $valid = false;
                        continue;
                    }

                    if (isset($param['optional'])) {
                        continue;
                    }

                    if (isset($param['filter'])) {
                        if (!$this->matchFilter($segments[$i + 1], $param['filter'])) {
                            $valid = false;
                            continue;
                        }
                    }
                }
            }

            if (!$valid) {
                continue;
            }

            $vars['task'] = $route['task'];

            if (isset($route['params'])) {
                foreach ($route['params'] as $i => $param) {
                    if (isset($param['optional']) && !isset($segments[$i + 1])) {
                        continue;
                    }

                    $vars[$param['name']] = $segments[$i + 1];
                }
            }

            return $vars;
        }

        return array();
    }
}
