<?php

require_once 'CRM/Core/Page.php';

class CRM_Postalcode_Page_Postalcodetableclear extends CRM_Core_Page {

	/**
	 * @todo 1) Check if the table exists & have access to it, otherwise we get an error when emptying the table...
	 * @todo 2) Add function to show previous versions of the table and add option to delete these tables via menu
	 * 
	 */

  function run() {
	// Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
	CRM_Utils_System::setTitle(ts('Postalcode table clear'));
 	require_once(dirname(__FILE__).'/../../../pum_classes/pum_log.class.php');
	$cPUMLog = new PUM_Log();
	
	$dtstamp = date('Y_m_d__H_i_s');
	
	//Even if we clear the table we want to have a backup so we can easily go back to a previous version of the table
	$qRenameTable_pc = "RENAME TABLE nl_pum_postalcodes TO nl_pum_postalcodes_".$dtstamp;
		
	$qCreateEmptyTable_pc = "CREATE TABLE IF NOT EXISTS `nl_pum_postalcodes` (
								`frompc` varchar(5) NOT NULL,
								`topc` varchar(5) NOT NULL,
								`time` varchar(8) NOT NULL,
								`distance` varchar(8) NOT NULL
							) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

	try {
		$eqRenameTable_pc = CRM_Core_DAO::executeQuery($qRenameTable_pc); 
		$eqCreateEmptyTable_pc = CRM_Core_DAO::executeQuery($qCreateEmptyTable_pc);
		
		//drupal_set_message('Postalcode table cleared succesfully!');
		$cPUMLog->message(1000, 'Postalcode table cleared succesfully!');		
	} catch (Exception $e) {
		//drupal_set_message('Postalcode table clearing failed!');
		$cPUMLog->message(1000, $e->getCode() & ' - ' & $e->getMessage());
	}
	

    parent::run();
  }
}
