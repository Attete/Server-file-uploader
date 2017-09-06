<?php #this php block will be executed after the form below (see the '<div class="section3">' section) has been submitted
$max = $_POST['MAX_FILE_SIZE'];
//$max= 150 * 1024; #size in Bytes, here max is 150 KBytes, works with hidden input field, see form below

//includes the external file that stores SCNUMBER strings as keys with corresponding Business ID strings as values; key=>value
include 'list.php'; 

$mnemonicInfo = $_POST['mnemonic']; //collects and stores the input of the 'Mnemonic' edit box
$systemInfo = $_POST['sys']; //collects and stores the input of the 'System' drop down list
$lobInfo = $_POST['lob']; //collects and stores the input of the 'Line of business' drop down list 
$emailInfo = $_POST['email']; //collects and stores the input of the 'User email' edit box
$scnumberInfo = $_POST['scnumber']; //collects and stores the input of the 'SCNUMBER' edit box    //testing


function missingMandatoryData($a, $b, $c, $d)
{
  if (($a == '') || ($b == '') || ($c == '') || ($d == ''))  //if any of these variables is empty...
  {
    return false;
	
  }
    else 
      {
         return true;
	   }
}


   
   //if the SCNUMBER edit box is NOT empty (if user provided a SCNUMBER)..
   //AND..
   //if the BusinessIDArray returns a matching ID .. 
 if(( $scnumberInfo != '')  &&  ($BusinessIDArray[$scnumberInfo] != '')) 
   {
	 //fetch the value of the Business ID storred in the $BusinessIDArray, 
	 //by using the SCNUMBER key stored in $scnumberInfo and assign it to $bi
	 $bi = $BusinessIDArray[$scnumberInfo]; 
   }
     else //..or the business id '$bi' and SCNUMBER '$scnumberInfo' variables 
	        //are assigned default values X12345 and 00
       {
		   $bi = "00";  //business id 
		   $scnumberInfo = "X12345";  //SCNUMBER
	   }  
	   
   

///////////////////////// Do the following on submit.. /////////////////////////

