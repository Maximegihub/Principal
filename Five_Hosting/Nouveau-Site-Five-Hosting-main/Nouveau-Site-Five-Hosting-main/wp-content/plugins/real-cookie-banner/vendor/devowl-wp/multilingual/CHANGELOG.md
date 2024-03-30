# Change Log

All notable changes to this project will be documented in this file.
See [Conventional Commits](https://conventionalcommits.org) for commit guidelines.

## 1.9.2 (2021-11-11)


### chore

* remove not-finished translations from feature branches to avoid huge ZIP size (CU-1rgn5h3)


### fix

* plugin PolyLang could not be deactivated if an option in RCB did not exist





## 1.9.1 (2021-10-12)


### fix

* use correct user locale for REST API requests in admin area when different from blog language (CU-1k51hkh)





# 1.9.0 (2021-09-30)


### build

* allow to define allowed locales to make release management possible (CU-1257b2b)
* copy files for i18n so we can drop override hooks and get performance boost (CU-wtt3hy)


### chore

* prepare for continuous localization with weblate (CU-f94bdr)
* refactor texts to use ellipses instead of ... (CU-f94bdr)
* remove language files from repository (CU-f94bdr)
* review english texts (CU-12w4012)


### ci

* introduce continuous localization (CU-f94bdr)


### feat

* introduce new API functions to get country flag and URL for a given locale (CU-cawgkp)


### fix

* allow to translate external URL of imprint and privacy policy page with WPML and PolyLang in customizer (CU-kv7qu2)
* compatibility with PolyLang when syncing is active (CU-11tuby2)


### perf

* remove translation overrides in preference of language files (CU-wtt3hy)


### refactor

* grunt-mojito to abstract grunt-continuous-localization package (CU-f94bdr)
* introduce @devowl-wp/continuous-integration





## 1.8.5 (2021-09-08)


### chore

* **release :** publish [ci skip]


### fix

* compatibility with WPML when taxonomies could not be cloned correctly (CU-yy9r8g)





## 1.8.4 (2021-08-20)


### chore

* update PHP dependencies





## 1.8.3 (2021-08-10)

**Note:** This package (@devowl-wp/multilingual) has been updated because a dependency, which is also shipped with this package, has changed.





## 1.8.2 (2021-05-25)


### chore

* migarte loose mode to compiler assumptions
* upgrade dependencies to latest minor version


### fix

* compatibility with TranslatePress + WP Rocket + BunnyCDN (CU-jn9w79)





## 1.8.1 (2021-05-14)


### fix

* multilingual plugins like Weglot and TranslatePress should show more options in Consent Forwarding setting





# 1.8.0 (2021-05-11)


### feat

* provide iso-3166-1 alpha-2 codes and translations (CU-g53zgk)


### fix

* assign cookie groups and cookies to correct source language after adding a new language to WPML (CU-hz3a83)


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





# 1.7.0 (2021-04-15)


### feat

* allow to lock current translations (CU-gt3kam)
* introduce a new class CopyContent that allows you to copy one language to another one completely or individually (CU-gt3kam)
* introduce new filter to skip language iterations and allow referencing Sync instances (CU-gt3kam)


### fix

* allow to set privacy policy URL per language (WPML, PolyLang, CU-gq33k2)
* usage with PolyLang with more than two languages (CU-gt3kam)





## 1.6.1 (2021-03-30)


### refactor

* use composer autoload to setup constants and package localization





# 1.6.0 (2021-03-23)


### chore

* **release :** publish [ci skip]


### feat

* introduce Weglot compatibility (CU-fd0cmc)


### fix

* array offset notice directly after installing WPML (CU-e8x3em)





## 1.5.1 (2021-02-24)


### chore

* introduce empty class for Weglot


### fix

* do not translate gettext texts with TranslatePress cause it adds some weired characters (CU-egxxjh)
* strip gettext texts for TranslatePress (CU-egxxjh)





# 1.5.0 (2021-02-16)


### feat

* introduce new function to iterate all language contexts
* introduce new Output Buffer plugins and TranslatePress compatibility (CU-cew7v9)


### fix

* add TranslatePress stub to translate a complete page
* compatibility with TranslatePress (CU-cew7v9)
* compatibility with WPML and PolyLang; defaults are not correctly created on installation (CU-e50f0d)


### perf

* do not translate JSON with TranslatePress, use single HTML string





# 1.4.0 (2021-02-02)


### feat

* introduce translations for output buffer plugins (TranslatePress, CU-dd4a3q)





## 1.3.5 (2021-01-24)


### refactor

* remove unused classes and methods





## 1.3.4 (2021-01-18)


### fix

* allow Show all languages in PolyLang and WPML (CU-cjyzay)





## 1.3.3 (2021-01-11)


### build

* reduce javascript bundle size by using babel runtime correctly with webpack / babel-loader


### chore

* **release :** publish [ci skip]
* **release :** publish [ci skip]


### fix

* wrong language for duplicated cookie when using PolyLang default language in admin dashboard





## 1.3.2 (2020-12-09)


### chore

* update to webpack v5 (CU-4akvz6)
* updates typings and min. Node.js and Yarn version (CU-9rq9c7)
* **release :** publish [ci skip]





## 1.3.1 (2020-12-01)


### chore

* update to composer v2 (CU-4akvjg)
* update to core-js@3 (CU-3cj43t)
* **release :** publish [ci skip]
* **release :** publish [ci skip]





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

* introduce LanguageDependingOption (#84mnnc)


### fix

* import settings (#82rk4n)
* use language for non-WPML pages in cookie / blockers presets cache key (#86wk0t)





## 1.1.1 (2020-08-20)


### fix

* improved content blocker with WPML / PolyLang (#6jggau)





# 1.1.0 (2020-08-17)


### feat

* introduce @devowl-wp/multilingual package (#4wqqym)





# 1.1.0 (2020-08-17)


### feat

* introduce @devowl-wp/multilingual package (#4wqqym)
