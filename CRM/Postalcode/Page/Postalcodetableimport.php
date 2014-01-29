<?php

require_once 'CRM/Core/Page.php';
//require_once '/../functions/dbconnect.inc.php';

class CRM_Postalcode_Page_Postalcodetableimport extends CRM_Core_Page {
  function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(ts('Postalcode table import'));

//$conn = new CRM_Postalcode_Page_Dbconnect();
	
    if (($handle = fopen(dirname(__FILE__).'/../../../verkleinde_postcode_tabel.txt','r')) !== FALSE) {
		$dtstamp = date('Y_m_d__H_i_s');
		
		//First drop existing table
		//Needs adding checksum code like if database exists etc., but couldn't get that to work at the moment
		
		//$sql_0 = "SELECT * FROM information_schema.TABLES WHERE TABLE_SCHEMA = `devcivi` AND table_name = `pum_postalcodes`;";
		$sql_0 = "SHOW TABLES FROM devcivi_civicrm";
		
		$sql_1 = "RENAME TABLE devcivi_civicrm.pum_postalcodes TO pum_postalcodes_".$dtstamp;
		$sql_2 = "CREATE TABLE IF NOT EXISTS `devcivi_civicrm.pum_postalcodes` (
					`frompc` int(11) NOT NULL,
					`topc` int(11) NOT NULL,
					`time` int(11) NOT NULL,
					`distance` mediumint(9) NOT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		
		$odb = "devcivi_civicrm";
		$otbl = "pum_postalcodes";
		$ndb = "devcivi_civicrm";
		$ntbl = "pum_postalcode_".$dtstamp;
		
		$qsql_0 = CRM_Core_DAO::executeQuery($sql_0);
		$fsql_0 = $qsql_0->fetchAll();
		dpm($fsql_0);
		
		/*
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {	
			if ($data[0]== "Frompc4") {
				continue;		//first line, so skip iteration
			}
			
			$sql_3 = "INSERT INTO devcivi_civicrm.pum_postalcodes (frompc, topc, time, distance) VALUES (%1,%2,%3,%4)";
			$sql_3_v = array( 	0 => array($data[0]),
								1 => array($data[1]),
								2 => array($data[2]),
								3 => array($data[3]),
						);
			$rsql_3 = CRM_Core_DAO::executeQuery($sql_3,$sql_3_v);
		
			dpm($data);
			
			/*foreach ($data as $distance) {
				dpm($distance);
				$rows++;
			}
			*
		}
		*/
		fclose($handle);
		//dpm($postal_codes);
		//dpm($rows.' rows imported!');
   	}
   	
   	parent::run();
  }
}
