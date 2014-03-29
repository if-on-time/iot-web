### Development instructions

Clone the repository: `git clone git@github.com:if-on-time/iot-web.git`

For others outside the organization try fork or use HTTPS.

Enter collaby: `cd iot-web`

Install zend: `php composer.phar install`

Create `local.php` file in `config/autoload`

Put this content:

~~~
<?php

return array(
    'db' => array(
        'username' => 'postgres',
        'password' => '**secret**',
    )
);
~~~


Install intl for i18n: `sudo apt-get install php5-intl`

Install mcrypt for hash operations: `sudo apt-get install php5-mcrypt`

Create a VirtualHost, on `/etc/apache2/sites-enabled` create the file iot-web.
Put this content:

~~~
<VirtualHost *:80>
        ServerName iot-web.local

        DocumentRoot /home/user/NetBeansProjects/iot-web/public
        <Directory "/home/user/NetBeansProjects/iot-web/public">
                AllowOverride FileInfo
        </Directory>
</VirtualHost>
~~~

Put this line in the `/etc/hosts` file:

~~~
127.0.0.1	iot-web.local
~~~

Ok, you're good to go.
