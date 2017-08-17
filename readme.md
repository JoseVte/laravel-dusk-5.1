<p align="center"><img src="https://laravel.com/assets/img/components/logo-dusk.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/dusk"><img src="https://travis-ci.org/laravel/dusk.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/dusk"><img src="https://poser.pugx.org/laravel/dusk/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/dusk"><img src="https://poser.pugx.org/laravel/dusk/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/dusk"><img src="https://poser.pugx.org/laravel/dusk/license.svg" alt="License"></a>
</p>

## Laravel 5.1

<p align="center">
<a href="https://travis-ci.org/JoseVte/laravel-dusk-5.1"><img src="https://travis-ci.org/JoseVte/laravel-dusk-5.1.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/josrom/laravel-dusk-5.1"><img src="https://poser.pugx.org/josrom/laravel-dusk-5.1/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/josrom/laravel-dusk-5.1"><img src="https://poser.pugx.org/josrom/laravel-dusk-5.1/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/josrom/laravel-dusk-5.1"><img src="https://poser.pugx.org/josrom/laravel-dusk-5.1/license.svg" alt="License"></a>
</p>

## Introduction

Laravel Dusk provides an expressive, easy-to-use browser automation and testing API. By default, Dusk does not require you to install JDK or Selenium on your machine. Instead, Dusk uses a standalone Chromedriver. However, you are free to utilize any other Selenium driver you wish.

## Official Documentation

Documentation for Dusk can be found on the [Laravel website](https://laravel.com/docs/master/dusk).

## Extra methods

| Method | Definition |
| ------ | ---------- |
| switchFrame | (type of selector, value of selector) |
| select2 | (selector, value(s), wait in seconds) |
| selectBySelector | (selector css, value of selector) |

### Example

Example of payment with paypal using the `switchFrame` method:

```php
$browser->loginAs($user)
    ->visit('/user')
    ->assertSee('Some Event')
    ->clickLink('Register Now')
    ->assertSee('Some Event')
    ->check('accept_terms')
    ->press('Submit Application')
    ->assertSee('Your application has been submitted.')
    ->press('.paypal-button')
    ->waitFor('#injectedUnifiedLogin', 30)
    ->switchFrame('injectedUl')
    ->type('#email', env('PAYPAL_TEST_BUYER_USERNAME'))
    ->type('#password', env('PAYPAL_TEST_BUYER_PASSWORD'))
    ->press('#btnLogin')
    ->waitFor('#confirmButtonTop', 30)
    ->waitUntilMissing('#spinner')
    ->press('#confirmButtonTop')
    ->waitForText('You paid', 30)
    ->waitUntilMissing('#spinner')
    ->press('#merchantReturnBtn')
    ->waitForText('Events Registration', 30)
    ->pause(10000) // waiting for IPN callback from paypal
    ->refresh()
    ->assertSee('Payment verified')
    ;
```

Example of select2 uses:

* For default select2. If value not passed, it be selected automatically:

```php
$browse->select2('@selector');
```

* Another way, if need concrete value:

```php
$browse->select2('@selector', 'you_text_value');
```

* For multiple mode usage like this:

```php
$browse->select2('@selector', ['foo', 'bar'], 5);
```

* Css-selector for the select html tag should be ends with + select2 name:

```html
<select class="form-control select2-users" name="user_id">
</select>
```

```php
$browse->select2('.select2-users + .select2', 'you_text_value');
```

Example of selectBySelector uses:

```php
$browse->selectBySelector('select.my-custom-selector', 'value');
```

## License

Laravel Dusk is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)