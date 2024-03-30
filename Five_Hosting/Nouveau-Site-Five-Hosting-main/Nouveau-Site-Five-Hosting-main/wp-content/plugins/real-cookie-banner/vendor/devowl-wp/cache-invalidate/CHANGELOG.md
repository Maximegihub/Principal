# Change Log

All notable changes to this project will be documented in this file.
See [Conventional Commits](https://conventionalcommits.org) for commit guidelines.

## 1.4.9 (2021-11-18)


### fix

* compatibility with Swift Performance (CU-m17wmf)





## 1.4.8 (2021-11-11)


### chore

* remove not-finished translations from feature branches to avoid huge ZIP size (CU-1rgn5h3)





## 1.4.7 (2021-09-30)


### build

* allow to define allowed locales to make release management possible (CU-1257b2b)


### chore

* prepare for continuous localization with weblate (CU-f94bdr)
* remove language files from repository (CU-f94bdr)


### ci

* introduce continuous localization (CU-f94bdr)


### refactor

* grunt-mojito to abstract grunt-continuous-localization package (CU-f94bdr)
* introduce @devowl-wp/continuous-integration





## 1.4.6 (2021-09-08)


### fix

* use non-CLI command API function to purge cache for WP Optimize (CU-10huz72)





## 1.4.5 (2021-08-31)


### fix

* exclude assets for WP Optimize (CU-raprnr)





## 1.4.4 (2021-08-20)


### chore

* update PHP dependencies





## 1.4.3 (2021-08-10)

**Note:** This package (@devowl-wp/cache-invalidate) has been updated because a dependency, which is also shipped with this package, has changed.





## 1.4.2 (2021-07-09)


### fix

* compatibility with WP Rocket 3.9 (CU-nkav4w)





## 1.4.1 (2021-05-25)


### build

* migrate loose to compiler assumptions (babel)


### chore

* prettify code to new standard





# 1.4.0 (2021-05-11)


### feat

* native compatibility with preloading and defer scripts with caching plugins (CU-h75rh2)


### refactor

* create wp-webpack package for WordPress packages and plugins
* introduce eslint-config package
* introduce new grunt workspaces package for monolithic usage
* introduce new package to validate composer licenses and generate disclaimer
* introduce new package to validate yarn licenses and generate disclaimer
* introduce new script to run-yarn-children commands
* move build scripts to proper backend and WP package
* move jest scripts to proper backend and WP package
* move PHP Unit bootstrap file to @devowl-wp/utils package
* move PHPUnit and Cypress scripts to @devowl-wp/utils package
* move WP build process to @devowl-wp/utils
* move WP i18n scripts to @devowl-wp/utils
* move WP specific typescript config to @devowl-wp/wp-webpack package
* remove @devowl-wp/development package





## 1.3.3 (2021-01-11)


### build

* reduce javascript bundle size by using babel runtime correctly with webpack / babel-loader





## 1.3.2 (2020-12-09)


### chore

* update to webpack v5 (CU-4akvz6)
* updates typings and min. Node.js and Yarn version (CU-9rq9c7)





## 1.3.1 (2020-12-01)


### chore

* update to composer v2 (CU-4akvjg)





# 1.3.0 (2020-10-23)


### feat

* route PATCH PaddleIncompleteOrder (#8ywfdu)





## 1.2.2 (2020-10-08)


### chore

* **release :** version bump





## 1.2.1 (2020-09-29)


### build

* backend pot files and JSON generation conflict-resistent (#6utk9n)


### chore

* introduce development package (#6utk9n)
* move backend files to development package (#6utk9n)
* move grunt to common package (#6utk9n)
* move packages to development package (#6utk9n)
* move some files to development package (#6utk9n)
* update dependencies (#3cj43t)
* update package.json script for WordPress packages (#6utk9n)





# 1.2.0 (2020-09-22)


### feat

* invalidate Borlabs Cache automatically (#8cpz9n)





## 1.1.3 (2020-09-22)


### fix

* import settings (#82rk4n)





## 1.1.2 (2020-08-17)


### ci

* prefer dist in composer install


### fix

* nginx-helper with PhpRedis





## 1.1.1 (2020-08-11)


### chore

* backends for monorepo introduced





# 1.1.0 (2020-07-30)


### feat

* introduce dashboard with assistant (#68k9ny)
