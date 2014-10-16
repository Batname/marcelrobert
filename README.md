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

System > Configuration > Design > Header


## 5. New domain

###### Adding Another Store In Magento

We're going to do a hypothetical here for the naming conventions, and assume we own marcelrobert.it. Adjust the values accordingly for your own store.

1. Login to the Magento admin.
2. Go to the Catalog tab, and select Manage Categories.
3. Click on the Add Root Category button on the left.
4. On the right, for the Name, we'll enter Marcelrobert.it. Set the dropdown to Yes for both Is Active and Is Anchor.
5. Click the Save Category button.
6. Go to the System tab and select Manage Stores.
7. Click on the Create Website button.
8. For the Name, we'll enter Shoes.com, and for the Code, we'll enter shoes. We'll use this value later, so don't forget this!
if error `An error occurred while saving. Please review the error log.` than change in index.php

`error_reporting(E_ALL | E_STRICT);` to

`error_reporting (
    defined('E_DEPRECATED')
        ? (E_ALL | E_STRICT) ^ E_DEPRECATED
        : E_ALL | E_STRICT
);`

9.  Click the Save Website button.
10. Click on the Create Store button.
11. For the Website, select marcelrobert.it from the dropdown. For the Name, we'll enter Main Store. For the Root Category, select the Shoes.com from the dropdown.
12. Click on the Save Store button.
13. Click on the Create Store View button.
14. For the Store, select Main Store from the dropdown, making sure it's for the Shoes.com website. For the Name, we'll enter English. For the Code, we'll enter shoes_en. For the Status, select Enabled from the dropdown.
`sudo chmod -R 777 /var/www/marcelrobert.com/skin/`
15. Click the Save Store View button.
16. Go to the System tab and select Configuration.
17. For the Current Configuration Scope (located on the top left), change the dropdown menu from Default Config to marcelrobert.it
18. Select Web from the sidebar on the left under the General heading.
19. For both the Unsecure and Secure sections, uncheck the Use default box next to the Base URL item, and enter the URL for your store, e.g. http://marcelrobert.it/. Don't forget the trailing slash!
20. Click the Save Config button.

store view config `System->COnfiguration->General->Web->Url options->Add Store Code to Urls`

###### Parked Domain Method

For this method, we'll pretend we own marcelrobert.com and marcelrobert.it. The marcelrobert.com domain is our primary domain, and Magento is already installed on it. Here's how we would set this up for the marcelrobert.it domain:

create new domain `sudo gedit /etc/hosts` marcelrobert.it

`sudo gedit /etc/apache2/sites-available/marcelrobert.conf`

```
<VirtualHost *:8080>
        ServerAdmin webmaster@localhost
        ServerName marcelrobert.it
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

`sudo a2ensite marcelrobertit.conf`

`sudo service apache2 restart`

Open up the index.php file for Magento and look for this line (it's the last line of the file):

`// Mage::run($mageRunCode, $mageRunType);`

`switch($_SERVER['HTTP_HOST']) {
    case 'marcelrobert.it':
    case 'www.marcelrobert.it':
        Mage::run('italy', 'website');
        break;
    default:
        Mage::run($mageRunCode, $mageRunType);
        break;
}`

Go to `System -> Configuration. Current Configuration Scope` and change Default Config to Italy.Im menu Web and in sections Secure и Unsecure set Base URL
For domain second level http://marcelrobert.it/

For create subdomain:

1. Add `ServerAlias www.marcelrobert.com` to marcelrobert.conf
2. Add www.marcelrobert.com to /etc/hosts
3. `sudo a2enmod vhost_alias`
4. `sudo service apache2 restart`

More Information
[habrahabr](http://habrahabr.ru/post/91611/)
[crucialwebhost](http://www.crucialwebhost.com/kb/how-to-setup-multiple-magento-stores/)
[magento-forum](http://magento-forum.ru/topic/339/)