## 1. Ready test Server

`sudo gedit /etc/apache2/sites-available/marcelrobert.conf`

```
<VirtualHost *:8080>
        ServerAdmin webmaster@localhost
        ServerName marcelrobert.com
        DocumentRoot /var/www/marcelrobert.com
        <Directory /var/www/>
                Options Indexes FollowSymlinks MultiViews
                AllowOverride All
                Order allow,deny
                allow from all
        </Directory>
        ErrorLog /var/log/apache2/mysite-error.log
        CustomLog /var/log/apache2/mysite-access.log common
</VirtualHost>
```

`sudo a2ensite marcelrobert.conf`

`sudo a2enmod rewrite`

`sudo mkdir /var/www/marcelrobert.com`

`sudo chmod -R 777 /var/www/marcelrobert.com`

`sudo gedit /var/www/marcelrobert.com/index.php`

`sudo gedit /etc/hosts`

`sudo service apache2 restart`

`sudo chmod -R 777 /var/www`

## 2. Ready test Database

Create Database/User/

Copy Test database

`mysql -umarcelrobert -pmarcelrobert marcelrobert < /home/bat/Desktop/demo_database_ultimo_1.10.1.sql`

## 3. Install Demo Theme

Now you can install Magento: using your FTP client, upload Magento.zip file to your server (to the folder where Magento can be installed) and extract it there

Open a web browser and navigate to your website (to the folder where you extracted Magento.zip) to load the Magento Setup Wizard.

`sudo chmod -R 777 /var/www/marcelrobert.com`


## 4. Settings

* System > Cache Management > Disable All
* System > Configuration > Advanced > Developer > Log Settings > Enabled => Yes
* System > Configuration > Web > Search Engine Optimization > Use Wbe Server Rewrites => Yes
* System > Index Management > Reindex All
* Open .htaccess and set: SetEnv MAGE_IS_DEVELOPER_MODE “true” at the end of the file
* Open .htaccess and set: php_value display_errors On somewhere within <IfModule mod_php5.c>
* Rename /errors/local.xml.sample to /errors/local.xml
* Create one sample customer with full valid American address (for example use US/California, city Alamo with ZIP 94507), and one with full valid non American address (other country) to test payment and shipping gateways properly

* Xdebug server

## 4. Customization

###### Logo