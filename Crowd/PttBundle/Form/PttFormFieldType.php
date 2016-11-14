<?php

/*
 * COPYRIGHT © 2014 THE CROWD CAVE S.L.
 * All rights reserved. No part of this publication may be reproduced, distributed, or transmitted in any form or by any means, including photocopying, recording, or other electronic or mechanical methods, without the prior written permission of the publisher.
 */

namespace Crowd\PttBundle\Form;

use Symfony\Component\HttpFoundation\Request;

use Crowd\PttBundle\Util\PttUtil;

class PttFormFieldType
{
	private $sentData;
	private $errors;

	protected $em;
	protected $field;
	protected $value;
	protected $entityInfo;
	protected $languageCode;
	protected $request;
	protected $defaultValue = '';
	protected $pttTrans;
	protected $container;
	protected $pttForm;

	public function __construct(PttForm $pttForm, PttField $field, $languageCode = false)
	{
		$this->entityInfo = $pttForm->getEntityInfo();
		$this->em = $pttForm->getEntityManager();
		$this->request = $pttForm->getRequest();
		$this->field = $field;
		$this->errors = $pttForm->getErrors($this->field->name, $this->languageCode);
		$this->sentData = $pttForm->getSentData($this->field->name, $this->languageCode);
		$this->languageCode = $languageCode;
		$this->pttTrans = $pttForm->getPttTrans();
		$this->container = $pttForm->getContainer();
		$this->pttForm = $pttForm;

		$this->_prepare();
	}

	public function start()
	{
		$errorClass = ($this->errors && $this->field->showErrors) ? ' has-error': '';

		$html = '
		<div class="' . $this->extraClassesForFieldContainer() . $errorClass . '" data-fieldName="' . $this->field->getFormName($this->languageCode) . '" data-fieldType="' . $this->field->type . '" '. $this->_addExtraAttrsToContainer().'>
		';

		return $html;
	}

	public function label($required = false, $append = '')
	{
		if ($required === false) {
			$required = ($this->field->validations && $this->field->showErrors) ? ' *' : '';
		}

		if ($this->errors && $this->field->showErrors) {
			$required .= ' (' . implode(', ', $this->errors) . ')';
		}

		$html = '';

		if ($this->_optionsValue('label', null) != null) {
			$html .= '<label class="control-label" for="' . $this->field->getFormId($this->languageCode) . '">' . $this->pttTrans->trans($this->_optionsValue('label', '')) . $append . $required . '</label>';
		}

		return $html;
	}

	public function end()
	{
		$html = '
		</div>
		';
		return $html;
	}

	public function defaultValue()
	{
		return $this->defaultValue;
	}

	protected function attributes($formFieldId = false, $formFieldName = false)
	{

		if ($formFieldId == false) {
			$formFieldId = $this->field->getFormId($this->languageCode);
		}
		if ($formFieldName == false) {
			$formFieldName = $this->field->getFormName($this->languageCode);
		}

		$htmlField = '';
		$htmlField .= 'id="' . $formFieldId . '" ';
		$htmlField .= 'name="' . $formFieldName . '" ';

		$required = ($this->_optionsValue('required', false)) ? 'true' : 'false';
		$htmlField .= 'data-required="' . $required . '" ';

		if ($this->_optionsValue('label', null) != null) {
			$htmlField .= 'placeholder="' . $this->pttTrans->trans($this->_optionsValue('label', '')) . '" ';
		}

		$this->_addExtraAttrsToField();
		$this->_addExtraClassesToField();

		if (isset($this->field->options['attr']) && count($this->field->options['attr'])) {
			foreach ($this->field->options['attr'] as $key => $value) {
				$htmlField .= $key . '="' . $this->pttTrans->trans($value) . '" ';
			}
		}

		return $htmlField;
	}

	protected function extraClassesForFieldContainer()
	{
		return 'form-group';
	}

	protected function extraClassesForField()
	{
		return 'form-control';
	}

	protected function extraAttrsForField()
	{
		return false;
	}

	protected function extraAttrsForContainer()
	{
		return false;
	}

	private function _prepare()
	{
		$className = $this->_formValueClassName($this->field->type);
		$formValue = new $className($this->field, $this->entityInfo, $this->sentData, $this->request, $this->languageCode);
		$this->value = $formValue->value();
	}

	private function _addExtraClassesToField()
	{
		if (array_key_exists('class', $this->field->options['attr'])) {
			$this->field->options['attr']['class'] .= ' ' . $this->extraClassesForField();
		} else {
			$this->field->options['attr']['class'] = $this->extraClassesForField();
		}
	}

	private function _addExtraAttrsToField()
	{
		if (!isset($this->field->options['attr']) || !is_array($this->field->options['attr'])) {
			$this->field->options['attr'] = array();
		}
		$extraAttrs = $this->extraAttrsForField();
		if ($extraAttrs) {
			foreach ($extraAttrs as $extraAttrKey => $extraAttrValue) {
				$this->field->options['attr'][$extraAttrKey] = $extraAttrValue;
			}
		}
	}

	private function _addExtraAttrsToContainer()
	{
		$extraAttrs = $this->extraAttrsForContainer();
		$attrs = '';
		if ($extraAttrs) {
			foreach ($extraAttrs as $extraAttrKey => $extraAttrValue) {
				$attrs .= ' ' . $extraAttrKey . '="' . $extraAttrValue . '"';
			}
		}
		return $attrs;
	}

	private function _optionsValue($value, $default = null)
	{
		if (isset($this->field->options[$value])) {
			return $this->field->options[$value];
		} else {
			return $default;
		}
	}

	private function _formValueClassName($type)
	{
		$className = 'Crowd\PttBundle\Form\PttFormFieldValue' . ucfirst($type);
		if (!class_exists($className)) {
			return 'Crowd\PttBundle\Form\PttFormFieldValueDefault';
		} else {
			return $className;
		}
	}
}