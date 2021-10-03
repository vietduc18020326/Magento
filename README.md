# new-magento

current setup:
```
php bin/magento setup:install --admin-firstname=Spring --admin-lastname=Bbe --admin-email=tridung240400@gmail.com --admin-user=admin --admin-password='AbC@12345' --base-url=http://localhost:8011 --backend-frontname=admin --db-host=mysql --db-name=magento_db --db-user=magento --db-password=secret --use-rewrites=1 --language=en_US --currency=VND --timezone=Asia/Ho_Chi_Minh --use-secure-admin=1 --admin-use-security-key=1 --session-save=files --elasticsearch-host=elasticsearch
```
disable two factors auth:
```
bin/magento module:disable Magento_TwoFactorAuth
```
