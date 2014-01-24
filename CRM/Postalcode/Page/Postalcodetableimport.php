<?php

require_once 'CRM/Core/Page.php';

class CRM_Postalcode_Page_Postalcodetableimport extends CRM_Core_Page {
  function run() {
    dpm('test');
    
	// Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(ts('Postalcode table import'));

    // Example: Assign a variable for use in a template
    $this->assign('currentTime', date('Y-m-d H:i:s'));

    
    /*
    if (($handle = fopen(dirname(__FILE__).'/verkleinde_postcode_tabel.txt','r')) !== FALSE) {
		//$rows = 0;
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {			
			//array_shift($data);
			dpm($data);
			
			/*foreach ($data as $distance) {
				dpm($distance);
				$rows++;
			}
		}
		
		fclose($handle);
		//dpm($postal_codes);
		//dpm($rows.' rows imported!');
   	}
   	*/
   	parent::run();
  }
}
