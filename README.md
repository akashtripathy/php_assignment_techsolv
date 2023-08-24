# php_assignment_techsolv

## Setup:
1. clone the project to the local repository (git clone)
2. After cloning you will get some file structure like below

   ![image](https://github.com/akashtripathy/php_assignment_techsolv/assets/55340850/2e9ec9da-c9be-4ab4-9167-1aa33ee0f57c)
4. Export the sql fine inside the config directory into your PhpMyAdmin
5. place the project inside XAMPP htdocs folder
6. start the XAMPP server

   ### Note:**  For Mail server we need to setup something additional in XAMPP>php>php config file and XAMPP>sendmail>sendmail config file
     Inside php:
   
       SMTP=smtp.gmail.com 
       smtp_port=587 
       sendmail_from = youremail@gmail.com
       sendmail_path = C:\xampp\sendmail\sendmail.exe
       extension=php_openssl.dll

     Inside sendmail:
   
       mtp_server=smtp.gmail.com
       smtp_port=587
       error_logfile=error.log
       debug_logfile=debug.log 
       auth_username=yourmail@gmail.com
       auth_password=yourAppPassword (you have to turn on 2-step verification for this password)
       force_sender=yourmail@gmail.com


 
 ## Understanding Code:
 
 `Config folder` contain Database.php , where the real coonection and data base configuration is added
 
 `Models folder` contain Contact.php , wherea all database realted opertion to contact_form id done
 
 `index.php` cantain the HTML part for frontend, all validation and program logic
 
 `mail.php` is responsible for sending mail to the site owner when someone submit the new form


 On Left corner all ERROR and SUCESS message will be shown


## Output Screensort:
1. Validating the form
   
   ![image](https://github.com/akashtripathy/php_assignment_techsolv/assets/55340850/7b414848-db96-46f5-9b86-5e383b894dfe)
2. When duplicate entry done
   
   ![image](https://github.com/akashtripathy/php_assignment_techsolv/assets/55340850/a7ca4b4d-b401-4f07-bac0-4c07fc59e092)
3. When form submit successfully
   
   ![image](https://github.com/akashtripathy/php_assignment_techsolv/assets/55340850/9d23f2d8-d108-4182-bf1a-481adfea4c6c)
4. Mail Send to Owner

   ![image](https://github.com/akashtripathy/php_assignment_techsolv/assets/55340850/41f6c403-de6b-4d4c-b02c-80e1d42985f4)





   
