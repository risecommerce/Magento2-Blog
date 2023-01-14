#Risecommerce Blog Module

##Support: 
version - 2.3.x, 2.4.x 

##How to install Extension

 Using Composer  
 
 composer require risecommerce/module-blog-extension:1.0.1
  
#Enable Extension:
- php bin/magento module:enable Risecommerce_Blog Risecommerce_Core Risecommerce_BlogAmp Risecommerce_BlogGraphQl
- php bin/magento setup:upgrade
- php bin/magento setup:di:compile
- php bin/magento setup:static-content:deploy
- php bin/magento cache:flush

#Disable Extension:
- php bin/magento module:disable Risecommerce_Blog Risecommerce_Core Risecommerce_BlogAmp Risecommerce_BlogGraphQl
- php bin/magento setup:upgrade
- php bin/magento setup:di:compile
- php bin/magento setup:static-content:deploy
- php bin/magento cache:flush
