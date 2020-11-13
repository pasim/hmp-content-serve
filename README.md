Test instructions

Prerequisites;

PHP 7.3
Drush - latest
PHP composer - latest

Installation
1. Clone this repo
2. Launch the Marida db local container from the root foder "docker-compose up -d"
3. Navigate to code - "cd code/"
4. Run composer install
5. Navigate to web/sites/default and copy default.settings.php to settings.php "cd web/sites/default && cp default.settings.php settings.php && chmod 777 settings.php"
6. Create a files folder and make it writable "mkdir files && chmod -R 777 files" 
7. Get back to web root "cd ../../"
8 Install a drupal test site. "chmod +x site-install.sh && ./site-install.sh"
