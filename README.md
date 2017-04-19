[![Build Status](https://travis-ci.org/borNfreee/SimpleHabits.svg?branch=master)](https://travis-ci.org/borNfreee/SimpleHabits) [![StyleCI](https://styleci.io/repos/65413292/shield)](https://styleci.io/repos/65413292)
[![codecov](https://codecov.io/gh/borNfreee/SimpleHabits/branch/master/graph/badge.svg)](https://codecov.io/gh/borNfreee/SimpleHabits)

Habits and Goals tracker

Code Coverage
================

* `bin/phpunit`
* `bin/phpspec run`
* `phpcov merge /tmp --clover coverage.xml`

Xdebug (homestead)
================

`phpenmod xdebug` / `phpdismod xdebug`
   * creates symlink: `/etc/php/7.1/cli/conf.d/20-xdebug.ini`

`service php7.1-fpm restart`