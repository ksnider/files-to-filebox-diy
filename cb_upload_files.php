<?php 

/**
 * Project Name: How To Upload Files To The Infusionsoft Filebox
 * File Name: cb_upload_files.php
 * Description: Upload multiple files to the Infusionsoft Filebox of a contact record
 * Version: 0.2
 * Author: Kim Snider / Carlos Rodrigues - The API Guys
 * Website: http://theapiguys.com
 * License: GNU3
 */

$currentDate = date_format(date_create(), 'Ymd H:i:s');

if(count($_FILES['files']['name'])) {

// Connect to Infusionsoft

require_once __DIR__ . '../../lib/Infusionsoft/isdk.php'; 
$app = new iSDK;

$contactId = $_POST['contactId'];

	// If connected
	if ($app->cfgCon("yourConnectionName")) { 
	
		// Set $fileUploadSuccess to true
		$fileUploadSuccess = 1;
	
		// Loop through each file to be uploaded
		foreach ($_FILES['files']['tmp_name'] as $index => $name) {
		    
			$userFileName = $_FILES['files']['name'][$index];
			
	        $userTmpFile  = $_FILES['files']['tmp_name'][$index];
	       
	                    #open the file
	                    $fileOpen = fopen($userTmpFile, 'r');
	                
	                    #read the data and save it to a variable
	                    $data = fread($fileOpen, filesize($userTmpFile));
	                
	                    #close the file
	                    fclose($fileOpen);
	                
	                    #encode the data from the file in base 64
	                    #infusionsoft needs the data to be in this format to store it properly
	                    $dataEncoded = base64_encode($data);
	                
	                    #upload file into app
	                    $uploadFile = $app->uploadFile($userFileName, $dataEncoded, $contactId);
	                    
	                    // write result to log file for troubleshooting
	                    $file=fopen("file_error_log.txt","a+");
							fwrite($file, "\n $currentDate \n");
							if ($uploadFile) {
		                    		fwrite($file, "Uploaded $userFileName for ContactId $contactId  Upload Id is $uploadFile \n");   
								} else {
									fwrite($file, "Unable to upload $userFileName for ContactId $contactId  Upload Id is $uploadFile \n");
									// change $fileUploadSuccess to false
									$fileUploadSuccess = 0;
							}
	                    $file=fclose($file);
	
		}
		
		// redirect to thank you page
		
		if ($fileUploadSuccess == 1) {
			header("location: http://theapiguys.com/thank-you/");
		} else {
			echo "There was a problem with file upload. Please inform site administrator.";
		}
		
		
	} else {
		echo "Not Connected...";
	} 
	
} else { echo "There are no files to be uploaded!";}

