# `@devowl-wp/deliver-anonymous-asset`

Provide a functionality to deliver assets anonymous.

## Usage

### 1. Initialize main builder

We need to create a single instance of our builder. From that builder we can create an anonymous asset **for each handle**. Make sure to save the instance globally in your main class as we only need to initiate a builder once.

```php
$this->anonymousAssetBuilder = new AnonymousAssetBuilder(
    // Configure table name
    $wpdb->prefix . "your-prefix" . AnonymousAssetBuilder::TABLE_NAME,
    // Configure prefix for `wp_options` options (needed for regeneration of hashes)
    "rcb"
);
```

### 2. Install the database table

In your `register_activation_hook` make sure to install the database table configured above.

```php
$this->anonymousAssetBuilder->dbDelta();
```

### 3. Enqueue your script

For each enqueued script or style we need to create a deliver instance.

```php
add_action("wp", function () {
    $this->myHandleDeliver = $this->anonymousAssetBuilder->build(
        "my-handle",
        // Full path to file
        "/var/www/html/[...]/my-file.js"
    );
});

add_action("wp_enqueue_scripts", function () {
    wp_enqueue_script("my-handle" /* [...] */);

    // Make sure to mark the deliver as ready and enqueued
    if ($this->myHandleDeliver !== null) {
        $this->myHandleDeliver->ready();
    }
});
```