//'upload' - name of the submit button in the form, 
//'isset' — determines if a variable is set and is not NULL
//if the AQA file DOES NOT error due to error 4..
if (isset($_POST['upload']) &&  ($_FILES['filename1']['error'] != 4) 	
	                                 && missingMandatoryData($mnemonicInfo, $systemInfo, $lobInfo, $emailInfo))  
			
	
{
	//Path to the 'upload' folder, where the uploaded files are eventually stored 
	$destination = __DIR__ . '/uploads/'; //'__DIR__' - constant that stores absolute path to the current folder (where the php file is), concatenated with the relative path
	
	//Check if the 1st file was uploaded successfully and if so, move the 1st file to its final destination
	if ($_FILES['filename1']['error'] == 0) 
	{// if there was no error while uploading the file
	
		//move the uploaded file from the temporary directory to /uploads
		//the file name will have the following info added to its name; SCNUMBER, Business ID, Mnemonic, LOB, System, Type of file (AQA) + file extension
        $result1 = move_uploaded_file($_FILES['filename1']['tmp_name'], $destination . $scnumberInfo .'_'. $bi .'_'. $mnemonicInfo .'_'. $lobInfo .'_'. $systemInfo .'_AQA_'. $emailInfo . '.FLE');
		//'filename' - the input filed in the form
		//'tmp_name' - subarray storing the temporary name of the submitted file
		// $destination - where the files will be moved
	    //'$_FILES['filename']['name']' - 'name' - the original file name, we could append this above to the 'moved file' to keep it original name, but we are renaming it.
		//'move_uploaded_file' - more secure thatn 'copy' as it only moved genuinely uploaded files
		
		if($result1) 
		  { //if true..if the file was successfully uploaded
	         $message1 = $_FILES['filename1']['name'] . '  - WAS UPLOADED SUCCESSFULLY.'; // 'name' - the original file name
             $scriptToExecute_1 = true;
		   } 
		   else 
		     {//..otherwise output correct error
		        $message1 = 'Sorry there was a problem uploading ' . $_FILES['filename1']['name']; 
		     }    
	} 
	 else 
	  {	
     		//Dsplays meaningful error to the user after the Submit button is clicked;
	          switch($_FILES['filename1']['error'])  //'filename' - the input filed in the form, 'error' - section of the array that stores error codes
	          {
		        // case 0: - taken care of in the 'if($result)' condition above
                    case 1:
		              $message1 = $_FILES['filename1']['name'] . ' - is to big to upload.'; 
		              break;
		            case 2:
		              $message1 = $_FILES['filename1']['name'] . ' - IS TO BIG TO UPLOAD.'; 
		              break;
		             case 3:
		              $message1 = $_FILES['filename1']['name'] . ' - WAS ONLY PARTIALLY UPLOADED.'; 
		              break;
		            case 4:
		              $message1 = ' NO FILE SELECTED.'; 
		              break;
		            case 6:
		              $message1 = ' MISSING A TEMPORARY FOLDER.'; 
		              break;
		            case 7:
		              $message1 = ' FAILED TO WRITE FILE TO DISK.'; 
		              break;
                    case 8:
		              $message1 = ' A PHP EXTENSION STOPPED THE ' . $_FILES['filename1']['name'] . ' FILE UPLOAD.'; 
		              break;
		            default:
		              $message1 = ' SORRY THERE WAS A PROBLEM UPLOADING - ' . $_FILES['filename1']['name'];
		              break;
	           }	  
	  }

//Check if the 2nd file was uploaded successfully and if so, move the 2nd file to its final destination
	//if the AQA (1st file) DOES NOT error due to error 3, 2 or 1 ..
	if ($_FILES['filename2']['error'] == 0 &&  ($_FILES['filename1']['error'] != 1) 
                                                      &&  ($_FILES['filename1']['error'] != 2) 
							                     	  &&  ($_FILES['filename1']['error'] != 3) )


	{// if there was no error while uploading the file
	
		//move the uploaded file from the temporary directory to /uploads
		//the file name will have the following info added to its name; SCNUMBER, Business ID, Mnemonic, LOB, System, Type of file (OUT)+ file extension
        $result2 = move_uploaded_file($_FILES['filename2']['tmp_name'], $destination . $scnumberInfo .'_'. $bi .'_'. $mnemonicInfo .'_'. $lobInfo .'_'. $systemInfo .'_OUT_'. $emailInfo . '.dat');
		//'filename' - the input filed in the form
		//'tmp_name' - subarray storing the temporary name of the submitted file
		// $destination - where the files will be moved
	    //'$_FILES['filename']['name']' - 'name' - the original file name, we could append this above to the 'moved file' to keep it original name, but we are renaming it.
		//'move_uploaded_file' - more secure thatn 'copy' as it only moved genuinely uploaded files
		
		
		
		if($result2) 
		  { //if true..if the file was successfully uploaded
	         $message2 = $_FILES['filename2']['name'] . ' - WAS UPLOADED SUCCESSFULLY.'; // 'name' - the original file name
	         $scriptToExecute_2 = true;
		  } 
		   else 
		     {//..otherwise output correct error
		        $message2 = 'Sorry there was a problem uploading ' . $_FILES['filename2']['name'];
		     }  
	 
	} 
	 else 
	  {	
     		//Dsplays meaningful error to the user after the Submit button is clicked;
	          switch($_FILES['filename2']['error'])  //'filename' - the input filed in the form, 'error' - section of the array that stores error codes
	          {
		        // case 0: - taken care of in the 'if($result)' condition above
                    case 1:
		              $message2 = $_FILES['filename2']['name'] . ' - is to big to upload.'; 
		              break;
		            case 2:
		              $message2 = $_FILES['filename2']['name'] . ' - IS TO BIG TO UPLOAD.'; 
		              break;
		            case 3:
		              $message2 = $_FILES['filename2']['name'] . ' - WAS ONLY PARTIALLY UPLOADED.'; 
		              break;
		            case 4:
		              $message2 = ' NO FILE SELECTED.'; 
		              break;
		            case 6:
		              $message2 = ' MISSING A TEMPORARY FOLDER.'; 
		              break;
		            case 7:
		              $message2 = ' FAILED TO WRITE FILE TO DISK.'; 
		              break;
                    case 8:
		              $message2 = ' A PHP EXTENSION STOPPED THE ' . $_FILES['filename2']['name'] . ' FILE UPLOAD.'; 
		              break;
		            default:
		              $message2 = ' SORRY THERE WAS A PROBLEM UPLOADING - ' . $_FILES['filename2']['name'];
		              break;
	           }	  
		  }

		
	//and some more info about the errors, just in case.. :-)
	/* Error Codes;
	UPLOAD_ERR_OK - Value: 0; There is no error, the file uploaded with success.
	UPLOAD_ERR_INI_SIZE - Value: 1; The uploaded file exceeds the upload_max_filesize directive in php.ini.
	UPLOAD_ERR_FORM_SIZE - Value: 2; The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.
    UPLOAD_ERR_PARTIAL - Value: 3; The uploaded file was only partially uploaded.
	UPLOAD_ERR_NO_FILE - Value: 4; No file was uploaded.
	UPLOAD_ERR_NO_TMP_DIR - Value: 6; Missing a temporary folder. Introduced in PHP 5.0.3.
	UPLOAD_ERR_CANT_WRITE - Value: 7; Failed to write file to disk. Introduced in PHP 5.1.0.
	UPLOAD_ERR_EXTENSION - Value: 8; A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension 
	 caused the file upload to stop; examining the list of loaded extensions with phpinfo() may help. Introduced in PHP 5.2.0.
	*/

 $displayData = true;	//if all mandatory data is provided
 
 if ($scriptToExecute_1 && $scriptToExecute_1) 
 {
	 shell_exec("/var/www/somePerlstuff.pl");
 }
}


