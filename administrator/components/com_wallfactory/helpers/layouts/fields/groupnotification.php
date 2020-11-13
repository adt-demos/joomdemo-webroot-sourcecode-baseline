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

extract($displayData);

$xml = array();

$xml[] = '<form>';
$xml[] = '<fieldset name="details">';

foreach (WallFactoryNotification::getGroupNotifications() as $notification) {
    $xml[] = '<field name="' . $notification . '" type="usergrouplist" multiple="true" label="COM_WALLFACTORY_NOTIFICATION_' . strtoupper($notification) . '" />';
}

$xml[] = '</fieldset>';
$xml[] = '</form>';

$form = new JForm('', array(
    'control' => $field->formControl . '[' . $field->group . '][' . $field->fieldname . ']',
));
$form->load(implode($xml));

$form->bind($field->value);

?>

<div style="margin-top: 5px;">
    <?php echo $form->renderFieldset('details'); ?>
</div>
