## wordpress3.9-on-ptvirtualize
============

Pharaoh Virtualize (Virtual Machine Management), Pharaoh Configure (Configuration Management), Pharaoh Deploy
(Application Deployment), Pharaoh Configure (Infrastructure as Code)

The Virtual Machine is running the following software:

Selenium 2.43 with Chrome and Firefox support, ChromeDriver Server, Behat 2.4 with Mink 1.4, JDK 1.7.0, PHPUnit 3.5,
SimpleTest, Jenkins with a range of PHP Plugins

Wordpress 3.9, PHP 5, Apache 2, Mysql 5.5



# Usage Instructions:
------------

Prerequisites: Install Pharaoh Configure, Pharaoh Virtualize and Virtualbox on your host machine. This takes about 2
minutes on most machines. You can get instructions at http://www.pharaohtools.com/products/install

1) Clone/Download this repository to your machine

2) Go to the root of the repository

3) Run the following command:
   ptvirtualize up now

4) When you're done gracefully close the VM with
   ptvirtualize halt now
   ptvirtualize destroy now
   to ensure the provisioning on your host machine is undone.