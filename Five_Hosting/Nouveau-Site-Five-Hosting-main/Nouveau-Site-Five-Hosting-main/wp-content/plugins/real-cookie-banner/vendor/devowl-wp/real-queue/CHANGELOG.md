# Change Log

All notable changes to this project will be documented in this file.
See [Conventional Commits](https://conventionalcommits.org) for commit guidelines.

## 0.2.7 (2021-11-18)


### fix

* rename some cookies to be more descriptive about their origin (CU-1tjwxmr)





## 0.2.6 (2021-11-11)


### chore

* remove not-finished translations from feature branches to avoid huge ZIP size (CU-1rgn5h3)





## 0.2.5 (2021-11-03)


### perf

* do only fetch status for active tabs (CU-1my8jgf)





## 0.2.4 (2021-09-30)


### build

* allow to define allowed locales to make release management possible (CU-1257b2b)
* copy files for i18n so we can drop override hooks and get performance boost (CU-wtt3hy)


### chore

* prepare for continuous localization with weblate (CU-f94bdr)
* remove language files from repository (CU-f94bdr)


### ci

* introduce continuous localization (CU-f94bdr)


### fix

* translate error dialog (CU-1257b2b)


### perf

* remove translation overrides in preference of language files (CU-wtt3hy)


### refactor

* grunt-mojito to abstract grunt-continuous-localization package (CU-f94bdr)
* introduce @devowl-wp/continuous-integration





## 0.2.3 (2021-09-08)


### fix

* queue hangs on 1% in Real Cookie Banner plugin (CU-11eccpg)





## 0.2.2 (2021-08-20)


### chore

* update PHP dependencies





## 0.2.1 (2021-08-11)


### fix

* timeout for websites with more than 30,000 sites to scan (database table could not be cleared correctly)





# 0.2.0 (2021-08-10)


### chore

* translations into German (CU-pb8dpn)


### feat

* add new checklist item to scan the website (CU-mk8ec0)
* allow to fetch queue status and delete jobs by type (CU-m57phr)
* initial commit with working server-worker queue (CU-kh49jp)
* introduce client worker and localStorage restore functionality (CU-kh49jp)
* introduce new event to modify job delay depending on idle state
* introduce new JobDone event
* prepare new functionalities for the initial release (CU-kh49jp)
* proper error handling with UI when e.g. the Real Cookie Banner scanner fails (CU-7mvhak)


### fix

* automatically refresh jobs if queue is empty and there are still remaining items
* be more loose when getting and parsing the sitemap
* do not add duplicate URLs to queue
* do not enqueue real-queue on frontend for logged-in users
* localStorage per WordPress instance to be MU compatible
* only run one queue per browser session
* review 1 (CU-mtdp7v, CU-n1f1xc)
* review 1 (CU-nd8ep0)
* review 2 (CU-7mvhak)
* review user tests #2 (CU-nvafz0)
* tab locking did not work as expected and introduced worker notifications


### perf

* speed up scan process by reducing server requests (CU-nvafz0)


### refactor

* split i18n and request methods to save bundle size
