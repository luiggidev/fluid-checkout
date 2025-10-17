# Fluid Checkout - Filter Hooks Documentation

This document provides comprehensive documentation for all Filter hooks available in the Fluid Checkout plugin, based on the codebase analysis.

## Table of Contents

1. [Checkout Sections](#checkout-sections)
2. [Checkout Steps Management](#checkout-steps-management)
3. [Contact Step](#contact-step)
4. [Shipping Step](#shipping-step)
5. [Billing Step](#billing-step)
6. [Payment Step](#payment-step)
7. [Order Summary](#order-summary)
8. [Widgets](#widgets)

---

## Checkout Sections

### Page Template and Layout

#### `fc_enable_checkout_page_template`
**Description** Controls whether to use Fluid Checkout page template instead of the default WooCommerce checkout template.
**Parameters**
- `$enabled` (bool) Whether the checkout page template is enabled. Defaults to `true`.
**Context** Used in `inc/checkout-page-template.php` to determine if the custom page template should be applied
**Example**
```php
/**
 * Disable Fluid Checkout page template
 */
add_filter( 'fc_enable_checkout_page_template', '__return_false', 10 );
```

#### `fc_enable_checkout_shortcode_wrapper`
**Description** Controls whether to wrap the checkout shortcode with a `fc-content` wrapper element.
**Parameters**
- `$enabled` (bool) Whether the shortcode wrapper is enabled. Defaults to `false`.
**Context** Used in `inc/checkout-page-template.php` when outputting checkout shortcode
**Example**
```php
/**
 * Enable checkout shortcode wrapper for custom styling
 */
add_filter( 'fc_enable_checkout_shortcode_wrapper', '__return_true', 10 );
```

#### `fc_override_template_with_theme_file`
**Description** Allows themes to override Fluid Checkout template files with their own versions.
**Parameters**
- `$override` (bool) Whether to override with theme file. Defaults to `false`.
- `$template` (string) The template file path.
- `$template_name` (string) The template name.
- `$template_path` (string) The template path.
**Context** Used in `inc/checkout-steps.php` when locating template files
**Example**
```php
/**
 * Override specific template files with theme versions
 */
function override_fc_templates_with_theme( $override, $template, $template_name, $template_path ) {
    if ( 'fc/checkout-steps/checkout/payment.php' === $template_name ) {
        return true;
    }
    return $override;
}
add_filter( 'fc_override_template_with_theme_file', 'override_fc_templates_with_theme', 10, 4 );
```

#### `fc_add_container_class`
**Description** Controls whether to add the `fc-container` class to the checkout wrapper element.
**Parameters**
- `$add_class` (bool) Whether to add the container class. Defaults to `true`.
**Context** Used in `inc/checkout-steps.php` when building wrapper classes
**Example**
```php
/**
 * Remove container class for custom theme layouts
 */
add_filter( 'fc_add_container_class', '__return_false', 10 );
```

#### `fc_content_section_class`
**Description** Adds custom CSS classes to the content section wrapper element.
**Parameters**
- `$class` (string) Additional CSS classes for the content section. Defaults to `''`.
**Context** Used in `templates/fc/checkout-page-template/checkout/page-checkout.php`
**Example**
```php
/**
 * Add custom classes to content section
 */
function add_custom_content_section_classes( $class ) {
    $class .= ' custom-content-wrapper theme-specific-class';
    return $class;
}
add_filter( 'fc_content_section_class', 'add_custom_content_section_classes', 10 );
```

#### `fc_wrapper_classes`
**Description** Adds custom CSS classes to the main checkout wrapper element.
**Parameters**
- `$classes` (string) Additional CSS classes for the wrapper. Defaults to `''`.
**Context** Used in `templates/fc/checkout-steps/checkout/form-checkout.php`
**Example**
```php
/**
 * Add custom wrapper classes
 */
function add_custom_wrapper_classes( $classes ) {
    $classes .= ' custom-checkout-wrapper';
    return $classes;
}
add_filter( 'fc_wrapper_classes', 'add_custom_wrapper_classes', 10 );
```

#### `fc_checkout_page_title`
**Description** Modifies the checkout page title text.
**Parameters**
- `$title` (string) The checkout page title. Defaults to `get_the_title()`.
**Context** Used in `templates/fc/checkout-page-template/checkout/page-checkout.php`
**Example**
```php
/**
 * Customize checkout page title
 */
function customize_checkout_page_title( $title ) {
    return __( 'Complete Your Order', 'my-theme' );
}
add_filter( 'fc_checkout_page_title', 'customize_checkout_page_title', 10 );
```

#### `fc_display_checkout_page_title`
**Description** Controls whether to display the checkout page title or hide it with screen-reader-only class.
**Parameters**
- `$display` (bool) Whether to display the title. Defaults to `false`.
**Context** Used in `templates/fc/checkout-page-template/checkout/page-checkout.php`
**Example**
```php
/**
 * Show checkout page title
 */
add_filter( 'fc_display_checkout_page_title', '__return_true', 10 );
```

### Header and Logo

#### `fc_checkout_header_logo_home_url`
**Description** Modifies the home URL for the checkout header logo link.
**Parameters**
- `$home_url` (string) The home URL for the logo link. Defaults to `home_url( '/' )`.
**Context** Used in `templates/fc/checkout-page-template/checkout/checkout-header.php`

**When this filter triggers:**
- When using Fluid Checkout's custom logo setting (`fc_checkout_logo_image` option)
- When falling back to site name (when no custom logo is set and no custom action is hooked to `fc_checkout_header_logo`)

**When this filter does NOT trigger:**
- When using WordPress's native custom logo functionality (`the_custom_logo()`) - this happens when the theme has a custom logo set in the WordPress Customizer
- When a custom action is hooked to `fc_checkout_header_logo`

**Note:** If you need to modify the home URL when using WordPress's native custom logo, you would need to either use Fluid Checkout's logo setting instead or hook into the `fc_checkout_header_logo` action to override the logo display.
**Example**
```php
/**
 * Customize header logo home URL
 */
function customize_header_logo_home_url( $home_url ) {
    // Redirect logo to an existing page (e.g., blog page)
    $blog_page = get_page_by_path( 'blog' );
    if ( $blog_page ) {
        return get_permalink( $blog_page->ID );
    }
    
    // Fallback to home URL if page doesn't exist
    return $home_url;
}
add_filter( 'fc_checkout_header_logo_home_url', 'customize_header_logo_home_url', 10 );
```

#### `fc_checkout_html_custom_attributes`
**Description** Adds custom HTML attributes to the checkout page HTML element.
**Parameters**
- `$attributes` (array) Array of HTML attributes as key-value pairs.. Defaults to `array()`.
**Context** Used in `templates/fc/checkout-page-template/checkout/page-checkout-header.php`
**Example**
```php
/**
 * Add custom HTML attributes to checkout page
 */
function add_custom_html_attributes( $attributes ) {
    $attributes['custom-attribute'] = 'custom-checkout-attribute';
    return $attributes;
}
add_filter( 'fc_checkout_html_custom_attributes', 'add_custom_html_attributes', 10 );
```

#### `fc_checkout_body_custom_attributes`
**Description** Adds custom HTML attributes to the checkout page body element.
**Parameters**
- `$attributes` (array) Array of HTML attributes as key-value pairs.. Defaults to `array()`.
**Context** Used in `templates/fc/checkout-page-template/checkout/page-checkout-header.php`

**⚠️ Important Limitation for CSS Classes:**
This filter has a limitation when adding CSS classes. Due to how the plugin outputs the body element, adding `class` attributes through this filter will result in invalid HTML (multiple `class` attributes on the same element). For CSS classes, use WordPress's `body_class` filter instead.

**Example for non-class attributes:**
```php
/**
 * Add custom body attributes for theme compatibility
 */
function add_custom_body_attributes( $attributes ) {
    // Add non-class attributes
    $attributes['data-custom'] = 'custom-value';
    $attributes['id'] = 'custom-checkout-page';
    
    return $attributes;
}
add_filter( 'fc_checkout_body_custom_attributes', 'add_custom_body_attributes', 10 );
```

**Example for CSS classes (use body_class filter instead):**
```php
/**
 * Add custom body class for checkout
 */
function add_custom_checkout_body_class( $classes ) {
    if ( is_checkout() ) {
        $classes[] = 'custom-checkout-body';
    }
    return $classes;
}
add_filter( 'body_class', 'add_custom_checkout_body_class' );
```

### Layout and Design

#### `fc_get_checkout_layout`
**Description** Modifies the checkout layout setting value.
**Parameters**
- `$layout` (string) The checkout layout setting value. Defaults to `'multi-step'`.
**Available Options**
- `'multi-step'` - Multi-step checkout layout (default)
- `'single-step'` - Single step checkout layout
**Context** Used in `inc/checkout-steps.php` to determine the current layout
**Example**
```php
/**
 * Force single-step layout for mobile devices
 */
function force_single_step_layout_mobile( $layout ) {
    if ( wp_is_mobile() ) {
        return 'single-step';
    }
    return $layout;
}
add_filter( 'fc_get_checkout_layout', 'force_single_step_layout_mobile', 10 );
```

#### `fc_is_checkout_layout_multistep`
**Description** Controls whether the checkout uses multi-step layout.
**Parameters**
- `$is_multistep` (bool) Whether the layout is multi-step. Defaults to `'multi-step' === $this->get_checkout_layout()`.
**Context** Used in `inc/checkout-steps.php` to check layout type
**Example**
```php
/**
 * Force multi-step layout for specific conditions
 */
add_filter( 'fc_is_checkout_layout_multistep', '__return_true', 10 );
```

#### `fc_checkout_layout_option_image_url`
**Description** Modifies the image URL for layout options in the admin settings.
**Parameters**
- `$image_url` (string) The image URL for the layout option.
- `$layout_key` (string) The layout option key.
**Context** Used in admin settings to display layout option images
**Example**
```php
/**
 * Customize layout option images
 */
function customize_layout_option_images( $image_url, $layout_key ) {
    if ( 'multi-step' === $layout_key ) {
        return get_template_directory_uri() . '/images/custom-multistep.png';
	   return 'https://picsum.photos/536/354';
    }
    return $image_url;
}
add_filter( 'fc_checkout_layout_option_image_url', 'customize_layout_option_images', 10, 2 );
```

#### `fc_design_template_option_image_url`
**Description** Modifies the image URL for design template options in the admin settings.
**Parameters**
- `$image_url` (string) The image URL for the design template option.
- `$template_key` (string) The design template option key.
**Context** Used in admin settings to display design template option images
**Example**
```php
/**
 * Customize design template option images
 */
function customize_design_template_images( $image_url, $template_key ) {
    if ( 'classic' === $template_key ) {
        return get_template_directory_uri() . '/images/custom-classic.png';
    }
    return $image_url;
}
add_filter( 'fc_design_template_option_image_url', 'customize_design_template_images', 10, 2 );
```

### Compatibility

#### Plugin Compatibility

#### `fc_enable_compat_plugin_*`
**Description** Controls whether to load compatibility files for specific plugins. The `*` is replaced with the plugin slug (e.g., `woocommerce-subscriptions` becomes `fc_enable_compat_plugin_woocommerce-subscriptions`).
**Parameters**
- `$enabled` (bool) Whether to enable compatibility for the specific plugin. Defaults to `true`.
**Context** Used in `fluid-checkout.php` when loading plugin compatibility files
**Example**
```php
/**
 * Disable compatibility for a specific plugin
 */
add_filter( 'fc_enable_compat_plugin_woocommerce-subscriptions', '__return_false', 10 );
```

#### Theme Compatibility

#### `fc_enable_compat_theme_*`
**Description** Controls whether to load compatibility files for specific themes. The `*` is replaced with the theme slug (e.g., `woodmart` becomes `fc_enable_compat_theme_woodmart`).
**Parameters**
- `$enabled` (bool) Whether to enable compatibility for the specific theme. Defaults to `true`.
**Context** Used in `fluid-checkout.php` when loading theme compatibility files
**Example**
```php
/**
 * Disable compatibility for a specific theme
 */
add_filter( 'fc_enable_compat_theme_woodmart', '__return_false', 10 );
```
#### `fc_enable_compat_plugin_style_*`
**Description** Controls whether to load plugin-specific CSS compatibility files. The `*` is replaced with the plugin slug.
**Parameters**
- `$enabled` (bool) Whether to enable style compatibility for the specific plugin. Defaults to `true`.
**Context** Used in `inc/enqueue.php` when enqueuing plugin compatibility styles
**Example**
```php
/**
 * Disable style compatibility for a specific plugin
 */
add_filter( 'fc_enable_compat_plugin_style_woocommerce-subscriptions', '__return_false', 10 );
```

#### `fc_enable_compat_theme_style_*`
**Description** Controls whether to load theme-specific CSS compatibility files. The `*` is replaced with the theme slug.
**Parameters**
- `$enabled` (bool) Whether to enable style compatibility for the specific theme. Defaults to `true`.
**Context** Used in `inc/enqueue.php` when enqueuing theme compatibility styles
**Example**
```php
/**
 * Disable style compatibility for a specific theme
 */
add_filter( 'fc_enable_compat_theme_style_woodmart', '__return_false', 10 );
```

#### `fc_enable_compat_theme_account_style_*`
**Description** Controls whether to load theme-specific CSS compatibility files for account pages. The `*` is replaced with the theme slug.
**Parameters**
- `$enabled` (bool) Whether to enable account page style compatibility for the specific theme. Defaults to `true`.
**Context** Used in `inc/enqueue.php` when enqueuing account page compatibility styles
**Example**
```php
/**
 * Disable account page style compatibility for a specific theme
 */
add_filter( 'fc_enable_compat_theme_account_style_woodmart', '__return_false', 10 );
```

#### `fc_enable_compat_theme_edit_address_style_*`
**Description** Controls whether to load theme-specific CSS compatibility files for edit address pages. The `*` is replaced with the theme slug.
**Parameters**
- `$enabled` (bool) Whether to enable edit address page style compatibility for the specific theme. Defaults to `true`.
**Context** Used in `inc/enqueue.php` when enqueuing edit address page compatibility styles
**Example**
```php
/**
 * Disable edit address page style compatibility for a specific theme
 */
add_filter( 'fc_enable_compat_theme_edit_address_style_woodmart', '__return_false', 10 );
```

#### `fc_enable_compat_plugin_edit_address_style_*`
**Description** Controls whether to load plugin-specific CSS compatibility files for edit address pages. The `*` is replaced with the plugin slug.
**Parameters**
- `$enabled` (bool) Whether to enable edit address style compatibility for the specific plugin. Defaults to `true`.
**Context** Used in `inc/enqueue.php` when enqueuing edit address compatibility styles
**Example**
```php
/**
 * Disable edit address style compatibility for a specific plugin
 */
add_filter( 'fc_enable_compat_plugin_edit_address_style_woocommerce-subscriptions', '__return_false', 10 );
```
#### Payment Gateway Compatibility

#### `fc_compat_dibs_easy_skip_undo_hooks_classes`
**Description** Defines PHP feature class names to skip when undoing hooks for DIBS Easy payment gateway compatibility.
**Parameters**
- `$skip_classes` (array) Array of PHP class names to skip when undoing hooks. Defaults to `array()`.
**Context** Used in `inc/compat/plugins/compat-plugin-dibs-easy-for-woocommerce.php`
**Example**
```php
/**
 * Add custom feature classes to skip when undoing DIBS Easy hooks
 */
function add_dibs_easy_skip_classes( $skip_classes ) {
    $skip_classes[] = 'FluidCheckout_CustomFeature';
    $skip_classes[] = 'FluidCheckout_AnotherFeature';
    return $skip_classes;
}
add_filter( 'fc_compat_dibs_easy_skip_undo_hooks_classes', 'add_dibs_easy_skip_classes', 10 );
```

#### `fc_compat_dibs_easy_skip_undo_hooks_early_classes`
**Description** Defines PHP feature class names to skip early when undoing hooks for DIBS Easy payment gateway compatibility.
**Parameters**
- `$skip_classes` (array) Array of PHP class names to skip early when undoing hooks. Defaults to `array( 'FluidCheckout_CheckoutWidgetAreas' )`.
**Context** Used in `inc/compat/plugins/compat-plugin-dibs-easy-for-woocommerce.php`
**Example**
```php
/**
 * Add custom feature classes to skip early when undoing DIBS Easy hooks
 */
function add_dibs_easy_early_skip_classes( $skip_classes ) {
    $skip_classes[] = 'FluidCheckout_EarlyFeature';
    return $skip_classes;
}
add_filter( 'fc_compat_dibs_easy_skip_undo_hooks_early_classes', 'add_dibs_easy_early_skip_classes', 10 );
```

#### `fc_compat_dintero_checkout_skip_undo_hooks_classes`
**Description** Defines PHP feature class names to skip when undoing hooks for Dintero Checkout payment gateway compatibility.
**Parameters**
- `$skip_classes` (array) Array of PHP class names to skip when undoing hooks. Defaults to `array()`.
**Context** Used in `inc/compat/plugins/compat-plugin-dintero-checkout-for-woocommerce.php`
**Example**
```php
/**
 * Add custom feature classes to skip when undoing Dintero Checkout hooks
 */
function add_dintero_skip_classes( $skip_classes ) {
    $skip_classes[] = 'FluidCheckout_CustomFeature';
    return $skip_classes;
}
add_filter( 'fc_compat_dintero_checkout_skip_undo_hooks_classes', 'add_dintero_skip_classes', 10 );
```

#### `fc_compat_dintero_checkout_skip_undo_hooks_early_classes`
**Description** Defines PHP feature class names to skip early when undoing hooks for Dintero Checkout payment gateway compatibility.
**Parameters**
- `$skip_classes` (array) Array of PHP class names to skip early when undoing hooks. Defaults to `array()`.
**Context** Used in `inc/compat/plugins/compat-plugin-dintero-checkout-for-woocommerce.php`
**Example**
```php
/**
 * Add custom feature classes to skip early when undoing Dintero Checkout hooks
 */
function add_dintero_early_skip_classes( $skip_classes ) {
    $skip_classes[] = 'FluidCheckout_EarlyFeature';
    return $skip_classes;
}
add_filter( 'fc_compat_dintero_checkout_skip_undo_hooks_early_classes', 'add_dintero_early_skip_classes', 10 );
```

#### `fc_compat_klarna_checkout_skip_undo_hooks_classes`
**Description** Defines PHP feature class names to skip when undoing hooks for Klarna Checkout payment gateway compatibility.
**Parameters**
- `$skip_classes` (array) Array of PHP class names to skip when undoing hooks. Defaults to `array()`.
**Context** Used in `inc/compat/plugins/compat-plugin-klarna-checkout-for-woocommerce.php`
**Example**
```php
/**
 * Add custom feature classes to skip when undoing Klarna Checkout hooks
 */
function add_klarna_skip_classes( $skip_classes ) {
    $skip_classes[] = 'FluidCheckout_CustomFeature';
    return $skip_classes;
}
add_filter( 'fc_compat_klarna_checkout_skip_undo_hooks_classes', 'add_klarna_skip_classes', 10 );
```

#### `fc_compat_klarna_checkout_skip_undo_hooks_early_classes`
**Description** Defines PHP feature class names to skip early when undoing hooks for Klarna Checkout payment gateway compatibility.
**Parameters**
- `$skip_classes` (array) Array of PHP class names to skip early when undoing hooks. Defaults to `array()`.
**Context** Used in `inc/compat/plugins/compat-plugin-klarna-checkout-for-woocommerce.php`
**Example**
```php
/**
 * Add custom feature classes to skip early when undoing Klarna Checkout hooks
 */
function add_klarna_early_skip_classes( $skip_classes ) {
    $skip_classes[] = 'FluidCheckout_EarlyFeature';
    return $skip_classes;
}
add_filter( 'fc_compat_klarna_checkout_skip_undo_hooks_early_classes', 'add_klarna_early_skip_classes', 10 );
```

#### `fc_compat_payson_checkout_skip_undo_hooks_classes`
**Description** Defines PHP feature class names to skip when undoing hooks for Payson Checkout payment gateway compatibility.
**Parameters**
- `$skip_classes` (array) Array of PHP class names to skip when undoing hooks. Defaults to `array()`.
**Context** Used in `inc/compat/plugins/compat-plugin-krokedil-paysoncheckout-20-for-woocommerce.php`
**Example**
```php
/**
 * Add custom feature classes to skip when undoing Payson Checkout hooks
 */
function add_payson_skip_classes( $skip_classes ) {
    $skip_classes[] = 'FluidCheckout_CustomFeature';
    return $skip_classes;
}
add_filter( 'fc_compat_payson_checkout_skip_undo_hooks_classes', 'add_payson_skip_classes', 10 );
```

#### `fc_compat_payson_checkout_skip_undo_hooks_early_classes`
**Description** Defines PHP feature class names to skip early when undoing hooks for Payson Checkout payment gateway compatibility.
**Parameters**
- `$skip_classes` (array) Array of PHP class names to skip early when undoing hooks. Defaults to `array()`.
**Context** Used in `inc/compat/plugins/compat-plugin-krokedil-paysoncheckout-20-for-woocommerce.php`
**Example**
```php
/**
 * Add custom feature classes to skip early when undoing Payson Checkout hooks
 */
function add_payson_early_skip_classes( $skip_classes ) {
    $skip_classes[] = 'FluidCheckout_EarlyFeature';
    return $skip_classes;
}
add_filter( 'fc_compat_payson_checkout_skip_undo_hooks_early_classes', 'add_payson_early_skip_classes', 10 );
```
#### Specific Theme and Plugin Compatibility

#### `fc_compat_theme_woodmart_disable_theme_checkout_options`
**Description** Controls whether to disable Woodmart theme checkout options (product image, quantity field, remove button, and product page link).
**Parameters**
- `$disable` (bool) Whether to disable theme checkout options. Defaults to `true` (enabled by default).
**Context** Used in `inc/compat/themes/compat-theme-woodmart.php` to control theme-specific checkout features
**Example**
```php
/**
 * Enable Woodmart theme checkout options
 */
add_filter( 'fc_compat_theme_woodmart_disable_theme_checkout_options', '__return_false', 10 );
```

#### `fc_compat_wcbcf_disable_marked_input_phone_feature`
**Description** Controls whether to disable the marked input phone feature for WooCommerce Brazilian Checkout Fields (WCBCF) compatibility.
**Parameters**
- `$disable` (bool) Whether to disable the marked input phone feature. Defaults to `false`.
**Context** Used in WCBCF compatibility files
**Example**
```php
/**
 * Disable marked input phone feature for WCBCF
 */
add_filter( 'fc_compat_wcbcf_disable_marked_input_phone_feature', '__return_true', 10 );
```

#### `fc_integration_woo_checkout_field_editor_pro_enable_edit_address_changes`
**Description** Controls whether to enable edit address changes for WooCommerce Checkout Field Editor Pro integration.
**Parameters**
- `$enable` (string) Whether to enable edit address changes. Defaults to `'yes'`.
**Context** Used in WooCommerce Checkout Field Editor Pro integration
**Example**
```php
/**
 * Disable edit address changes for WC Checkout Field Editor Pro
 */
function fc_disable_checkout_field_editor_pro_edit_address_changes( $enable ) {
	return 'no';
}
add_filter( 'fc_integration_woo_checkout_field_editor_pro_enable_edit_address_changes', 'fc_disable_checkout_field_editor_pro_edit_address_changes', 10 );
```

#### `fc_pro_override_template_with_theme_file`
**Description** Controls whether to override Pro template files with theme files.
**Parameters**
- `$override` (bool) Whether to override with theme file. Defaults to `false`.
**Context** Used in Pro features when locating template files
**Example**
```php
/**
 * Enable Pro template override with theme files
 */
add_filter( 'fc_pro_override_template_with_theme_file', '__return_true', 10 );
```

#### `fc_thwcfe_clear_field_keys_skip_list`
**Description** Defines field keys to skip when clearing THWCFE (ThemeHigh WooCommerce Checkout Field Editor) fields from session after order processing.
**Parameters**
- `$skip_field_keys` (array) Array of field keys to skip when clearing. Defaults to `array( 'billing_email', 'billing_first_name', 'billing_last_name', 'billing_company', 'billing_phone' )`.
**Context** Used in `inc/compat/plugins/compat-plugin-woocommerce-checkout-field-editor-pro.php`
**Example**
```php
/**
 * Add custom field keys to skip when clearing THWCFE fields
 */
function add_thwcfe_skip_field_keys( $skip_field_keys ) {
    $skip_field_keys[] = 'billing_custom_field';
    $skip_field_keys[] = 'shipping_custom_field';
    return $skip_field_keys;
}
add_filter( 'fc_thwcfe_clear_field_keys_skip_list', 'add_thwcfe_skip_field_keys', 10 );
```

## Checkout Steps Management

### Step Registration and Configuration

#### `fc_register_checkout_step_args`
**Description** Modifies arguments when registering checkout steps, allowing customization of step properties.
**Parameters**
- `$step_args` (array) Array of step configuration arguments including:
  - `step_id` (string) Unique identifier for the step.
  - `step_title` (string) Display title for the step.
  - `proceed_to_step_button_label` (string) Label for the proceed button.
  - `priority` (int) Step priority/order.
  - `next_step_button_classes` (array) Array of CSS classes to add to the "Next step" button.
  - `render_condition_callback` (callable, optional) Function to determine if the step should be rendered.
  - `substeps` (array, optional) Array of substeps to be displayed within the checkout step.
**Context** Used in `inc/checkout-steps.php` during step registration
**Example**
```php
/**
 * Customize checkout step arguments
 */
function customize_checkout_step_args( $step_args ) {
    if ( 'billing' === $step_args['step_id'] ) {
        $step_args['next_step_button_classes'][] = 'custom-billing-button-class';
    }
    return $step_args;
}
add_filter( 'fc_register_checkout_step_args', 'customize_checkout_step_args', 10 );
```

#### `fc_register_checkout_substep_args`
**Description** Modifies arguments when registering checkout substeps, allowing customization of substep properties.
**Parameters**
- `$substep_args` (array) Array of substep configuration arguments containing:
  - `substep_id` (string)(required) Unique identifier for the substep.
  - `substep_title` (string) Display title for the substep.
  - `priority` (int) Display order priority for the substep.
  - `render_fields_callback` (callable)(required) Function to render substep fields.
  - `render_review_text_callback` (callable)(required) Function to render substep review text.
  - `render_condition_callback` (callable, optional) Function to determine if substep should be rendered.
  - `is_complete_callback` (callable, optional) Function to determine if substep is complete.
- `$step_id` (string) The parent step ID ('contact', 'shipping', 'billing', or 'payment').
**Context** Used in `inc/checkout-steps.php` during substep registration
**Example**
```php
/**
 * Customize checkout substep arguments
 */
function customize_checkout_substep_args( $substep_args, $step_id ) {
    if ( 'shipping_address' === $substep_args['substep_id'] ) {
        $substep_args['substep_title'] = __( 'Delivery Address', 'my-theme' );
    }
    return $substep_args;
}
add_filter( 'fc_register_checkout_substep_args', 'customize_checkout_substep_args', 10, 2 );
```

#### `fc_get_checkout_steps_before`
**Description** Allows intercepting the checkout steps before they are returned, enabling complete customization of the steps array.
**Parameters**
- `$steps` (array|null) The checkout steps array or null if not intercepted.
- `$context` (string) The context in which steps are being retrieved (default: 'checkout').
**Context** Used in `inc/checkout-steps.php` before returning checkout steps
**Example**
```php
/**
 * Intercept checkout steps for custom implementation
 */
function intercept_checkout_steps( $steps, $context ) {
    if ( 'checkout' === $context ) {
        // Return custom steps array
        return array(
            'custom_step_1' => array(
                'step_id' => 'custom_step_1',
                'step_title' => __( 'Custom Step', 'my-theme' ),
                'priority' => 5,
            ),
        );
    }
    return $steps;
}
add_filter( 'fc_get_checkout_steps_before', 'intercept_checkout_steps', 10, 2 );
```

#### `fc_is_checkout_page_or_fragment`
**Description** Determines if the current page is a checkout page or checkout fragment (AJAX request).
**Parameters**
- `$is_checkout` (bool) Whether the current page is checkout. Defaults to `false`.
**Context** Used in `inc/checkout-steps.php` to identify checkout contexts
**Example**
```php
/**
 * Mark custom page as checkout page
 */
function mark_custom_page_as_checkout( $is_checkout ) {
    if ( is_page( 'custom-checkout' ) ) {
        return true;
    }
    return $is_checkout;
}
add_filter( 'fc_is_checkout_page_or_fragment', 'mark_custom_page_as_checkout', 10 );
```

#### `fc_is_cart_page_or_fragment`
**Description** Determines if the current page is a cart page or cart fragment (AJAX request).
**Parameters**
- `$is_cart` (bool) Whether the current page is cart. Defaults to `false`.
**Context** Used in various places to identify cart contexts
**Example**
```php
/**
 * Mark custom page as cart page
 */
function mark_custom_page_as_cart( $is_cart ) {
    if ( is_page( 'custom-cart' ) ) {
        return true;
    }
    return $is_cart;
}
add_filter( 'fc_is_cart_page_or_fragment', 'mark_custom_page_as_cart', 10 );
```

### Step Titles and Labels

#### `fc_step_title_contact`
**Description** Modifies the contact step title text.
**Parameters**
- `$title` (string) The contact step title. Defaults to `_x( 'Contact', 'Checkout step title', 'fluid-checkout' )`.
**Context** Used in `inc/checkout-steps.php` when registering the contact step
**Note** Step titles are hidden by default (using `screen-reader-text` class) and only visible to screen readers. They are used for accessibility and JavaScript functionality. To make them visually visible, you'll need to add CSS to override the `screen-reader-text` class.
**Example**
```php
/**
 * Customize contact step title
 */
function customize_contact_step_title( $title ) {
    return __( 'Your Information', 'my-theme' );
}
add_filter( 'fc_step_title_contact', 'customize_contact_step_title', 10 );
```

#### `fc_step_title_shipping`
**Description** Modifies the shipping step title text.
**Parameters**
- `$title` (string) The shipping step title. Defaults to `_x( 'Shipping', 'Checkout step title', 'fluid-checkout' )`
**Context** Used in `inc/checkout-steps.php` when registering the shipping step
**Note** Step titles are hidden by default (using `screen-reader-text` class) and only visible to screen readers. They are used for accessibility and JavaScript functionality. To make them visually visible, you'll need to add CSS to override the `screen-reader-text` class.
**Example**
```php
/**
 * Customize shipping step title
 */
function customize_shipping_step_title( $title ) {
    return __( 'Delivery Details', 'my-theme' );
}
add_filter( 'fc_step_title_shipping', 'customize_shipping_step_title', 10 );
```

#### `fc_step_title_billing`
**Description** Modifies the billing step title text.
**Parameters**
- `$title` (string) The billing step title. Defaults to `_x( 'Billing', 'Checkout step title', 'fluid-checkout' )`
**Context** Used in `inc/checkout-steps.php` when registering the billing step
**Note** Step titles are hidden by default (using `screen-reader-text` class) and only visible to screen readers. They are used for accessibility and JavaScript functionality. To make them visually visible, you'll need to add CSS to override the `screen-reader-text` class.
**Example**
```php
/**
 * Customize billing step title
 */
function customize_billing_step_title( $title ) {
    return __( 'Payment Information', 'my-theme' );
}
add_filter( 'fc_step_title_billing', 'customize_billing_step_title', 10 );
```

#### `fc_step_title_payment`
**Description** Modifies the payment step title text.
**Parameters**
- `$title` (string) The payment step title. Defaults to `_x( 'Payment', 'Checkout step title', 'fluid-checkout' )`
**Context** Used in `inc/checkout-steps.php` when registering the payment step
**Note** Step titles are hidden by default (using `screen-reader-text` class) and only visible to screen readers. They are used for accessibility and JavaScript functionality. To make them visually visible, you'll need to add CSS to override the `screen-reader-text` class.
**Example**
```php
/**
 * Customize payment step title
 */
function customize_payment_step_title( $title ) {
    return __( 'Complete Order', 'my-theme' );
}
add_filter( 'fc_step_title_payment', 'customize_payment_step_title', 10 );
```

**Making Step Titles Visually Visible**

To make the step titles visible on the frontend, add this CSS to your theme:

```css
.fc-step__title.screen-reader-text {
    position: static !important;
    clip: auto !important;
    height: auto !important;
    width: auto !important;
    overflow: visible !important;
}
```

#### `fc_proceed_to_next_step_button_label`
**Description** Modifies the proceed to next step button label text.
**Parameters**
- `$label` (string) The button label text.
- `$step_id` (string) The current step ID.
**Context** Used in `inc/checkout-steps.php` when displaying step buttons
**Example**
```php
/**
 * Customize proceed button labels
 */
function customize_proceed_button_labels( $label, $step_id ) {
    if ( 'contact' === $step_id ) {
        return __( 'Continue to Delivery', 'my-theme' );
    }
    return $label;
}
add_filter( 'fc_proceed_to_next_step_button_label', 'customize_proceed_button_labels', 10, 2 );
```

#### `fc_next_step_button_label`
**Description** Modifies the next step button label text.
**Parameters**
- `$label` (string) The button label text.
- `$step_id` (string) The current step ID.
**Context** Used in `inc/checkout-steps.php` when displaying next step buttons
**Example**
```php
/**
 * Customize next step button labels
 */
function customize_next_step_button_labels( $label, $step_id ) {
    return __( 'Next', 'my-theme' );
}
add_filter( 'fc_next_step_button_label', 'customize_next_step_button_labels', 10, 2 );
```

#### `fc_next_step_button_classes`
**Description** Adds custom CSS classes to the next step button.
**Parameters**
- `$classes` (array) Array of CSS classes for the button. Defaults to `array( 'button' )`
**Context** Used in `inc/checkout-steps.php` when building button attributes
**Example**
```php
/**
 * Add custom classes to next step button
 */
function add_custom_next_step_button_classes( $classes ) {
    $classes[] = 'custom-button';
    $classes[] = 'btn-primary';
    return $classes;
}
add_filter( 'fc_next_step_button_classes', 'add_custom_next_step_button_classes', 10 );
```

### Step Completion and Navigation

#### `fc_is_step_complete`
**Description** Controls whether a checkout step is considered complete, affecting step navigation and validation.
**Parameters**
- `$is_complete` (bool) Whether the step is complete.
- `$step_id` (string) The step identifier.
- `$context` (string) The context in which the step is being checked (default: 'checkout').
**Context** Used in `inc/checkout-steps.php` when determining step completion status
**Example**
```php
/**
 * Custom step completion logic
 */
function custom_step_completion_logic( $is_complete, $step_id, $context ) {
    if ( 'shipping' === $step_id ) {
        // Require shipping address line 2 for shipping step completion
        $address_2 = WC()->checkout()->get_value( 'shipping_address_2' );
        return ! empty( $address_2 );
    }
    return $is_complete;
}
add_filter( 'fc_is_step_complete', 'custom_step_completion_logic', 10, 3 );
```

#### `fc_is_step_complete_*`
**Description** Controls completion for specific steps using dynamic filter names (e.g., `fc_is_step_complete_contact`).
**Parameters**
- `$is_complete` (bool) Whether the specific step is complete.
- `$context` (string) The context in which the step is being checked.
**Context** Used in `inc/checkout-steps.php` for step-specific completion checks
**Example**
```php
/**
 * Custom contact step completion
 */
function custom_contact_step_completion( $is_complete, $context ) {
    // Add custom validation for contact step
    $email = WC()->checkout()->get_value( 'billing_email' );
    return ! empty( $email ) && is_email( $email );
}
add_filter( 'fc_is_step_complete_contact', 'custom_contact_step_completion', 10, 2 );
```

#### `fc_is_current_step`
**Description** Determines if a step is the current active step in the checkout flow.
**Parameters**
- `$is_current` (bool) Whether the step is current.
- `$step_id` (string) The step identifier..
- `$context` (string) The context in which the step is being checked.
**Context** Used in `inc/checkout-steps.php` when determining active step
**Example**
```php
/**
 * Custom current step logic
 */
function custom_current_step_logic( $is_current, $step_id, $context ) {
    // Force specific step as current based on conditions
    if ( 'payment' === $step_id && is_user_logged_in() ) {
        return true;
    }
    return $is_current;
}
add_filter( 'fc_is_current_step', 'custom_current_step_logic', 10, 3 );
```

#### `fc_checkout_maybe_disable_place_order_button`
**Description** Controls whether the place order button should be disabled when not in the last step of a multistep checkout layout.
**Parameters**
- `$value` (string) Whether to enable the disable functionality. Defaults to `'yes'`. Use `'no'` to disable this feature.
**Context** Used in checkout steps to determine if place order button should be disabled in non-final steps
**Example**
```php
/**
 * Disable the place order button disable functionality
 */
function disable_place_order_button_disable_feature( $value ) {
    // Always allow place order button to be enabled
    return 'no';
}
add_filter( 'fc_checkout_maybe_disable_place_order_button', 'disable_place_order_button_disable_feature', 10 );
```

#### `fc_checkout_steps_script_settings`
**Description** Modifies JavaScript settings for checkout steps functionality.
**Parameters**
- `$settings` (array) Array of JavaScript settings for checkout steps.
**Context** Used when enqueuing checkout steps JavaScript
**Example**
```php
/**
 * Add custom JavaScript settings for checkout steps
 */
function add_custom_checkout_steps_settings( $settings ) {
    $settings['customOption'] = 'customValue';
    return $settings;
}
add_filter( 'fc_checkout_steps_script_settings', 'add_custom_checkout_steps_settings', 10 );
```

### Progress Bar

#### `fc_checkout_progress_bar_style`
**Description** Modifies the progress bar style setting (bars or breadcrumbs).
**Parameters**
- `$style` (string) The progress bar style. Defaults to `'bars'`
**Context** Used in `inc/checkout-steps.php` when getting progress bar style
**Example**
```php
/**
 * Force breadcrumbs style
 */
function force_breadcrumbs_style( $style ) {
   return 'breadcrumbs';
}
add_filter( 'fc_checkout_progress_bar_style', 'force_breadcrumbs_style', 10 );
```

#### `fc_checkout_progress_bar_attributes`
**Description** Adds custom HTML attributes to the progress bar element.
**Parameters**
- `$attributes` (array) Array of HTML attributes as key-value pairs.
**Context** Used in `inc/checkout-steps.php` when building progress bar attributes
**Example**
```php
/**
 * Add custom attributes to progress bar
 */
function add_custom_progress_bar_attributes( $attributes ) {
    $attributes['class'] = 'custom-progress-bar';
    return $attributes;
}
add_filter( 'fc_checkout_progress_bar_attributes', 'add_custom_progress_bar_attributes', 10 );
```

#### `fc_checkout_progress_bar_inner_attributes`
**Description** Adds custom HTML attributes to the progress bar inner element.
**Parameters**
- `$attributes` (array) Array of HTML attributes as key-value pairs.
**Context** Used in `inc/checkout-steps.php` when building progress bar inner attributes
**Example**
```php
/**
 * Add custom attributes to progress bar inner element
 */
function add_custom_progress_bar_inner_attributes( $attributes ) {
    $attributes['data-animation'] = 'slide';
    return $attributes;
}
add_filter( 'fc_checkout_progress_bar_inner_attributes', 'add_custom_progress_bar_inner_attributes', 10 );
```

#### `fc_checkout_progress_bar_display_count`
**Description** Controls whether to display step count in the progress bar.
**Parameters**
- `$display_count` (bool) Whether to display step count. Defaults to `true`.
**Context** Used in `inc/checkout-steps.php` when rendering progress bar
**Example**
```php
/**
 * Hide step count in progress bar
 */
add_filter( 'fc_checkout_progress_bar_display_count', '__return_false', 10 );
```

#### `fc_checkout_step_attributes`
**Description** Adds custom HTML attributes to individual checkout steps.
**Parameters**
- `$attributes` (array) Array of HTML attributes as key-value pairs.
- `$step_id` (string) The step identifier.
- `$step_index` (int) The step index.
- `$context` (string) The context in which the step is being rendered.
**Context** Used in `inc/checkout-steps.php` when building step attributes
**Example**
```php
/**
 * Add custom attributes to checkout steps
 */
function add_custom_step_attributes( $attributes, $step_id, $step_index, $context ) {
    $attributes['data-step-custom'] = 'value';
    if ( 'contact' === $step_id ) {
        $attributes['class'] .= ' custom-contact-step';
    }
    return $attributes;
}
add_filter( 'fc_checkout_step_attributes', 'add_custom_step_attributes', 10, 4 );
```

### Step Positioning and Hooks

#### `fc_do_order_notes_hooks_position`
**Description** Controls the hook name where order notes hooks are executed.
**Parameters**
- `$position` (string) The hook name where order notes hooks are executed. Defaults to `'fc_checkout_after_step_shipping_fields_inside'`
**Context** Used in `inc/checkout-steps.php` when positioning order notes hooks
**Example**
```php
/**
 * Change order notes hooks position to run after payment fields
 */
function change_order_notes_hooks_position( $position ) {
    return 'fc_checkout_after_step_payment_fields';
}
add_filter( 'fc_do_order_notes_hooks_position', 'change_order_notes_hooks_position', 10 );
```

#### `fc_do_order_notes_hooks_priority`
**Description** Controls the priority of order notes hooks execution.
**Parameters**
- `$priority` (int) The hook priority. Defaults to `100`
**Context** Used in `inc/checkout-steps.php` when setting hook priorities
**Example**
```php
/**
 * Change order notes hooks priority
 */
function change_order_notes_hooks_priority( $priority ) {
    return 20;
}
add_filter( 'fc_do_order_notes_hooks_priority', 'change_order_notes_hooks_priority', 10 );
```

#### `fc_billing_step_hook_priority`
**Description** Controls the priority of billing step hooks execution.
**Parameters**
- `$priority` (int) The hook priority. Defaults to `30`
**Context** Used in `inc/checkout-steps.php` when setting billing step hook priorities
**Example**
```php
/**
 * Change billing step hooks priority
 */
function change_billing_step_hooks_priority( $priority ) {
	// Forces billing before shipping
	return 15;
}
add_filter( 'fc_billing_step_hook_priority', 'change_billing_step_hooks_priority', 10 );
```

#### `fc_billing_address_substep_position_args`
**Description** Controls positioning arguments for the billing address substep. The filter receives a multi-dimensional array where each position key (e.g., 'step_after_shipping', 'substep_before_shipping') contains 'step_id' and 'priority' values that determine where the billing address substep appears.

**Parameters**
- `$position_args` (array) Multi-dimensional array of position options, each containing:
  - `step_id` (string) The step to attach the billing substep to
  - `priority` (int) The priority within that step


**Example**

```php
/**
 * Customize billing address substep position
 */
function customize_billing_address_substep_position( $position_args ) {
	// Position billing after additional notes in shipping step
	$position_args['substep_after_shipping'] = array( 'step_id' => 'billing', 'priority' => 50 );
	
	return $position_args;
}
add_filter( 'fc_billing_address_substep_position_args', 'customize_billing_address_substep_position', 10 );
```

#### `fc_checkout_after_step_shipping_fields_inside`
**Description** Defines the hook position for after shipping fields inside the shipping step.
**Parameters**
- `$position` (string) The hook position. Defaults to `'inside'`
**Context** Used in `inc/checkout-steps.php` when positioning shipping field hooks
**Example**
```php
/**
 * Change shipping fields hook position
 */
function change_shipping_fields_hook_position( $position ) {
    return 'outside';
}
add_filter( 'fc_checkout_after_step_shipping_fields_inside', 'change_shipping_fields_hook_position', 10 );
```

#### `fc_checkout_wrapper_inside_element_custom_attributes`
**Description** Adds custom HTML attributes to the checkout wrapper inside element.
**Parameters**
- `$attributes` (array) Array of HTML attributes as key-value pairs.
**Context** Used in checkout templates when rendering wrapper elements
**Example**
```php
/**
 * Add custom attributes to checkout wrapper inside element
 */
function add_custom_wrapper_inside_attributes( $attributes ) {
    $attributes['data-custom'] = 'inside-wrapper';
    return $attributes;
}
add_filter( 'fc_checkout_wrapper_inside_element_custom_attributes', 'add_custom_wrapper_inside_attributes', 10 );
```

#### `fc_locale_language_variant`
**Description** Modifies the array of locale language variant mappings for internationalization. This filter allows you to customize which locale variants should map to which main locales for translation purposes.
**Parameters**
- `$variants` (array) The array of locale language variant mappings. Keys are variant locales, values are the main locales they should map to.
**Context** Used in `get_locale_language_variants()` method to determine which translation files to load for different locale variants.
**Example**
```php
/**
 * Customize locale language variant mappings
 */
function customize_locale_language_variant( $variants ) {
    // Modify existing mappings
    $variants['pt_PT'] = 'pt_BR'; // Override to pt_BR mapping
    
    return $variants;
}
add_filter( 'fc_locale_language_variant', 'customize_locale_language_variant', 10 );
```

#### `fc_show_shipping_section_highlighted`
**Description** Controls whether to highlight the shipping section.
**Parameters**
- `$highlight` (bool) Whether to highlight the shipping section. Defaults to `false`.
**Context** Used in checkout templates when rendering shipping section
**Example**
```php
/**
 * Always highlight shipping section
 */
add_filter( 'fc_show_shipping_section_highlighted', '__return_true', 10 );
```

#### `fc_show_billing_section_highlighted`
**Description** Controls whether to highlight the billing section.
**Parameters**
- `$highlight` (bool) Whether to highlight the billing section. Defaults to `false`.
**Context** Used in checkout templates when rendering billing section
**Example**
```php
/**
 * Highlight billing section for specific conditions
 */
function highlight_billing_section_conditionally( $highlight ) {
    if ( WC()->cart->needs_payment() ) {
        return true;
    }
    return $highlight;
}
add_filter( 'fc_show_billing_section_highlighted', 'highlight_billing_section_conditionally', 10 );
```

#### `fc_show_order_totals_row_highlighted`
**Description** Controls whether to highlight the order totals row.
**Parameters**
- `$highlight` (bool) Whether to highlight the order totals row. Defaults to `false`.
**Context** Used in checkout templates when rendering order totals
**Example**
```php
/**
 * Highlight order totals for high-value orders
 */
function highlight_order_totals_high_value( $highlight ) {
    $cart_total = WC()->cart->get_total( 'raw' );
    if ( $cart_total > 1000 ) {
        return true;
    }
    return $highlight;
}
add_filter( 'fc_show_order_totals_row_highlighted', 'highlight_order_totals_high_value', 10 );
```

## Contact Step

### Login and Authentication

#### `fc_enable_checkout_ajax_login`
**Description** Controls whether AJAX login is enabled at checkout.
**Parameters**
- `$enabled` (bool) Whether AJAX login is enabled. Defaults to `true`.
**Context** Used in `inc/checkout-login.php` to determine if the login feature should be active
**Example**
```php
/**
 * Disable AJAX login at checkout
 */
add_filter( 'fc_enable_checkout_ajax_login', '__return_false', 10 );
```

#### `fc_checkout_login_script_settings`
**Description** Modifies JavaScript settings for checkout login functionality.
**Parameters**
- `$settings` (array) Array of JavaScript settings for checkout login. Defaults to `array( 'checkoutLoginNonce' => wp_create_nonce( 'fc-checkout-login' ) )`.
**Context** Used in `inc/checkout-login.php` when building JavaScript settings
**Example**
```php
/**
 * Add custom JavaScript settings for checkout login
 */
function add_custom_login_settings( $settings ) {
    $settings['customOption'] = 'customValue';
    $settings['redirectUrl'] = home_url( '/block-image' );
    return $settings;
}
add_filter( 'fc_checkout_login_script_settings', 'add_custom_login_settings', 10 );
```

#### `fc_checkout_login_modal_title`
**Description** Modifies the login modal title text.
**Parameters**
- `$title` (string) The login modal title. Defaults to `__( 'Log in to your account', 'fluid-checkout' )`.
**Context** Used in `templates/fc/checkout-steps/checkout/form-contact-login-modal.php`
**Example**
```php
/**
 * Customize login modal title
 */
function customize_login_modal_title( $title ) {
    return __( 'Sign In', 'my-theme' );
}
add_filter( 'fc_checkout_login_modal_title', 'customize_login_modal_title', 10 );
```

#### `fc_checkout_login_cta_text`
**Description** Modifies the "Already have an account?" text displayed in the contact step.
**Parameters**
- `$text` (string) The CTA text. Defaults to `__( 'Already have an account?', 'fluid-checkout' )`.
**Context** Used in `templates/fc/checkout-steps/checkout/form-contact-login.php`
**Example**
```php
/**
 * Customize login CTA text
 */
function customize_login_cta_text( $text ) {
    return __( 'Returning customer?', 'my-theme' );
}
add_filter( 'fc_checkout_login_cta_text', 'customize_login_cta_text', 10 );
```

#### `fc_checkout_login_button_label`
**Description** Modifies the login button label text.
**Parameters**
- `$label` (string) The button label. Defaults to `_x( 'Log in', 'Log in link label at checkout contact step', 'fluid-checkout' )`.
**Context** Used in `templates/fc/checkout-steps/checkout/form-contact-login.php` and `templates/fc/checkout-steps/global/form-login.php`
**Example**
```php
/**
 * Customize login button label
 */
function customize_login_button_label( $label ) {
    return __( 'Sign In', 'my-theme' );
}
add_filter( 'fc_checkout_login_button_label', 'customize_login_button_label', 10 );
```

#### `fc_checkout_login_button_class`
**Description** Modifies the login button CSS class for the CTA link.
**Parameters**
- `$class` (string) The CSS class. Defaults to `'fc-contact-login__action--underline'`.
**Context** Used in `templates/fc/checkout-steps/checkout/form-contact-login.php`
**Example**
```php
/**
 * Customize login button class
 */
function customize_login_button_class( $class ) {
    $class .= ' custom-button-class';
    
    return $class;
}
add_filter( 'fc_checkout_login_button_class', 'customize_login_button_class', 10 );
```

#### `fc_checkout_login_separator_text`
**Description** Modifies the separator text between login and guest checkout.
**Parameters**
- `$text` (string) The separator text. Defaults to `_x( 'Or continue as a guest', 'Log in separator label at for when guest checkout is disabled', 'fluid-checkout' )` when guest checkout is enabled, or `_x( 'Or continue below', 'Log in separator label at for when guest checkout is disabled', 'fluid-checkout' )` when disabled.
**Context** Used in `templates/fc/checkout-steps/checkout/form-contact-login.php`
**Related WooCommerce Settings** This filter's behavior is directly tied to the WooCommerce "Enable guest checkout" setting (`woocommerce_enable_guest_checkout`) found in **WooCommerce > Settings > Accounts & Privacy > Checkout**. When guest checkout is enabled, the separator text defaults to "Or continue as a guest", and when disabled, it shows "Or continue below".
**Example**
```php
/**
 * Customize login separator text
 */
function customize_login_separator_text( $text ) {
    return __( 'Or proceed as guest', 'my-theme' );
}
add_filter( 'fc_checkout_login_separator_text', 'customize_login_separator_text', 10 );
```

#### `fc_output_checkout_contact_login_cta_section`
**Description** Controls whether to output the checkout contact login CTA section.
**Parameters**
- `$output` (string) Whether to output the section. Defaults to `'yes'`.
**Context** Used in `templates/fc/checkout-steps/checkout/form-contact-login.php`
**Example**
```php
/**
 * Hide login CTA section
 */
function hide_login_cta_section( $output ) {
    return 'no';
}
add_filter( 'fc_output_checkout_contact_login_cta_section', 'hide_login_cta_section', 10 );
```

#### `fc_output_checkout_contact_logout_cta_section`
**Description** Controls whether to output the checkout contact logout CTA section for logged-in users.
**Parameters**
- `$output` (string) Whether to output the section. Defaults to `'no'`.
**Context** Used in `templates/fc/checkout-steps/checkout/form-contact-login.php`
**Example**
```php
/**
 * Show logout CTA section for logged-in users
 */
function show_logout_cta_section( $output ) {
    return 'yes';
}
add_filter( 'fc_output_checkout_contact_logout_cta_section', 'show_logout_cta_section', 10 );
```

#### `fc_checkout_login_fields_unique_id`
**Description** Modifies the unique ID for login form fields to prevent conflicts.
**Parameters**
- `$unique_id` (string) The unique ID for form fields. Defaults to `'_' . uniqid()`.
**Context** Used in `templates/fc/checkout-steps/global/form-login.php`
**Example**
```php
/**
 * Customize login fields unique ID
 */
function customize_login_fields_unique_id( $unique_id ) {
    return '_custom_' . time();
}
add_filter( 'fc_checkout_login_fields_unique_id', 'customize_login_fields_unique_id', 10 );
```

#### `fc_checkout_login_input_classes`
**Description** Adds custom classes to login form input fields.
**Parameters**
- `$classes` (string) Additional CSS classes for input fields. Defaults to `''`.
**Context** Used in `templates/fc/checkout-steps/global/form-login.php`
**Example**
```php
/**
 * Add custom classes to login inputs
 */
function add_login_input_classes( $classes ) {
    return 'custom-input-class';
}
add_filter( 'fc_checkout_login_input_classes', 'add_login_input_classes', 10 );
```

#### `fc_checkout_login_button_classes`
**Description** Adds custom classes to the login button.
**Parameters**
- `$classes` (string) Additional CSS classes for the button. Defaults to `'woocommerce-button button'`.
**Context** Used in `templates/fc/checkout-steps/global/form-login.php`
**Example**
```php
/**
 * Add custom classes to login button
 */
function add_login_button_classes( $classes ) {
    return $classes . ' custom-login-btn primary-button';
}
add_filter( 'fc_checkout_login_button_classes', 'add_login_button_classes', 10 );
```

#### `fc_login_form_wrapper_class`
**Description** Adds custom classes to the login form wrapper element.
**Parameters**
- `$class` (string) Additional CSS classes for the wrapper. Defaults to `''`.
**Context** Used in `templates/fc/checkout-steps/checkout/form-contact-login-modal.php`
**Example**
```php
/**
 * Add custom classes to login form wrapper
 */
function add_login_form_wrapper_class( $class ) {
    return 'custom-login-wrapper theme-login-modal';
}
add_filter( 'fc_login_form_wrapper_class', 'add_login_form_wrapper_class', 10 );
```

#### `fc_login_form_class`
**Description** Adds custom classes to the login form element.
**Parameters**
- `$class` (string) Additional CSS classes for the form. Defaults to `''`.
**Context** Used in `templates/fc/checkout-steps/checkout/form-contact-login-modal.php`
**Example**
```php
/**
 * Add custom classes to login form
 */
function add_login_form_class( $class ) {
    return 'custom-login-form modal-form';
}
add_filter( 'fc_login_form_class', 'add_login_form_class', 10 );
```

#### `fc_login_form_inner_class`
**Description** Adds custom classes to the login form inner element.
**Parameters**
- `$class` (string) Additional CSS classes for the inner element. Defaults to `''`.
**Context** Used in `templates/fc/checkout-steps/checkout/form-contact-login-modal.php`
**Example**
```php
/**
 * Add custom classes to login form inner element
 */
function add_login_form_inner_class( $class ) {
    return 'custom-login-inner form-content';
}
add_filter( 'fc_login_form_inner_class', 'add_login_form_inner_class', 10 );
```

### Contact Fields

#### `fc_checkout_contact_step_field_ids`
**Description** Modifies which fields are displayed in the contact step.
**Parameters**
- `$field_ids` (array) Array of field IDs to display in contact step. Defaults to `array( 'billing_email', 'billing_first_name', 'billing_last_name', 'billing_phone' )`.
**Context** Used in `inc/checkout-steps.php` when determining which fields to show in contact step
**Example**
```php
/**
 * Add custom field to contact step
 */
function add_custom_field_to_contact_step( $field_ids ) {
    $field_ids[] = 'billing_company';
    return $field_ids;
}
add_filter( 'fc_checkout_contact_step_field_ids', 'add_custom_field_to_contact_step', 10 );
```

#### `fc_checkout_email_field_description`
**Description** Modifies the email field description text.
**Parameters**
- `$description` (string) The email field description. Defaults to `__( 'Order number and receipt will be sent to this email address.', 'fluid-checkout' )`.
**Context** Used in `inc/checkout-fields.php` when setting up field arguments
**Example**
```php
/**
 * Customize email field description
 */
function customize_email_field_description( $description ) {
    return __( 'We will send your order confirmation to this email address.', 'my-theme' );
}
add_filter( 'fc_checkout_email_field_description', 'customize_email_field_description', 10 );
```

#### `fc_checkout_field_args`
**Description** Modifies checkout field arguments for all fields.
**Parameters**
- `$fields_args` (array) Array of field arguments for checkout fields.
**Context** Used in `inc/checkout-fields.php` when applying field customizations
**Example**
```php
/**
 * Modify checkout field arguments
 */
function modify_checkout_field_args( $fields_args ) {
    // Change billing_first_name field CSS class
    if ( isset( $fields_args['billing_first_name'] ) ) {
        $fields_args['billing_first_name']['class'] = array( 'billing-first-name-class' );
    }
    
    return $fields_args;
}
add_filter( 'fc_checkout_field_args', 'modify_checkout_field_args', 10 );
```

#### `fc_apply_address_1_field_description`
**Description** Controls whether to apply the address 1 field description.
**Parameters**
- `$apply` (bool) Whether to apply the description. Defaults to `true`.
**Context** Used in `inc/checkout-fields.php` when setting up default locale field arguments
**Example**
```php
/**
 * Disable address 1 field description
 */
add_filter( 'fc_apply_address_1_field_description', '__return_false', 10 );
```

#### `fc_apply_address_2_field_description`
**Description** Controls whether to apply the address 2 field description.
**Parameters**
- `$apply` (bool) Whether to apply the description. Defaults to `true`.
**Context** Used in `inc/checkout-fields.php` when setting up default locale field arguments
**Example**
```php
/**
 * Disable address 2 field description
 */
add_filter( 'fc_apply_address_2_field_description', '__return_false', 10 );
```

#### `fc_default_locale_field_args`
**Description** Modifies default locale field arguments for address fields.
**Parameters**
- `$field_args` (array) Array of field arguments for default locale fields.
**Context** Used in `inc/checkout-fields.php` when applying default locale field customizations
**Example**
```php
/**
 * Modify default locale field arguments
 */
function modify_default_locale_field_args( $field_args ) {
    // Add custom placeholder for address_1
    $field_args['address_1']['placeholder'] = __( 'Enter your street address', 'my-theme' );
    return $field_args;
}
add_filter( 'fc_default_locale_field_args', 'modify_default_locale_field_args', 10 );
```

#### `fc_select2_field_types`
**Description** Defines which field types should render as select2 dropdowns.
**Parameters**
- `$field_types` (array) Array of field types that should use select2. Defaults to `array( 'country', 'state', 'select' )`.
**Context** Used in `inc/checkout-fields.php` when adding select2 classes to fields
**Example**
```php
/**
 * Add custom field type to select2
 */
function add_custom_field_type_to_select2( $field_types ) {
    $field_types[] = 'custom_select';
    return $field_types;
}
add_filter( 'fc_select2_field_types', 'add_custom_field_type_to_select2', 10 );

/**
 * Remove country field type from select2
 */
function remove_country_from_select2_field_types( $field_types ) {
    // Remove 'country' from the array
    $field_types = array_diff( $field_types, array( 'country' ) );
    return $field_types;
}
add_filter( 'fc_select2_field_types', 'remove_country_from_select2_field_types', 10 );
```

### Account Creation

#### `fc_checkout_display_create_account_optional_label`
**Description** Controls whether to show "optional" label for account creation checkbox.
**Parameters**
- `$display` (bool) Whether to display the optional label. Defaults to `true`.
**Context** Used in `templates/fc/checkout-steps/checkout/form-account-creation.php`
**Example**
```php
/**
 * Hide optional label for account creation
 */
add_filter( 'fc_checkout_display_create_account_optional_label', '__return_false', 10 );
```

#### `fc_checkout_account_creation_notice_message`
**Description** Modifies the account creation notice message text.
**Parameters**
- `$message` (string) The notice message. Defaults to `__( 'An account will be created with the information provided at checkout when completing the order.', 'fluid-checkout' )`.
**Context** Used in `inc/checkout-steps.php` when displaying account creation notices
**Example**
```php
/**
 * Customize account creation notice message
 */
function customize_account_creation_notice( $message ) {
    return __( 'Create an account to track your orders and save time on future purchases.', 'my-theme' );
}
add_filter( 'fc_checkout_account_creation_notice_message', 'customize_account_creation_notice', 10 );
```

#### `fc_show_account_creation_notice_checkout_contact_step_text`
**Description** Controls whether to show the account creation notice in the contact step.
**Parameters**
- `$show` (string) Whether to show the notice. Defaults to `'yes'`.
**Context** Used in `inc/checkout-steps.php` when determining if notice should be displayed
**Example**
```php
/**
 * Hide account creation notice
 */
function hide_account_creation_notice( $show ) {
    return 'no';
}
add_filter( 'fc_show_account_creation_notice_checkout_contact_step_text', 'hide_account_creation_notice', 10 );
```

### Form Validation and Display

#### `fc_checkout_email_fields_for_mailcheck`
**Description** Defines which email fields should use mailcheck for typo suggestions.
**Parameters**
- `$field_ids` (array) Array of field IDs that should use mailcheck. Defaults to `array( 'billing_email' )`.
**Context** Used in `inc/checkout-validation.php` when applying mailcheck attributes
**Example**
```php
/**
 * Add custom email field to mailcheck
 */
function add_custom_email_field_to_mailcheck( $field_ids ) {
    $field_ids[] = 'shipping_email';
    return $field_ids;
}
add_filter( 'fc_checkout_email_fields_for_mailcheck', 'add_custom_email_field_to_mailcheck', 10 );
```

#### `fc_enable_checkout_email_mailcheck`
**Description** Controls whether email typo suggestions are enabled.
**Parameters**
- `$enabled` (bool) Whether mailcheck is enabled. Defaults to `true`.
**Context** Used in `inc/checkout-validation.php` when determining if mailcheck should be active
**Example**
```php
/**
 * Disable email typo suggestions
 */
add_filter( 'fc_enable_checkout_email_mailcheck', '__return_false', 10 );
```

#### `fc_checkout_is_valid_phone_number`
**Description** Customizes phone number validation logic.
**Parameters**
- `$is_valid` (bool) Whether the phone number is valid.
- `$phone_number` (string) The phone number to validate.
**Context** Used in `inc/checkout-validation.php` when validating phone fields
**Example**
```php
/**
 * Disable phone number validation completely
 */
function disable_phone_validation( $is_valid, $phone_number ) {
    // Always return true to disable validation
    return true;
}
add_filter( 'fc_checkout_is_valid_phone_number', 'disable_phone_validation', 10, 2 );
```

#### `fc_no_validation_icon_field_types`
**Description** Defines field types that should not show validation icons.
**Parameters**
- `$field_types` (array) Array of field types to hide validation icons for. Defaults to `array( 'hidden', 'checkbox', 'radio' )`.
**Context** Used in `inc/checkout-validation.php` when adding validation classes
**Example**
```php
/**
 * Add custom field type to hide validation icons
 */
function hide_validation_icon_for_custom_fields( $field_types ) {
    $field_types[] = 'custom_field_type';
    return $field_types;
}
add_filter( 'fc_no_validation_icon_field_types', 'hide_validation_icon_for_custom_fields', 10 );
```

#### `fc_no_validation_icon_field_keys`
**Description** Defines field keys that should not show validation icons.
**Parameters**
- `$field_keys` (array) Array of field keys to hide validation icons for. Defaults to `array()`.
**Context** Used in `inc/checkout-validation.php` when adding validation classes
**Example**
```php
/**
 * Hide validation icons for specific fields
 */
function hide_validation_icons_for_specific_fields( $field_keys ) {
    $field_keys[] = 'billing_company';
    $field_keys[] = 'shipping_company';
    return $field_keys;
}
add_filter( 'fc_no_validation_icon_field_keys', 'hide_validation_icons_for_specific_fields', 10 );
```

#### `fc_checkout_validation_script_settings`
**Description** Modifies JavaScript settings for checkout validation.
**Parameters**
- `$settings` (array) Array of JavaScript settings for validation. Contains form selectors, validation messages, and mailcheck settings.
**Context** Used in `inc/checkout-validation.php` when building JavaScript settings
**Example**
```php
/**
 * Customize validation script settings
 */
function customize_validation_settings( $settings ) {
    $settings['customValue'] = 'custom-value';
    return $settings;
}
add_filter( 'fc_checkout_validation_script_settings', 'customize_validation_settings', 10 );
```

#### `fc_checkout_validation_brazilian_documents_script_settings`
**Description** Modifies settings for Brazilian document validation (CPF/CNPJ).
**Parameters**
- `$settings` (array) Array of settings for Brazilian document validation. Contains validation flags and error messages.
**Context** Used in `inc/checkout-validation.php` when building Brazilian document validation settings
**Example**
```php
/**
 * Customize Brazilian document validation settings
 */
function customize_brazilian_validation_settings( $settings ) {
    $settings['customValue'] = 'custom-value';

    return $settings;
}
add_filter( 'fc_checkout_validation_brazilian_documents_script_settings', 'customize_brazilian_validation_settings', 10 );
```

### Mobile and Accessibility

#### `fc_fix_zoom_in_form_fields_mobile_devices`
**Description** Controls whether to fix zoom issues on mobile devices by preventing form field zoom.
**Parameters**
- `$fix` (bool) Whether to apply the zoom fix. Defaults to the value of the `fc_fix_zoom_in_form_fields_mobile_devices` setting.
**Context** Used in `inc/checkout-steps.php` and `inc/account-edit-address.php` when adding viewport meta tags
**Example**
```php
/**
 * Disable mobile zoom fix
 */
add_filter( 'fc_fix_zoom_in_form_fields_mobile_devices', '__return_false', 10 );
```

#### `fc_use_verbose_loading_indicator`
**Description** Controls whether to use verbose loading indicators on blocked parts of the page.
**Parameters**
- `$use` (bool) Whether to use verbose loading indicators. Defaults to `false`.
**Context** Used in `inc/checkout-steps.php` when determining loading indicator behavior
**Example**
```php
/**
 * Enable verbose loading indicators
 */
add_filter( 'fc_use_verbose_loading_indicator', '__return_true', 10 );
```

## Shipping Step

### Shipping Methods

#### `fc_shipping_method_option_markup`
**Description** Modifies the complete markup for shipping method options in the shipping methods list.
**Parameters**
- `$markup` (string) The HTML markup for the shipping method option. Defaults to the generated markup.
- `$method` (WC_Shipping_Rate) The shipping method object.
- `$package_index` (int) The package index for the shipping method.
- `$chosen_method` (string) The currently chosen shipping method.
- `$first` (bool) Whether this is the first shipping method in the list.
**Context** Used in both checkout and cart contexts when rendering shipping method options:
- `templates/fc/checkout-steps/cart/shipping-methods-available.php` (cart context)
- `templates/compat/plugins/woocommerce-subscriptions/cart/cart-recurring-shipping.php` (subscriptions cart context)
**Example**
```php
/**
 * Customize shipping method option markup
 */
function customize_shipping_method_option_markup( $markup, $method, $package_index, $chosen_method, $first ) {
    $custom_class = 'custom-shipping-method';
    return str_replace( 'class="', 'class="' . $custom_class . ' ', $markup );
}
add_filter( 'fc_shipping_method_option_markup', 'customize_shipping_method_option_markup', 10, 5 );
```

#### `fc_shipping_method_option_start_tag_markup`
**Description** Modifies the opening tag markup for the shipping methods list container.
**Parameters**
- `$markup` (string) The opening tag HTML markup. Defaults to `<div class="shipping-methods">`.
**Context** Used in `templates/fc/checkout-steps/shipping/shipping-methods.php` when starting the shipping methods list
**Example**
```php
/**
 * Add custom attributes to shipping methods container
 */
function customize_shipping_methods_start_tag( $markup ) {
    return '<ul id="shipping_method" class="shipping-method__options" data-custom-attribute="shipping-options">';
}
add_filter( 'fc_shipping_method_option_start_tag_markup', 'customize_shipping_methods_start_tag', 10 );
```

#### `fc_shipping_method_option_end_tag_markup`
**Description** Modifies the closing tag markup for the shipping methods list container.
**Parameters**
- `$markup` (string) The closing tag HTML markup. Defaults to `</div>`.
**Context** Used in `templates/fc/checkout-steps/shipping/shipping-methods.php` when ending the shipping methods list
**Example**
```php
/**
 * Add custom content after shipping methods
 */
function customize_shipping_methods_end_tag( $markup ) {
    return '</ul><!-- End shipping methods -->';
}
add_filter( 'fc_shipping_method_option_end_tag_markup', 'customize_shipping_methods_end_tag', 10 );
```

#### `fc_shipping_method_option_label_markup`
**Description** Modifies the label markup for individual shipping method options.
**Parameters**
- `$markup` (string) The label HTML markup. Defaults to the generated label markup.
- `$method` (WC_Shipping_Rate) The shipping method object.
**Context** Used in `inc/checkout-steps.php` and `inc/compat/plugins/compat-plugin-woocommerce-subscriptions.php` when rendering shipping method labels
**Example**
```php
/**
 * Add custom styling to shipping method labels
 */
function customize_shipping_method_label( $markup, $method ) {
    $method_id = $method->get_method_id();
    $custom_class = 'custom-shipping-label-' . sanitize_html_class( $method_id );
    return str_replace( 'class="', 'class="' . $custom_class . ' ', $markup );
}
add_filter( 'fc_shipping_method_option_label_markup', 'customize_shipping_method_label', 10, 2 );
```

#### `fc_shipping_method_option_image_html`
**Description** Adds custom HTML for shipping method images/icons.
**Parameters**
- `$html` (string) The image HTML. Defaults to empty string.
- `$method` (WC_Shipping_Rate) The shipping method object.
**Context** Used in `templates/fc/checkout-steps/shipping/shipping-methods.php` when rendering shipping method images
**Example**
```php
/**
 * Add shipping method images
 */
function add_shipping_method_images( $html, $method ) {
    $method_id = $method->get_method_id();
    $image_map = array(
        'free_shipping' => '<img src="https://picsum.photos/536/354" alt="Free Shipping" class="shipping-method-image" />',
        'flat_rate' => '<img src="https://picsum.photos/536/354" alt="Standard Delivery" class="shipping-method-image" />',
        'local_pickup' => '<img src="https://picsum.photos/536/354" alt="Store Pickup" class="shipping-method-image" />',
    );
    
    if ( isset( $image_map[ $method_id ] ) ) {
        $html = $image_map[ $method_id ];
    }
    
    return $html;
}
add_filter( 'fc_shipping_method_option_image_html', 'add_shipping_method_images', 10, 2 );
```

#### `fc_shipping_method_option_image_markup`
**Description** Modifies the markup wrapper for shipping method images.
**Parameters**
- `$markup` (string) The image wrapper markup. Defaults to `<span class="shipping-method__option-image">%s</span>`.
- `$method` (WC_Shipping_Rate) The shipping method object.
- `$method_image_html` (string) The HTML content for the shipping method image.
**Context** Used in `inc/checkout-steps.php` in the `get_cart_shipping_methods_label()` method when wrapping shipping method images
**Example**
```php
/**
 * Customize shipping method image wrapper adding custom-clas
 */
function customize_shipping_method_image_markup( $markup, $method, $method_image_html ) {
    return '<span class="custom-class shipping-method__option-image">%s</span>';
}
add_filter( 'fc_shipping_method_option_image_markup', 'customize_shipping_method_image_markup', 10, 3 );
```

#### `fc_shipping_method_has_cost`
**Description** Controls whether a shipping method has a cost (affects free shipping display).
**Parameters**
- `$has_cost` (bool) Whether the shipping method has a cost. Defaults to `$method->get_cost() > 0`.
- `$method` (WC_Shipping_Rate) The shipping method object.
**Context** Used in `templates/fc/checkout-steps/shipping/shipping-methods.php` when determining cost display
**Example**
```php
/**
 * Always show cost for all shipping methods
 */
function force_shipping_method_cost_display( $has_cost, $method ) {
    return true;
}
add_filter( 'fc_shipping_method_has_cost', 'force_shipping_method_cost_display', 10, 2 );
```

#### `fc_shipping_method_option_price`
**Description** Modifies the price display text for shipping methods.
**Parameters**
- `$price` (string) The formatted price text. Defaults to `wc_price( $method->get_cost() )`.
- `$method` (WC_Shipping_Rate) The shipping method object.
**Context** Used in `templates/fc/checkout-steps/shipping/shipping-methods.php` when displaying shipping costs
**Example**
```php
/**
 * Customize shipping method price display
 */
function customize_shipping_method_price( $price, $method ) {
    $cost = $method->get_cost();
    if ( $cost == 0 ) {
        return '<span class="free-shipping-text">' . __( 'FREE', 'my-theme' ) . '</span>';
    }
    return $price;
}
add_filter( 'fc_shipping_method_option_price', 'customize_shipping_method_price', 10, 2 );
```

#### `fc_shipping_method_option_price_markup`
**Description** Modifies the markup wrapper for shipping method prices.
**Parameters**
- `$markup` (string) The price wrapper markup. Defaults to the generated markup.
- `$method` (WC_Shipping_Rate) The shipping method object.
**Context** Used in `templates/fc/checkout-steps/shipping/shipping-methods.php` when wrapping shipping method prices
**Example**
```php
/**
 * Add custom styling to shipping method prices
 */
function customize_shipping_method_price_markup( $markup, $method ) {
	// Get cost
	$cost = $method->get_cost();
	
	// Define return custom price classes
	$price_class = $cost == 0 ? 'price-free' : 'price-cost';
	return str_replace( 'class="', 'class="' . $price_class . ' ', $markup );
}
add_filter( 'fc_shipping_method_option_price_markup', 'customize_shipping_method_price_markup', 10, 2 );
```

#### `fc_shipping_method_description_html_element`
**Description** Defines the HTML element used for shipping method descriptions.
**Parameters**
- `$element` (string) The HTML element name. Defaults to `'small'`.
**Context** Used in `templates/fc/checkout-steps/shipping/shipping-methods.php` when rendering descriptions
**Example**
```php
/**
 * Use paragraph element for shipping method descriptions
 */
function change_shipping_method_description_element( $element ) {
    return 'p';
}
add_filter( 'fc_shipping_method_description_html_element', 'change_shipping_method_description_element', 10 );
```

#### `fc_shipping_method_option_description`
**Description** Modifies the description text for shipping method options.
**Parameters**
- `$description` (string) The description text. Defaults to `''` (empty string).
- `$method` (WC_Shipping_Rate) The shipping method object.
**Context** Used in `templates/fc/checkout-steps/shipping/shipping-methods.php` when displaying descriptions
**Example**
```php
/**
 * Add custom descriptions to shipping methods
 */
function customize_shipping_method_descriptions( $description, $method ) {
    $method_id = $method->get_method_id();
    $custom_descriptions = array(
        'free_shipping' => __( 'Free shipping on orders over $50', 'my-theme' ),
        'flat_rate' => __( 'Standard delivery in 3-5 business days', 'my-theme' ),
        'local_pickup' => __( 'Pick up from our store location', 'my-theme' ),
    );
    
    if ( isset( $custom_descriptions[ $method_id ] ) ) {
        $description = $custom_descriptions[ $method_id ];
    }
    
    return $description;
}
add_filter( 'fc_shipping_method_option_description', 'customize_shipping_method_descriptions', 10, 2 );
```

#### `fc_shipping_method_option_description_markup`
**Description** Modifies the markup wrapper for shipping method descriptions.
**Parameters**
- `$markup` (string) The description wrapper markup. Defaults to the generated markup.
- `$method` (WC_Shipping_Rate) The shipping method object.
**Context** Used in `templates/fc/checkout-steps/shipping/shipping-methods.php` when wrapping descriptions
**Example**
```php
/**
 * Add custom styling to shipping method descriptions
 */
function customize_shipping_method_description_markup( $markup, $method ) {
    return '<div class="shipping-method-description-wrapper">' . $markup . '</div>';
}
add_filter( 'fc_shipping_method_option_description_markup', 'customize_shipping_method_description_markup', 10, 2 );
```

### Shipping Address

#### `fc_shipping_phone_field_args`
**Description** Modifies the field arguments for the shipping phone field in the checkout form.
**Parameters**
- `$field_args` (array) The field arguments array. Defaults to WooCommerce phone field arguments.
**Context** Used in `inc/checkout-fields.php` when registering the shipping phone field
**Example**
```php
/**
 * Customize shipping phone field
 */
function customize_shipping_phone_field( $field_args ) {
    $field_args['class'] = array( 'form-row-wide', 'custom-class' );
    return $field_args;
}
add_filter( 'fc_shipping_phone_field_args', 'customize_shipping_phone_field', 10 );
```

#### `fc_checkout_shipping_collapsible_initial_state`
**Description** Controls the initial state (expanded/collapsed) of the shipping address collapsible section.
**Parameters**
- `$collapsible_initial_state` (string) The initial state as either `'expanded'` or `'collapsed'`. Defaults to `'expanded'` or `'collapsed'` based on shipping same as billing state.
**Context** Used in `templates/fc/checkout-steps/checkout/form-shipping.php` when rendering the collapsible section
**Example**
```php
/**
 * Start with shipping address collapsed
 */
function start_shipping_address_collapsed( $state ) {
    return 'collapsed';
}
add_filter( 'fc_checkout_shipping_collapsible_initial_state', 'start_shipping_address_collapsed', 10 );
```

#### `fc_is_shipping_address_available_for_billing`
**Description** Controls whether the shipping address is available to be used as billing address.
**Parameters**
- `$is_available` (bool) Whether shipping address is available for billing. Defaults to `true`.
**Context** Used in `inc/checkout-fields.php` when determining address availability
**Example**
```php
/**
 * Disable using shipping address for billing
 */
add_filter( 'fc_is_shipping_address_available_for_billing', '__return_false', 10 );
```

#### `fc_is_billing_address_available_for_shipping`
**Description** Controls whether the billing address is available to be used as shipping address.
**Parameters**
- `$is_available` (bool) Whether billing address is available for shipping. Defaults to `true`.
**Context** Used in `inc/checkout-fields.php` when determining address availability
**Example**
```php
/**
 * Disable using billing address for shipping
 */
add_filter( 'fc_is_billing_address_available_for_shipping', '__return_false', 10 );
```

#### `fc_shipping_same_as_billing_option_label`
**Description** Modifies the label text for the "Same as billing address" option in shipping section.
**Parameters**
- `$label` (string) The option label text. Defaults to `__( 'Same as billing address', 'fluid-checkout' )`.
**Context** Used in `templates/fc/checkout-steps/shipping/shipping-address.php` when rendering the option
**Example**
```php
/**
 * Customize shipping same as billing option label
 */
function customize_shipping_same_as_billing_label( $label ) {
    return __( 'Use billing address for shipping', 'my-theme' );
}
add_filter( 'fc_shipping_same_as_billing_option_label', 'customize_shipping_same_as_billing_label', 10 );
```

#### `fc_shipping_same_as_billing_skip_fields`
**Description** Defines which fields to skip when copying billing address to shipping address.
**Parameters**
- `$skip_fields` (array) Array of field keys to skip. Defaults to empty array.
**Context** Used in `inc/checkout-fields.php` when copying address data
**Example**
```php
/**
 * Skip phone field when copying billing to shipping
 */
function skip_phone_when_copying_billing_to_shipping( $skip_fields ) {
    $skip_fields[] = 'shipping_phone';
    return $skip_fields;
}
add_filter( 'fc_shipping_same_as_billing_skip_fields', 'skip_phone_when_copying_billing_to_shipping', 10 );
```

#### `fc_shipping_same_as_billing_field_keys`
**Description** Defines which field keys to copy from billing address to shipping address.
**Parameters**
- `$field_keys` (array) Array of field keys to copy. Defaults to standard address fields.
**Context** Used in `inc/checkout-fields.php` when copying address data
**Example**
```php
/**
 * Add custom field to billing to shipping copy
 */
function add_custom_field_to_billing_shipping_copy( $field_keys ) {
    $field_keys[] = 'billing_company';
    return $field_keys;
}
add_filter( 'fc_shipping_same_as_billing_field_keys', 'add_custom_field_to_billing_shipping_copy', 10 );
```

#### `fc_output_shipping_same_as_billing_as_hidden_field`
**Description** Controls whether to output the shipping same as billing option as a hidden field instead of a checkbox.
**Parameters**
- `$output_as_hidden` (bool) Whether to output as hidden field. Defaults to `false`.
**Context** Used in `templates/fc/checkout-steps/shipping/shipping-address.php` when rendering the option
**Example**
```php
/**
 * Force shipping same as billing as hidden field
 */
add_filter( 'fc_output_shipping_same_as_billing_as_hidden_field', '__return_true', 10 );
```

### Shipping Package Display

#### `fc_shipping_method_display_package_name`
**Description** Controls whether to display package names in the shipping methods section.
**Parameters**
- `$display_package_name` (bool) Whether to display package names. Defaults to `false`.
**Context** Used in `templates/fc/checkout-steps/shipping/shipping-methods.php` when rendering package information
**Example**
```php
/**
 * Show package names in shipping methods
 */
add_filter( 'fc_shipping_method_display_package_name', '__return_true', 10 );
```

#### `fc_shipping_method_display_package_content_substep_text_lines`
**Description** Controls whether to display package content information in the substep text.
**Parameters**
- `$display_content` (bool) Whether to display package content. Defaults to `true`.
**Context** Used in `inc/checkout-steps.php` when generating substep text
**Example**
```php
/**
 * Hide package content in substep text
 */
add_filter( 'fc_shipping_method_display_package_content_substep_text_lines', '__return_false', 10 );
```

#### `fc_shipping_method_display_package_destination_substep_text_lines`
**Description** Controls whether to display package destination information in the substep text.
**Parameters**
- `$display_destination` (bool) Whether to display package destination. Defaults to `true`.
**Context** Used in `inc/checkout-steps.php` when generating substep text
**Example**
```php
/**
 * Hide package destination in substep text
 */
add_filter( 'fc_shipping_method_display_package_destination_substep_text_lines', '__return_false', 10 );
```

#### `fc_cart_has_multiple_packages`
**Description** Determines if the cart has multiple shipping packages (affects display logic).
**Parameters**
- `$has_multiple_packages` (bool) Whether cart has multiple packages. Defaults to `count( $packages ) > 1`.
**Context** Used in `inc/checkout-steps.php` when determining package display logic
**Example**
```php
/**
 * Force single package display even with multiple packages
 */
function force_single_package_display( $has_multiple_packages ) {
    return false; // Always treat as single package
}
add_filter( 'fc_cart_has_multiple_packages', 'force_single_package_display', 10, 1 );
```

#### `fc_shipping_method_substep_text_chosen_method_label`
**Description** Modifies the label text for the chosen shipping method in substep text.
**Parameters**
- `$chosen_method_label` (string) The chosen method label. Defaults to shipping method label or `__( 'Not selected yet.', 'fluid-checkout' )`.
- `$method` (WC_Shipping_Rate|null) The shipping method object.
**Context** Used in `inc/checkout-steps.php` when generating substep text
**Example**
```php
/**
 * Customize chosen shipping method label
 */
function customize_chosen_shipping_method_label( $chosen_method_label, $method ) {
    return __( 'Selected shipping', 'my-theme' );
}
add_filter( 'fc_shipping_method_substep_text_chosen_method_label', 'customize_chosen_shipping_method_label', 10, 2 );
```

#### `fc_shipping_method_substep_text_package_destination_data`
**Description** Modifies the package destination data used for generating substep text.
**Parameters**
- `$destination_data` (array) The destination data array.
- `$package_index` (int) The package index.
- `$package` (array) The shipping package data.
- `$chosen_method` (string) The chosen shipping method.
- `$method` (WC_Shipping_Rate) The shipping method object.
**Context** Used in `inc/checkout-steps.php` when generating substep text
**Example**
```php
/**
 * Add custom data to package destination
 */
function add_custom_package_destination_data( $destination_data, $package_index, $package, $chosen_method, $method ) {
    $destination_data['custom_field'] = 'Custom value';
    return $destination_data;
}
add_filter( 'fc_shipping_method_substep_text_package_destination_data', 'add_custom_package_destination_data', 10, 5 );
```

#### `fc_shipping_method_substep_text_package_destination_text`
**Description** Modifies the package destination text displayed in substep text.
**Parameters**
- `$destination_text` (string) The destination text. Defaults to formatted address.
- `$package_index` (int) The package index.
- `$package` (array) The shipping package data.
- `$chosen_method` (string) The chosen shipping method.
- `$method` (WC_Shipping_Rate) The shipping method object.
**Context** Used in `inc/checkout-steps.php` when generating substep text
**Example**
```php
/**
 * Customize package destination text
 */
function customize_package_destination_text( $destination_text, $package_index, $package, $chosen_method, $method ) {
    return 'Destination: ' . $destination_text;
}
add_filter( 'fc_shipping_method_substep_text_package_destination_text', 'customize_package_destination_text', 10, 5 );
```

#### `fc_shipping_method_substep_text_package_review_text_lines_before_contents`
**Description** Modifies the text lines displayed before package contents in substep text.
**Parameters**
- `$text_lines` (array) Array of text lines. Defaults to array containing existing content (package name, shipping method label, and destination if applicable).
- `$package_index` (int) The package index.
- `$package` (array) The shipping package data.
- `$chosen_method` (string) The chosen shipping method.
- `$method` (WC_Shipping_Rate) The shipping method object.
**Context** Used in `inc/checkout-steps.php` when generating substep text
**Example**
```php
/**
 * Add custom text before package contents
 */
function add_text_before_package_contents( $text_lines, $package_index, $package, $chosen_method, $method ) {
    $text_lines[] = __( 'Package details:', 'my-theme' );
    return $text_lines;
}
add_filter( 'fc_shipping_method_substep_text_package_review_text_lines_before_contents', 'add_text_before_package_contents', 10, 5 );
```

#### `fc_shipping_method_substep_text_package_review_text_lines`
**Description** Modifies the package review text lines displayed in substep text.
**Parameters**
- `$text_lines` (array) Array of text lines. Defaults to generated review text.
- `$package_index` (int) The package index.
- `$package` (array) The shipping package data.
- `$chosen_method` (string) The chosen shipping method.
- `$method` (WC_Shipping_Rate) The shipping method object.
**Context** Used in `inc/checkout-steps.php` when generating substep text
**Example**
```php
/**
 * Customize package review text lines
 */
function customize_package_review_text_lines( $text_lines, $package_index, $package, $chosen_method, $method ) {
    // Add custom line at the beginning
    array_unshift( $text_lines, __( 'Review your shipping:', 'my-theme' ) );
    return $text_lines;
}
add_filter( 'fc_shipping_method_substep_text_package_review_text_lines', 'customize_package_review_text_lines', 10, 5 );
```

#### `fc_shipping_same_as_billing_display_substep_review_text_notice`
**Description** Controls whether to display a "same as billing" notice in the substep text.
**Parameters**
- `$display_notice` (bool) Whether to display the notice. Defaults to `true`.
**Context** Used in `inc/checkout-steps.php` when generating substep text
**Example**
```php
/**
 * Hide same as billing notice in substep text
 */
add_filter( 'fc_shipping_same_as_billing_display_substep_review_text_notice', '__return_false', 10 );
```

### Shipping Method Selection

#### `fc_shipping_methods_disable_auto_select`
**Description** Controls whether to disable automatic selection of shipping methods (first available method).
**Parameters**
- `$disable_auto_select` (bool) Whether to bail out and allow auto-selection. Defaults to `true` (when setting is 'no').
- `$default` (string) Default shipping method from WooCommerce.
- `$rates` (array) Available shipping rates for the package.
- `$chosen_method` (string) Currently chosen method ID.
**Context** Used in `inc/checkout-steps.php` when processing the `woocommerce_shipping_chosen_method` filter
**Configuration** Admin: WooCommerce → Settings → Checkout → Shipping methods → "Prevent automatic selection of the first shipping method"
**Note** This filter has counterintuitive behavior: `true` allows auto-selection, `false` prevents it.
**Example**
```php
/**
 * Allow automatic shipping method selection (default behavior)
 */
add_filter( 'fc_shipping_methods_disable_auto_select', '__return_true', 10 );

/**
 * Prevent automatic shipping method selection
 */
add_filter( 'fc_shipping_methods_disable_auto_select', '__return_false', 10 );
```

#### `fc_is_substep_complete_shipping_address`
**Description** Controls whether the shipping address substep is considered complete.
**Parameters**
- `$is_complete` (bool) Whether the substep is complete. Defaults to validation result.
**Context** Used in `inc/checkout-steps.php` when checking substep completion
**Example**
```php
/**
 * Always consider shipping address complete
 */
add_filter( 'fc_is_substep_complete_shipping_address', '__return_true', 10 );
```

#### `fc_is_substep_complete_shipping_address_field_keys_skip_list`
**Description** Defines which field keys to skip when checking shipping address completion.
**Parameters**
- `$skip_field_keys` (array) Array of field keys to skip. Defaults to empty array.
**Context** Used in `inc/checkout-steps.php` when validating address completion
**Example**
```php
/**
 * Skip phone field when checking shipping address completion
 */
function skip_phone_in_shipping_completion( $skip_field_keys ) {
    $skip_field_keys[] = 'shipping_phone';
    return $skip_field_keys;
}
add_filter( 'fc_is_substep_complete_shipping_address_field_keys_skip_list', 'skip_phone_in_shipping_completion', 10 );
```

#### `fc_is_substep_complete_shipping_method`
**Description** Controls whether the shipping method substep is considered complete.
**Parameters**
- `$is_complete` (bool) Whether the substep is complete. Defaults to validation result.
**Context** Used in `inc/checkout-steps.php` when checking substep completion
**Example**
```php
/**
 * Custom shipping method completion logic
 */
function custom_shipping_method_completion( $is_complete ) {
    // Add custom logic here
    return $is_complete && WC()->session->get( 'custom_shipping_validated' );
}
add_filter( 'fc_is_substep_complete_shipping_method', 'custom_shipping_method_completion', 10 );
```

#### `fc_is_shipping_address_data_same_as_billing_before`
**Description** Allows intercepting the comparison between shipping and billing address data before the default comparison logic runs.
**Parameters**
- `$value` (bool|null) Initial value is `null`. Return `true` if addresses should be considered the same, `false` if different, or `null` to use default comparison.
**Context** Used in `inc/checkout-steps.php` in the `is_shipping_address_data_same_as_billing()` method
**Example**
```php
/**
 * Force shipping and billing addresses to always be considered different
 * This will prevent the "Same as billing" checkbox from being checked automatically
 */
function fc_force_addresses_always_different( $value ) {
    // Return false to always consider addresses as different
    // This is useful for testing or when you want to force separate address entry
    return false;
}
add_filter( 'fc_is_shipping_address_data_same_as_billing_before', 'fc_force_addresses_always_different', 10, 1 );
```

#### `fc_is_shipping_same_as_billing_checked`
**Description** Controls whether the "shipping same as billing" checkbox is checked by default.
**Parameters**
- `$is_checked` (bool) Whether the checkbox should be checked. Defaults to `false`.
**Context** Used in `templates/fc/checkout-steps/shipping/shipping-address.php` when rendering the checkbox
**Example**
```php
/**
 * Check shipping same as billing by default
 */
add_filter( 'fc_is_shipping_same_as_billing_checked', '__return_true', 10 );
```

#### `fc_save_new_address_data_shipping_skip_update`
**Description** Controls whether to skip updating shipping address data when saving new address information.
**Parameters**
- `$skip_update` (bool) Whether to skip the update. Defaults to `false`.
**Context** Used in `inc/checkout-fields.php` when saving address data
**Example**
```php
/**
 * Skip updating shipping address data
 */
add_filter( 'fc_save_new_address_data_shipping_skip_update', '__return_true', 10 );
```

### Address Localization

#### `fc_add_phone_localisation_formats`
**Description** Controls whether to add phone number to address localization formats when displaying formatted addresses.
**Parameters**
- `$should_add` (string) Whether to add phone to formatted addresses. Accepts 'yes' or 'no'. Defaults to `'yes'`.
**Context** Used in `inc/checkout-steps.php` when generating formatted addresses for display
**Example**
```php
/**
 * Disable phone number in formatted addresses
 */
function fc_disable_phone_in_formatted_addresses( $should_add ) {
	return 'no';
}
add_filter( 'fc_add_phone_localisation_formats', 'fc_disable_phone_in_formatted_addresses', 10 );
```

#### `fc_formatted_address_replacements_custom_field_keys`
**Description** Defines custom field keys that should be added to formatted address replacements for display in addresses.
**Parameters**
- `$custom_field_keys` (array) Array of custom field keys to add to address replacements. Defaults to empty array.
**Context** Used in `inc/checkout-steps.php` when generating formatted address replacements
**Example**
```php
/**
 * Add custom fields to formatted address replacements
 */
function add_custom_address_fields( $custom_field_keys ) {
    $custom_field_keys[] = 'custom_field_1';
    $custom_field_keys[] = 'billing_custom_field_2';
    return $custom_field_keys;
}
add_filter( 'fc_formatted_address_replacements_custom_field_keys', 'add_custom_address_fields', 10, 1 );
```

#### `fc_shipping_substep_text_address_data`
**Description** Modifies shipping address data used for generating substep review text display.
**Parameters**
- `$address_data` (array) The address data array containing field values for display.
**Context** Used in `inc/checkout-steps.php` when generating shipping address substep text
**Example**
```php
/**
 * Customize shipping address data for substep display
 */
function customize_shipping_substep_data( $address_data ) {
    // Remove phone number from substep display
    unset( $address_data['phone'] );
    return $address_data;
}
add_filter( 'fc_shipping_substep_text_address_data', 'customize_shipping_substep_data', 10, 1 );
```

### Shipping Not Needed

#### `fc_shipping_not_needed_shipping_field_keys`
**Description** Defines the list of shipping field keys that should be copied from billing address when shipping is not needed.
**Parameters**
- `$field_keys` (array) Array of shipping field keys to copy from billing. Defaults to standard address fields with the `shipping_` prefix (shipping_first_name, shipping_last_name, shipping_country, shipping_state, shipping_postcode, shipping_city, shipping_address_1, shipping_address_2).
**Context** Used in `inc/checkout-steps.php` when copying billing to shipping address for non-shipping orders
**Example**
```php
/**
 * Add custom shipping fields when shipping not needed
 */
function add_custom_shipping_fields( $field_keys ) {
    $field_keys[] = 'shipping_custom_field';
    return $field_keys;
}
add_filter( 'fc_shipping_not_needed_shipping_field_keys', 'add_custom_shipping_fields', 10, 1 );
```

#### `fc_copy_billing_to_shipping_address_when_shipping_not_needed`
**Description** Controls whether to automatically copy billing address to shipping address when shipping is not needed.
**Parameters**
- `$should_copy` (bool) Whether to copy billing to shipping when shipping not needed. Defaults to `true`.
**Context** Used in `inc/checkout-steps.php` when processing checkout data for non-shipping orders
**Example**
```php
/**
 * Disable automatic copying of billing to shipping when shipping not needed
 */
add_filter( 'fc_copy_billing_to_shipping_address_when_shipping_not_needed', '__return_false', 10 );
```

## Billing Step

### Billing Address

#### `fc_checkout_billing_collapsible_initial_state`
**Description** Controls the initial state (expanded/collapsed) of the billing address collapsible section.
**Parameters**
- `$collapsible_initial_state` (string) The initial state as either `'expanded'` or `'collapsed'`. Defaults to `'expanded'` or `'collapsed'` based on billing same as shipping state.
**Context** Used in `templates/fc/checkout-steps/checkout/form-billing.php` when rendering the collapsible section
**Example**
```php
/**
 * Start with billing address collapsed
 */
function start_billing_address_collapsed( $state ) {
    return 'collapsed';
}
add_filter( 'fc_checkout_billing_collapsible_initial_state', 'start_billing_address_collapsed', 10 );
```

#### `fc_is_billing_address_before_shipping_address`
**Description** Controls the check for whether the billing address should be displayed before the shipping address in the checkout flow. This filter modifies the return value of the `is_billing_address_before_shipping_address()` method, but does not implement the actual reordering behavior itself. The actual step reordering is implemented by the `fc_billing_step_hook_priority` filter in the PRO plugin, which changes the billing step priority from 30 to 15 when billing should come before shipping.
**Parameters**
- `$is_before` (bool) Whether billing address comes before shipping address. Defaults to `false`.
**Context** Used in `inc/checkout-steps.php` when determining checkout step order
**Example**
```php
/**
 * Display billing address before shipping address
 */
add_filter( 'fc_is_billing_address_before_shipping_address', '__return_true', 10 );
```

#### `fc_is_billing_address_forced_same_as_shipping_address`
**Description** Controls whether the billing address is forced to be the same as the shipping address.
**Parameters**
- `$is_forced` (bool) Whether billing address is forced to be same as shipping. Defaults to `false`.
**Context** Used in `inc/checkout-steps.php` when determining address behavior
**Example**
```php
/**
 * Force billing address to always be same as shipping
 */
add_filter( 'fc_is_billing_address_forced_same_as_shipping_address', '__return_true', 10 );
```

#### `fc_billing_same_as_shipping_option_label`
**Description** Modifies the label text for the "Same as shipping address" option in billing section.
**Parameters**
- `$label` (string) The option label text. Defaults to `__( 'Same as shipping address', 'fluid-checkout' )`.
**Context** Used in `inc/checkout-steps.php` when rendering the billing same as shipping option
**Example**
```php
/**
 * Customize billing same as shipping option label
 */
function customize_billing_same_as_shipping_label( $label ) {
    return __( 'Use shipping address for billing', 'my-theme' );
}
add_filter( 'fc_billing_same_as_shipping_option_label', 'customize_billing_same_as_shipping_label', 10 );
```

#### `fc_billing_same_as_shipping_skip_fields`
**Description** Defines which fields to skip when copying shipping address to billing address.
**Parameters**
- `$skip_fields` (array) Array of field keys to skip. Defaults to empty array.
**Context** Used in `inc/checkout-steps.php` when copying address data
**Example**
```php
/**
 * Skip phone field when copying shipping to billing
 */
function skip_phone_when_copying_shipping_to_billing( $skip_fields ) {
    $skip_fields[] = 'billing_phone';
    return $skip_fields;
}
add_filter( 'fc_billing_same_as_shipping_skip_fields', 'skip_phone_when_copying_shipping_to_billing', 10 );
```

#### `fc_billing_same_as_shipping_field_keys`
**Description** Defines which field keys to copy from shipping address to billing address.
**Parameters**
- `$field_keys` (array) Array of field keys to copy. Defaults to standard address fields.
**Context** Used in `inc/checkout-steps.php` when copying address data
**Example**
```php
/**
 * Add custom field to shipping to billing copy
 */
function add_custom_field_to_shipping_billing_copy( $field_keys ) {
    $field_keys[] = 'billing_company';
    return $field_keys;
}
add_filter( 'fc_billing_same_as_shipping_field_keys', 'add_custom_field_to_shipping_billing_copy', 10 );
```

#### `fc_output_billing_same_as_shipping_as_hidden_field`
**Description** Controls whether to output the billing same as shipping option as a hidden field instead of a checkbox.
**Parameters**
- `$output_as_hidden` (bool) Whether to output as hidden field. Defaults to `false`.
**Context** Used in `inc/checkout-steps.php` when rendering the billing same as shipping option
**Example**
```php
/**
 * Force billing same as shipping as hidden field
 */
add_filter( 'fc_output_billing_same_as_shipping_as_hidden_field', '__return_true', 10 );
```

### Address Data Management

#### `fc_is_billing_address_data_same_as_shipping_before`
**Description** Allows intercepting the comparison between billing and shipping address data before the default comparison.
**Parameters**
- `$is_same` (bool|null) Whether addresses are the same. Return `null` to use default comparison.
**Context** Used in `inc/checkout-steps.php` when comparing address data
**Example**
```php
/**
 * Custom billing address comparison logic
 */
function custom_billing_address_comparison( $is_same ) {
    // Custom comparison logic - return true/false or null for default comparison
    return null; // Use default comparison
}
add_filter( 'fc_is_billing_address_data_same_as_shipping_before', 'custom_billing_address_comparison', 10, 1 );
```

#### `fc_is_billing_same_as_shipping_checked`
**Description** Controls whether the "billing same as shipping" checkbox is checked by default.
**Parameters**
- `$is_checked` (bool) Whether the checkbox should be checked. Defaults to `false`.
**Context** Used in `inc/checkout-steps.php` when determining checkbox state
**Example**
```php
/**
 * Check billing same as shipping by default
 */
add_filter( 'fc_is_billing_same_as_shipping_checked', '__return_true', 10 );
```

#### `fc_default_to_billing_same_as_shipping`
**Description** Controls the default state of the billing same as shipping checkbox based on plugin settings. This filter affects both billing→shipping and shipping→billing scenarios depending on which address section is displayed first. Only applies during initial page load, not during AJAX updates.
**Parameters**
- `$default_value` (bool) Whether to default to billing same as shipping. Defaults to plugin setting value (`'yes'` === `true`).
**Context** Used in `inc/checkout-steps.php` when determining default checkbox state in both `is_billing_same_as_shipping_checked()` and `is_shipping_same_as_billing_checked()` functions
**Example**
```php
/**
 * Force default to billing same as shipping regardless of settings
 */
add_filter( 'fc_default_to_billing_same_as_shipping', '__return_true', 10 );
```

#### `fc_save_new_address_data_billing_skip_update`
**Description** Controls whether to skip updating billing address data when saving new address information.
**Parameters**
- `$skip_update` (bool) Whether to skip the update. Defaults to `false`.
- `$posted_data` (array) The posted data array.
**Context** Used in `inc/checkout-steps.php` when saving address data
**Example**
```php
/**
 * Skip updating billing address data
 */
function skip_billing_address_update( $skip_update, $posted_data ) {
    return true; // Skip the update
}
add_filter( 'fc_save_new_address_data_billing_skip_update', 'skip_billing_address_update', 10, 2 );
```

#### `fc_billing_same_as_shipping_field_value`
**Description** Modifies field values when copying shipping address to billing address.
**Parameters**
- `$new_field_value` (mixed) The field value to be copied.
- `$field_key` (string) The billing field key.
- `$shipping_field_key` (string) The shipping field key.
- `$posted_data` (array) The posted data array.
**Context** Used in `inc/checkout-steps.php` when copying address data
**Example**
```php
/**
 * Customize field values when copying shipping to billing
 */
function customize_billing_field_value( $new_field_value, $field_key, $shipping_field_key, $posted_data ) {
    if ( 'billing_first_name' === $field_key ) {
        return 'Customer ' . $new_field_value;
    }
    return $new_field_value;
}
add_filter( 'fc_billing_same_as_shipping_field_value', 'customize_billing_field_value', 10, 4 );
```

#### `fc_shipping_same_as_billing_field_value`
**Description** Modifies field values when copying billing address to shipping address.
**Parameters**
- `$field_value` (mixed) The field value to be copied.
- `$shipping_field_key` (string) The shipping field key.
- `$billing_field_key` (string) The billing field key.
- `$posted_data` (array) The posted data array.
**Context** Used in `inc/checkout-steps.php` when copying address data
**Example**
```php
/**
 * Customize field values when copying billing to shipping
 */
function customize_shipping_field_value( $field_value, $shipping_field_key, $billing_field_key, $posted_data ) {
    // Customize specific field values
    if ( 'shipping_company' === $shipping_field_key ) {
        return 'Shipping Company Name';
    }
    return $field_value;
}
add_filter( 'fc_shipping_same_as_billing_field_value', 'customize_shipping_field_value', 10, 4 );
```

### Billing Address Completion

#### `fc_is_substep_complete_billing_address`
**Description** Controls whether the billing address substep is considered complete.
**Parameters**
- `$is_complete` (bool) Whether the substep is complete. Defaults to validation result based on required fields.
**Context** Used in `inc/checkout-steps.php` when checking substep completion
**Example**
```php
/**
 * Always consider billing address complete
 */
add_filter( 'fc_is_substep_complete_billing_address', '__return_true', 10 );
```

#### `fc_is_substep_complete_billing_address_field_keys_skip_list`
**Description** Defines which field keys to skip when checking billing address completion.
**Parameters**
- `$skip_field_keys` (array) Array of field keys to skip. Defaults to contact step display field IDs.
**Context** Used in `inc/checkout-steps.php` when validating address completion
**Example**
```php
/**
 * Skip phone field when checking billing address completion
 */
function skip_phone_in_billing_completion( $skip_field_keys ) {
    $skip_field_keys[] = 'billing_phone';
    return $skip_field_keys;
}
add_filter( 'fc_is_substep_complete_billing_address_field_keys_skip_list', 'skip_phone_in_billing_completion', 10 );
```

#### `fc_billing_same_as_shipping_display_substep_review_text_notice`
**Description** Controls whether to display a "same as shipping" notice in the billing address substep text.
**Parameters**
- `$display_notice` (bool) Whether to display the notice. Defaults to `true`.
**Context** Used in `inc/checkout-steps.php` when generating substep text
**Example**
```php
/**
 * Hide same as shipping notice in billing substep text
 */
add_filter( 'fc_billing_same_as_shipping_display_substep_review_text_notice', '__return_false', 10 );
```

#### `fc_billing_substep_text_address_data`
**Description** Modifies billing address data used for generating substep review text display.
**Parameters**
- `$address_data` (array) The address data array containing field values for display.
**Context** Used in `inc/checkout-steps.php` when generating billing address substep text
**Example**
```php
/**
 * Customize billing address data for substep display
 */
function customize_billing_substep_data( $address_data ) {
    // Remove phone number from substep display
    unset( $address_data['phone'] );
    return $address_data;
}
add_filter( 'fc_billing_substep_text_address_data', 'customize_billing_substep_data', 10, 1 );
```

### Address Field Management

#### `fc_address_field_keys_skip_list`
**Description** Defines field keys to skip in address processing and field updates.
**Parameters**
- `$skip_field_keys` (array) Array of field keys to skip. Defaults to array containing email field.
**Context** Used in `inc/checkout-steps.php` when processing address field updates
**Example**
```php
/**
 * Skip phone field in address processing
 */
function skip_phone_in_address_processing( $skip_field_keys ) {
    $skip_field_keys[] = 'billing_phone';
    $skip_field_keys[] = 'shipping_phone';
    return $skip_field_keys;
}
add_filter( 'fc_address_field_keys_skip_list', 'skip_phone_in_address_processing', 10 );
```

#### `fc_address_field_keys`
**Description** Modifies address field keys for processing and updates.
**Parameters**
- `$field_keys` (array) Array of field keys to process.
- `$address_type` (string) The address type ('billing' or 'shipping').
**Context** Used in `inc/checkout-steps.php` when processing address field updates
**Example**
```php
/**
 * Add custom fields to address processing
 */
function add_custom_fields_to_address_processing( $field_keys, $address_type ) {
    $field_keys[] = $address_type . '_custom_field';
    return $field_keys;
}
add_filter( 'fc_address_field_keys', 'add_custom_fields_to_address_processing', 10, 2 );
```

#### `fc_skip_change_customer_address_field_value_from_checkout_data`
**Description** Controls whether to skip changing customer address field values from checkout data.
**Parameters**
- `$skip_change` (bool) Whether to skip changing the field value. Defaults to `false`.
- `$value` (mixed) The current field value.
- `$customer` (WC_Customer) The customer object.
**Context** Used in `inc/checkout-steps.php` when updating customer address field values
**Example**
```php
/**
 * Skip changing customer address field values
 */
function skip_customer_address_field_changes( $skip_change, $value, $customer ) {
    return true; // Skip all changes
}
add_filter( 'fc_skip_change_customer_address_field_value_from_checkout_data', 'skip_customer_address_field_changes', 10, 3 );
```

#### `fc_skip_checkout_field_value_from_session_or_posted_data`
**Description** Controls whether to skip getting field values from session or posted data.
**Parameters**
- `$skip_value` (bool) Whether to skip getting the field value. Defaults to `false`.
- `$input` (string) The checkout field key.
**Context** Used in `inc/checkout-steps.php` when retrieving field values from session or posted data
**Example**
```php
/**
 * Skip getting field values from session for specific fields
 */
function skip_session_values_for_fields( $skip_value, $input ) {
    if ( 'billing_phone' === $input ) {
        return true; // Skip getting phone value from session
    }
    return $skip_value;
}
add_filter( 'fc_skip_checkout_field_value_from_session_or_posted_data', 'skip_session_values_for_fields', 10, 2 );
```

### Address Validation

#### `fc_checkout_address_i18n_override_locale_required_attribute`
**Description** Controls whether to override locale required attributes with checkout field attributes.
**Parameters**
- `$override_required` (bool) Whether to override locale required attributes. Defaults to `false`.
**Context** Used in `inc/checkout-fields.php` when generating JavaScript settings for address internationalization
**Example**
```php
/**
 * Override locale required attributes with checkout field attributes
 */
add_filter( 'fc_checkout_address_i18n_override_locale_required_attribute', '__return_true', 10 );
```

#### `fc_checkout_address_i18n_override_locale_attributes`
**Description** Modifies locale attributes for address fields that should be overridden with checkout field attributes.
**Parameters**
- `$override_attributes` (array) Array of attribute names to override. Defaults to empty array or array containing 'required' if `fc_checkout_address_i18n_override_locale_required_attribute` is true.
**Context** Used in `inc/checkout-fields.php` when generating JavaScript settings for address internationalization
**Example**
```php
/**
 * Override locale attributes for address fields
 */
function override_locale_attributes( $override_attributes ) {
    $override_attributes[] = 'custom-attribute';
    return $override_attributes;
}
add_filter( 'fc_checkout_address_i18n_override_locale_attributes', 'override_locale_attributes', 10 );
```

## Payment Step

### Payment Methods

#### `fc_payment_method_review_text_*`
**Description** Modifies review text for specific payment methods displayed in substep text. The filter name includes the payment method key (e.g., `fc_payment_method_review_text_bacs` for BACS payments).
**Parameters**
- `$payment_method_review_text` (string) The review text HTML containing payment method icon and title. Defaults to `<span class="payment-method-icon">[icon]</span><span class="payment-method-title">[title]</span>`.
- `$gateway` (WC_Payment_Gateway) The payment gateway object.
**Context** Used in `inc/checkout-steps.php` when generating payment method substep text
**Example**
```php
/**
 * Customize BACS payment method review text
 */
function customize_bacs_payment_review_text( $payment_method_review_text, $gateway ) {
    return '<span class="payment-method-title">' . __( 'Bank Transfer Payment', 'my-theme' ) . '</span>';
}
add_filter( 'fc_payment_method_review_text_bacs', 'customize_bacs_payment_review_text', 10, 2 );
```

#### `fc_payment_not_needed_message`
**Description** Modifies the message displayed when no payment is needed (e.g., free orders or gift cards covering full amount).
**Parameters**
- `$message` (string) The message text. Defaults to formatted message with order total amount.
**Context** Used in `templates/fc/checkout-steps/checkout/payment.php` when payment is not required
**Example**
```php
/**
 * Customize payment not needed message
 */
function customize_payment_not_needed_message( $message ) {
    return __( 'Your order is free! No payment required.', 'my-theme' );
}
add_filter( 'fc_payment_not_needed_message', 'customize_payment_not_needed_message', 10 );
```

#### `fc_place_order_button_classes`
**Description** Adds custom CSS classes to the place order button.
**Parameters**
- `$classes` (string) CSS classes for the button. Defaults to `'button alt'`.
**Context** Used in `inc/checkout-steps.php` when building place order button HTML
**Example**
```php
/**
 * Add custom classes to place order button
 */
function add_place_order_button_classes( $classes ) {
    return $classes . ' custom-place-order primary-checkout-btn';
}
add_filter( 'fc_place_order_button_classes', 'add_place_order_button_classes', 10 );
```

### Order Notes

#### `fc_no_order_notes_order_review_notice`
**Description** Modifies the notice text displayed when no order notes are provided in the order review section.
**Parameters**
- `$notice_text` (string) The notice text to display. Defaults to the result of `get_no_substep_review_text_notice()` function.
**Context** Used in `inc/compat/plugins/compat-plugin-yith-woocommerce-checkout-manager.php` when no order notes are available
**Example**
```php
/**
 * Customize no order notes notice
 */
function customize_no_order_notes_notice( $notice_text ) {
    return __( 'No special instructions provided.', 'my-theme' );
}
add_filter( 'fc_no_order_notes_order_review_notice', 'customize_no_order_notes_notice', 10 );
```

#### `fc_no_substep_review_text_notice`
**Description** Modifies the notice text displayed for substeps when there is no review content available.
**Parameters**
- `$notice_text` (string) The notice text to display. Defaults to `_x( 'None.', 'Substep review text', 'fluid-checkout' )`.
- `$substep_id` (string) The substep identifier.
**Context** Used in `inc/checkout-steps.php` when generating substep review text for empty substeps
**Example**
```php
/**
 * Customize no substep review text notice
 */
function customize_no_substep_review_notice( $notice_text, $substep_id ) {
    if ( 'order_notes' === $substep_id ) {
        return __( 'No notes added.', 'my-theme' );
    }
    return __( 'Not specified.', 'my-theme' );
}
add_filter( 'fc_no_substep_review_text_notice', 'customize_no_substep_review_notice', 10, 2 );
```

### Coupon Codes

#### `fc_coupon_code_substep_step_id`
**Description** Modifies the step ID where the coupon code substep should be displayed.
**Parameters**
- `$step_id` (string) The step ID. Defaults to `'payment'`.
**Context** Used in `inc/checkout-coupon-codes.php` when registering coupon code substep
**Example**
```php
/**
 * Display coupon codes in shipping step
 */
function move_coupon_codes_to_shipping_step( $step_id ) {
    return 'shipping';
}
add_filter( 'fc_coupon_code_substep_step_id', 'move_coupon_codes_to_shipping_step', 10 );
```

#### `fc_display_coupon_code_section_title`
**Description** Controls whether to display the coupon code section title. This is a plugin setting filter.
**Parameters**
- `$display_title` (string|bool) Whether to display the title. Defaults to plugin setting value.
**Context** Used in `inc/checkout-coupon-codes.php` when determining substep title display
**Example**
```php
/**
 * Always display coupon code section title
 */
add_filter( 'fc_display_coupon_code_section_title', '__return_true', 10 );
```

#### `fc_coupon_code_substep_priority`
**Description** Modifies the priority for the coupon code substep within its step.
**Parameters**
- `$priority` (int) The substep priority. Defaults to `10`.
**Context** Used in `inc/checkout-coupon-codes.php` when registering coupon code substep
**Example**
```php
/**
 * Set higher priority for coupon code substep
 */
function set_coupon_code_substep_priority( $priority ) {
    return 5; // Higher priority (lower number)
}
add_filter( 'fc_coupon_code_substep_priority', 'set_coupon_code_substep_priority', 10 );
```

#### `fc_coupon_code_displayed_as_substep`
**Description** Controls whether coupon codes are displayed as a substep.
**Parameters**
- `$display_as_substep` (bool) Whether to display as substep. Defaults to `true`.
**Context** Used in `inc/checkout-coupon-codes.php` when determining substep registration
**Example**
```php
/**
 * Disable coupon code substep display
 */
add_filter( 'fc_coupon_code_displayed_as_substep', '__return_false', 10 );
```

#### `fc_substep_coupon_codes_section_title`
**Description** Modifies the section title for the coupon codes substep.
**Parameters**
- `$title` (string) The section title. Defaults to `__( 'Coupon code', 'woocommerce' )`.
**Context** Used in `inc/checkout-coupon-codes.php` when registering coupon code substep
**Example**
```php
/**
 * Customize coupon code substep title
 */
function customize_coupon_code_substep_title( $title ) {
    return __( 'Discount Code', 'my-theme' );
}
add_filter( 'fc_substep_coupon_codes_section_title', 'customize_coupon_code_substep_title', 10 );
```

#### `fc_checkout_coupons_script_settings`
**Description** Modifies JavaScript settings for checkout coupons functionality.
**Parameters**
- `$settings` (array) JavaScript settings array.
**Context** Used in `inc/checkout-coupon-codes.php` when adding JavaScript settings
**Example**
```php
/**
 * Add custom JavaScript settings for coupons
 */
function add_custom_coupon_js_settings( $settings ) {
    $settings['customSetting'] = 'value';
    return $settings;
}
add_filter( 'fc_checkout_coupons_script_settings', 'add_custom_coupon_js_settings', 10 );
```

#### `fc_coupon_code_field_label`
**Description** Modifies the coupon code field label text.
**Parameters**
- `$label` (string) The field label. Defaults to `__( 'Coupon code', 'woocommerce' )`.
**Context** Used in `inc/checkout-coupon-codes.php` when rendering coupon code fields
**Example**
```php
/**
 * Customize coupon code field label
 */
function customize_coupon_code_field_label( $label ) {
    return __( 'Discount Code', 'my-theme' );
}
add_filter( 'fc_coupon_code_field_label', 'customize_coupon_code_field_label', 10 );
```

#### `fc_coupon_code_field_description`
**Description** Modifies the coupon code field description text.
**Parameters**
- `$description` (string) The field description. Defaults to empty string.
**Context** Used in `inc/checkout-coupon-codes.php` when rendering coupon code fields
**Example**
```php
/**
 * Add description to coupon code field
 */
function add_coupon_code_field_description( $description ) {
    return __( 'Enter your discount code to apply savings.', 'my-theme' );
}
add_filter( 'fc_coupon_code_field_description', 'add_coupon_code_field_description', 10 );
```

#### `fc_coupon_code_field_placeholder`
**Description** Modifies the coupon code field placeholder text.
**Parameters**
- `$placeholder` (string) The field placeholder. Defaults to `__( 'Enter your code here', 'fluid-checkout' )`.
**Context** Used in `inc/checkout-coupon-codes.php` when rendering coupon code fields
**Example**
```php
/**
 * Customize coupon code field placeholder
 */
function customize_coupon_code_field_placeholder( $placeholder ) {
    return __( 'Type your discount code', 'my-theme' );
}
add_filter( 'fc_coupon_code_field_placeholder', 'customize_coupon_code_field_placeholder', 10 );
```

#### `fc_coupon_code_button_label`
**Description** Modifies the coupon code apply button label text.
**Parameters**
- `$label` (string) The button label. Defaults to `_x( 'Apply', 'Button label for applying coupon codes', 'fluid-checkout' )`.
**Context** Used in `inc/checkout-coupon-codes.php` when rendering coupon code fields
**Example**
```php
/**
 * Customize coupon code apply button label
 */
function customize_coupon_code_button_label( $label ) {
    return __( 'Apply Discount', 'my-theme' );
}
add_filter( 'fc_coupon_code_button_label', 'customize_coupon_code_button_label', 10 );
```

#### `fc_coupon_code_field_initially_expanded`
**Description** Controls whether the coupon code field is initially expanded.
**Parameters**
- `$is_expanded` (bool) Whether the field is initially expanded. Defaults to `false`.
**Context** Used in `inc/checkout-coupon-codes.php` when rendering expansible coupon code sections
**Example**
```php
/**
 * Start with coupon code field expanded
 */
add_filter( 'fc_coupon_code_field_initially_expanded', '__return_true', 10 );
```

#### `fc_expansible_section_toggle_label_*`
**Description** Modifies toggle labels for expansible sections. The filter name includes the section ID (e.g., `fc_expansible_section_toggle_label_coupon_code`).
**Parameters**
- `$toggle_label` (string) The toggle label text. Defaults to formatted label with "Add" prefix.
**Context** Used in `inc/checkout-coupon-codes.php` when rendering expansible coupon code sections
**Example**
```php
/**
 * Customize coupon code toggle label
 */
function customize_coupon_code_toggle_label( $toggle_label ) {
    return __( 'Have a discount code?', 'my-theme' );
}
add_filter( 'fc_expansible_section_toggle_label_coupon_code', 'customize_coupon_code_toggle_label', 10 );
```

#### `fc_coupon_code_apply_button_classes`
**Description** Adds custom CSS classes to the coupon code apply button.
**Parameters**
- `$classes` (string) CSS classes for the button. Defaults to `'button'`.
**Context** Used in `inc/checkout-coupon-codes.php` when rendering coupon code apply button
**Example**
```php
/**
 * Add custom classes to coupon code apply button
 */
function add_coupon_code_apply_button_classes( $classes ) {
    return $classes . ' custom-apply-btn primary-button';
}
add_filter( 'fc_coupon_code_apply_button_classes', 'add_coupon_code_apply_button_classes', 10 );
```

#### `fc_substep_coupon_codes_text`
**Description** Modifies the text content displayed for the coupon codes substep.
**Parameters**
- `$text` (string) The substep text content.
**Context** Used in `inc/checkout-coupon-codes.php` when generating substep text
**Example**
```php
/**
 * Customize coupon codes substep text
 */
function customize_coupon_codes_substep_text( $text ) {
    return __( 'Applied discount codes will be shown here.', 'my-theme' );
}
add_filter( 'fc_substep_coupon_codes_text', 'customize_coupon_codes_substep_text', 10 );
```

#### `fc_coupon_code_error_message_dismiss_button_enabled`
**Description** Controls whether to show a dismiss button for coupon error messages.
**Parameters**
- `$enabled` (bool) Whether to show dismiss button. Defaults to `true`.
**Context** Used in JavaScript when handling coupon error messages
**Example**
```php
/**
 * Disable dismiss button for coupon error messages
 */
add_filter( 'fc_coupon_code_error_message_dismiss_button_enabled', '__return_false', 10 );
```

#### `fc_coupon_code_error_message_dismiss_button`
**Description** Modifies the dismiss button HTML for coupon error messages.
**Parameters**
- `$button_html` (string) The dismiss button HTML. Default: `'<a href="#dismiss_coupon_message" data-coupon="' . esc_attr( $coupon_code ) . '" class="fc-coupon-code-message-dismiss">' . __( 'Dismiss', 'fluid-checkout' ) . '</a>'`
**Context** Used in JavaScript when rendering coupon error messages
**Example**
```php
/**
 * Add custom class to coupon error dismiss button
 */
function customize_coupon_error_dismiss_button( $button_html ) {
    return str_replace( 'class="fc-coupon-code-message-dismiss"', 'class="fc-coupon-code-message-dismiss custom-dismiss-btn"', $button_html );
}
add_filter( 'fc_coupon_code_error_message_dismiss_button', 'customize_coupon_error_dismiss_button', 10 );
```

### Expansible Sections

#### `fc_expansible_section_toggle_label_add_optional_text`
**Description** Controls whether to add "(optional)" text to toggle labels for expansible sections.
**Parameters**
- `$add_optional_text` (bool) Whether to add optional text. Defaults to `true`.
**Context** Used in `inc/checkout-hide-optional-fields.php` when generating toggle labels for optional fields
**Example**
```php
/**
 * Remove optional text from all toggle labels
 */
add_filter( 'fc_expansible_section_toggle_label_add_optional_text', '__return_false', 10 );
```

#### `fc_expansible_section_toggle_label_*_add_optional_text`
**Description** Controls whether to add "(optional)" text to toggle labels for specific expansible sections. The filter name includes the field key (e.g., `fc_expansible_section_toggle_label_billing_company_add_optional_text`).
**Parameters**
- `$add_optional_text` (bool) Whether to add optional text for this specific field. Defaults to `true`.
**Context** Used in `inc/checkout-hide-optional-fields.php` when generating toggle labels for specific optional fields
**Example**
```php
/**
 * Remove optional text from company field toggle label
 */
add_filter( 'fc_expansible_section_toggle_label_billing_company_add_optional_text', '__return_false', 10 );
```

#### `fc_substep_change_button_label`
**Description** Modifies the "Change" button label text for substeps.
**Parameters**
- `$label` (string) The button label text. Defaults to `_x( 'Change', 'Checkout substep change link label', 'fluid-checkout' )`.
**Context** Used in `inc/checkout-steps.php` when rendering substep change buttons
**Example**
```php
/**
 * Customize substep change button label
 */
function customize_substep_change_button_label( $label ) {
    return __( 'Edit', 'my-theme' );
}
add_filter( 'fc_substep_change_button_label', 'customize_substep_change_button_label', 10 );
```

#### `fc_substep_save_button_classes`
**Description** Adds custom CSS classes to the substep save button.
**Parameters**
- `$classes` (string) CSS classes for the button. Defaults to `'button'`.
**Context** Used in `inc/checkout-steps.php` when rendering substep save buttons
**Example**
```php
/**
 * Add custom classes to substep save button
 */
function add_substep_save_button_classes( $classes ) {
    return $classes . ' custom-save-btn primary-button';
}
add_filter( 'fc_substep_save_button_classes', 'add_substep_save_button_classes', 10 );
```

#### `fc_substep_save_button_label`
**Description** Modifies the "Save changes" button label text for substeps.
**Parameters**
- `$label` (string) The button label text. Defaults to `_x( 'Save changes', 'Checkout substep save link label', 'fluid-checkout' )`.
**Context** Used in `inc/checkout-steps.php` when rendering substep save buttons
**Example**
```php
/**
 * Customize substep save button label
 */
function customize_substep_save_button_label( $label ) {
    return __( 'Update', 'my-theme' );
}
add_filter( 'fc_substep_save_button_label', 'customize_substep_save_button_label', 10 );
```

### Hide Optional Fields

#### `fc_hide_optional_fields_skip_list`
**Description** Defines field keys to skip when hiding optional fields behind expansible sections.
**Parameters**
- `$skip_field_keys` (array) Array of field keys to skip. Defaults to empty array.
**Context** Used in `inc/checkout-hide-optional-fields.php` when determining which fields to hide
**Example**
```php
/**
 * Skip hiding specific optional fields
 */
function skip_hiding_specific_fields( $skip_field_keys ) {
    $skip_field_keys[] = 'billing_company';
    $skip_field_keys[] = 'shipping_company';
    return $skip_field_keys;
}
add_filter( 'fc_hide_optional_fields_skip_list', 'skip_hiding_specific_fields', 10 );
```

#### `fc_hide_optional_fields_skip_field`
**Description** Controls whether to skip hiding a specific optional field.
**Parameters**
- `$skip_field` (bool) Whether to skip hiding this field. Defaults to `false`.
- `$key` (string) The field key.
- `$args` (array) The field arguments.
- `$value` (mixed) The field value.
**Context** Used in `inc/checkout-hide-optional-fields.php` when processing individual fields
**Example**
```php
/**
 * Skip hiding company fields based on conditions
 */
function skip_hiding_company_fields( $skip_field, $key, $args, $value ) {
    if ( 'billing_company' === $key && ! empty( $value ) ) {
        return true; // Skip hiding if field has value
    }
    return $skip_field;
}
add_filter( 'fc_hide_optional_fields_skip_field', 'skip_hiding_company_fields', 10, 4 );
```

#### `fc_hide_optional_fields_skip_types`
**Description** Defines field types to skip when hiding optional fields.
**Parameters**
- `$skip_types` (array) Array of field types to skip. Defaults to `array( 'state', 'country', 'select', 'checkbox', 'radio', 'hidden' )`.
**Context** Used in `inc/checkout-hide-optional-fields.php` when determining field types to skip
**Example**
```php
/**
 * Add textarea fields to skip list
 */
function add_textarea_to_skip_types( $skip_types ) {
    $skip_types[] = 'textarea';
    return $skip_types;
}
add_filter( 'fc_hide_optional_fields_skip_types', 'add_textarea_to_skip_types', 10 );
```

#### `fc_hide_optional_fields_skip_by_class`
**Description** Defines CSS classes to skip when hiding optional fields.
**Parameters**
- `$skip_classes` (array) Array of CSS classes to skip. Defaults to `array( 'fc-skip-hide-optional-field' )`.
**Context** Used in `inc/checkout-hide-optional-fields.php` when checking field classes
**Example**
```php
/**
 * Add custom class to skip list
 */
function add_custom_skip_class( $skip_classes ) {
    $skip_classes[] = 'always-visible-field';
    return $skip_classes;
}
add_filter( 'fc_hide_optional_fields_skip_by_class', 'add_custom_skip_class', 10 );
```

## Order Summary

### Order Summary Display

#### `fc_order_review_title`
**Description** Modifies the order review/order summary section title.
**Parameters**
- `$title` (string) The order review title. Defaults to `__( 'Order summary', 'fluid-checkout' )`.
**Context** Used in `inc/checkout-steps.php` in the `get_order_review_title()` method
**Example**
```php
/**
 * Change order summary title
 */
function change_order_summary_title( $title ) {
    return __( 'Your Order', 'my-theme' );
}
add_filter( 'fc_order_review_title', 'change_order_summary_title', 10 );
```

#### `fc_order_summary_display_desktop_edit_cart_link`
**Description** Controls whether to display the "Edit cart" link in the order summary header section on desktop.
**Parameters**
- `$enabled` (bool) Whether to display the edit cart link. Defaults to `true`.
**Context** Used in `inc/checkout-steps.php` in the `output_order_review_header_edit_cart_link()` method
**Example**
```php
/**
 * Hide edit cart link on desktop
 */
add_filter( 'fc_order_summary_display_desktop_edit_cart_link', '__return_false', 10 );
```

#### `fc_order_summary_continue_button_classes`
**Description** Adds custom CSS classes to the order summary "Continue" button on mobile.
**Parameters**
- `$classes` (string) CSS classes for the button. Defaults to `'button'`.
**Context** Used in `templates/fc/checkout-steps/checkout/review-order-section.php`
**Location** This button appears in the mobile checkout header - click the cart icon in the top-right corner to open the order summary modal. The "Continue" button is located at the bottom of this modal.
**Example**
```php
/**
 * Add custom classes to order summary continue button
 */
function add_order_summary_continue_button_classes( $classes ) {
    return $classes . ' custom-continue-btn primary';
}
add_filter( 'fc_order_summary_continue_button_classes', 'add_order_summary_continue_button_classes', 10 );
```

#### `fc_pro_checkout_review_order_table_classes`
**Description** Adds custom CSS classes to the checkout review order table element.
**Parameters**
- `$classes` (string) CSS classes for the table. Defaults to `''`.
**Context** Used in `templates/fc/checkout-steps/checkout/review-order.php`
**Example**
```php
/**
 * Add custom classes to checkout review order table
 */
function add_checkout_review_order_table_classes( $classes ) {
    return $classes . ' custom-order-table highlight-table';
}
add_filter( 'fc_pro_checkout_review_order_table_classes', 'add_checkout_review_order_table_classes', 10 );
```



### Shipping Display

#### `fc_checkout_no_shipping_method_chosen_html`
**Description** Modifies the HTML displayed when no shipping method has been chosen in the order summary.
**Parameters**
- `$html` (string) The HTML to display. Defaults to a formatted string containing `'--'` followed by the shipping destination in bold.
**Context** Used in `templates/fc/checkout-steps/checkout/review-order-shipping.php`
**Example**
```php
/**
 * Customize no shipping method chosen message
 */
function customize_no_shipping_chosen_html( $html ) {
    return '<span class="no-shipping">' . __( 'Please select a shipping method', 'my-theme' ) . '</span>';
}
add_filter( 'fc_checkout_no_shipping_method_chosen_html', 'customize_no_shipping_chosen_html', 10 );
```

#### `fc_order_summary_shipping_package_name`
**Description** Modifies the shipping package name displayed in the order summary.
**Parameters**
- `$package_name` (string) The package name.
- `$method` (WC_Shipping_Rate|false) The shipping method object or `false`.
- `$package_index` (int) The package index.
- `$package` (array) The package data array.
**Context** Used in `inc/checkout-steps.php` in the `get_shipping_data_for_packages()` method
**Example**
```php
/**
 * Customize shipping package name in order summary
 */
function customize_shipping_package_name( $package_name, $method, $package_index, $package ) {
     return sprintf( __( 'Package %d', 'my-theme' ), $package_index + 1 );

    return $package_name;
}
add_filter( 'fc_order_summary_shipping_package_name', 'customize_shipping_package_name', 10, 4 );
```

#### `fc_order_summary_shipping_package_price_html`
**Description** Modifies the shipping package price HTML displayed in the order summary.
**Parameters**
- `$shipping_total_label` (string) The formatted shipping price HTML.
- `$method` (WC_Shipping_Rate|false) The shipping method object or `false`.
- `$package_index` (int) The package index.
- `$package` (array) The package data array.
- `$package_name` (string) The package name.
**Context** Used in `inc/checkout-steps.php` in the `get_cart_totals_shipping_method_label()` method
**Example**
```php
/**
 * Add custom text to shipping price
 */
function customize_shipping_price_html( $shipping_total_label, $method, $package_index, $package, $package_name ) {
    if ( $method && $method->get_cost() == 0 ) {
        return '<strong>' . __( 'FREE', 'my-theme' ) . '</strong>';
    }
    return $shipping_total_label;
}
add_filter( 'fc_order_summary_shipping_package_price_html', 'customize_shipping_price_html', 10, 5 );
```

#### `fc_enable_order_summary_cart_item_unit_price`
**Description** Controls whether to display unit prices for cart items in the order summary.
**Parameters**
- `$enabled` (bool) Whether to display unit prices. Defaults to `true`.
**Context** Used in `inc/checkout-steps.php` in the `output_order_summary_cart_item_unit_price()` method
**Example**
```php
/**
 * Hide unit prices in order summary
 */
add_filter( 'fc_enable_order_summary_cart_item_unit_price', '__return_false', 10 );
```

### Cart and Product Display

#### `fc_checkout_header_cart_link_label_html`
**Description** Modifies the cart link label HTML displayed in the checkout header.
**Parameters**
- `$link_label_html` (string) The cart link label HTML (defaults to cart total).
**Context** Used in `inc/checkout-steps.php` in the `output_checkout_header_cart_link()` method
**Example**
```php
/**
 * Add item count to cart link
 */
function customize_cart_link_label( $link_label_html ) {
    $item_count = WC()->cart->get_cart_contents_count();
    return $link_label_html . sprintf( _n( ' (%d item)', ' (%d items)', $item_count, 'my-theme' ), $item_count );
}
add_filter( 'fc_checkout_header_cart_link_label_html', 'customize_cart_link_label', 10 );
```

#### `fc_subscription_shipping_package_name`
**Description** Modifies the shipping package name for subscription products in the order summary.
**Parameters**
- `$package_name` (string) The package name.
- `$package_index` (int) The package index.
- `$package` (array) The package data array.
- `$recurring_cart` (WC_Cart|object) The recurring cart object.
**Context** Used in `templates/compat/plugins/woocommerce-subscriptions/cart/cart-recurring-shipping.php` for WooCommerce Subscriptions compatibility
**Example**
```php
/**
 * Customize subscription package name
 */
function customize_subscription_package_name( $package_name, $package_index, $package, $recurring_cart ) {
    return __( 'Subscription Shipping', 'my-theme' );
}
add_filter( 'fc_subscription_shipping_package_name', 'customize_subscription_package_name', 10, 4 );
```

#### `fc_shipping_method_option_start_tag_markup`
**Description** Modifies the opening tag markup for the shipping methods list wrapper element.
**Parameters**
- `$markup` (string) The opening tag markup. Defaults to `'<ul id="shipping_method" class="shipping-method__options">'`.
**Context** Used in `templates/fc/checkout-steps/cart/shipping-methods-available.php` and subscription shipping templates
**Example**
```php
/**
 * Change shipping methods wrapper to div
 */
function change_shipping_methods_start_tag( $markup ) {
    return '<ul id="shipping_method" class="shipping-method__options custom-class">';
}
add_filter( 'fc_shipping_method_option_start_tag_markup', 'change_shipping_methods_start_tag', 10 );
```

#### `fc_shipping_method_option_end_tag_markup`
**Description** Modifies the closing tag markup for the shipping methods list wrapper element.
**Parameters**
- `$markup` (string) The closing tag markup. Defaults to `'</ul>'`.
**Context** Used in `templates/fc/checkout-steps/cart/shipping-methods-available.php` and subscription shipping templates
**Example**
```php
/**
 * Change shipping methods wrapper closing tag to div
 */
function change_shipping_methods_end_tag( $markup ) {
    return '</div>';
}
add_filter( 'fc_shipping_method_option_end_tag_markup', 'change_shipping_methods_end_tag', 10 );
```

#### `fc_shipping_method_option_markup`
**Description** Modifies the complete markup for individual shipping method options.
**Parameters**
- `$markup` (string) The shipping method option markup.
- `$method` (WC_Shipping_Rate) The shipping method rate object.
- `$package_index` (int) The package index.
- `$chosen_method` (string) The chosen shipping method ID.
- `$first` (bool) Whether this is the first shipping method in the list.
**Context** Used in `templates/fc/checkout-steps/cart/shipping-methods-available.php`
**Example**
```php
/**
 * Add delivery time to shipping method markup
 */
function add_delivery_time_to_shipping_method( $markup, $method, $package_index, $chosen_method, $first ) {
    $delivery_time = $method->get_meta_data()['delivery_time'] ?? '';
    if ( $delivery_time ) {
        $markup = str_replace( '</label>', '<span class="delivery-time">' . esc_html( $delivery_time ) . '</span></label>', $markup );
    }
    return $markup;
}
add_filter( 'fc_shipping_method_option_markup', 'add_delivery_time_to_shipping_method', 10, 5 );
```

### Customer Data Persistence

#### `fc_customer_persisted_data_skip_fields`
**Description** Defines field keys to skip when persisting customer data to session.
**Parameters**
- `$skip_field_keys` (array) Array of field keys to skip.
- `$parsed_posted_data` (array) The parsed posted data from the checkout form.
**Context** Used in `inc/checkout-steps.php` in the `get_session_field_keys()` method
**Example**
```php
/**
 * Skip persisting specific custom fields
 */
function skip_persisting_custom_fields( $skip_field_keys, $parsed_posted_data ) {
    $skip_field_keys[] = 'custom_temporary_field';
    $skip_field_keys[] = 'custom_sensitive_field';
    return $skip_field_keys;
}
add_filter( 'fc_customer_persisted_data_skip_fields', 'skip_persisting_custom_fields', 10, 2 );
```

#### `fc_customer_persisted_data_session_field_keys`
**Description** Defines session field keys for customer data persistence.
**Parameters**
- `$session_field_keys` (array) Array of field keys to persist in session.
- `$parsed_posted_data` (array) The parsed posted data from the checkout form.
**Context** Used in `inc/checkout-steps.php` in the `get_session_field_keys()` method
**Example**
```php
/**
 * Add custom fields to session persistence
 */
function add_custom_fields_to_session( $session_field_keys, $parsed_posted_data ) {
    $session_field_keys[] = 'custom_delivery_notes';
    $session_field_keys[] = 'custom_gift_message';
    return $session_field_keys;
}
add_filter( 'fc_customer_persisted_data_session_field_keys', 'add_custom_fields_to_session', 10, 2 );
```

#### `fc_set_parsed_posted_data`
**Description** Modifies parsed posted data before it is processed and saved to session.
**Parameters**
- `$new_posted_data` (array) The parsed posted data array.
**Context** Used in `inc/checkout-steps.php` in the `set_parsed_posted_data()` method
**Example**
```php
/**
 * Add prefix to order notes
 */
function add_prefix_to_order_notes( $new_posted_data ) {
    // Add prefix to order notes if present
    if ( ! empty( $new_posted_data['order_comments'] ) ) {
        $new_posted_data['order_comments'] = 'Customer note: ' . $new_posted_data['order_comments'];
    }
    return $new_posted_data;
}
add_filter( 'fc_set_parsed_posted_data', 'add_prefix_to_order_notes', 10 );
```

#### `fc_parsed_posted_data_reset_field_keys`
**Description** Defines field keys that should be reset if not present in posted data.
**Parameters**
- `$other_fields_keys` (array) Array of field keys to reset. Defaults to `array( 'createaccount' )`.
- `$posted_data` (array) The posted data array.
**Context** Used in `inc/checkout-steps.php` in the `maybe_reset_parsed_posted_data_fields()` method
**Example**
```php
/**
 * Add custom checkbox fields to reset list
 */
function add_fields_to_reset_list( $other_fields_keys, $posted_data ) {
    $other_fields_keys[] = 'custom_newsletter_opt_in';
    $other_fields_keys[] = 'custom_terms_acceptance';
    return $other_fields_keys;
}
add_filter( 'fc_parsed_posted_data_reset_field_keys', 'add_fields_to_reset_list', 10, 2 );
```

#### `fc_customer_persisted_data_clear_fields_order_processed`
**Description** Defines customer data fields to clear from session when an order is successfully processed.
**Parameters**
- `$clear_field_keys` (array) Array of field keys to clear from session.
**Context** Used in `inc/checkout-steps.php` in the `clear_customer_data_order_processed()` method
**Example**
```php
/**
 * Clear custom fields after order is placed
 */
function clear_custom_fields_after_order( $clear_field_keys ) {
    $clear_field_keys[] = 'custom_gift_message';
    $clear_field_keys[] = 'custom_delivery_instructions';
    return $clear_field_keys;
}
add_filter( 'fc_customer_persisted_data_clear_fields_order_processed', 'clear_custom_fields_after_order', 10 );
```

#### `fc_customer_meta_data_clear_fields_order_processed`
**Description** Defines customer meta data fields to clear when an order is successfully processed.
**Parameters**
- `$clear_customer_meta_field_keys` (array) Array of customer meta field keys to clear. Defaults to empty array.
**Context** Used in `inc/checkout-steps.php` in the `clear_customer_meta_order_processed()` method
**Example**
```php
/**
 * Clear custom customer meta after order
 */
function clear_custom_customer_meta( $clear_customer_meta_field_keys ) {
    $clear_customer_meta_field_keys[] = '_temporary_preference';
    $clear_customer_meta_field_keys[] = '_one_time_discount';
    return $clear_customer_meta_field_keys;
}
add_filter( 'fc_customer_meta_data_clear_fields_order_processed', 'clear_custom_customer_meta', 10 );
```

#### `fc_customer_persisted_data_clear_all_fields_skip_list`
**Description** Defines fields to skip when clearing all customer data from session.
**Parameters**
- `$clear_field_keys_skip_list` (array) Array of field keys to skip clearing. Defaults to `array( 'order_comments' )`.
**Context** Used in `inc/checkout-steps.php` in the `clear_all_customer_data()` method
**Example**
```php
/**
 * Preserve additional fields when clearing all data
 */
function preserve_fields_on_clear_all( $clear_field_keys_skip_list ) {
    $clear_field_keys_skip_list[] = 'custom_preferences';
    $clear_field_keys_skip_list[] = 'custom_saved_selections';
    return $clear_field_keys_skip_list;
}
add_filter( 'fc_customer_persisted_data_clear_all_fields_skip_list', 'preserve_fields_on_clear_all', 10 );
```

### Substep Text Display

#### `fc_substep_text_display_value_show_field_label`
**Description** Controls whether to show field labels in substep text display values.
**Parameters**
- `$show_field_label` (bool) Whether to show field labels. Defaults to `false`.
**Context** Used in `inc/checkout-steps.php` in the `get_substep_text_display_value()` method
**Example**
```php
/**
 * Show field labels in substep display
 */
add_filter( 'fc_substep_text_display_value_show_field_label', '__return_true', 10 );
```

#### `fc_substep_text_display_value_password_char`
**Description** Modifies the character used to mask password field values in substep text display.
**Parameters**
- `$char` (string) The masking character. Defaults to `'*'`.
**Context** Used in `inc/checkout-steps.php` in the `get_substep_text_display_value()` method for password fields
**Example**
```php
/**
 * Change password masking character
 */
function change_password_mask_char( $char ) {
    return '•';
}
add_filter( 'fc_substep_text_display_value_password_char', 'change_password_mask_char', 10 );
```

#### `fc_substep_text_display_value_show_field_label_{field_type}`
**Description** Controls whether to show field label for specific field types in substep text display. Replace `{field_type}` with the actual field type (e.g., `text`, `email`, `number`, `checkbox`, etc.).
**Parameters**
- `$show_field_label` (bool) Whether to show field label for this field type.
**Context** Used in `inc/checkout-steps.php` in the `get_substep_text_display_value()` method for specific field types
**Example**
```php
/**
 * Show labels for email fields in substep display
 */
add_filter( 'fc_substep_text_display_value_show_field_label_email', '__return_true', 10 );

/**
 * Hide labels for text fields in substep display
 */
add_filter( 'fc_substep_text_display_value_show_field_label_text', '__return_false', 10 );
```

#### `fc_substep_text_display_value_{field_type}`
**Description** Modifies the display value for specific field types in substep text. Replace `{field_type}` with the actual field type.
**Parameters**
- `$field_display_value` (string) The formatted display value.
- `$field_value` (mixed) The raw field value.
- `$field_key` (string) The field key.
- `$field_args` (array) The field arguments.
**Context** Used in `inc/checkout-steps.php` in the `get_substep_text_display_value()` method
**Example**
```php
/**
 * Customize display for select fields
 */
function customize_select_display_value( $field_display_value, $field_value, $field_key, $field_args ) {
    return '<strong>' . $field_display_value . '</strong>';
}
add_filter( 'fc_substep_text_display_value_select', 'customize_select_display_value', 10, 4 );
```

#### `fc_substep_text_display_value_{field_key}`
**Description** Modifies the display value for specific field keys in substep text. Replace `{field_key}` with the actual field key.
**Parameters**
- `$field_display_value` (string) The formatted display value.
- `$field_value` (mixed) The raw field value.
- `$field_key` (string) The field key.
- `$field_args` (array) The field arguments.
**Context** Used in `inc/checkout-steps.php` in the `get_substep_text_display_value()` method
**Example**
```php
/**
 * Customize display for billing email field
 */
function customize_billing_email_display( $field_display_value, $field_value, $field_key, $field_args ) {
    return '<a href="mailto:' . esc_attr( $field_value ) . '">' . esc_html( $field_display_value ) . '</a>';
}
add_filter( 'fc_substep_text_display_value_billing_email', 'customize_billing_email_display', 10, 4 );
```

### Order Details Page

#### `fc_pro_order_details_customer_billing_address_formatted`
**Description** Modifies the formatted billing address displayed in order details page and emails.
**Parameters**
- `$billing_address_formatted` (string) The formatted billing address HTML.
- `$order` (WC_Order) The order object.
**Context** Used in `templates/fc/checkout-steps/emails/email-addresses.php` and `templates/fc/checkout-steps/emails/plain/email-addresses.php` in Fluid Checkout
**Example**
```php
/**
 * Add custom text to billing address in order details
 */
function customize_order_details_billing_address( $billing_address_formatted, $order ) {
    if ( $order->get_meta( '_priority_customer' ) ) {
        $billing_address_formatted = '<span class="priority-badge">' . __( 'Priority Customer', 'my-theme' ) . '</span>' . $billing_address_formatted;
    }
    return $billing_address_formatted;
}
add_filter( 'fc_pro_order_details_customer_billing_address_formatted', 'customize_order_details_billing_address', 10, 2 );
```


#### `fc_pro_order_details_customer_shipping_address_formatted`
**Description** Modifies the formatted shipping address displayed in order details page.
**Parameters**
- `$shipping_address_formatted` (string) The formatted shipping address HTML.
- `$order` (WC_Order) The order object.
**Context** Used in `templates/fc-pro/order-details/order/order-details-customer.php` in Fluid Checkout PRO
**Example**
```php
/**
 * Add custom text to shipping address in order details
 */
function customize_order_details_shipping_address( $shipping_address_formatted, $order ) {
    if ( $order->get_meta( '_is_gift' ) ) {
        $shipping_address_formatted = '<span class="gift-badge">' . __( 'Gift', 'my-theme' ) . '</span>' . $shipping_address_formatted;
    }
    return $shipping_address_formatted;
}
add_filter( 'fc_pro_order_details_customer_shipping_address_formatted', 'customize_order_details_shipping_address', 10, 2 );
```

#### `fc_pro_order_details_customer_information_show_shipping`
**Description** Controls whether to show shipping address section in order details customer information.
**Parameters**
- `$show_shipping` (bool) Whether to show shipping address.
- `$order` (WC_Order) The order object.
**Context** Used in `templates/fc-pro/order-details/order/order-details-customer.php` in Fluid Checkout PRO
**Example**
```php
/**
 * Always show shipping address section
 */
function always_show_shipping_in_order_details( $show_shipping, $order ) {
    return true;
}
add_filter( 'fc_pro_order_details_customer_information_show_shipping', 'always_show_shipping_in_order_details', 10, 2 );
```

#### `fc_pro_order_details_customer_billing_address_label`
**Description** Modifies the billing address section label in order details page.
**Parameters**
- `$billing_address_label` (string) The billing address label.
- `$order` (WC_Order) The order object.
**Context** Used in `templates/fc-pro/order-details/order/order-details-customer.php` in Fluid Checkout PRO
**Example**
```php
/**
 * Customize billing address label
 */
function customize_billing_label_order_details( $billing_address_label, $order ) {
    return __( 'Invoice Address', 'my-theme' );
}
add_filter( 'fc_pro_order_details_customer_billing_address_label', 'customize_billing_label_order_details', 10, 2 );
```

#### `fc_pro_order_details_customer_shipping_address_label`
**Description** Modifies the shipping address section label in order details page.
**Parameters**
- `$shipping_address_label` (string) The shipping address label.
- `$order` (WC_Order) The order object.
**Context** Used in `templates/fc-pro/order-details/order/order-details-customer.php` in Fluid Checkout PRO
**Example**
```php
/**
 * Customize shipping address label
 */
function customize_shipping_label_order_details( $shipping_address_label, $order ) {
    return __( 'Delivery Address', 'my-theme' );
}
add_filter( 'fc_pro_order_details_customer_shipping_address_label', 'customize_shipping_label_order_details', 10, 2 );
```

## Widgets

### Checkout Sidebar

#### `fc_checkout_sidebar_attributes`
**Description** Adds custom HTML attributes to the checkout sidebar wrapper element.
**Parameters**
- `$sidebar_attributes` (array) Associative array of HTML attributes.
**Context** Used in `inc/checkout-steps.php` in the `output_checkout_order_review_section()` method
**Example**
```php
/**
 * Add custom attributes to checkout sidebar
 */
function add_sidebar_custom_attributes( $sidebar_attributes ) {
    $sidebar_attributes['data-custom'] = 'value';
    $sidebar_attributes['aria-label'] = __( 'Order Summary Sidebar', 'my-theme' );
    return $sidebar_attributes;
}
add_filter( 'fc_checkout_sidebar_attributes', 'add_sidebar_custom_attributes', 10 );
```

#### `fc_checkout_sidebar_attributes_inner`
**Description** Adds custom HTML attributes to the checkout sidebar inner wrapper element.
**Parameters**
- `$sidebar_attributes_inner` (array) Associative array of HTML attributes for the inner element.
**Context** Used in `inc/checkout-steps.php` in the `output_checkout_order_review_section()` method
**Example**
```php
/**
 * Add custom attributes to sidebar inner element
 */
function add_sidebar_inner_attributes( $sidebar_attributes_inner ) {
    $sidebar_attributes_inner['data-scroll'] = 'smooth';
    return $sidebar_attributes_inner;
}
add_filter( 'fc_checkout_sidebar_attributes_inner', 'add_sidebar_inner_attributes', 10 );
```

### Design and Styling

#### `fc_enable_dark_mode_styles`
**Description** Controls whether dark mode color scheme styles are enabled for the checkout page.
**Parameters**
- `$enabled` (bool) Whether dark mode is enabled. Defaults to plugin settings value.
**Context** Used in `inc/design-templates.php` in the `is_dark_mode_enabled()` method
**Example**
```php
/**
 * Enable dark mode
 */
add_filter( 'fc_enable_dark_mode_styles', '__return_true', 10 );
```

#### `fc_apply_button_colors_styles`
**Description** Controls whether Fluid Checkout's button color styles are applied to the checkout page.
**Parameters**
- `$enabled` (bool) Whether button color styles are enabled. Defaults to `false`.
**Context** Used in `inc/design-templates.php` in the `is_button_color_styles_enabled()` method
**Example**
```php
/**
 * Enable custom button colors
 */
add_filter( 'fc_apply_button_colors_styles', '__return_true', 10 );
```

#### `fc_apply_button_design_styles`

**Description** Controls whether Fluid Checkout's button design styles are applied to the checkout page.
**Parameters**
- `$enabled` (bool) Whether button design styles are enabled. Defaults to `false`.
**Context** Used in `inc/design-templates.php` in the `is_button_design_styles_enabled()` method
**Example**
```php
/**
 * Enable custom button design
 */
add_filter( 'fc_apply_button_design_styles', '__return_true', 10 );
```

#### `fc_css_variables`
**Description** Modifies CSS variables used for styling the checkout page.
**Parameters**
- `$css_variables` (array) Multi-dimensional array with CSS variables organized by scope. Defaults to `array( ':root' => array() )`.
- `$context` (string) The context for which CSS variables are being loaded (e.g., 'frontend', 'admin').
**Context** Used in `inc/design-templates.php` in the `get_css_variables_styles()` method
**Example**
```php
/**
 * Add custom CSS variables
 */
function add_custom_css_variables( $css_variables, $context ) {
    if ( 'frontend' === $context ) {
        $new_css_variables = array(
            ':root' => array(
			'--fluidcheckout--button--primary--text-color' => "#ffffff",
			'--fluidcheckout--button--height' => '50px',
            )
        );

        return FluidCheckout_DesignTemplates::instance()->merge_css_variables( $css_variables, $new_css_variables );
    }
    return $css_variables;
}
add_filter( 'fc_css_variables', 'add_custom_css_variables', 10, 2 );
```

#### `fc_output_custom_styles`
**Description** Adds custom CSS styles to the checkout page.
**Parameters**
- `$custom_styles` (string) Custom CSS styles as a string. Defaults to empty string.
**Context** Used in `inc/design-templates.php` in the `output_custom_styles()` method
**Example**
```php
/**
 * Add custom CSS to checkout page
 */
function add_custom_checkout_styles( $custom_styles ) {
    $custom_styles .= '
        .fc-checkout-form { 
            max-width: 1200px; 
        }
        .fc-sidebar { 
            background: #fafafa; 
        }
    ';
    return $custom_styles;
}
add_filter( 'fc_output_custom_styles', 'add_custom_checkout_styles', 10 );
```

### JavaScript Settings

#### `fc_js_settings`
**Description** Modifies JavaScript settings object passed to Fluid Checkout scripts.
**Parameters**
- `$settings` (array) Associative array of JavaScript settings.
**Context** Used in `inc/enqueue.php` in the `get_js_settings()` method
**Example**
```php
/**
 * Add custom JavaScript settings
 */
function add_custom_js_settings( $settings ) {
    $settings['customFeature'] = array(
        'enabled' => true,
        'timeout' => 5000,
    );
    return $settings;
}
add_filter( 'fc_js_settings', 'add_custom_js_settings', 10 );
```

#### `fc_checkout_script_settings`
**Description** Modifies checkout-specific JavaScript settings.
**Parameters**
- `$checkout_settings` (array) Associative array of checkout JavaScript settings.
**Context** Used in `inc/enqueue.php` in the `get_js_settings()` method
**Example**
```php
/**
 * Customize checkout script settings
 */
function customize_checkout_script_settings( $checkout_settings ) {
    $checkout_settings['customCheckoutOption'] = 'value';
    return $checkout_settings;
}
add_filter( 'fc_checkout_script_settings', 'customize_checkout_script_settings', 10 );
```

#### `fc_checkout_update_before_unload`
**Description** Controls whether to trigger checkout update before the page unloads (when user navigates away).
**Parameters**
- `$enabled` (string) Whether the feature is enabled. Values: `'yes'` or `'no'`. Defaults to `'yes'`.
**Context** Used in `inc/enqueue.php` in the checkout script settings
**Example**
```php
/**
 * Disable checkout update before page unload
 */
function disable_checkout_update_before_unload( $enabled ) {
    return 'no';
}
add_filter( 'fc_checkout_update_before_unload', 'disable_checkout_update_before_unload', 10 );
```

#### `fc_checkout_update_on_visibility_change`
**Description** Controls whether to trigger checkout update when page visibility changes (tab switching).
**Parameters**
- `$enabled` (string) Whether the feature is enabled. Values: `'yes'` or `'no'`. Defaults to `'yes'`.
**Context** Used in `inc/enqueue.php` in the checkout script settings
**Example**
```php
/**
 * Disable checkout update on visibility change
 */
function disable_update_on_visibility_change( $enabled ) {
    return 'no';
}
add_filter( 'fc_checkout_update_on_visibility_change', 'disable_update_on_visibility_change', 10 );
```

#### `fc_checkout_update_fields_selectors`
**Description** Defines CSS selectors for form fields that should trigger checkout updates.
**Parameters**
- `$selectors` (array) Array of CSS selectors. Defaults to `array( '.address-field input.input-text', '.update_totals_on_change input.input-text' )`.
**Context** Used in `inc/enqueue.php` in the checkout script settings
**Example**
```php
/**
 * Add custom field selectors for checkout updates
 */
function add_custom_update_field_selectors( $selectors ) {
    $selectors[] = '.custom-field input';
    return $selectors;
}
add_filter( 'fc_checkout_update_fields_selectors', 'add_custom_update_field_selectors', 10 );
```

### Fragments and Updates

#### `fc_enable_fragments_refresh`
**Description** Controls whether the fragments refresh feature is enabled for updating specific parts of the checkout page via AJAX.
**Parameters**
- `$enabled` (bool) Whether fragments refresh is enabled. Defaults to `false`.
**Context** Used in `inc/fragments-refresh.php` to conditionally enable the feature
**Example**
```php
/**
 * Enable fragments refresh feature
 */
add_filter( 'fc_enable_fragments_refresh', '__return_true', 10 );
```

#### `fc_fragments_update_settings`
**Description** Modifies settings for the fragments update feature.
**Parameters**
- `$settings` (array) Associative array of fragments update settings. Defaults to `array( 'updateFragmentsNonce' => wp_create_nonce( 'fc-fragments-refresh' ) )`.
**Context** Used in `inc/fragments-refresh.php` in the `maybe_add_js_settings()` method
**Example**
```php
/**
 * Add custom fragments update settings
 */
function add_custom_fragments_settings( $settings ) {
    // Add custom settings
    $settings['customSetting'] = 'custom-value';
    
    // Return modified settings
    return $settings;
}
add_filter( 'fc_fragments_update_settings', 'add_custom_fragments_settings', 10 );
```

#### `fc_update_fragments`
**Description** Modifies the fragments (HTML sections) to be updated via AJAX on checkout and other pages where fragments refresh is enabled.
**Parameters**
- `$fragments` (array) Associative array where keys are CSS selectors and values are the HTML content to replace. Defaults to empty array.
**Context** Used in `inc/fragments-refresh.php` in the AJAX handler for updating fragments
**Example**
```php
/**
 * Add custom fragments to update via AJAX.
 */
function add_custom_fragments( $fragments ) {
    ob_start();
    echo '<div class="custom-element">';
    echo '<span>Cart items: ' . WC()->cart->get_cart_contents_count() . '</span>';
    echo '</div>';
    $fragments['.custom-element'] = ob_get_clean();
    
    return $fragments;
}
add_filter( 'fc_update_fragments', 'add_custom_fragments', 10 );
```

### Settings and Admin

#### `fc_default_option_values`
**Description** Modifies default option values for Fluid Checkout settings.
**Parameters**
- `$defaults` (array) Associative array of default option values.
**Context** Used in `inc/settings.php` in the `get_option_defaults()` method
**Example**
```php
/**
 * Set custom default values for settings
 */
function customize_default_settings( $defaults ) {
    $defaults['fc_enable_checkout_place_order_sidebar'] = 'yes';

    return $defaults;
}
add_filter( 'fc_default_option_values', 'customize_default_settings', 10 );
```

#### `fc_{section}_settings`
**Description** Modifies settings for specific admin settings sections. Replace `{section}` with the actual section name (e.g., `tools`, `license_keys`, `integrations`, `dashboard`).
**Parameters**
- `$settings` (array) Array of settings for the section.
- `$current_section` (string) The current section identifier.
**Context** Used in various admin settings files when building settings arrays
**Example**
```php
/**
 * Add custom tool to tools section
 */
function add_custom_tool_setting( $settings, $current_section ) {
    // Add custom tool setting
    $settings[] = array(
					'title' => __( 'Custom title', 'fluid-checkout' ),
					'type'  => 'title',
					'desc'  => 'Custom Description',
					'id'    => 'fc_checkout_advanced_debug_options',
    );

    return $settings;
}
add_filter( 'fc_tools_settings', 'add_custom_tool_setting', 10, 2 );

/**
 * Handle custom tool action
 */
function handle_custom_tool_action() {
    if ( isset( $_POST['fc_clear_cache_tool'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'fc_tools_settings-options' ) ) {
        // Clear checkout steps cache
        FluidCheckout_Steps::instance()->clear_checkout_steps_cache();
        
        // Clear other caches as needed
        wp_cache_flush();
        
        // Add success notice
        add_action( 'admin_notices', function() {
            echo '<div class="notice notice-success is-dismissible"><p>' . 
                 esc_html__( 'Cache cleared successfully!', 'my-theme' ) . 
                 '</p></div>';
        });
    }
}
add_action( 'admin_init', 'handle_custom_tool_action' );
```

#### `fc_{section}_settings_add`
**Description** Adds additional settings to specific admin settings sections. Replace `{section}` with the actual section name.
**Parameters**
- `$settings_add` (array) Array of additional settings to add. Defaults to empty array.
**Context** Used in admin settings files for adding settings via filters
**Example**
```php
/**
 * Add settings to tools section
 */
function add_custom_tool_settings( $settings_add ) {
    $settings_add[] = array(
        'title' => __( 'Custom title', 'fluid-checkout' ),
        'type'  => 'title',
        'desc'  => 'Custom Description',
        'id'    => 'fc_checkout_advanced_debug_options',
    );
    return $settings_add;
}
add_filter( 'fc_tools_settings_add', 'add_custom_tool_settings', 10 );
```

#### `fc_show_settings_license_keys`
**Description** Controls whether to show the license keys settings section.
**Parameters**
- `$show` (bool) Whether to show the license keys section. Defaults to `false`.
**Context** Used in `inc/admin/admin-settings-license-keys.php` to conditionally display the section
**Timing** This filter should be set early (priority 10-30) to ensure it's available when the license keys class loads (priority 50)
**Example**
```php
/**
 * Show license keys section
 */
add_filter( 'fc_show_settings_license_keys', '__return_true', 10 );
```

#### `fc_admin_license_keys_group_exists`
**Description** Controls whether the license keys settings group already exists (prevents duplicate registration).
**Parameters**
- `$exists` (bool) Whether the group exists. Defaults to `false`.
**Context** Used in `inc/admin/admin-settings-license-keys.php` to check if group is already registered
**Note** This filter is managed internally by the license keys class. External plugins should not modify this filter.
**Example**
```php
/**
 * Mark license keys group as existing (internal use only)
 */
add_filter( 'fc_admin_license_keys_group_exists', '__return_true', 10 );
```

#### `fc_admin_field_type_license_exists`
**Description** Controls whether the license field type already exists (prevents duplicate registration).
**Parameters**
- `$exists` (bool) Whether the field type exists. Defaults to `false`.
**Context** Used in `inc/admin/admin.php` to check if license field type is already registered
**Example**
```php
/**
 * Mark license field type as existing
 */
add_filter( 'fc_admin_field_type_license_exists', '__return_true', 10 );
```

#### `fc_admin_tab_fluidcheckout_exists`
**Description** Controls whether the Fluid Checkout admin tab already exists (prevents duplicate registration).
**Parameters**
- `$exists` (bool) Whether the admin tab exists. Defaults to `false`.
**Context** Used in `inc/admin/admin.php` to check if admin tab is already registered
**Example**
```php
/**
 * Mark Fluid Checkout admin tab as existing
 */
add_filter( 'fc_admin_tab_fluidcheckout_exists', '__return_true', 10 );
```

### Add Payment Method Page

#### `fc_wrapper_classes_add_payment_method_page`
**Description** Adds custom CSS classes to the add payment method page wrapper element.
**Parameters**
- `$classes` (string) Additional CSS classes. Defaults to empty string.
**Context** Used in `templates/fc/checkout-steps/myaccount/form-add-payment-method.php`
**Example**
```php
/**
 * Add custom classes to add payment method page
 */
function add_payment_method_page_classes( $classes ) {
    $classes .= ' custom-payment-page branded-style';
    return $classes;
}
add_filter( 'fc_wrapper_classes_add_payment_method_page', 'add_payment_method_page_classes', 10 );
```

#### `fc_add_payment_method_button_classes`
**Description** Adds custom CSS classes to the add payment method submit button.
**Parameters**
- `$classes` (array) Array of CSS classes. Defaults to empty array.
**Context** Used in `templates/fc/checkout-steps/myaccount/form-add-payment-method.php`
**Example**
```php
/**
 * Add custom classes to add payment method button
 */
function add_payment_button_classes( $classes ) {
    $classes[] = 'custom-button';
    $classes[] = 'primary-action';
    return $classes;
}
add_filter( 'fc_add_payment_method_button_classes', 'add_payment_button_classes', 10 );
```
