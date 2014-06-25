# Driver file cache - Fcache
========

**Driver file cache, separation key-folder, Laravel 4 integration. Driver file cache folder Fcache builds based on the transmitted key.**

## Quick Start

You can install this Image class quickly and easily with Composer.

Require the package via Composer in your composer.json.

```php
"artdevue/fcache": "dev-master"
```

Run Composer to install or update the new requirement. 

```php
$ composer update
```
## Laravel 4 Integration

The Fcache Cache class supports Laravel 4 integration. Best practice to use the library in Laravel 4 is to add the ServiceProvider of the Intervention Fcache.

Open your Laravel config file config/app.php and add the following lines.

In the *$providers* array add the service providers for this package.

```php
'Artdevue\Fcache\FcacheServiceProvider'
```
Open your Laravel global file start/global.php and add the following lines.

```php
Cache::extend('fcache', function($app)
{
    $store = new Artdevue\Fcache\Fcache;
    return new Illuminate\Cache\Repository($store);
});
```
## Usage

Open your Laravel config file config/cache.php and change driver.
```php
'driver' => 'fcache',
```
**Note!** All commands are identical to the driver file cache, except *flush*

To create a directory cache, enough to separate the slash key directory, the file will be the last word.

For example, create the key *folder/onesubfolder/onefile* , The system will create subfolders - *folder* and *onesubfolder*, and the file *onefile.cache*
```php
folder
	onesubfolder
		onefile.cache
		twofile.cache
	twosubfolder
		onefile.cache
		twofile.cache
file.cache
```
With the file cache Fcache, we can delete the entire cache, and the cache folder.




**Note!** If you have a web site is not connected JQuery, then the call must specify the *&jsConnect=`true`*, and the call should look like this

```php
[[likeCssjs? &jsConnect=`true`]]
```

## Basic Configuration

Before you start using LikeDislike, you can customize it to fit your work priorities. You can configure Cookies, IP and user id

The main settings are located in LikeDislike System Settings, in the section *"likedislike"*.

All tips are described in the comments for each configuration.

## Admin panel

By selecting the top menu under *"Components"* - LikeDislike, you are in control LikeDislike.

You can keep track of your objects, delete them, close the vote. Added to the blocked IP addresses of users who are not eligible to vote.

## Creating

You can create LikeDislike click anywhere on the page. To do this, add the snippet call:

```php
[[!LikeDislike? &name=`ITEM_NAME`]]
```

The item name (ITEM_NAME) may be omitted if you visit a call LikeDislike, because the default name equally **pagetitle**.

**Remember!** , that the element name must be unique on a single resource or exclusion.

Call LikeDislike should **NOT CACHE**

## Added property to display the results in the field of TV or a resource 

in more [detail](http://like.artdevue.com/en/help.html#output-target)

### More on the election of the template and output format on the page [help](http://like.artdevue.com/en/help.html)

### Authors
<table>
  <tr>
    <td><img src="http://www.gravatar.com/avatar/39ef1c740deff70b054c1d9ae8f86d02?s=60"></td><td valign="middle">Valentin Rasulov<br>artdevue.com<br><a href="http://artdevue.com">http://artdevue.com</a></td>
  </tr>
</table>
