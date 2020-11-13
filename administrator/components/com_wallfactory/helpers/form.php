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

class WallFactoryForm
{
    public static function load($name)
    {
        $option = strtolower('com_' . str_replace('Form', '', __CLASS__));

        JForm::addFormPath(JPATH_COMPONENT . '/models/forms');
        JForm::addFieldPath(JPATH_COMPONENT . '/models/fields');
        JForm::addRulePath(JPATH_COMPONENT . '/models/rules');

        $form = JForm::getInstance($option . '.' . $name, $name, array(
            'control' => $name,
        ));

        self::addLabelsToForm($form);

        return $form;
    }

    public static function addLabelsToForm(JForm $form, $debug = false)
    {
        $formName = str_replace('.', '_', $form->getName());

        foreach ($form->getFieldsets() as $fieldset) {
            foreach ($form->getFieldset($fieldset->name) as $field) {
                $fieldGroup = str_replace('.', '_', $field->group);
                $fieldName = ($fieldGroup ? $fieldGroup . '_' : '') . $field->fieldname;

                $label = $form->getFieldAttribute($field->fieldname, 'label', '', $field->group);

                if ('' == $label) {
                    $label = !$debug ? JText::_(strtoupper($formName . '_form_field_' . $fieldName . '_label')) : $fieldName;
                    $form->setFieldAttribute($field->fieldname, 'label', $label, $field->group);
                }

                $desc = $form->getFieldAttribute($field->fieldname, 'description', '', $field->group);

                if ('' == $desc) {
                    $desc = !$debug ? JText::_(strtoupper($formName . '_form_field_' . $fieldName . '_desc')) : $fieldName;
                    $form->setFieldAttribute($field->fieldname, 'description', $desc, $field->group);
                }

                $generateHint = $form->getFieldAttribute($field->fieldname, 'generateHint', '', $field->group);

                if ('true' === $generateHint) {
                    $hint = JText::_(strtoupper($formName . '_form_field_' . $fieldName . '_hint'));
                    $form->setFieldAttribute($field->fieldname, 'hint', $hint, $field->group);
                }
            }
        }
    }

    public static function validate(JForm $form, array $data = array())
    {
        self::setContextData($form, $data);

        $data = $form->filter($data);
        $return = $form->validate($data);

        if ($return === false) {
            $messages = array();
            foreach ($form->getErrors() as $message) {
                $messages[] = $message->getMessage();
            }

            throw new Exception(implode('<br />', $messages));
        }

        return $data;
    }

    public static function setContextData(JForm $form, $data)
    {
        $session = JFactory::getSession();
        $session->set($form->getName() . '.data', $data);
    }

    public static function getSetup(JForm $form, $tabbed = true)
    {
        $setup = array();

        foreach ($form->getFieldsets() as $fieldset) {
            if ($tabbed) {
                $setup[$fieldset->tab][$fieldset->side][] = $fieldset->name;
            }
            else {
                $setup[$fieldset->side][] = $fieldset->name;
            }
        }

        return $setup;
    }

    public static function bindContextData(JForm $form, $default = null)
    {
        if (null !== $data = self::getContextData($form)) {
            $form->bind($data);
        }
        else {
            $form->bind($default);
        }
    }

    public static function getContextData(JForm $form)
    {
        $session = JFactory::getSession();
        $data = $session->get($form->getName() . '.data', null);

        $session->set($form->getName() . '.data', null);

        return $data;
    }

    public static function processUploads(JInput $request, JForm $form)
    {
        // Get files.
        $files = $request->files->get('emoticon', array(), 'array');
        $registry = new \Joomla\Registry\Registry($files);

        foreach ($form->getFieldsets() as $name => $fieldset) {
            foreach ($form->getFieldset($name) as $field) {
                if (!$field instanceof JFormFieldFile) {
                    continue;
                }

                $fieldName = array($field->fieldname);

                if ($field->group) {
                    array_unshift($fieldName, $field->group);
                }

                $fieldName = implode('.', $fieldName);

                $value = $registry->get($fieldName, null);

                if (!isset($value->name) || !isset($value->type) || !isset($value->tmp_name) || !isset($value->error) || !isset($value->size) || 0 !== (int)$value->error) {
                    $registry->set($fieldName, null);
                }
                else {
                    $registry->set($fieldName, $value->name);
                }
            }
        }

        $data = $request->post->get($form->getFormControl(), array(), 'array');
        $request->post->set($form->getFormControl(), $data + $registry->toArray());
    }

    public static function filterImage($value)
    {
        $value = (array)$value;

        if (!isset($value['name']) || !isset($value['type']) || !isset($value['tmp_name']) || !isset($value['error']) || !isset($value['size'])) {
            return null;
        }

        if (0 !== $value['error']) {
            return null;
        }

        $imagine = new Imagine\Gd\Imagine();

        try {
            $imagine->open($value['tmp_name']);
        } catch (Exception $e) {
            return null;
        }

        return $value;
    }
}
