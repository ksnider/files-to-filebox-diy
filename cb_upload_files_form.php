<!doctype html>

<?php

/**
 * Project Name: How To Upload Files To The Infusionsoft Filebox
 * File Name: cb_upload_files_form.php
 * Description: Upload multiple files to the Infusionsoft Filebox of a contact record
 * Version: 0.2
 * Author: Kim Snider / Carlos Rodrigues - The API Guys
 * Website: http://theapiguys.com
 * License: GNU3
 */


// Assign REQUEST variables using ternary operators and IF statement
	

if ($_GET['Id']) {
		$contactId = $_GET['Id'];
	} else {
		$contactId = ($_GET['contactId']) ? $_GET['contactId'] : '';	
	}	




?>

<html>
    <head>
        <title>FileBox Upload</title>
    </head>
    <body>
        <div id="TAG-filebox-form">
            <form action="cb_upload_files.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="contactId" value="<?php echo $contactId ?>" />
                <div style="overflow: auto; min-width: 300px;">
                    <div style="float: left; margin-top: 3px; margin-right: 10px;">
                        Select your files:
                    </div>
                    <div style="float: left;">
                        <input type="file" name="files[]" multiple />
                    </div>
                </div>
                <div style="margin-top: 10px;">
                    <button type="submit">Upload</button>
                </div>
            </form>
        </div>
    </body>
</html>