# Server-file-uploader
PURPOSE
-----------------------------------------
This is a front-end file uploader that is intended to upload one or two files (max file size 200KB) onto Linux/Unix server. The first file called ‘AQA file’ is mandatory, the second one called ‘Output file’ is optional. 
User selects the files from her/his computer, and provides several pieces of information that is used to rename the files once uploaded onto the server.
The files are then uploaded onto directory 'uploads' (previously created inside the directory where all the files reside, see ‘INITIAL LINUX/UNIX SERVER SETUP’) and the files’ names are changed by incorporating the supplied pieces of information. The files extensions are also changed to reflect the type of file uploaded (*.FLE for AQA, and *.dat for Output).
At the end of execution, subject the files are successfully uploaded, the confirmation.php triggers shell script (not included).

INITIAL LINUX/UNIX SERVER SETUP
-----------------------------------------
1) Place all the file in one directory on your server
2) Inside the directory create a new directory and name it 'uploads'
3) Change the files' and the 'uploads' directory's  permissions to allow execution, read and write (chmod 777 filename.php)

so the file/directory structure should look as follows;

me@myserver /var/www $ ls -ltr

-rwxrwxrwx 1 me me 1258 Sep  6 19:17  fileuploader.css

-rwxrwxrwx 1 me me 12044 Sep  6 19:17 confirmation.php

-rwxrwxrwx 1 me me 1258 Sep  6 19:17 fileuploaderform.php

-rwxrwxrwx 1 me me 1258 Sep  6 19:17 list.php

drwxrwxrwx 2 me me 4096 Sep  6 19:18 uploads

EXAMPLE USAGE
-----------------------------------------
The uploaded files, can be ‘picked up’ by a shell script and process further on the server using the information within the file names.
