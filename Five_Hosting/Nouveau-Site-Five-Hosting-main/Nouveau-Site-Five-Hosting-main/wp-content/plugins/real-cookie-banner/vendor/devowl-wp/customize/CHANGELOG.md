# Change Log

All notable changes to this project will be documented in this file.
See [Conventional Commits](https://conventionalcommits.org) for commit guidelines.

## 1.8.7 (2021-11-11)


### chore

* remove not-finished translations from feature branches to avoid huge ZIP size (CU-1rgn5h3)





## 1.8.6 (2021-09-30)


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





## 1.8.5 (2021-08-20)


### chore

* update PHP dependencies





## 1.8.4 (2021-08-12)


### fix

* customizer did not load correctly (CU-u3q46w)





## 1.8.3 (2021-08-10)


### chore

* translations into German (CU-pb8dpn)


### fix

* check if panel exists and return boolean in some API functions (CU-rp0p10)





## 1.8.2 (2021-07-16)


### fix

* customizer prints Array as input value for CSS margin / padding fields (CU-nva63b)





## 1.8.1 (2021-05-25)


### chore

* migarte loose mode to compiler assumptions
* polyfill setimmediate only if needed (CU-jh3czf)
* prettify code to new standard
* upgrade dependencies to latest minor version





# 1.8.0 (2021-05-11)


### feat

* add contrast ratio (luminosity) calculator and validator (CU-cq25hu)
* introduce new filter DevOwl/Customize/Sections/$panel


### fix

* compatibility with Customizer checkbox values and Redis Object Cache (CU-jd4662)
* print description for TinyMCE control (CU-cq1rka)


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





## 1.7.4 (2021-04-27)


### fix

* banner overlay not shown when number format was individually configured on your server (CU-h977nc)





## 1.7.3 (2021-04-15)


### chore

* **release :** publish [ci skip]
* **release :** publish [ci skip]


### fix

* allow to Add Media in banner description





## 1.7.2 (2021-02-16)


### fix

* compatibility with users which have disabled the visual editor in their profile
* use correct ID for none-visual editors





## 1.7.1 (2021-02-02)


### fix

* translated page in footer is not shown in PolyLang correctly (CU-d6wumw)





# 1.7.0 (2021-01-24)


### feat

* allow to make customizer fields resettable with a button (CU-crwyqn)





# 1.6.0 (2021-01-18)


### feat

* make texts in cookie banner more customizable (CU-cjy9gd)





## 1.5.3 (2021-01-11)


### build

* reduce javascript bundle size by using babel runtime correctly with webpack / babel-loader


### chore

* **release :** publish [ci skip]
* **release :** publish [ci skip]





## 1.5.2 (2020-12-09)


### chore

* update to webpack v5 (CU-4akvz6)
* updates typings and min. Node.js and Yarn version (CU-9rq9c7)
* **release :** publish [ci skip]





## 1.5.1 (2020-12-01)


### chore

* update dependencies (CU-3cj43t)
* update to composer v2 (CU-4akvjg)
* update to core-js@3 (CU-3cj43t)
* **release :** publish [ci skip]
* **release :** publish [ci skip]





# 1.5.0 (2020-10-23)


### feat

* route PATCH PaddleIncompleteOrder (#8ywfdu)


### refactor

* use "import type" instead of "import"





# 1.4.0 (2020-10-16)


### chore

* rename folder name (#94xp4g)


### feat

* add checklist in config page header (#8cxk67)





## 1.3.2 (2020-10-08)


### chore

* **release :** version bump





## 1.3.1 (2020-09-29)


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





# 1.3.0 (2020-09-22)


### feat

* CustomHTML control so you can e. g. show notices (#86wk0t)
* introduce LanguageDependingOption (#84mnnc)


### fix

* import settings (#82rk4n)





## 1.2.3 (2020-08-31)


### fix

* review 1 (#6utam1)





## 1.2.2 (2020-08-28)


### fix

* register options autoload in plugins init hook (#74t83a)





## 1.2.1 (2020-08-26)


### ci

* install container volume with unique name (#7gmuaa)


### perf

* remove transients and introduce expire options for better performance (#7cqdzj)





# 1.2.0 (2020-08-17)


### ci

* prefer dist in composer install


### feat

* add filter to modify customize value
* allow controlled SameSectionAccordion
* finished PolyLang compatibility (#4wqqym)
* introduce rich editor in customize controls (#6wtzrg)





## 1.1.1 (2020-08-11)


### chore

* backends for monorepo introduced





# 1.1.0 (2020-07-30)


### feat

* correction of the English texts in the backend #CU-6mtd2n
* introduce dashboard with assistant (#68k9ny)





## 1.0.3 (2020-07-02)


### chore

* allow to define allowed licenses in root package.json (#68jvq7)
* update dependencies (#3cj43t)





## 1.0.2 (2020-06-12)


### chore

* i18n update (#5ut991)


### ci

* use hot cache and node-gitlab-ci (#54r34g)





## 1.0.1 (2020-05-20)


### chore

* move plugin/rcb branch to develop
