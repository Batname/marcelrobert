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

###### Create custom sub-theme

Do not copy all files and when you're creating a sub-theme, don’t copy folder skin/frontend/ultimo/default/css/_config/ to your sub-theme, that folder should stay in the default theme. Otherwise it will override all your theme configuration from the admin panel.

1. Create **main_marcelrobert** Theme

Template files are organized as follows:
* layout – directory contains XML files which define page structure
* template – directory contains template files (.phtml), a mix of HTML and PHP
* locale – directory contains CSV files with translation strings
Skin files are organized as follows:
* css – directory contains CSS files
* images – directory contains images
* js – directory contains theme-specific JavaScript files

Enable the new sub-theme in the admin panel. Go to `System > Configuration >Design > Themes` and enter **main_marcelrobert** (the sub-theme name) in the default field:

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

## 5. Localization

###### Translation

* Create a new folder for your translation. For Spanish language it will be app/design/frontend/ultimo/default/locale/es_ES.
* Copy translate.csv from app/design/frontend/ultimo/default/locale/en_US and paste it into created folder app/design/frontend/ultimo/default/locale/es_ES.
* Open app/design/frontend/ultimo/default/locale/es_ES/translate.csv

Set Translation to store View `System->COnfiguration->General->General->Locale Options->(Change Current Configuration Scope)`

###### Language flag / Localization link

link store view config `System->COnfiguration->General->Web->Url options->Add Store Code to Urls`

Flag images (16x12 pixels, PNG format) should be uploaded to skin/frontend/ultimo/default/images/flags folder. Image names should be the same as the store view codes. E.g. if you have a store view with the code de, you will need to upload a flag image de.png to skin/frontend/ultimo/default/images/flags folder.

## 6. Theme features and elements

###### Home page

Create Marcel Robert Theme Page set this on `System > Configuration > General > Web > Default Pages`

1. Static blocks
Add blocks to cms blocks
* home_main_sb_1
* home_main_sb_2
* home_main_sb_3
* home_main_sb_4
* home_main_sb_5

than add to home page `{{block type="cms/block" block_id="foo_block"}}`

2. Sitemaster_LinkPartners module
* ok
3. Footer

* `System > Configuration > Ultimo > Theme Settings > Default Magento Blocks`  remove footer_links
* disable block_footer_row2_column5
* footer ultimo settings
* Slideshow settings available in the admin panel in `System > Configuration > Ultimo > Slideshow`.

* call newsletter in static block `{{block type="newsletter/subscribe" template="newsletter/subscribe.phtml"}}`

* change position social link, change copyright

4. Sitemaster_Ultimo module to theme settings all in one module

`/var/www/marcelrobert.com/app/code/local/Sitemaster/Ultimo/etc/config.xml`

`/var/www/marcelrobert.com/app/code/local/Sitemaster/Ultimo/etc/system.xml`

`/var/www/marcelrobert.com/app/etc/modules/Sitemaster_All.xml`

And settings in:

`/var/www/marcelrobert.com/app/design/frontend/ultimo/main_marcelrobert/layout/local.xml`
`/var/www/marcelrobert.com/app/design/frontend/ultimo/main_marcelrobert/template/page/html/footer.phtml`

Add new template website.phtml for switch between websites

4. Header

* Disabling wishlist functionality
⋅⋅* Go to the Admin interface (select the appropriate scope) and under System -> Configuration -> Customers -> Whishlist select “No” under the “Enabled” in the General options.
* Disabling "Compare" Drop-down"
⋅⋅* Admin panel: System > Configuration > Ultimo > Theme Settings
⋅⋅* Show Text Label "Compare" – if set to No, label "Compare" will be hidden.
⋅⋅* Display Block "Compare" in the Header – enable/disable "Compare" drop-down block in the header. If set to off
* Create block websites in header
* changes in `app/design/frontend/ultimo/main_marcelrobert/template/page/html/header.phtml`

5. Catalog-Category-View
* Disabling RSS In the Configuration panel on the left, under Catalog, select RSS Feeds.
* Settings in layout & phtml

6. Catalog-Product-View
*  `<validate>validate-number validate-number-range number-range-2-8</validate>` `in /var/www/marcelrobert.com/app/code/local/Infortis/Ultimo/etc/config.xml`
than `$imgColUnits+$primaryColUnits <=10` in `app/design/frontend/ultimo/main_marcelrobert/template/catalog/product/view.phtml`

*  Unset UnsetChildren in layout.xml
        `<!--<reference name="product.info">-->
            <!--<action method="unsetChild">-->
                <!--<block>info_tabs</block>-->
            <!--</action>-->
            <!--<action method="unsetChild">-->
                <!--<block>upsell_products</block>-->
            <!--</action>-->
        <!--</reference>-->`

            `<reference name="product.info">
                <reference name="product.info.options.wrapper.bottom">
                    <action method="unsetChild"><name>product.info.addtocart</name></action>
                </reference>
            </reference>`

*  Create video static block
set `<reference name="product.info">
      <block type="cms/block" name="product_static_block_1" as="product_video">
        <action method="setBlockId"><id>product_static_block_1</id></action>
     </block>
    </reference>`

 and in template     `<div class="grid-container feature centered">
                         <div class="grid12-12"><?php echo $this->getChildHtml('product_video') ?></div>
                     </div>`

*  Disable related `System > Configuration > Ultimo > Theme Settings`

* add Jquery to template         `<script type="text/javascript">
                                     //<![CDATA[
                                     jQuery(function ($) {
                                         $('#tabreviews').click(function() {
                                             $( "#formreviews" ).toggle("slow");
                                         });
                                     });
                                     //]]>
                                 </script>`
* search page

* set new search module  Sitemaster_Emptysearch         `var_dump($queryText);
                if ($queryText != 'bat') {
                    if ($where != '') {
                        $select->where($where);
                    }
                }`

in `/var/www/pro-ex/app/code/core/Mage/CatalogSearch/Model/Resource/Fulltext.php`

* unsetChild and set 1 column in search

7. checkout-cart-index

8. checkout-onepage-index

in /var/www/marcelrobert.com/skin/frontend/ultimo/main_marcelrobert/js/opcheckout.js 50-63

   ` /**
     * Top Section header click handler
     *
     * @param event
     */
    _onTopSectionClick: function(event) {
        var section = $(Event.element(event).up());
        console.log(section);
        if (section.hasClassName('allow')) {
            Event.stop(event);
            this.gotoSection(section.readAttribute('id').replace('top-opc-', ''));
            return false;
        }
    },`

in /var/www/marcelrobert.com/skin/frontend/ultimo/main_marcelrobert/js/opcheckout.js 50-63
            `Event.observe($('top-'+section.readAttribute('id')), 'click', this._onTopSectionClick.bindAsEventListener(this));`

9. Login & Ajax modules

10. Sitemaster_Wishlist

## 7. Install debug module
