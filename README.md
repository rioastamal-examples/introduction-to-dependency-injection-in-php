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

## Read More

My full article about introduction to dependency injection in PHP can be found
on link below. It's in Bahasa Indonesia.

REPLACE_THIS_WITH_ARTICLE_URL

## Author

This example is written by Rio Astamal <rio@rioastamal.net>

## License

This example and it sources is open source licensed under [MIT license](http://opensource.org/licenses/MIT).