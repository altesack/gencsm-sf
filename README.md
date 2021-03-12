# About the application
I think it could be a genealogy engine, but now it's just a stub. Actually this part is a backend. 
Symfony 5 is used.

One day I will write a frontend part :)

# Requirements
* PHP 7.2
* composer
* some RDBMS (MySQL, SQLite or whatever else)

# Installation

* clone the repository
```
git clone https://github.com/altesack/books_simple_crud_app_backend.git
```
* install packages
```
composer install
```
* create empty database on your RDBMS with your favorite tool
* copy `.end` to the `.env.local`
* edit your `.env.local` and put there your DB credentials and other DB config
* create the schema
```
./bin/console doctrine:schema:update --force
```
* To run it on your local you can start php in server mode
```
./bin/console server:start
```

