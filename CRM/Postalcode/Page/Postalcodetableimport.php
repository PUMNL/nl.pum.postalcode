<?php

require_once 'CRM/Core/Page.php';

class CRM_Postalcode_Page_Postalcodetableimport extends CRM_Core_Page {
  function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(ts('Postcode.nl DTM Postalcode table import'));

	$file_pctable = dirname(__FILE__).'/../../../verkleinde_postcode_tabel.txt';
	
    if (($handle = fopen($file_pctable,'r')) !== FALSE) {
		$dtstamp = date('Y_m_d__H_i_s');
		
		/**
		 * First backup existing table, then create new table
		 * 
		 * @todo On install of the module, check if the table already exists by some other module
		 * @todo On import check if the table exists & check access to table, otherwise we will get an error on renaming...
		 * @todo On uninstall of module remove table from database
		 */
		
		$qRenameTable_pc = "RENAME TABLE nl_pum_postalcodes TO nl_pum_postalcodes_".$dtstamp;
		
		$qCreateTable_pc = "CREATE TABLE IF NOT EXISTS `nl_pum_postalcodes` (
								`frompc` varchar(5) NOT NULL,
								`topc` varchar(5) NOT NULL,
								`time` varchar(8) NOT NULL,
								`distance` varchar(8) NOT NULL
							) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		
		$eqRenameTable_pc = CRM_Core_DAO::executeQuery($qRenameTable_pc); 
		$eqCreateTable_pc = CRM_Core_DAO::executeQuery($qCreateTable_pc);
		
		/**
		 * @todo 
		 * Method now used to skip the first line not very beautiful, maybe PHP has a function for it?
		 * 
		 */
		 
	 
		$i = 0;
		$rows = 0;
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			if ($i == 0) {
				$i++;
				continue;	//We have to skip the first line
			}

			$num = count($data);
			
			echo "<p> ".$num." fields in line ".$i.": <br /></p>\n";
			
			for ($k = 0; $k < $num; $k++) {
				echo $data[$k] . "<br />\n";
			}
			
			$qInsert_pc = "INSERT INTO nl_pum_postalcodes (frompc, topc, time, distance) VALUES (%0,%1,%2,%3)";
			
			$qInsert_pc_v = array(
						 array($data[0], 'String'),
						 array($data[1], 'String'),
						 array($data[2], 'String'),
						 array($data[3], 'String'),
						);
						
			$eqInsert_pc = CRM_Core_DAO::executeQuery($qInsert_pc,$qInsert_pc_v);
			$rows++;
		}
		drupal_set_message($rows." rows imported succesfully!");
		
		fclose($handle);
   	}
   	
   	parent::run();
  }
}