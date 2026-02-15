# LAMP-Stack-Colors-Lab
GitHub Repository for my Assignment 1 submission, Version Control with GitHub. Contained within this repository is my implementation of the LAMP Stack COLORS Lab as outlined in [1.4] Getting Started with LAMP.pdf.

# Colors Lab Application
The COLORS application is a simple website-based application that is comprised of HTML, javascript, php, and css files. Following along in setting up a LAMP stack server, connecting a domain, and uploading the required files to the server, one gains the knowledge and fundamental understanding of how a website works.

# Technologies Used:
In this project, I created a LAMP droplet on DigitalOcean. This acts as the remote server for the website to be hosted on. A personal computer is needed in order to connect to the remote server (via SSH). Applications like PuTTY or FileZilla are needed for FTP transfer of files from your personal computer to your server.

# Setup Instructions:
 - Create a LAMP Droplet at [digitalocean.com](https://marketplace.digitalocean.com/apps/lamp) (or another server for your website if comfortable)
- Log in to the server via ssh (ssh root@MyDomainOrIPAddress). 
- Create a MySQL server with databases for the colors and users. You may follow the below instructions to do this:
    * Connect to MySQL (enter password when prompted): mysql -u root -p 
    * create database COP4331;
    * use COP4331;
    * CREATE TABLE `COP4331`.`Users` ( `ID` INT NOT NULL AUTO_INCREMENT , `FirstName`
VARCHAR(50) NOT NULL DEFAULT '' , `LastName` VARCHAR(50) NOT NULL DEFAULT '' , `Login`
VARCHAR(50) NOT NULL DEFAULT '' , `Password` VARCHAR(50) NOT NULL DEFAULT '' ,
PRIMARY KEY (`ID`)) ENGINE = InnoDB;
    * CREATE TABLE `COP4331`.`Colors` ( `ID` INT NOT NULL AUTO_INCREMENT , `Name`
VARCHAR(50) NOT NULL DEFAULT '' , `UserID` INT NOT NULL DEFAULT '0' , PRIMARY KEY
(`ID`)) ENGINE = InnoDB;

- Create a MySQL user with access to your new colors and users databases. You may follow the below instructions to do this:
    * Use COP4331; // Use our database
    * create user 'USERNAME' identified by 'PASSWORD'; // Replace USERNAME and PASSWORD with desired username and password
    * grant all privileges on COP4331.* to 'USERNAME'@'%'; // Grants all privileges to our new user, which our API will need

- Upload the files from this GitHub repository, including all files in the public and LAMP_API folders. You can use PuTTY or a UI-based FTP upload tool like FileZilla.
- Create a database.php file and store the host, username, password, and database credentials as constants. Upload or save this file to the LAMP_API folders.
- Navigate to the public folder, then to the js folder, and edit the first line in the code.js file, setting the base URL variable to your site (either your connected domain or raw IP address).

# How to run and access the application
- Access your site using either your raw IP address or through your connected domain! As stated above, a server will be needed to run your lab application. A LAMP droplet running as a server is recommended for this project.

The instructions above assume basic knowledge of the command line or terminal on Windows or Linux systems. Setup may vary depending on operating system. AI was not knowingly used to develop this code or README file, however nearly all code is adopted from our course modules (credits to Aashish Yadavally and other authors as applicable). 