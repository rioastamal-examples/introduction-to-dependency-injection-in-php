## About

This example contains simple introduction to Dependency Injection (DI) in PHP.
In simple term Dependency Injection is design principle where dependencies of
an object are provided (injected) as an argument rather than the object
creating it internally inside its own class.

This example uses Mailer class to demonstrate the use of dependency injection.
Here's how we build Mailer object using DI principle.

```php
$email = new Email($to, $subject, $body, $from);
$transport = new PhpMailTransport();
$mailer = new Mailer($emal, $transport);
$mailer->send();
```

As you can see above we are injecting the dependencies of Mailer class as an
arguments of the class constructor.

## How To Run

To run this example you need to clone or download the source code from github.
You will also need composer to install all the dependency packages.

```
$ git clone git@github.com:rioastamal/introduction-to-dependency-injection-in-php.git
$ cd introduction-to-dependency-injection-in-php
$ composer install
$ php -S 127.0.0.1:8080 -t public/
```

Open your web browser point to http://localhost:8080 to test the application.
Keep in mind, if you use PhpMailTransport class you need to provide working
local smtp server.

To run the unit test simply issue command below.

```
$ phpunit
PHPUnit 6.5.7 by Sebastian Bergmann and contributors.

.                                                                   1 / 1 (100%)

Time: 159 ms, Memory: 8.00MB

OK (1 test, 5 assertions)
```

## Improvement

Please create SmtpMailTransport class to support sending email using SMTP
protocol and also SMTP authentication.

## Read More

My full article about introduction to dependency injection in PHP can be found
on link below. It's in Bahasa Indonesia.

REPLACE_THIS_WITH_ARTICLE_URL

## Author

This example is written by Rio Astamal <rio@rioastamal.net>

## License

This example and it sources is open source licensed under [MIT license](http://opensource.org/licenses/MIT).