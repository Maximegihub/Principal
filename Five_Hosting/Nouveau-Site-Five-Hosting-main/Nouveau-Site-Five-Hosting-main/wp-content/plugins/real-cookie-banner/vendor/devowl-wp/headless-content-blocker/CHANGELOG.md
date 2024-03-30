# Change Log

All notable changes to this project will be documented in this file.
See [Conventional Commits](https://conventionalcommits.org) for commit guidelines.

## 0.2.1 (2021-11-12)


### fix

* **critical :** server error when inline style found as blockable, but no URL got blocked inside rules (CU-1rvx2h3)





# 0.2.0 (2021-11-11)


### chore

* remove not-finished translations from feature branches to avoid huge ZIP size (CU-1rgn5h3)


### feat

* allow to calculate unique keys for (blocked) tags
* introduce DoNotBlockScriptTextTemplates plugin (CU-1qe7t0t)
* introduce new afterSetup callback


### fix

* consider line breaks in content blocker attributes (CU-1nfe6kd)
* correctly block inline style when using selector syntax (CU-1nfazd0)


### refactor

* extract content blocker to own package @devowl-wp/headless-content-blocker (CU-1nfazd0)
