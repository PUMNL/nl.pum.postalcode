<?php

require_once 'postalcode.civix.php';

/**
 * Implementation of hook_civicrm_config
 */
function postalcode_civicrm_config(&$config) {
  _postalcode_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 */
function postalcode_civicrm_xmlMenu(&$files) {
  _postalcode_civix_civicrm_xmlMenu($files);
}

/**
 * Implementation of hook_civicrm_install
 */
function postalcode_civicrm_install() {
  return _postalcode_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_uninstall
 */
function postalcode_civicrm_uninstall() {
  return _postalcode_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 */
function postalcode_civicrm_enable() {
  return _postalcode_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 */
function postalcode_civicrm_disable() {
  return _postalcode_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 */
function postalcode_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _postalcode_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 */
function postalcode_civicrm_managed(&$entities) {
  return _postalcode_civix_civicrm_managed($entities);
}

/**
 * Implementation of hook_civicrm_navigationMenu
 *
 * Discloses additional menu options to trigger import functions through page urls
  */
function postalcode_civicrm_navigationMenu( &$params ) {
	//  Get the maximum key of $params
	$maxKey = ( max( array_keys($params) ) );
	
	$params[$maxKey+1] = array (
		'attributes' => array (
			'label'      => 'Config',
			'name'       => 'Config',
			'url'        => null,
			'permission' => 'administer CiviCRM',
			'operator'   => null,
			'separator'  => null,
			'parentID'   => null,
			'navID'      => $maxKey+1,
			'active'     => 1
			),
		'child' =>  array (
			'1' => array (
				'attributes' => array (
					'label'      => 'Import Postalcode Table',
					'name'       => 'Postalcodetable_import',
					'url'        => 'civicrm/Postalcodetable_import',
					'permission' => 'administer CiviCRM',
					'operator'   => null,
					'separator'  => 1,
					'parentID'   => $maxKey+1,
					'navID'      => 1,
					'active'     => 1
					),
				'child' => null
				),
			'2' => array (
				'attributes' => array (
					'label'      => 'Clear Postalcode Table',
					'name'       => 'Postalcodetable_clear',
					'url'        => 'civicrm/Postalcodetable_clear',
					'permission' => 'administer CiviCRM',
					'operator'   => null,
					'separator'  => 1,
					'parentID'   => $maxKey+1,
					'navID'      => 1,
					'active'     => 1
					),
				'child' => null
				),
			)
		);
}

function postalcode_civicrm_postProcess( $formName, &$form ) {
	if ($formName == 'CRM_Contact_Form_Contact' ) {
		//dpm("Submitted values: ");
		//dpm($form->_submitValues);
		
		if (array_key_exists('address',$form->_submitValues)) {
			$total_addresses = count($form->_submitValues['address']);
			//dpm('Number of addresses: '.$total_addresses);
    	}
    	
		//Note: $form->_submitValues starts with key 1
    	for ($i = 1; $i <= count($form->_submitValues['address']); $i++) {
    		//dpm($form->_submitValues['address'][$i]['postal_code']);
    	}
    	
    	//Postcode.nl API: https://api.postcode.nl/rest/addresses/2012ES/30		//authentication required
   	}
}