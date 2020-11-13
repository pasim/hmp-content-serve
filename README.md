Test instructions

Prerequisites;

- PHP 7.3
- Drush:latest
- PHP composer:latest

Installation
1. Clone this repo
2. Launch the Marida db local container from the root foder "docker-compose up -d"
3. Navigate to code - "cd code/"
4. Run composer install
5. Navigate to web/sites/default and copy default.settings.php to settings.php "cd web/sites/default && cp default.settings.php settings.php && chmod 777 settings.php"
6. Create a files folder and make it writable "mkdir files && chmod -R 777 files" 
7. Get back to web root "cd ../../"
8 Install a drupal test site. "chmod +x site-install.sh && ./site-install.sh" This will be a standard instalation
9. Install easy Install module and dependancies "drush en easy_install media media_library -y"
10. Purge unnecessary config from web run "drush scr clean_up.php" in web root.
11. Enable finally the Prison list module "drush en prison_list -y"
12. You can use build in web server from drush "drush rs" from web root
13. Local site url "http://127.0.0.1:8888/" username: "admin" password: "a210c3c009814fa413f4eeb0de00a4a3"
14. Go ahead and create basic page content as in the test task.
15. Check the url http://127.0.0.1:8888/api/v1/content


