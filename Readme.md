Unfraud Opencart
=======

This is the Unfraud plugin for Opencart. The plugin supports the Opencart edition from 1.5.4.0 to 2.1.0.2.

We commit all our new features directly into our GitHub repository.
But you can also request or suggest new features or code changes yourself!


Requirements
-------------------------
1. The service uses the Unfraud REST api for processing transactions.
2. The server needs to support cURL



Installation Instructions
-------------------------
### Via modman

- Install [modman](https://github.com/colinmollenhour/modman)
- Use the command from your Magento installation folder: `modman clone https://github.com/Unfraud/Unfraud-Opencart/`

### Via composer
- Install [composer](http://getcomposer.org/download/)
- Install [Magento Composer](https://github.com/magento-hackathon/magento-composer-installer)
- Create a composer.json into your project like the following sample:

```json
{
    ...
    "require": {
        "unfraud/unfraud-opencart":"*"
    },
    "repositories": [
	    {
            "type": "vcs",
            "url": "https://github.com/Unfraud/Unfraud-Opencart"
        }
    ],
    "extra":{
        "magento-root-dir": "./"
    }
}
```

- Then from your `composer.json` folder: `php composer.phar install` or `composer install`

### Manually
- You can copy and merge the folders "admin" and "catalog" of this repository to the same folders into main folder of your opencart installation 



Configuration
-------------------------
a) Enter into admin tab "Extension > Modules"
 
b) Install Unfraud module from module's list

c) Enter into Unfraud module configuration 

d) Fill the input data with your Unfraud credentials: "Email","Password" and "API_KEY" (you can find it into your Unfraud panel in https://www.unfraud.com/dashboard/).

e) After that you'll see your "Unfraud Dashboard" below the configuration form of the same page.


Installation (ONLY FROM VERSION 2.0.0.0 )
-------------------------

a) Open up the success.php file found in /catalog/controller/checkout/success.php 

b) Paste the follow line 
```php
    $this->load->controller('module/unfraud');  
```
after
```php
    public function index() {
``` 

c) Save success.php file

d) Open up the footer.php file found in /catalog/controller/common/footer.php
 
e) Paste the follow line 
```php
    $data['unfraud_html'] = $this->load->controller('module/unfraud');  
```
   before
```php 
    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/footer.tpl')) {
        return $this->load->view($this->config->get('config_template') . '/template/common/footer.tpl', $data);
    } else {
        return $this->load->view('default/template/common/footer.tpl', $data);
    }
```

f) Save footer.php file


Operation of the module
-------------------------
The score of your transaction will be added to the Unfraud cloud service when the user first creates order. 
The source code is commented on how to delay the creation of a transaction score in Unfruad to when the order is completed.

