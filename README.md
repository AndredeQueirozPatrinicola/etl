# ETL FFLCH

## Deployment instructions

First, have all the project's dependencies installed:

```
composer install
```

Make a copy of *.env.example* and configure your *.env*:

```
cp .env.example .env
```

After your database is set up, you may create (or recreate) the tables and populate them:

```
php build.php && php lattes.php
```

Finally, if you'd like to drop all tables, you may run:

```
php drop.php
```