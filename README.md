# LessElephant ![Travis build status](https://secure.travis-ci.org/matteosister/CompassElephant.png)#

A wrapper for the less binary written in PHP

Requirements
------------

- php >= 5.3
- *nix system with less (lessc binary) installed

Dependencies
------------

- [Symfony Finder](https://github.com/symfony/Finder)
- [Symfony Process](https://github.com/symfony/Process)

*for tests*

- [PHPUnit](https://github.com/sebastianbergmann/phpunit)

Installation
------------

**composer**

To install LessElephant with composer you simply need to create a *composer.json* in your project root and add:

``` json
{
    "require": {
        "cypresslab/less-elephant": ">=0.0.1"
    }
}
```

Then run

``` bash
$ wget -nc http://getcomposer.org/composer.phar
$ php composer.phar install
```

You have now LessElephant installed in *vendor/cypresslab/lesselephant*

And an handy autoload file to include in you project in *vendor/.composer/autoload.php*

**pear**

Add the Cypresslab channel

``` bash
$ pear channel-discover pear.cypresslab.net
```

And install the package. *By now LessElephant is in alpha state. So remember the -alpha in the library name*

``` bash
$ pear install cypresslab/LessElephant-alpha
```

On [Cypresslab pear channel homepage](http://pear.cypresslab.net/) you can find other useful information

Testing
-------

The library is tested with PHPUnit.

Go to the base library folder and run the test suites

``` bash
$ phpunit
```

Code style
----------

* LessElephant follows the [Symfony2 Coding Standard](https://github.com/opensky/Symfony2-coding-standard)
* I'm using [gitflow](https://github.com/nvie/gitflow) so, if you want to contribute, please send a pull-request on develop branch

How to use
----------

Remember to **give the user the right permissions to access the filesystem**. If you are using a web server give permissions to both your user and the web server user.

**constructor**

``` php
<?php

$project = new LessProject("/path/to/less/folder", "screen.less", "/path/to/css/screen.css"); // create the base class

// optionally you can pass a project name and a custom LessBinary class
$project = new LessProject(
    "/path/to/less/folder",
    "main_file.less",
    "/path/to/css/file.css",
    "my-awesome-project",
    new LessBinary("/path/to/lessc")
);
```

**manage a less project**

``` php
// return false if the project needs to be recompiled. In other words if you changed something in any of your less files after the last sylesheets generation
if (!$project->isClean()) {
    $project->compile(); // compile the project
}
echo $project->isClean(); // returns true
```

**Staleness Checker**

Compass checks if the project need to be compiled with the awesome [Symfony Finder](https://github.com/symfony/Finder) component, by scanning your source less folder

Symfony2
--------

[AssetsElephantBundle](https://github.com/matteosister/AssetsElephantBundle) let symfony do the work for you