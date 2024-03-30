# Change Log

All notable changes to this project will be documented in this file.
See [Conventional Commits](https://conventionalcommits.org) for commit guidelines.

# 2.10.0 (2021-11-18)


### feat

* new content blocker template Elementor Forms with Google reCAPTCHA (CU-nqbu52)


### fix

* add TCF stub to anti-ad-block system (CU-1phrar6)
* compatiblity with Themeco X Pro page builder (CU-11eagky)
* consents could not be given in private wordpress.com sites (CU-1td2p11)
* do not show all Facebook services when only one is found (CU-1nn1qrg)
* missing Linkedin Partner ID in service template for noscript fallback (CU-rga6b3)
* rename some cookies to be more descriptive about their origin (CU-1tjwxmr)
* show a warning in main settings page when the user is using an adblocker (CU-1hwuugw)
* show essential services' labels in content blocker form (CU-p5fgk8)
* show notice if GTM/MTM is not defined as service but setted as manager (CU-z9n7g2)
* with some MySQL database versions the scanner found external URLs are not displayed (CU-1tjtn8q)


### refactor

* save user country in consent itself instead of independent revision (CU-1tjy2nr)





## 2.9.3 (2021-11-12)

**Note:** This package (@devowl-wp/real-cookie-banner) has been updated because a dependency, which is also shipped with this package, has changed.





## 2.9.2 (2021-11-11)


### chore

* remove not-finished translations from feature branches to avoid huge ZIP size (CU-1rgn5h3)


### fix

* block Google Analytics embedded via Rank Math as locally hosted gtag (CU-1q2x5pa)
* block Google Maps in Elementor widget
* block gtag events in WooCommerce Enhanced Tracking (CU-1qe7tam)
* compatibility with latest Ninja Forms update (CU-1uf8fq9)
* compatibility with Modern Events Calendar and Google Maps (CU-1qecxy4)
* compatibility with UCSS / CCSS in LiteSpeed Cache plugin (CU-1m1h4mh)
* content blocker for Google Maps in WPResidence theme
* correctly display special characters in page dropdown in settings (CU-1phmb9g)
* correctly filter modified publisher restrictions for TCF purposes (CU-1rarxc7)
* do not block content in script text templates (CU-1qe7t0t)
* filter by URL with more accurate pure referer respecting current permalink settings (CU-ad0gf1)
* redirect back to scanner when creating the WooCommerce service (service without content blocker, CU-1nn08eb)


### refactor

* extract content blocker to own package @devowl-wp/headless-content-blocker (CU-1nfazd0)
* extract HTML-extractor to own package @devowl-wp/fast-html-tag


### style

* line height in header of elementor widget so content blocker text does not overlap





## 2.9.1 (2021-11-03)


### fix

* create visual content blocker within responsive container (like Vimeo, CU-1mju68j)
* do not lazy load Code on page load scripts when WP Rocket is active (CU-1mjk6cn)
* never block inline scripts only holding JSON objects (CU-1mjv9gh)
* try to find possible visual content blockers in hidden modals (CU-1my8az3)
* warning in PHP 8 when creating a new service (CU-1my8zcu)
* warning in PHP 8 when using WP CLI (CU-1my8zcu)





# 2.9.0 (2021-10-12)


### ci

* remove some jobs no longer needed in CI (CU-1jtj4fg)


### feat

* allow to filter by context, period and URL in list of consents (CU-ad0gf1)
* block Vimeo Showcases in Vimeo content blocker
* new service and content blocker template Taboola (CU-n1bn4x)


### fix

* allow to reset group texts correctly for the current blog language (CU-1k51cgn)
* compatibility with Extension for Elementor plugin (CU-1kvu486)
* compatibility with Meow Lightbox (CU-1m784c9)
* compatibility with WP Google Maps Gold add-on (CU-1kankt3)
* compatiblity with Groove Mneu Plugin (CU-1kgeggn)
* do not allow to import PRO templates in free version as we cannot ensure up-to-date (CU-1bzrthu)
* do not show empty context in context dropdown if there were already consents
* do not try to expose empty hosts / URLs in content blocker settings (CU-1k51ax2)
* remove Google Adsense warnings in console when ads are initialized multiple times (CU-1m7c86a)
* scanner did not found Google reCAPTCHA when used standalone (CU-1kvurfe)
* show fallback language for language context is list of consents
* use correct user locale for REST API requests in admin area when different from blog language (CU-1k51hkh)


### perf

* block very (very) large inline CSS (like fusion builder does) took up to 5 seconds (CU-1kvpuwz)





# 2.8.0 (2021-09-30)


### build

* allow to define allowed locales to make release management possible (CU-1257b2b)
* copy files for i18n so we can drop override hooks and get performance boost (CU-wtt3hy)


### chore

* english translation revision (CU-vhmn9k)
* prepare for continuous localization with weblate (CU-f94bdr)
* remove language files from repository (CU-f94bdr)
* rename 'Statistic' to 'Statistics' (CU-12gwu5r)
* translation review round 2 (CU-vhmn9k)


### ci

* introduce continuous localization (CU-f94bdr)


### feat

* allow to declare an external URL for imprint and privacy policy page (CU-kv7qu2)


### fix

* allow to translate external URL of imprint and privacy policy page with WPML and PolyLang in customizer (CU-kv7qu2)
* backwards-compatible Statistic cookie group naming for service templates (CU-12gwu5r)
* block content also on pages which got declared as hidden in cookie settings (CU-1jkue32)
* block Google Maps in Adava with Fusion Builder as "Fusion Google Map" (CU-12b2jft)
* content blocker for Google Maps in Avada theme
* custom config for COOKIEPATH never should be empty (CU-1jth67d)
* do not follow CORS redirected URLs in scanner (CU-11m6me9)
* do not show cookie banner in legacy widget preview coming with WP 5.8 (CU-1jdzfnn)
* link for customer center in Licensing tab not present (CU-vhmn9k)
* make animations work again in Divi page builder when a custom link with blocked URL got created (CU-1jz6bgn)
* save job result for cors requests while scanning pages (CU-1je508f)
* scanner threw an error when using WP < 5.5 and deleting a file


### perf

* remove translation overrides in preference of language files (CU-wtt3hy)


### refactor

* grunt-mojito to abstract grunt-continuous-localization package (CU-f94bdr)
* introduce @devowl-wp/continuous-integration
* introduce new command with execa instead of own exec implementation


### style

* do line break content blocker buttons (CU-12b05vm)





# 2.7.0 (2021-09-08)


### chore

* translate new service templates (CU-yrgfkk)


### docs

* mention support for automatic video playback for Dailymotion and Loom at wordpress.org (CU-yrge7n)


### feat

* autoplay for Loom and Dailymotion (CU-yrge7n)
* new service and content blocker template Dailymotion (CU-n1f306)
* new service and content blocker template Giphy (CU-mt8ktd)
* new service and content blocker template LinkedIn Ads (Insight Tag, CU-rga6b3)
* new service and content blocker template Loom (CU-u9fxx7)
* new service and content blocker template OpenStreetMap (CU-pn8mu0)
* new service and content blocker template TikTok Pixel (CU-p1a7av)
* new service and content blocker template WordPress Plugin embed (CU-p382wk)


### fix

* adjust texts for powered-by link (CU-we5cq1)
* allow force hidden also for absolute positioned content like Dailymotion embed
* bypass CMP – Coming Soon & Maintenance Plugin when scanning a site (CU-118ud0m)
* bypass Under Construction by WebFactory plugin when scanning a site (CU-118ud0m)
* compatibility with lazysizes (used e.g. in EWWW, CU-11ehp99)
* content blocker removes inline style in some cases (e.g. when parent is wrapper)
* do not clear cache too often when accesing the Dashboard and no consents are given yet (CU-10huz72)
* extract @font-face CSS rules correctly (Divi latest update, CU-118mpjh)
* php logging Undefined offset: 1 in scanner/Query.php
* server error when content blocker finds CSS style which does not represent an URL (CU-10hruca)
* transmit realCookieBannerOptInEvents and realCookieBannerOptOutEvents variable to GTM/MTM data layer (CU-118ugwy)
* wrong GTM template variables for AddToAny service





## 2.6.5 (2021-08-31)


### fix

* add missing script to be scanned for Google Adsense (CU-yyep3k)
* allow to unblock nested jQuery ready functions (WP Google Maps, CU-wkyk4h)
* compatibility with latest PHP version 8.0.9
* compatibility with latest Thrive Leads plugin version (CU-yrkt9b)
* compatibility with latest Thrive themes & plugins (global CSS variables, CU-wkuq39)
* compatibility with Thrive Quiz Builder (CU-yjt538)
* console warning when google maps is used but jQuery is not yet ready on page load
* decode URLs differently than e.g. JSON attributes when unblocking content (CU-z3zua1)
* do not try to apply content blocker to rewritten endpoints which server downloads / binary data (CU-z9qhnd)
* make CSS functions work when they are blocked via Content Blocker (CU-wkuq39)
* scanner should not find link rel=author links
* with some caching plugins enabled the consent can no longer be saved after x hours (CU-wtj9td)





## 2.6.4 (2021-08-20)


### chore

* update PHP dependencies


### docs

* use redirects for legal documents


### fix

* allow emojis in cookie banner and content blocker (CU-u3xv7j)
* banner not visible for older safari and internet explorer browser (CU-vhq9jn)
* banner not visible for older safari and internet explorer browser (CU-vhq9jn)
* compatibility with latest Avada Fusion Builder (live editor, CU-u9mb2h)
* consider non-WWW host as same host and do not detect as external URL (CU-u9m6rv)
* consider WWW subdomain also for link preconnects and dns-prefetch for the correct template (CU-u9m5e5)
* cookie banner history dropdown gets wrong font color (CU-u9m484)
* do not show content blocker in Fusion Builder live editor (CU-u9mb2h)
* empty Google Analytics 4 opt-in code (CU-w8c0r4)
* false-positive detection of Reamaze in scanner
* modals wrongly titled
* modify composer autoloading to avoid multiple injections (CU-w8kvcq)
* scanner did not find sitemap correctly when WPML is active (CU-vhpgdw)


### style

* delete button in service form in wrong position





## 2.6.3 (2021-08-12)


### chore

* update text when scanner has finished to make clear it is coming from Real Cookie Banner (CU-t1ccx6)


### docs

* enhance wordpress.org product description (CU-rvu601)


### fix

* allow different site and home URL for the scanner to find robots.txt (CU-t1mafb)
* allow optional path to Matomo Host (CU-t1cpvz)
* customizer did not load correctly (CU-u3q46w)
* link to multisite consent forwarding knowledge base article (CU-rg8p46)
* remove React warning in developer console about unique keys (CU-u3q46w)
* scanner compatibility with PHP < 7.3
* www URLs of the same WordPress installations were considered as external URL in scanner (CU-6fcxcr)


### refactor

* remove unnecessary translations





## 2.6.2 (2021-08-11)


### fix

* error message when using PHP < 7.3
* loose sitemap index URLs (CU-rvwmnk)





## 2.6.1 (2021-08-10)


### fix

* link rel blocker should handle subdomains correctly
* userlike blocker should block by their CDN instead of usual URL





# 2.6.0 (2021-08-10)


### chore

* introduce new developer filter RCB/Blocker/IsBlocked/AllowMultiple and RCB/Blocker/ResolveBlockables (CU-7mvhak)
* new developer filter RCB/Blocker/SelectorSyntax/IsBlocked
* settled TODOs and update since-versions (CU-7mvhak)
* translations into German (CU-pb8dpn)
* update texts for scanner tab (hint, CU-mtddjt)


### docs

* service scanner featured in wordpress.org description (CU-n9cuyh)


### feat

* add 9 new content blockers for existing services (CU-mtdp7v)
* add content blocker for 19 services so the scanner can find it (CU-mtdp7v)
* add new checklist item to scan the website (CU-mk8ec0)
* allow to create a new service from scratch directly within a content blocker form (CU-mk8ec0)
* allow to scan also essential services which could not be blocked (e.g. Elementor)
* automatically rescan updated posts
* block link preconnect's and dns-prefetch's automatically based on URL hosts defined in content blocker (CU-nn7g16)
* handle external URLs popover with Cookie Experts dialog (CU-mk8ec0)
* introduce client worker and localStorage restore functionality (CU-kh49jp)
* introduce functionality to find sitemap or fallback to WP default if not existing (CU-kfbzc6)
* introduce mechanism to scan a site for usable presets and external URLs (CU-kf71p4)
* introduce new package @devowl-wp/sitemap-crawler to parse and crawl a sitemap (CU-kh49jp)
* introduce scanner UI for found presets and external URLs (CU-m57phr)
* introduce UI for scanned markups for predefined presets (CU-m57phr)
* new service and content blocker preset Ad Inserter (plugin, CU-kvcmp7)
* popup notification when scan hast finished and allow to ignore external URLs (CU-m57phr)
* proper error handling with UI when e.g. the Real Cookie Banner scanner fails (CU-7mvhak)
* show global notice when using services without consent
* show recommended services not by content blocker but by dependency (CU-mtdp7v)
* translate scanner into German (CU-n9cuyh)
* use @devowl-wp/real-queue to scan the complete website (CU-kh49jp)


### fix

* add remarketing to Google Ads Conversation Tracking service template (CU-pb9txp)
* allow to block the same element by multiple attributes (CU-p3agpd)
* always save the markup so redundant external URLs can be wiped (CU-mtdp7v)
* automatically start scan process for the first time
* be more loose when getting and parsing the sitemap
* block ad block from Ad Inserter newer than 2.7.2 in content blocker template (CU-kvcmp7)
* change close label text when updating privacy preferences (CU-rgdp01)
* compatibility with Impreza frontend page builder
* compatibility with latest Thrive Architect plugin (CU-p3agpd)
* compatibility with Ultimate Video WP Bakery Page builder add-ons (CU-pd9uab)
* create new service within content blocker shows zero as prefilled group
* do not add duplicate URLs to queue
* do not enqueue real-queue on frontend for logged-in users
* german support link (CU-rg8qrt)
* improve German translations for scanner (CU-n9cuyh)
* include all revision data in single consent export
* native integration for Analytify preset (disabled status, CU-n1f1xc)
* native integration for GA Google Analytics preset (disabled status, CU-n1f1xc)
* native integration for MonsterInsights preset (disabled status, CU-n1f1xc)
* native integration for RankMath SEO Google Analytics (install code, CU-n1bd59)
* native integration for WooCommerce Google Analytics preset (disabled status, CU-n1f1xc)
* preset WordPress Emojis should also block the DNS prefetch
* remove extended presets from scan results
* review 1 (CU-mtdp7v, CU-n1f1xc)
* review 1 (CU-nd8ep0)
* review 2 (CU-7mvhak)
* review 2 (CU-nd8ep0)
* review 3 (CU-7mvhak)
* review user tests #1 (CU-nvafz0)
* review user tests #2 (CU-nvafz0)
* review user tests #3 (CU-nvafz0)
* split Google Analytics into two content blockers UA and V4 (CU-nq8c3j)
* tag to fully blocked associated with found count instead of distinct of sites count
* update Facebook Post preset to be compatible with Facebook Video (CU-p1dxwp)
* use correct cookie experts link (CU-mtddaa)


### perf

* speed up scan process by reducing server requests (CU-nvafz0)


### refactor

* introduce new keywords needs for presets (CU-mzf8gj)
* move code dynamic fields to preset attributes (CU-h38crf)
* presets extends should no longer be a class name, instead use identifier (CU-n19da6)
* split i18n and request methods to save bundle size
* use instance for blocked result in RCB/Blocker/IsBlocked filters (CU-nxeknj)


### style

* background color for recommandations admin bar menu
* gray out already existing prestes in service and content blocker template screen
* move Google Ads hint about Adwords ID to the input field





## 2.5.1 (2021-08-05)


### chore

* translate (CU-pkhcg8)
* update TCF dependencies to latest version (CU-pq8wt4)


### fix

* decode and encode HTML attributes correctly and only when needed (CU-q1a82b)
* duplicate external hosts in multisite forwarding leads to invisible banner
* enhance Google Maps Content Blocker to be compatible with WP Store Locator (CU-pkhmqy)
* introduce new unique-write attribute in opt-in field for Google Ads and Google Analytics (CU-raj3eg)
* put powered-by link in banner in same align as the legal links (CU-pn8pcz)
* reload page after consent change (CU-pnbunr)
* reset essential cookies correctly when custom choice is selected
* review 1 (CU-pn8pcz)


### refactor

* remove TCF global scope coding (CU-pq8wt4)


### style

* make content blocker hosts collapsable instead of showing all (CU-pkhcg8)





# 2.5.0 (2021-07-16)


### chore

* update compatibility with WordPress 5.8 (CU-n9dfx9)


### feat

* new service and content blocker preset Podigee (CU-nzbb2q)


### fix

* assign GetYourGuide preset to Marketing cookie group instead of Functional (CU-nv85ef)
* imported content blockers leads to empty admin page in lite version (CU-nzc6gg)
* regex for Google Ads Conversation Tracking ID too strict





# 2.4.0 (2021-07-09)


### feat

* new cookie and content blocker preset MailPoet (CU-m3dtuf)


### fix

* add EFTA countries to countries where the GDPR applies (CU-mhcqjz)
* compatibility with dynamic modules in Thrive Architect (CU-n9bup4)
* compatibility with Elementor video overlay and lightbox (CU-nkb66n)
* compatibility with Pinterest JavaScript SDK (CU-nkaq8m)
* compatibility with themify.me Builder Maps Pro add-on (CU-nna6bg)
* compatibility with themify.me video modules (CU-nna6bg)
* compatibility with WP Rocket 3.9 (CU-nkav4w)
* cookie groups are sortable again via drag & drop (CU-nhfmkt)
* detect multisite / network wide plugins as active for services (CU-mzb2kw)
* do not block content in Themify.me page builder (CU-nna6bg)
* do not hide blocked elements when they use visual parent from children element
* do not show banner for browsers without cookie support (CU-v77cgg)
* do not stop code execution for opt-in scripts and content blocker when blocked through Ad blocker (CU-ndd0dp)
* explain where to find Google Adwords ID in Google Ads service template (CU-mtav6f)
* lite version dashboard not scrollable (CU-nd8e07)
* recalculate responsive handlers after content got unblocked (CU-nnfb22)
* typo in Google Maps content blocker description





# 2.3.0 (2021-06-15)


### chore

* allow to check for consent with consentApi by post ID (CU-m9e56j)
* introduce new PHP developer API wp_rcb_service_groups() and wp_rcb_services_by_group() (CU-m9e56j)
* simplify text of the age notice (CU-m3a6n2)
* translate new presets (CU-m38dkk, CU-kt8cat, CU-m3dtuf, CU-m15mty)


### feat

* automatically delegate click from content blocker when we unblock a link
* content blocker Google Translate compatible with "Translate WordPress" plugin (CU-m3e1fm)
* define Google Adsense Publisher ID in Google Adsense service template to alloew e.g. auto ads (CU-m7e13d)
* new cookie and content blocker preset Calendly (CU-m38dkk)
* new cookie and content blocker preset MailPoet (CU-m3dtuf)
* new cookie and content blocker preset My Cruise Excursion / meine-landesausflüge (CU-kt8cat)
* new cookie and content blocker preset Smash Balloon Social Photo Feed (CU-m15mty)


### fix

* adjust three customizer presets to be compatible with latest Dr. Schwenke newsletter (Dark patterns, CU-m1e0zn)
* allow service for MailPoet 2 (deprecated plugin, CU-m3dtuf)
* allow window.onload assignments in blocked content (CU-m38dkk)
* block reddit post embed as iframe (CU-m15mty)
* compatibility with Astra theme and hamburger menu (automatically collapse if clicked too early)
* compatibility with BookingKit and blur effect (CU-m1acj0)
* content blocker could not find already existing cookies
* do not show element server-side rendered to improve web vitals (CU-m15mty)
* elementor ready trigger is dispatched too early
* hide Refresh site on consent option as it is not needed (CU-m9dey3)
* load animate.css only when needed (CU-mddt99)
* show warning when accept essentials differs from accept all button type (CU-m1e0zn)


### revert

* disable MailPoet preset as it is not yet ready (https://git.io/JnqoX, CU-m3dtuf)





# 2.2.0 (2021-06-05)


### chore

* clearer differentiation of the plugin's benefits in wordpress.org description (CU-kbaequ)
* clearer differentiation of the plugin's benefits in wordpress.org description (CU-kbaequ)
* clearer differentiation of the plugin's benefits in wordpress.org description (CU-kbaequ)
* clearer differentiation of the plugin's benefits in wordpress.org description (CU-kbaequ)
* translate new cookie and content blocker presets (CU-kt7e5r, CU-kk8gvu, CU-k759kz)
* update Cloudflare service template (CU-ff6vzc)


### feat

* allow match elements by div[my-attribute-exists], div[class^="starts-with-value"] and div[class$="ends-with-value"] (CU-kt829t)
* new content blocker for WordPress login when using e.g. reCaptcha (CU-jqb6y0)
* new cookie and content blocker preset Awin Link and Image Ads (CU-k759kz)
* new cookie and content blocker preset Awin Publisher MasterTag (CU-k759kz)
* new cookie and content blocker preset ConvertKit (CU-kk8gvu)
* new cookie and content blocker preset GetYourGuide (CU-kt829t)
* new cookie and content blocker preset WP-Matomo Integration (former WP-Piwik, CU-kt7e5r)


### fix

* avoid duplicate execution of inline scripts when they take longer than 1 second
* block more JS code in content blocker of "Mailchimp for WooCommerce" template
* compatibility with 'Modern' admin style
* compatibility with Elementor PRO Video API / blocks (CU-kd5nne)
* compatibility with Elementor Video API for Vimeo and YouTube (CU-kd5nne)
* compatibility with Google Maps plugin by flippercode (CU-kn82nw)
* do anonymize localized variables in wp-login.php (CU-jqb6y0)
* do not allow creating a content blocker when you try to assign a cookie to essential group (CU-jqb6y0)
* do not apply content blocker in customizer preview
* page does not get reloaded automatically after consent on safari / iOS (CU-kt8q4n)
* use anti-ad-block system also in login page (CU-kh5jpd)
* use script tag with custom type declaration to be HTML markup compatible (head, CU-kt4njv)





# 2.1.0 (2021-05-25)


### chore

* compatibility with latest antd version
* introduce new developer filter RCB/Misc/ProUrlArgs (CU-jbayae)
* introduce new RCB/Hint section to add custom tiles to the right dashboard section (CU-jbayae)
* migarte loose mode to compiler assumptions
* own chunk for blocker vendors, but still share (CU-jhbuvd)
* polyfill setimmediate only if needed (CU-jh3czf)
* prettify code to new standard
* remove es6-promise polyfill (CU-jh3czn)
* remove whatwg-fetch polyfill (CU-jh3czg)
* revert update of typedoc@0.20.x as it does not support monorepos yet
* upgrade dependencies to latest minor version


### ci

* move type check to validate stage


### docs

* highlight that not all service templates are free in wordpress.org plugin description


### feat

* allow to block content in login page (e.g. using Google reCaptcha, CU-jqb6y0)
* new service and content blocker preset Sendinblue (CU-k3cf3r)
* new service and content blocker preset Xing Events (CU-k3cfab)


### fix

* allow visual parent by children selector (querySelector on blocked content, CU-k7601j)
* block new elements of Popup Maker in content blocker template
* compatibility with Astra theme oEmbed container (CU-k18eqe)
* compatibility with Dynamic Content for Elementor plugin (CU-k7601j)
* compatibility with elementor widgets when they are directly blocked (CU-k7601j)
* do not content block when elementor preview is active
* do not rely on install_plugins capability, instead use activate_plugins so GIT-synced WP instances work too (CU-k599a2)
* padding of content blocker parent got reset
* support for @font-face directive when blocking inline style (CU-k3cf3r)
* visual parent does not work for custom elementor blocker (CU-k7601j)
* when an inline script creates a new DOM element it is sometimes invisible (CU-k3cf3r)
* white screen when searching for duplicate content blockers


### refactor

* move compatibility code to own folder
* own function to override native addEventListener functionality
* style classes to functions for tree shaking (CU-jh75eg)


### revert

* own vendor bundle for blocker


### style

* pro dialog (CU-jbayae)


### test

* make window.fetch stubbable (CU-jh3cza)





## 2.0.3 (2021-05-14)


### fix

* customizer does not work when WP Fastest Cache is active (CU-jq9aua)
* multilingual plugins like Weglot and TranslatePress should show more options in Consent Forwarding setting





## 2.0.2 (2021-05-12)


### fix

* compatibility with PixelYourSite Facebook image tag (pixel)
* compatibility with WP Rocket lazy loading scripts (CU-jq4bhw)





## 2.0.1 (2021-05-11)


### docs

* update README typos


### fix

* **hotfix :** new cookie presets are not visible for Weglot users (CU-hk3jfn)





# 2.0.0 (2021-05-11)


### build

* allow to patch scoped build artifact to fix unicode issues (CU-80ub8k)
* allow to set config name for yarn dev
* consume TCF CMP ID via environment variable (CU-h15h9f)
* own JS bundle for TCF banner and enqueue stub (CU-fk051q)
* update wordpress.org screenshot assets (CU-gf917p)
* wrong refernce to PSR-4 namespace


### chore

* add screenshots for TCF compatibility and Geo-restriction (CU-gf917p)
* core features description text (CU-gf7dnf)
* deactivate option to resepect Do Not Track by default (CU-gx1m76)
* increase minimum PHP version to 7.2 (CU-fh3qby)
* introduce new filter to disable setting the RCB cookie via RCB/SetCookie/Allow
* minimum required version of PHP is 7.2
* name cookie designs consistently (CU-g779gw)
* remove classnames as dependency
* rename "cookies" to "services" for consistent wording (CU-f571nh)
* sharp terms of buttons and labels in cookie banner
* update @iabtcf packages to >= 1.2.0 to support TCF 2.1 (CU-h539k3)
* update @iabtcf packages to stable version (CU-g977x9)
* update texts to be more informative about legal basis and print text for Consent Forwarding if active (respects also TCF global scope) (CU-cq1rka)
* use more normal style to be independent from formal/informal language (CU-f4ycka)


### docs

* wordpress.org description revised (CU-gf7dnf)


### feat

* add contrast ratio validator and call-to-action adjustments for TCF compatibility (CU-cq25hu)
* add GVL instance to all available banner contexts (CU-fjzcd8)
* allow to customize the text of the powered-by link (CU-f74d53)
* allow to define a list of countries to show only the banner to them e.g. only EU (Country Bypass, CU-80ub8k)
* allow to export and import TCF vendor configurations (CU-ff0yvh)
* allow to forward TCF consent with Consent Forwarding (CU-ff10cy)
* allow to reset all settings to default in Settings tab (CU-8extcg)
* automatically refresh GVL via button and periodically (CU-63ty1t)
* calculate suitable stacks and add them to revision (CU-fh0bx6)
* compatibility of TCF vendors with ePrivacy USA functionality (CU-h57u92)
* compatibility with TCF v2.1 (device storage disclosures, CU-h74vna)
* complement translations for English and German (CU-ex0u4a)
* completion of English and German translations (CU-ex0u4a)
* completion of English and German translations (CU-ex0u4a)
* contrast ratio warning for non-TCF users, opt-in cookie banner activation through popconfirm (CU-j78m3t)
* create content blockers for TCF vendor configurations (CU-gv58rr)
* download and normalize Global Vendor List for TCF compatibility (CU-63ty1t)
* eight new cookie banner presets (CU-g779gw)
* introduce Learn More links to different parts of the UI (CU-gv58rr)
* introduce new service field to allow opt-out based on legal basis (CU-ht2zwt)
* introduce origin of business entity field for TCF integration (CU-g53zgk)
* introduce revision for TCF vendors and declarations (CU-ff0zhy)
* introduce settings tab for TCF compatibility in Cookies > Settings (CU-cq29n2)
* introduce so-called Custom Bypass so developers can dynamically set a predecision and hide the banner automatically (e.g. Geolocation, CU-80ub8k)
* introduce UI to create a TCF vendor configuration and create TCF vendor configuration REST API (CU-crwq2r)
* introduce UI to edit a TCF vendor configuration (CU-crwq2r)
* native compatibility with preloading and defer scripts with caching plugins (CU-h75rh2)
* new cookie presets for Ezoic (CU-ch2rng)
* new customizer control to adjust the opacity of box shadow color (CU-cz1d9t)
* persist TCF strings for proof of consent and dispatch to CMP API (CU-ff0z49)
* properly replace non-javascript ad tags with current TC String (CU-ct1gfd)
* provide a migration wizard for v2 in the dashboard (CU-g75t1p)
* register new Custom Post Type for TCF vendor configurations (CU-crwq2r)
* show and allow to customize TCF stacks (CU-cq1rka)
* show TCF vendors and declarations (purposes, special purposes, ...) in second view of cookie banner (CU-ff0yvh)
* translate backend into German (CU-ex0u4a)
* translate frontend into German (CU-ex0u4a)
* when navigating to /tcf-vendors/new show a list of all available vendors (CU-crwq2r)


### fix

* add custom bypasses to the DnT stats pie chart (CU-gf4egf)
* add United Kingdom (GB) as default to Country Bypass list (CU-hz8rka)
* assign cookie groups and cookies to correct source language after adding a new language to WPML (CU-hz3a83)
* automatically clear page caches after license activation / deactivation (CU-jd7t87)
* automatically deactivate option to respect DnT header when activating TCF for the first time
* compatibility TCF and WPML / PolyLang
* compatibility with Customizer checkbox values and Redis Object Cache (CU-jd4662)
* cookie history could not be closed when no consent given
* do not output RCB settings as base64 encoded string (CU-gx8jkw)
* first review with Advanced Ads (Pro, CU-g9665t)
* localize stacks correctly and sort by score (CU-ff0zhy)
* make consentAPI available in head scripts
* make group description texts resettable (CU-gf3dew)
* notices thrown when no vendor given (CU-ff0yvh)
* output UUID on legal sites, too (CU-jha8xc)
* review 1 (TCF, CU-ff0yck)
* review 2 (CU-ff0yvh)
* review 3 (CU-ff0yvh)
* review 4 (CU-ff0yvh)
* review 5 (CU-ff0z49)
* review 6 (CU-80ub8k)
* review 7 (CU-80ub8k)
* review TCF CMP validator (CU-hh395u, CU-hh3dkn)
* review with user test (thanks to Carlo, CU-gd12qp)
* review with user test (thanks to Franz, CU-gd12mq)
* review with user test (thanks to Franz, CU-gd12mq)
* review with user test (thanks to Jonas, CU-gd12hq)
* show vendor ID in list table of TCF vendors (CU-gf8h2g)
* show vendor list link for TCF banner in footer (CU-g977x9)
* the Lighthouse crawler is not a bot (CU-j575je)
* translate "legitimate interest" always with "Berechtigtes Interesse" (CU-ht31w2)
* translate footer text correctly for TranslatePress / Weglot (CU-ht82qm)
* usage with deferred scripts and content blocker (DOM waterfall, CU-gn4ng5)


### perf

* avoid catastrophal backtracing and speed up regular expression for inline scripts/styles by 90% (CU-j77a9g)
* combine vendor modules to a common chunk for both TCF and non-TCF
* introduce deferred and preloaded scripts for cookie banner (CU-gn4ng5)
* remove TCF CmpApi from non-TCF bundle


### refactor

* create wp-webpack package for WordPress packages and plugins
* introduce bundleAnalyzerOptions in development package
* introduce eslint-config package
* introduce new grunt workspaces package for monolithic usage
* introduce new package to validate composer licenses and generate disclaimer
* introduce new package to validate yarn licenses and generate disclaimer
* introduce new script to run-yarn-children commands
* make content blocker independent of custom post type
* make Vimeo and SoundCloud to Pro presets (CU-gf49yy)
* move build scripts to proper backend and WP package
* move jest scripts to proper backend and WP package
* move PHP Unit bootstrap file to @devowl-wp/utils package
* move PHPUnit and Cypress scripts to @devowl-wp/utils package
* move special blocker PHP classes in own namespace
* move technical doc scripts to proper WP and backend package
* move WP build process to @devowl-wp/utils
* move WP i18n scripts to @devowl-wp/utils
* move WP specific typescript config to @devowl-wp/wp-webpack package
* remove @devowl-wp/development package
* split stubs.php to individual plugins' package


### style

* improve Web Vitals by setting a fixed width / height for the logo (CU-j575je)
* refactor all banner presets (CU-fn68er)


### test

* fix failing smoke test for Real Cookie Banner Lite


### BREAKING CHANGE

* please upgrade your PHP version to >= 7.2





## 1.14.1 (2021-04-27)


### ci

* push plugin artifacts to GitLab Generic Packages registry (CU-hd6ef6)


### fix

* compatibility with Lite Speed Cache; white screen in customizer
* introduce new filter RCB/Blocker/InlineScript/AvoidBlockByLocalizedVariable and fix copmatibility with EmpowerWP/Mesmerize (CU-hb8v51)
* notice array_walk_recursive() expects parameter 1 to be array, integer given
* output buffer callback should be called always and cannot be removed by third parties


### refactor

* use shorter function to get cookie by name (CU-hv8ypq)


### revert

* output buffer callback should be called always and cannot be removed by third parties





# 1.14.0 (2021-04-15)


### chore

* translate new cookie and content blocker presets (CU-h158p2)


### feat

* new cookie and content blocker preset Metricool (CU-gz7ptb)
* new cookie and content blocker preset Popup Maker (CU-gt22gk)
* new cookie and content blocker preset RankMath Google Analytics (CU-gh4gcw)
* new cookie and content blocker preset Thrive Leads (CU-gh4qgh)


### fix

* allow to Add Media in banner description
* allow to extract blocked inline style to own style HTML block (CU-gk0d9a)
* allow to granular block urls in inline CSS (CU-gk0d9a)
* allow to set privacy policy URL per language (WPML, PolyLang, CU-gq33k2)
* avoid catasrophical backtrace when blocking an inline style (CU-gh964b)
* compatibility with LiteSpeed cache buffer
* compatibility with MailerLite content blocker and Thrive Archtiect page builder (CU-gh4hr5)
* compatibility with Ultimate Video (CU-fz6gxc)
* consentSync API returned the wrong found cookie when two cookies use same technical definitions - introduced relevance scoring
* usage with PolyLang with more than two languages and copy automatically to new languages (CU-gt3kam)





## 1.13.1 (2021-03-30)

**Note:** This package (@devowl-wp/real-cookie-banner) has been updated because a dependency, which is also shipped with this package, has changed.





# 1.13.0 (2021-03-23)


### chore

* translate and register new presets (CU-fn1j8z, CU-c6vmwh)


### docs

* new compatibilities in wordpress.org description (CU-fk068g)


### feat

* new cookie and content blocker preset Bloom (CU-fn1j8z)
* new cookie and content blocker preset Typeform (CU-c6vmwh)


### fix

* calculate rendered height for banner footer to gain better edge smoothing
* compatibility of content blocker with TranslatePress and Weglot (CU-fz6gxc)
* compatibility with Ultimate Video (CU-fz6gxc)
* export of consents contained notices in some PHP environments (CU-ff0z49)
* show notice for frontend banner if no license is active (CU-fyzukg)
* use the correct permalinks in the banner footer (CU-e8x3em)





# 1.12.0 (2021-03-10)


### build

* plugin tested for WordPress 5.7 (CU-f4ydk2)


### chore

* register and translate new presets (CU-eyzegt, CU-f4yzpm)


### feat

* new cookie and content blocker preset Yandex Metrica (CU-f4yzpm)
* new cookie preset for Bing Ads (Microsoft UET) (CU-eyzegt)
* new cookie preset found.ee (CU-f97ady)


### fix

* more granular translation for TranslatePress for blockers, cookie group, cookies and banner texts





# 1.11.0 (2021-03-10)


### chore

* hide some notices on try.devowl.io (CU-f53trz)


### feat

* added ability to auto play videos if they got unblocked (Divi Page Builder, CU-f51p51)
* added ability to auto play videos if they got unblocked (JetElements for Elementor, CU-f51p51)
* autoplay YoutTube and Vimeo videos after unblocking through content blocker (CU-f558r1)


### fix

* compatibility with Combine JavaScript in WP Rocket (CU-f35k4j)
* compatibility with Divi videos (e.g. YouTube) when using an overlay
* compatibility with JetElements for Elementor Video Player (CU-f51p51)
* compatibility with lazy loaded scripts e.g. WP Rocket when they are present in the configuration list (CU-f35k4j)
* in some cases the blocked content was still display:none after unblocking (e.g. GTranslate, CU-f35k4j)





# 1.10.0 (2021-03-02)


### chore

* update german text for privacy settings history dialog title (CU-ev2070)


### feat

* allow to customize more texts for content blocker (CU-ev2070)
* new cookie preset (CU-ev6jyb)


### fix

* allow HTML formatting in content blocker accept info text (CU-ev2070)
* compatibility with Thrive Architect embeds
* compatibility with Thrive Archtitect Custom HTML block
* do not allow cookie duration greater than 365 (CU-cpyc46)
* do not override position:relative for content blocker





# 1.9.0 (2021-02-24)


### chore

* drop moment bundle where not needed (CU-e94pnh)
* introduce new JavaScript API window.consentApi.consentSync


### docs

* rename test drive to sanbox (#ef26y8)


### feat

* new cookie banner preset 'Ronny's Dialog'
* new customizer option in Body > Accept all Button > Align side by side (CU-cv0d8g)


### fix

* compatibility with X Theme and Cornerstone
* content blocker containers may also have an empty style
* content blocker for JetPack Site Stats too aggressive when using together with wordpress.com
* content blocking for Quform in some cases to aggressive (#ejxq3b)
* do not annonymously server when SCRIPT_DEBUG is active
* do not apply style to parent containers if no style was previously present
* do not show cookie banner when editing in Divi and Beaver Builder page builder
* illegal mix of collations (CU-ef1dtp)
* in some cases the original iframe was blocked, but not completely hidden
* when a profile deactivate syntax highlighting, the cookie form did not work (CU-en3mxa)





# 1.8.0 (2021-02-16)


### chore

* register and translate new cookie and content blocker presets
* show notice for Quform cause content blocker is not necessery (CU-cawja6)


### feat

* allow to apply content blockers to JSON output of e.g. REST services
* improve English translation (#devznm)
* new cookie and content blocker preset Issuu (CU-e14yht)
* new cookie and content blocker preset Pinterest Tag (CU-eb3wu9)
* new cookie and content blocker preset Quform (CU-cawja6)
* new cookie preset Klarna Checkout for WooCommerce (CU-e2z7u7)
* new cookie preset TranslatePress (CU-e14nf6)


### fix

* compatibility Instagram blocker with WoodMart theme
* compatibility with Elementor inline styles
* compatibility with TranslatePress (CU-cew7v9)
* do not block links without class and external URLs
* do not output calculated time for blocker when not requested; compatibility with Themebeez Toolkit
* show correct tooltip when Google / Matomo Tag Manager template can not be created (CU-e6xyc5)





## 1.7.3 (2021-02-05)


### docs

* update README to be compatible with Requires at least (CU-df2wb4)


### fix

* in some edge cases the wordpress autoupdater does not fire the wp action and dynamic javascript assets are not generated





## 1.7.2 (2021-02-05)


### chore

* show notice after one week when setup not yet completed (CU-djx8ga)


### fix

* deliver anonymous assets like JavaScripts files correctly (CU-dgz2p9)
* remove anonymous javascript files on uninstall (CU-dgz2p9)





## 1.7.1 (2021-02-02)

**Note:** This package (@devowl-wp/real-cookie-banner) has been updated because a dependency, which is also shipped with this package, has changed.





# 1.7.0 (2021-02-02)


### chore

* allow to edit custom post types and taxnomies to be edited via native UI for debug purposes
* remove limit for cookies and content blockers (CU-d6z2u6)


### docs

* improved product description for wordpress.org (#d6z2u6)


### feat

* new cookie and content blocker preset MailerLite (CU-d10rw9)
* new cookie preset CleanTalk Spam Protection (CU-d93t70)
* new cookie preset WordFence (CU-dcyv72)


### fix

* allow to block inline styles by URL (CU-d10rw9)
* compatibility with Custom Facebook Feed Pro v3.18 (CU-cwx3bn)
* compatibility with FooBox lightbox (CU-dczh1k)
* compatibility with TranslatePress to avoid flickering (CU-dd4a3q)
* compatibility with Uncode Google Maps block (CU-d12m5q)
* content blocker should also execute window 'load' event after unblock (CU-d12m5q)
* do correctly find duplicate content blockers and avoid them (CU-d10rw9)
* do not block twice for custom element blockers (CU-d10rw9)
* translated page in footer is not shown in PolyLang correctly (CU-d6wumw)





# 1.6.0 (2021-01-24)


### chore

* register new cookie and content blockers and update README (CU-cwx3bn)


### feat

* allow to make customizer fields resettable with a button (CU-crwyqn)
* new banner preset in customizer 'Clean Dialog'
* new content blocker preset CleverReach with Google Recaptcha (CU-cryuv0)
* new cookie and content blocker preset Custom Twitter Feeds (Tweets Widget) (CU-cwx3bn)
* new cookie and content blocker preset Feeds for YouTube (CU-cwx3bn)
* new cookie and content blocker preset FontAwesome (CU-cx067u)
* new cookie and content blocker preset Smash Balloon Social Post Feed (CU-cwx3bn)
* preset extends middleware now supports extendsStart and extendsEnd for array properties (CU-cwx3bn)


### fix

* allow all URLs for affiliates in PRO version (CU-cyyh2z)
* compatibility with CloudFlare caches; nonce is no longer needed as we have rate limit in public APIs (CU-cwvke2)
* compatibility with Impreza lazy loading grid (CU-94w719)
* improve UX when creating Content Blocker and open the Add-Cookie form in a modal instead of new tab (CU-cz12vj)
* review 1 (CU-cz12vj)
* wrong character encoding for VG Wort preset


### refactor

* remove unused classes and methods


### revert

* always show recommened cookies in content blocker select (CU-cwx3bn)


### style

* do not break line in cookie preset selector description
* use flexbox instead of usual containers for banner buttons (CU-cv0ff2)





# 1.5.0 (2021-01-18)


### chore

* introduce new developer filters RCB/Blocker/KeepAttributes and RCB/Blocker/VisualParent (CU-cn0wvd)
* new Consent API function consentApi.consent() and consentApi.consentAll() to wait for consent
* presets can no be extended by a parent class definition
* register new cookie and content blockers and update README (CU-cewwda)
* translate new presets, update README


### feat

* new content blocker preset Google Analytics (CU-cewwda)
* new cookie and content blocker preset Analytify (CU-cewwda)
* new cookie and content blocker preset ExactMetrics (CU-cewwda)
* new cookie and content blocker preset Facebook For WooCommerce (CU-cewwda)
* new cookie and content blocker preset GA Google Analytics (CU-cewwda)
* new cookie and content blocker preset Mailchimp for WooCommerce (CU-cn234z)
* new cookie and content blocker preset Matomo WordPress plugin (CU-ch3etd)
* new cookie and content blocker preset MonsterInsights (CU-cewwda)
* new cookie and content blocker preset WooCommerce Google Analytics Integration (CU-cewwda)
* new cookie preset Lucky Orange (CU-ccwj8v)
* new cookie preset WooCommerce Stripe (CU-cn232u)
* recommend MonsterInsights content blocker in Google Analytics cookie preset (CU-cewwda)


### fix

* automatically invalidate preset cache after any plugin activated / deactivated
* compatibility with FloThemes embed codes and blocks (CU-cn0wvd)
* do not show footer links when label is empty (CU-cjwyqw)
* do not show hidden or disabled content blocker presets in cookie form
* extended presets can disable technical handling through compatible plugin (CU-cewwda)
* footer not shown when imprint empty in PRO version
* include description in preset search index
* overcompressed logo
* review 1 (CU-cewwda)


### refactor

* presets gets more and more complex, let's simplify with a middleware system


### style

* gray out disabled cookie and content blocker presets
* gray out plugin-specific cookie and content blocker presets
* show a tooltip when a preset is currently disabled





## 1.4.2 (2021-01-11)


### fix

* in some edge cases WP Rocket does blockage twice (CU-ccvvdn)





## 1.4.1 (2021-01-11)


### fix

* hotfix to make presets available again





# 1.4.0 (2021-01-11)


### build

* reduce javascript bundle size by using babel runtime correctly with webpack / babel-loader


### chore

* translate new cookie and blocker presets and register
* **release :** publish [ci skip]
* **release :** publish [ci skip]


### ci

* automatically activate PRO version in review application (CU-hatpe6)


### docs

* update README (CU-bevae9)


### feat

* new cookie and content blocker preset ActiveCampaign forms and site tracking (CU-bh04kz)
* new cookie and content blocker preset Discord (CU-c6vmgg)
* new cookie and content blocker preset MyFonts.net (CU-cawhga)
* new cookie and content blocker preset Proven Expert (Widget) (CU-cawhfp)
* new cookie preset Elementor (CU-cawhdk)
* new cookie preset Mouseflow (CU-cawj3n)
* new cookie preset Userlike (CU-cawhr3)


### fix

* apply gzip compression on the fly to the anti-ad-block system (CU-bx0am1)
* compatibility with All In One WP Security & Firewall (CU-bh08zp)
* compatibility with Facebook for WooCommerce plugin (CU-bwwwrt)
* compatibility with Meks Easy Photo Feed Widget Instagram feed (CU-bx0wd7)
* compatibility with Oxygen page builder
* compatibility with video and audio shortcode (CU-bt21kd)
* compatibility with youtu.be domain in YouTube content blocker preset (CU-bt21hp)
* compatiblity with WP Rocket lazy loading inline scripts (CU-bwwwrt)
* compatiblity with WP Rocket lazy loading YouTube videos (CU-byw6ua)
* content blocker for video and audio tags in some edge cases
* cookie preset selector busy indicator (CU-a8x3j0)
* generate dependency map for translations
* jquery issue when not in use (jQuery is now optional for RCB)
* use correct stubs for PolyLang


### perf

* preset PHP classes are only loaded when needed (CU-a8x3j0)
* speed up caching of presets (CU-a8x3j0)


### style

* input text fields in config page (CU-a8x3j0)





# 1.3.0 (2020-12-15)


### chore

* introduce custom powered-by link in PRO version (CU-b8wzqu)


### feat

* introduce rcb-consent-print-uuid shortcode (CU-bateay)
* new cookie and content blocker preset AddThis (CU-beva7q)
* new cookie and content blocker preset AddToAny (CU-beva7q)
* new cookie and content blocker preset Anchor.fm (CU-beva7q)
* new cookie and content blocker preset Apple Music (CU-beva7q)
* new cookie and content blocker preset Bing Maps (CU-beva7q)
* new cookie and content blocker preset reddit (CU-beva7q)
* new cookie and content blocker preset Spotify (CU-beva7q)
* new cookie and content blocker preset TikTok (CU-beva7q)
* new cookie and content blocker preset WordPress Emojis (CU-beva7q)


### fix

* block sandbox attribute for iframes (CU-beva7q)
* compatibility with WP External Links icon in banner and blocker footer (CU-bew81p)
* dashboard in lite version scrolls automatically to bottom (CU-bez8qn)
* list of consents does not expand if not initially saved settings once before
* memory error while reading the consent list (CU-9yzhrr)
* show ePrivacy and age notice even without description in visual content blocker (CU-beurgy)


### refactor

* introduce code splitting to reduce config page JavaScript assets (CU-b10ahe)





## 1.2.4 (2020-12-10)

**Note:** This package (@devowl-wp/real-cookie-banner) has been updated because a dependency, which is also shipped with this package, has changed.





## 1.2.3 (2020-12-09)

**Note:** This package (@devowl-wp/real-cookie-banner) has been updated because a dependency, which is also shipped with this package, has changed.





## 1.2.2 (2020-12-09)


### build

* use correct pro folders in build folder (CU-5ymbqn)


### chore

* update to cypress v6 (CU-7gmaxc)
* update to webpack v5 (CU-4akvz6)
* updates typings and min. Node.js and Yarn version (CU-9rq9c7)


### fix

* anonymous localized script settings to avoid incompatibility with WP Rocket lazy execution (CU-b4rp51)
* automatically deactivate lite version when installing pro version (CU-5ymbqn)
* compatibility with WP External Links (CU-b8w6yv)
* validate cookie host according to RFC 1123 instead of RFC 952 (CU-b31nf0)


### test

* smoke tests for Real Cookie Banner PRO





## 1.2.1 (2020-12-05)


### fix

* sometimes the privacy and imprint link are not correctly redirected (CU-b2x8wp)





# 1.2.0 (2020-12-01)


### chore

* translate new presets
* update dependencies (CU-3cj43t)
* update major dependencies (CU-3cj43t)
* update to composer v2 (CU-4akvjg)
* update to core-js@3 (CU-3cj43t)
* update to TypeScript 4.1 (CU-3cj43t)


### feat

* new cookie preset Zoho Forms and Zoho Bookings (CU-awy9wa)


### refactor

* enforce explicit-member-accessibility (CU-a6w5bv)





## 1.1.3 (2020-11-26)


### fix

* compatibility with WebFontLoader for Google Fonts and Adobe Typekit (CU-aq01tu)
* never block codeOnPageLoad scripts of cookies (introduce consent-skip-blocker HTML attribute, CU-aq01tu)





## 1.1.2 (2020-11-25)


### fix

* code on page load should be execute inside head-tag (CU-aq01tu)
* consent does not get saved in development websites (CU-aq0tbk)
* wrong link to consent forwarding in german WordPress installation





## 1.1.1 (2020-11-24)


### fix

* compatibility with RankMath SEO
* do not block content in beaver builder edit mode (CU-agzcrp)
* do not output rcb calc time in json content type responses (Beaver Builder compatibility, CU-agzcrp)





# 1.1.0 (2020-11-24)


### docs

* add MS Clarity in README


### feat

* new cookie preset Google Trends (CU-ajrchu)
* new cookie preset Microsoft Clarity (#a8rv4x)


### fix

* allow document.write for unblocked scripts (#ajrchu)
* compatibility with upcoming WordPress 5.6 (CU-amzjdz)
* decode HTML entities in content blocker scripts, e.g. old Google Trends embed (#ajrchu)
* ensure banner overlay is always a children of document.body (CU-agz6u3)
* ensure banner overlay is always a children of document.body (CU-agz6u3)
* modify Google Trends to work with older embed codes (CU-ajrchu)
* modify max index length for MySQL 5.6 databases so all database tables get created (CU-agzcrp)
* multiple content blockers should be inside a blocking wrapper (CU-ajrchu)
* order with multiple content blocker scripts (#ajrchu)
* typo in german translation (CU-agzcrp)
* update Jetpack Site Stats and Comments content blocker (CU-amr3f1)
* use no-store caching for WP REST API calls to avoid issues with browsers and CloudFlare (CU-agzcrp)
* using multiple ads with Google Adsense (CU-ajrcn2)
* wrong cookie count for first time usage in dashboard (CU-agzcrp)





## 1.0.4 (2020-11-19)

**Note:** This package (@devowl-wp/real-cookie-banner) has been updated because a dependency, which is also shipped with this package, has changed.





## 1.0.3 (2020-11-18)


### fix

* add Divi maps block to Google Maps content blocker
* banner not shown up in Happy Wedding Day theme
* compatibility with Divi Maps block





## 1.0.2 (2020-11-17)


### fix

* do not show licensing tab in free test drive (#acypm6)





## 1.0.1 (2020-11-17)


### ci

* wrong license.devowl.io package.json


### docs

* wordpress.org README


### fix

* remove unnecessary dependency (composer) package (#acwy1g)





# 1.0.0 (2020-11-17)


### chore

* initial release (#4rruvq)


### test

* fix lite version smoke tests
* fix smoke test
* fix smoke tests for lite version
* fix typo in lite smoke test


* chore!: remove early access notice for newer updates (#4rruvq)
* feat!: use new license server (#4rruvq)
* ci!: release free version to wordpress.org automatically (#4rruvq)


### BREAKING CHANGE

* we are live!
* if you were a early access user, please upgrade to the initial version
* you need to enter your license key again to get automatic updates
* download initial version now here: https://wordpress.org/plugins/real-cookie-banner
