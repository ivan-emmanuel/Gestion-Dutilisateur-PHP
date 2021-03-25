##  PHP Users management / account system in Oriented Object Programming
#### Open source account system in PHP  without using a Framework

#### this project is for learn PHP.  It may therefore contain bad code. consider this aspect using it ...

### Features
| Members Space Features                                       |
| :----------------------------------------------------------- |
| Creation of Admin account before first use                   |
| Account confirmation by email send with a confirmation token |
| User registration and management by Admin user               |
| User registration Confirmation with  email  a password token |
| Easy deployment with configuration files                     |


### Libraries

| Backend libraries                                            |
| :----------------------------------------------------------- |
| Database migration by [Phinx](https://phinx.org) Package     |
| Mail send  by [swiftmailer](https://swiftmailer.symfony.com/docs/introduction.html) Package |


| Frontend libraries                                           |
| :----------------------------------------------------------- |
| [animatedModal](https://joaopereirawd.github.io/animatedModal.js/) |
| [bootstrap](https://getbootstrap.com/docs/4.3/getting-started/introduction/) |
| [Bootwatch Yeti](https://bootswatch.com/yeti/)               |
| [Datatables](https://datatables.net/)                        |
| [fontawesome](https://fontawesome.com/v4.7.0/)               |
| [jquery](https://jquery.com/)                                |
| [select2](https://select2.org/)                              |

### Installation Instructions
1. Run `git clone ...`
2. Create a MySQL database for the project ```mysql -u root -p -e "create database users" ```
3. Run `cd   ...` to open project root folder
4. Run `composer install && composer dump-autoload` from the projects root folder
5. Run `mysql -u root -p  users < db\db.sql` 
7. Run `php -S 127.0.0.2:80 -t web` to start PHP FPM server
8. Launch application in your browser on [http://127.0.0.2/](http://127.0.0.2)

### Seeds
* [UserTableSeeder.php](https://github.com/ledevivan/.../blob/master/db/seeds/UserTableSeeder.php)


##### Seeded Users
| login    | Email           | Password |
| :------- | :-------------- | :------- |
| tester1  | tester1@app.com | tester1  |
| tester2  | tester2@app.com | tester2  |
| tester3  | tester3@app.com | tester3  |
| tester4  | tester4@app.com | tester4  |
| tester15 | tester5@app.com | tester5  |



### Configs
#### Config File
Here is a list of the custom config files that have been added or modified to the project:
* `configs/app.php` : global application configurations
* `configs/local.php` : locals application configurations
* `configs/production.php` : production application configurations


Open source projects are the community’s responsibility to use, contribute, and debug.

### License
The license is licensed under the [MIT license](https://opensource.org/licenses/MIT). Enjoy!**
