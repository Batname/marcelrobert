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