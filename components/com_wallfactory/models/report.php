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

class WallFactoryFrontendModelReport extends JModelLegacy
{
    protected $option = 'com_wallfactory';

    public function submit(array $data = array())
    {
        $form = $this->getForm();

        $data = WallFactoryForm::validate($form, $data);

        JLoader::discover('WallFactory', JPATH_ADMINISTRATOR . '/components/com_wallfactory/helpers/');
        JLoader::discover('WallFactoryReport', JPATH_ADMINISTRATOR . '/components/com_wallfactory/helpers/reports/');

        $resource = null;
        $class = 'WallFactoryReport' . ucfirst($data['resource_type']);

        if (class_exists($class)) {
            $resource = new $class($data['resource_id']);
        }

        if (null === $resource || !$resource instanceof WallFactoryReportResource) {
            throw new Exception(WallFactoryText::_('report_resource_not_found'));
        }

        /** @var WallFactoryTableReport $report */
        $report = WallFactoryTable::getInstance('Report');
        $report->bind($data);
        $report->setResource($resource);

        $report->save(array());

        return true;
    }

    public function getForm()
    {
        JForm::addFormPath(__DIR__ . '/forms');
        JForm::addRulePath(__DIR__ . '/rules');

        $form = JForm::getInstance(
            $this->option . '.' . $this->getName(),
            $this->getName(),
            array(
                'control' => $this->getName(),
            )
        );

        WallFactoryForm::addLabelsToForm($form);

        return $form;
    }
}
