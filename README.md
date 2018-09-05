# Sixt test assignment

## Installation

1. Clone repo

```
git clone https://github.com/dimichspb/sixt
```

2. Change directory

```
cd sixt
```

3. Install dependenies

```
composer install
```

## Configuration

1. Define default values

```
bootstrap\Bootstrap.php
```

2. Setup apache configuration

```
<VirtualHost *:80>
    DocumentRoot "C:/Projects/PHP/sixt/web"
    ServerName sixt.localhost
    <Directory "C:/Projects/PHP/sixt/web">
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all Granted
    </Directory>
</VirtualHost>
```

3. Restart apache service

```
apachectl restart
```

4. Configure database connection:

```
config\db.php
```

5. Apply migrations:

```
php yii migrate
```

## Usage

1. Web GUI

```
http://sixt.localhost
```

2. REST API

```
http://sixt.localhost/api/request/quotations
```

3. Console

```
php yii request/quotations
```

## Tests

```
codecept run
```

## TODOs

1. ~~Implement GoogleMapWidget~~
2. ~~Add DateTimeWidget to the request form~~
3. ~~Implement database storage for Commissions~~
4. ~~Implement history of requests~~
5. Implement cache
6. Implement authentication
7. Implement authorization
8. Move MyDriver SDK to stand-alone repository