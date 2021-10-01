# Lendinvest investment calculator

Composer based project, no framework
Language: PHP (min v7.3)
Libraries:
```
"require": {
  "php": "^7.3",
  "ext-curl": "*",
  "ext-json": "*"
},
"require-dev": {
  "phpunit/phpunit": "^9.3"
},
```

Code owner: Zoltan Nagy <nzolthu@gmail.com> 

### Acceptance Criteria:
- See in provided pdf document.

- Can be run in demo container, docker-compose.yml provided. 

### Start:

- user@host$ docker-compose -up [-d]
- user@host$ docker exec -ti app-lin bash
- root@app-lin$ cd /var/www/app/
- root@app-lin$ composer install (composer 2.*)
- root@app-lin$ php app.php (demo)
- root@app-lin$ php vendor/bin/phpunit --group [unit|ready]
__________________________________________________________________________________________
root@app-lin:/var/www/app# php ./vendor/bin/phpunit --group unit
PHPUnit 9.5.10 by Sebastian Bergmann and contributors.

Runtime:       PHP 7.4.3
Configuration: /var/www/app/phpunit.xml
Random Seed:   1633101023
Warning:       No code coverage driver available

......................                                            22 / 22 (100%)

Time: 00:00.077, Memory: 8.00 MB

OK (22 tests, 38 assertions)
__________________________________________________________________________________________

### TODO:

- Add Date validation for input date strings.
- Ideally add more documentation.
