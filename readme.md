# Kirby XML Sitemap [![Release](https://img.shields.io/github/release/pedroborges/kirby-xml-sitemap.svg)](https://github.com/pedroborges/kirby-xml-sitemap/releases) [![Issues](https://img.shields.io/github/issues/pedroborges/kirby-xml-sitemap.svg)](https://github.com/pedroborges/kirby-xml-sitemap/issues)

XML Sitemap is a powerful Kirby CMS plugin that generates a nice `sitemap.xml` for your site!

![Kirby XML Sitemap screenshot](https://raw.githubusercontent.com/pedroborges/kirby-xml-sitemap/master/screenshot.png)

## Requirements
- Git
- Kirby 2.4.0+
- PHP 5.4+

## Installation

### Download
[Download the files](https://github.com/pedroborges/kirby-xml-sitemap/archive/master.zip) and place them inside `site/plugins/xml-sitemap`.

### Kirby CLI
Kirby's [command line interface](https://github.com/getkirby/cli) makes installing the XML Sitemap a breeze:

    $ kirby plugin:install pedroborges/kirby-xml-sitemap

Updating couldn't be any easier, simply run:

    $ kirby plugin:update pedroborges/kirby-xml-sitemap

### Git Submodule
You can add the XML Sitemap as a Git submodule.

    $ cd your/project/root
    $ git submodule add https://github.com/pedroborges/kirby-xml-sitemap.git site/plugins/xml-sitemap
    $ git submodule update --init --recursive
    $ git commit -am "Add XML Sitemap plugin"

Updating is as easy as running a few commands.

    $ cd your/project/root
    $ git submodule foreach git checkout master
    $ git submodule foreach git pull
    $ git commit -am "Update submodules"
    $ git submodule update --init --recursive

## Options
The following options can be set in your `/site/config/config.php`:

    c::set('sitemap.include.images', true);
    c::set('sitemap.include.invisible', false);
    c::set('sitemap.ignored.pages', []);
    c::set('sitemap.ignored.templates', []);
    c::set('sitemap.attributes.frequency', false);
    c::set('sitemap.attributes.priority', false);
    c::set('sitemap.transform', null);

## Change Log
All notable changes to this project will be documented at: <https://github.com/pedroborges/kirby-xml-sitemap/blob/master/changelog.md>

## License
XML Sitemap is open-sourced software licensed under the [MIT license](http://www.opensource.org/licenses/mit-license.php).

Copyright © 2017 Pedro Borges <oi@pedroborg.es>