?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Server file uploader</title>

<link href="fileuploader.css" rel="stylesheet" type="text/css">  
<style>
</style>
</head>

<body>
			

<!--
>>> HTML FORM  that allow users to choose the files they want to upload <<<<<<
1) Uses method="post"
2) The form attribute: enctype="multipart/form-data" specifies which content-type to use when submitting the form
3) The type="file" attribute of the <input> tag shows the input field as a file-select control, with a "browse" button next to the input control
This form sends data to a temoprary defautl directory on the server, and it then picke up and moved 
by the php code located in this file above <!doctype html> tag
-->
<!------------------------- START of the FORM  --------------------------->
<div class="container">
<h1>Server file uploader</h1>
<hr>


<form action="fileuploaderform.php" > 

<h3>Confirmation; <?php  ?></h3>

<?php 
if($displayData) //if all mandatory data was provided
{
echo $mainFile;

echo "SCNUMBER ; " . $scnumberInfo;
echo "<br>";

echo "Business ID ; " . $bi; 
echo "<br>";

echo "Mnemonic ; " . $mnemonicInfo; 
echo "<br>";

echo "System ; " . $systemInfo ; 
echo "<br>";

echo "LOB ; " . $lobInfo;
echo "<br>";

echo "Email ; " . $emailInfo; 
echo "<br><br>";

// displays the upload error messages as specified in the php block at the top, see switch section
 if ($message1) //if '$message1' string empty nothing will be displayed, if not empty it evaluates to true and displays the error string
{
	echo "<b> AQA file ;</b><br>  " . $message1;
	echo "<br><br>";
} 
 // displays the upload error messages as specified in the php block at the top, see switch section
 if ($message2) //if '$message2' string empty nothing will be displayed, if not empty it evaluates to true and displays the error string
{
	echo "<b>Output file ;</b><br>  " . $message2;
	echo "<br><br><br>";
} 

}
else 
	
	{
		echo "No action taken, because <b>some mandatory data was missing</b><br><br>";
		echo "Please go back and try again.<br><br>";
	
	}

?>



<hr>
<p><!-- submit - section of the form 
'value' - caption of the button
'name' - name of the submit button-->
<input type="submit" name="goback" value="Go back" >

</p>
</div>

</form> 

<!------------------------- END of the FORM  --------------------------->


</body>
</html>



