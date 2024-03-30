# `@devowl-wp/customize`

Some customize utility functionality for your WordPress plugins. This package does not render any items, it only provides guidelines and assistance in an abstract implementation.

## Installation

Navigate to your plugin and install this package:

```bash
composer require "devowl-wp/customize @dev"
yarn lerna add @devowl-wp/customize --scope @devowl-wp/real-cookie-banner
```

## Enqueue JavaScript helpers

1. Add the `DevOwl\Customize\Core` trait to your `Core` class and call `$this->overrideInitCustomize()` in your `init` method
1. Add the `DevOwl\Customize\Assets` trait to your `Assets` class and call `$this->probablyEnqueueCustomizeHelpers()` in your `enqueue_scripts_and_styles` method
1. Done, now you can use utility functionality in your JavaScript assets

**Note:** There are two types of helpers, preview-helpers and sidebar-helpers:

-   **Preview**: It's the right side of the customize manager (iframe)
-   **Sidebar**: It's the left side of the customize manager (sidebar with tons of customization)

This leads to the conclusion that you also have to enqueue a separate JavaScript for both areas and use the helpers differently.

## Use JavaScript helpers

As mentioned above there are two types of helpers. The most usual way is to use the both provided factory functions:

-   `previewFactory({ /* [...] */ })`: Allow you to configure the preview of your customizable control
-   `sidebarFactory({ /* [...] */ })`: Allow you to configure the sidebar for your customizable control
