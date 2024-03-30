# `@devowl-wp/cache-invalidate`

Provide a single entry point to trigger cache invalidation of known caching plugins.

```php
<?php
use DevOwl\CacheInvalidate\CacheInvalidator;
CacheInvalidator::getInstance()->getLabels(); // Get activated caching plugins
CacheInvalidator::getInstance()->invalidate(); // Invalidate entire cache of all active caching plugins
```
