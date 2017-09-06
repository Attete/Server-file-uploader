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
This form sends data to a temporary default directory on the server. The files are then picked up by the
second php page 'confirmation.php' and moved to their actual destination /uploads
-->
<!--^^^^^^^^^^^^^^^^^^^^^^ START of the FORM  ^^^^^^^^^^^^^^^^^^^^^^  -->
<div class="container">
<h1>Server file uploader</h1>
<hr>

<form action="confirmation.php" method="post" enctype="multipart/form-data"> 

<!-- hidden input filed used to restrict max size of the file to be uploaded, 
see $max value in fileuploaderform.php -->
<input type="hidden" name="MAX_FILE_SIZE" value="204800"> <!-- value given in Bytes, so 204800/1024=200KB, so max file size is 200KB -->

<!------------------------------------------->
<!-- section of the form for selecting the 1st file -->
<label for="filename1"><b>Select AQA file</b></label> <!-- 'for' attribute of the label takes the Id of the target element -->
<input type="file" name="filename1" id="filename1">
<br><br>

<!------------------------------------------->

<!-- section of the form for selecting the 2nd file-->
<label for="filename2"><b>Select Output file </b></label> <!-- 'for' attribute of the label takes the Id of the target element -->
<input type="file" name="filename2" id="filename2">
<br><br>
<hr>

<!------------------------------------------->

<!--user input for the customer's SCNUMBER number -->
<b>SCNUMBER</b> (defaults to X12345 if left empty) <input type="text" name="scnumber"><br> <br> 

<!------------------------------------------->

<!-- drop down list for the user to choose customer's system  -->
<b>System</b> (required)
<select name="sys"> 
  <option value=""></option> 
  <option value="System1">System1</option>
  <option value="System2">System2</option>
  <option value="System3">System3</option>
</select><br><br>

<!------------------------------------------->

<!-- drop down list for the user to choose line of business  -->
<b>Line of business</b> (required)
<select name="lob"> 
  <option value=""></option> 
  <option value="CB">Consumer Banking</option> 
  <option value="SBB">Small Business Banking</option>
  <option value="WM">Wealth Management</option>
  <option value="MAA">Mergers and Acquisitions</option>
</select><br><br> 
  
<!-- user input for the user's email address   -->
<b>User email address</b> (required)
<input type="text" name="email"><br><br>

<!-- user input for the scheme mnemonic  -->
<b>Scheme mnemonic </b> (required)
<input type="text" name="mnemonic"><br><br>  

<hr>
<p>

<!-- submit - section of the form 
'value' - the button caption
'name' - name of the submit button-->
<input type="submit" name="upload" value="Submit files">

</p>

</form> 
</div>
<!--^^^^^^^^^^^^^^^^^^^^^^ END of the FORM  ^^^^^^^^^^^^^^^^^^^^^^  -->


</body>
</html>



