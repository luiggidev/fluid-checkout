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
- `$enabled` (bool) Whether the checkout page template is enabled. Default: `true`
**Context** Used in `inc/checkout-page-template.php` to determine if the custom page template should be applied
**Example**
```php
/**
 * Disable Fluid Checkout page template
 */
function disable_fc_page_template( $enabled ) {
    return false;
}
add_filter( 'fc_enable_checkout_page_template', 'disable_fc_page_template', 10 );
```

#### `fc_enable_checkout_shortcode_wrapper`
**Description** Controls whether to wrap the checkout shortcode with a `fc-content` wrapper element.
**Parameters**
- `$enabled` (bool) Whether the shortcode wrapper is enabled. Default: `false`
**Context** Used in `inc/checkout-page-template.php` when outputting checkout shortcode
**Example**
```php
/**
 * Enable checkout shortcode wrapper for custom styling
 */
function enable_checkout_shortcode_wrapper( $enabled ) {
    return true;
}
add_filter( 'fc_enable_checkout_shortcode_wrapper', 'enable_checkout_shortcode_wrapper', 10 );
```

#### `fc_override_template_with_theme_file`
**Description** Allows themes to override Fluid Checkout template files with their own versions.
**Parameters**
- `$override` (bool) Whether to override with theme file. Default: `false`
- `$template` (string) The template file path
- `$template_name` (string) The template name
- `$template_path` (string) The template path
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
- `$add_class` (bool) Whether to add the container class. Default: `true`
**Context** Used in `inc/checkout-steps.php` when building wrapper classes
**Example**
```php
/**
 * Remove container class for custom theme layouts
 */
function remove_fc_container_class( $add_class ) {
    return false;
}
add_filter( 'fc_add_container_class', 'remove_fc_container_class', 10 );
```

#### `fc_content_section_class`
**Description** Adds custom CSS classes to the content section wrapper element.
**Parameters**
- `$class` (string) Additional CSS classes for the content section. Default: `''`
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
- `$classes` (string) Additional CSS classes for the wrapper. Default: `''`
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
- `$title` (string) The checkout page title. Default: `get_the_title()`
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
- `$display` (bool) Whether to display the title. Default: `false`
**Context** Used in `templates/fc/checkout-page-template/checkout/page-checkout.php`
**Example**
```php
/**
 * Show checkout page title
 */
function show_checkout_page_title( $display ) {
    return true;
}
add_filter( 'fc_display_checkout_page_title', 'show_checkout_page_title', 10 );
```

### Header and Logo

#### `fc_checkout_header_logo_home_url`
**Description** Modifies the home URL for the checkout header logo link.
**Parameters**
- `$home_url` (string) The home URL for the logo link. Default: `home_url( '/' )`
**Context** Used in `templates/fc/checkout-page-template/checkout/checkout-header.php`
**Example**
```php
/**
 * Customize header logo home URL
 */
function customize_header_logo_home_url( $home_url ) {
    return home_url( '/custom-landing-page/' );
}
add_filter( 'fc_checkout_header_logo_home_url', 'customize_header_logo_home_url', 10 );
```

#### `fc_checkout_html_custom_attributes`
**Description** Adds custom HTML attributes to the checkout page HTML element.
**Parameters**
- `$attributes` (array) Array of HTML attributes as key-value pairs. Default: `array()`
**Context** Used in `templates/fc/checkout-page-template/checkout/page-checkout-header.php`
**Example**
```php
/**
 * Add custom HTML attributes to checkout page
 */
function add_custom_html_attributes( $attributes ) {
    $attributes['data-theme'] = 'custom-checkout';
    $attributes['data-version'] = '2.0';
    return $attributes;
}
add_filter( 'fc_checkout_html_custom_attributes', 'add_custom_html_attributes', 10 );
```

#### `fc_checkout_body_custom_attributes`
**Description** Adds custom HTML attributes to the checkout page body element.
**Parameters**
- `$attributes` (array) Array of HTML attributes as key-value pairs. Default: `array()`
**Context** Used in `templates/fc/checkout-page-template/checkout/page-checkout-header.php`
**Example**
```php
/**
 * Add custom body attributes for theme compatibility
 */
function add_custom_body_attributes( $attributes ) {
    $attributes['class'] = 'custom-checkout-body';
    $attributes['data-page'] = 'checkout';
    return $attributes;
}
add_filter( 'fc_checkout_body_custom_attributes', 'add_custom_body_attributes', 10 );
```

### Layout and Design

#### `fc_get_checkout_layout`
**Description** Modifies the checkout layout setting value.
**Parameters**
- `$layout` (string) The checkout layout setting value. Default: `'multi-step'`
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
- `$is_multistep` (bool) Whether the layout is multi-step. Default: `'multi-step' === $this->get_checkout_layout()`
**Context** Used in `inc/checkout-steps.php` to check layout type
**Example**
```php
/**
 * Force multi-step layout for specific conditions
 */
function force_multistep_layout( $is_multistep ) {
    return true;
}
add_filter( 'fc_is_checkout_layout_multistep', 'force_multistep_layout', 10 );
```

#### `fc_checkout_layout_option_image_url`
**Description** Modifies the image URL for layout options in the admin settings.
**Parameters**
- `$image_url` (string) The image URL for the layout option
- `$layout_key` (string) The layout option key
**Context** Used in admin settings to display layout option images
**Example**
```php
/**
 * Customize layout option images
 */
function customize_layout_option_images( $image_url, $layout_key ) {
    if ( 'multi-step' === $layout_key ) {
        return get_template_directory_uri() . '/images/custom-multistep.png';
    }
    return $image_url;
}
add_filter( 'fc_checkout_layout_option_image_url', 'customize_layout_option_images', 10, 2 );
```

#### `fc_design_template_option_image_url`
**Description** Modifies the image URL for design template options in the admin settings.
**Parameters**
- `$image_url` (string) The image URL for the design template option
- `$template_key` (string) The design template option key
**Context** Used in admin settings to display design template option images
**Example**
```php
/**
 * Customize design template option images
 */
function customize_design_template_images( $image_url, $template_key ) {
    if ( 'minimal' === $template_key ) {
        return get_template_directory_uri() . '/images/custom-minimal.png';
    }
    return $image_url;
}
add_filter( 'fc_design_template_option_image_url', 'customize_design_template_images', 10, 2 );
```

### Compatibility

- `fc_enable_compat_plugin_*` - Controls compatibility with specific plugins
- `fc_enable_compat_theme_*` - Controls compatibility with specific themes
- `fc_enable_compat_plugin_style_*` - Controls plugin-specific style compatibility
- `fc_enable_compat_theme_style_*` - Controls theme-specific style compatibility
- `fc_enable_compat_theme_account_style_*` - Controls theme-specific account page style compatibility
- `fc_enable_compat_theme_edit_address_style_*` - Controls theme-specific edit address page style compatibility
- `fc_enable_compat_plugin_edit_address_style_*` - Controls plugin-specific edit address page style compatibility
- `fc_compat_dibs_easy_skip_undo_hooks_classes` - Defines classes to skip when undoing hooks for DIBS Easy compatibility
- `fc_compat_dibs_easy_skip_undo_hooks_early_classes` - Defines classes to skip early when undoing hooks for DIBS Easy compatibility
- `fc_compat_dintero_checkout_skip_undo_hooks_classes` - Defines classes to skip when undoing hooks for Dintero Checkout compatibility
- `fc_compat_dintero_checkout_skip_undo_hooks_early_classes` - Defines classes to skip early when undoing hooks for Dintero Checkout compatibility
- `fc_compat_klarna_checkout_skip_undo_hooks_classes` - Defines classes to skip when undoing hooks for Klarna Checkout compatibility
- `fc_compat_klarna_checkout_skip_undo_hooks_early_classes` - Defines classes to skip early when undoing hooks for Klarna Checkout compatibility
- `fc_compat_payson_checkout_skip_undo_hooks_classes` - Defines classes to skip when undoing hooks for Payson Checkout compatibility
- `fc_compat_payson_checkout_skip_undo_hooks_early_classes` - Defines classes to skip early when undoing hooks for Payson Checkout compatibility
- `fc_compat_theme_woodmart_disable_theme_checkout_options` - Controls whether to disable Woodmart theme checkout options
- `fc_compat_wcbcf_disable_marked_input_phone_feature` - Controls whether to disable marked input phone feature for WCBCF compatibility
- `fc_integration_woo_checkout_field_editor_pro_enable_edit_address_changes` - Controls whether to enable edit address changes for WooCommerce Checkout Field Editor Pro
- `fc_pro_override_template_with_theme_file` - Controls whether to override template with theme file for Pro features
- `fc_thwcfe_clear_field_keys_skip_list` - Defines field keys to skip when clearing THWCFE fields

## Checkout Steps Management

### Step Registration and Configuration

#### `fc_register_checkout_step_args`
**Description** Modifies arguments when registering checkout steps, allowing customization of step properties.
**Parameters**
- `$step_args` (array) Array of step configuration arguments including:
  - `step_id` (string) Unique identifier for the step
  - `step_title` (string) Display title for the step
  - `proceed_to_step_button_label` (string) Label for the proceed button
  - `priority` (int) Step priority/order
  - `next_step_button_classes` (array) Additional CSS classes for next step button
**Context** Used in `inc/checkout-steps.php` during step registration
**Example**
```php
/**
 * Customize checkout step arguments
 */
function customize_checkout_step_args( $step_args ) {
    if ( 'contact' === $step_args['step_id'] ) {
        $step_args['step_title'] = __( 'Your Information', 'my-theme' );
        $step_args['next_step_button_classes'][] = 'custom-button-class';
    }
    return $step_args;
}
add_filter( 'fc_register_checkout_step_args', 'customize_checkout_step_args', 10 );
```

#### `fc_register_checkout_substep_args`
**Description** Modifies arguments when registering checkout substeps, allowing customization of substep properties.
**Parameters**
- `$substep_args` (array) Array of substep configuration arguments
- `$step_id` (string) The parent step ID
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
**Description** Allows hijacking the checkout steps before they are returned, enabling complete customization of the steps array.
**Parameters**
- `$steps` (array|null) The checkout steps array or null if not hijacked
- `$context` (string) The context in which steps are being retrieved (default: 'checkout')
**Context** Used in `inc/checkout-steps.php` before returning checkout steps
**Example**
```php
/**
 * Hijack checkout steps for custom implementation
 */
function hijack_checkout_steps( $steps, $context ) {
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
add_filter( 'fc_get_checkout_steps_before', 'hijack_checkout_steps', 10, 2 );
```

#### `fc_is_checkout_page_or_fragment`
**Description** Determines if the current page is a checkout page or checkout fragment (AJAX request).
**Parameters**
- `$is_checkout` (bool) Whether the current page is checkout. Default: `false`
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
- `$is_cart` (bool) Whether the current page is cart. Default: `false`
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
- `$title` (string) The contact step title. Default: `_x( 'Contact', 'Checkout step title', 'fluid-checkout' )`
**Context** Used in `inc/checkout-steps.php` when registering the contact step
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
- `$title` (string) The shipping step title. Default: `_x( 'Shipping', 'Checkout step title', 'fluid-checkout' )`
**Context** Used in `inc/checkout-steps.php` when registering the shipping step
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
- `$title` (string) The billing step title. Default: `_x( 'Billing', 'Checkout step title', 'fluid-checkout' )`
**Context** Used in `inc/checkout-steps.php` when registering the billing step
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
- `$title` (string) The payment step title. Default: `_x( 'Payment', 'Checkout step title', 'fluid-checkout' )`
**Context** Used in `inc/checkout-steps.php` when registering the payment step
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

#### `fc_proceed_to_next_step_button_label`
**Description** Modifies the proceed to next step button label text.
**Parameters**
- `$label` (string) The button label text
- `$step_id` (string) The current step ID
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
- `$label` (string) The button label text
- `$step_id` (string) The current step ID
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
- `$classes` (array) Array of CSS classes for the button. Default: `array( 'button' )`
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
- `$is_complete` (bool) Whether the step is complete
- `$step_id` (string) The step identifier
- `$context` (string) The context in which the step is being checked (default: 'checkout')
**Context** Used in `inc/checkout-steps.php` when determining step completion status
**Example**
```php
/**
 * Custom step completion logic
 */
function custom_step_completion_logic( $is_complete, $step_id, $context ) {
    if ( 'contact' === $step_id ) {
        // Require phone number for contact step completion
        $phone = WC()->checkout()->get_value( 'billing_phone' );
        return ! empty( $phone );
    }
    return $is_complete;
}
add_filter( 'fc_is_step_complete', 'custom_step_completion_logic', 10, 3 );
```

#### `fc_is_step_complete_*`
**Description** Controls completion for specific steps using dynamic filter names (e.g., `fc_is_step_complete_contact`).
**Parameters**
- `$is_complete` (bool) Whether the specific step is complete
- `$context` (string) The context in which the step is being checked
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
- `$is_current` (bool) Whether the step is current
- `$step_id` (string) The step identifier
- `$context` (string) The context in which the step is being checked
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
**Description** Controls whether to disable the place order button, typically for validation purposes.
**Parameters**
- `$disable` (bool) Whether to disable the place order button. Default: `false`
**Context** Used in checkout templates when rendering the place order button
**Example**
```php
/**
 * Disable place order button for specific conditions
 */
function disable_place_order_button_conditionally( $disable ) {
    // Disable if cart total is below minimum
    $cart_total = WC()->cart->get_total( 'raw' );
    if ( $cart_total < 50 ) {
        return true;
    }
    return $disable;
}
add_filter( 'fc_checkout_maybe_disable_place_order_button', 'disable_place_order_button_conditionally', 10 );
```

#### `fc_checkout_steps_script_settings`
**Description** Modifies JavaScript settings for checkout steps functionality.
**Parameters**
- `$settings` (array) Array of JavaScript settings for checkout steps
**Context** Used when enqueuing checkout steps JavaScript
**Example**
```php
/**
 * Add custom JavaScript settings for checkout steps
 */
function add_custom_checkout_steps_settings( $settings ) {
    $settings['customOption'] = 'customValue';
    $settings['debugMode'] = defined( 'WP_DEBUG' ) && WP_DEBUG;
    return $settings;
}
add_filter( 'fc_checkout_steps_script_settings', 'add_custom_checkout_steps_settings', 10 );
```

### Progress Bar

#### `fc_checkout_progress_bar_style`
**Description** Modifies the progress bar style setting (bars or breadcrumbs).
**Parameters**
- `$style` (string) The progress bar style. Default: `'bars'`
**Context** Used in `inc/checkout-steps.php` when getting progress bar style
**Example**
```php
/**
 * Force breadcrumbs style for mobile devices
 */
function force_breadcrumbs_style_mobile( $style ) {
    if ( wp_is_mobile() ) {
        return 'breadcrumbs';
    }
    return $style;
}
add_filter( 'fc_checkout_progress_bar_style', 'force_breadcrumbs_style_mobile', 10 );
```

#### `fc_checkout_progress_bar_attributes`
**Description** Adds custom HTML attributes to the progress bar element.
**Parameters**
- `$attributes` (array) Array of HTML attributes as key-value pairs
**Context** Used in `inc/checkout-steps.php` when building progress bar attributes
**Example**
```php
/**
 * Add custom attributes to progress bar
 */
function add_custom_progress_bar_attributes( $attributes ) {
    $attributes['data-custom'] = 'value';
    $attributes['class'] = 'custom-progress-bar';
    return $attributes;
}
add_filter( 'fc_checkout_progress_bar_attributes', 'add_custom_progress_bar_attributes', 10 );
```

#### `fc_checkout_progress_bar_inner_attributes`
**Description** Adds custom HTML attributes to the progress bar inner element.
**Parameters**
- `$attributes` (array) Array of HTML attributes as key-value pairs
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
- `$display_count` (bool) Whether to display step count. Default: `true`
**Context** Used in `inc/checkout-steps.php` when rendering progress bar
**Example**
```php
/**
 * Hide step count in progress bar
 */
function hide_progress_bar_step_count( $display_count ) {
    return false;
}
add_filter( 'fc_checkout_progress_bar_display_count', 'hide_progress_bar_step_count', 10 );
```

#### `fc_checkout_step_attributes`
**Description** Adds custom HTML attributes to individual checkout steps.
**Parameters**
- `$attributes` (array) Array of HTML attributes as key-value pairs
- `$step_id` (string) The step identifier
- `$step_index` (int) The step index
- `$context` (string) The context in which the step is being rendered
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
**Description** Controls the position where order notes hooks are executed.
**Parameters**
- `$position` (string) The hook position. Default: `'after'`
**Context** Used in `inc/checkout-steps.php` when positioning order notes hooks
**Example**
```php
/**
 * Change order notes hooks position
 */
function change_order_notes_hooks_position( $position ) {
    return 'before';
}
add_filter( 'fc_do_order_notes_hooks_position', 'change_order_notes_hooks_position', 10 );
```

#### `fc_do_order_notes_hooks_priority`
**Description** Controls the priority of order notes hooks execution.
**Parameters**
- `$priority` (int) The hook priority. Default: `10`
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
- `$priority` (int) The hook priority. Default: `10`
**Context** Used in `inc/checkout-steps.php` when setting billing step hook priorities
**Example**
```php
/**
 * Change billing step hooks priority
 */
function change_billing_step_hooks_priority( $priority ) {
    return 15;
}
add_filter( 'fc_billing_step_hook_priority', 'change_billing_step_hooks_priority', 10 );
```

#### `fc_billing_address_substep_position_args`
**Description** Controls positioning arguments for the billing address substep.
**Parameters**
- `$position_args` (array) Array of positioning arguments
**Context** Used in `inc/checkout-steps.php` when positioning billing address substep
**Example**
```php
/**
 * Customize billing address substep position
 */
function customize_billing_address_substep_position( $position_args ) {
    $position_args['priority'] = 25;
    return $position_args;
}
add_filter( 'fc_billing_address_substep_position_args', 'customize_billing_address_substep_position', 10 );
```

#### `fc_checkout_after_step_shipping_fields_inside`
**Description** Defines the hook position for after shipping fields inside the shipping step.
**Parameters**
- `$position` (string) The hook position. Default: `'inside'`
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
- `$attributes` (array) Array of HTML attributes as key-value pairs
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
**Description** Modifies locale language variants for internationalization.
**Parameters**
- `$variant` (string) The language variant
**Context** Used in various places for locale-specific functionality
**Example**
```php
/**
 * Customize locale language variant
 */
function customize_locale_language_variant( $variant ) {
    return 'US';
}
add_filter( 'fc_locale_language_variant', 'customize_locale_language_variant', 10 );
```

#### `fc_show_shipping_section_highlighted`
**Description** Controls whether to highlight the shipping section.
**Parameters**
- `$highlight` (bool) Whether to highlight the shipping section. Default: `false`
**Context** Used in checkout templates when rendering shipping section
**Example**
```php
/**
 * Highlight shipping section for new customers
 */
function highlight_shipping_section_new_customers( $highlight ) {
    if ( ! is_user_logged_in() ) {
        return true;
    }
    return $highlight;
}
add_filter( 'fc_show_shipping_section_highlighted', 'highlight_shipping_section_new_customers', 10 );
```

#### `fc_show_billing_section_highlighted`
**Description** Controls whether to highlight the billing section.
**Parameters**
- `$highlight` (bool) Whether to highlight the billing section. Default: `false`
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
- `$highlight` (bool) Whether to highlight the order totals row. Default: `false`
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

- `fc_enable_checkout_ajax_login` - Controls whether AJAX login is enabled at checkout
- `fc_checkout_login_script_settings` - Modifies JavaScript settings for checkout login
- `fc_checkout_login_modal_title` - Modifies the login modal title
- `fc_checkout_login_cta_text` - Modifies the "Already have an account?" text
- `fc_checkout_login_button_label` - Modifies the login button label
- `fc_checkout_login_button_class` - Modifies the login button CSS class
- `fc_checkout_login_separator_text` - Modifies the separator text between login and guest checkout
- `fc_output_checkout_contact_login_cta_section` - Controls whether to output checkout contact login CTA section
- `fc_output_checkout_contact_logout_cta_section` - Controls whether to output checkout contact logout CTA section
- `fc_checkout_login_fields_unique_id` - Modifies the unique ID for login form fields
- `fc_checkout_login_input_classes` - Adds custom classes to login form inputs
- `fc_checkout_login_button_classes` - Adds custom classes to login button
- `fc_login_form_wrapper_class` - Adds custom classes to login form wrapper
- `fc_login_form_class` - Adds custom classes to login form
- `fc_login_form_inner_class` - Adds custom classes to login form inner element

### Contact Fields

- `fc_checkout_contact_step_field_ids` - Modifies which fields are displayed in contact step
- `fc_checkout_email_field_description` - Modifies the email field description
- `fc_checkout_field_args` - Modifies checkout field arguments
- `fc_apply_address_1_field_description` - Controls whether to apply address 1 field description
- `fc_apply_address_2_field_description` - Controls whether to apply address 2 field description
- `fc_default_locale_field_args` - Modifies default locale field arguments
- `fc_select2_field_types` - Defines which field types should render as select2

### Account Creation

- `fc_checkout_display_create_account_optional_label` - Controls whether to show "optional" label for account creation
- `fc_checkout_account_creation_notice_message` - Modifies the account creation notice message
- `fc_show_account_creation_notice_checkout_contact_step_text` - Controls whether to show account creation notice

### Form Validation and Display

- `fc_checkout_email_fields_for_mailcheck` - Defines which email fields should use mailcheck
- `fc_enable_checkout_email_mailcheck` - Controls whether email typo suggestions are enabled
- `fc_checkout_is_valid_phone_number` - Customizes phone number validation
- `fc_no_validation_icon_field_types` - Defines field types that should not show validation icons
- `fc_no_validation_icon_field_keys` - Defines field keys that should not show validation icons
- `fc_checkout_validation_script_settings` - Modifies JavaScript settings for checkout validation
- `fc_checkout_validation_brazilian_documents_script_settings` - Modifies settings for Brazilian document validation

### Mobile and Accessibility

- `fc_fix_zoom_in_form_fields_mobile_devices` - Controls whether to fix zoom issues on mobile devices
- `fc_use_verbose_loading_indicator` - Controls whether to use verbose loading indicators

## Shipping Step

### Shipping Methods

- `fc_shipping_method_option_markup` - Modifies the markup for shipping method options
- `fc_shipping_method_option_start_tag_markup` - Modifies the opening tag markup for shipping methods list
- `fc_shipping_method_option_end_tag_markup` - Modifies the closing tag markup for shipping methods list
- `fc_shipping_method_option_label_markup` - Modifies the label markup for shipping method options
- `fc_shipping_method_option_image_html` - Adds custom HTML for shipping method images
- `fc_shipping_method_option_image_markup` - Modifies the markup for shipping method images
- `fc_shipping_method_has_cost` - Controls whether a shipping method has a cost
- `fc_shipping_method_option_price` - Modifies the price display for shipping methods
- `fc_shipping_method_option_price_markup` - Modifies the price markup for shipping methods
- `fc_shipping_method_description_html_element` - Defines the HTML element for shipping method descriptions
- `fc_shipping_method_option_description` - Modifies the description for shipping method options
- `fc_shipping_method_option_description_markup` - Modifies the description markup for shipping methods

### Shipping Address

- `fc_shipping_phone_field_args` - Modifies arguments for shipping phone field
- `fc_checkout_shipping_collapsible_initial_state` - Controls initial state of shipping address collapsible section
- `fc_is_shipping_address_available_for_billing` - Controls whether shipping address is available for billing
- `fc_is_billing_address_available_for_shipping` - Controls whether billing address is available for shipping
- `fc_shipping_same_as_billing_option_label` - Modifies the "Same as billing address" option label
- `fc_shipping_same_as_billing_skip_fields` - Defines fields to skip when copying billing to shipping
- `fc_shipping_same_as_billing_field_keys` - Defines field keys to copy from billing to shipping
- `fc_output_shipping_same_as_billing_as_hidden_field` - Controls whether to output shipping same as billing as hidden field

### Shipping Package Display

- `fc_shipping_method_display_package_name` - Controls whether to display package names
- `fc_shipping_method_display_package_content_substep_text_lines` - Controls package content display in substep text
- `fc_shipping_method_display_package_destination_substep_text_lines` - Controls package destination display in substep text
- `fc_cart_has_multiple_packages` - Determines if cart has multiple shipping packages
- `fc_shipping_method_substep_text_chosen_method_label` - Modifies the chosen shipping method label in substep text
- `fc_shipping_method_substep_text_package_destination_data` - Modifies package destination data for substep text
- `fc_shipping_method_substep_text_package_destination_text` - Modifies package destination text for substep text
- `fc_shipping_method_substep_text_package_review_text_lines_before_contents` - Modifies package review text before contents
- `fc_shipping_method_substep_text_package_review_text_lines` - Modifies package review text lines
- `fc_shipping_same_as_billing_display_substep_review_text_notice` - Controls whether to display "same as billing" notice in substep text

### Shipping Method Selection

- `fc_shipping_methods_disable_auto_select` - Controls whether to disable auto-selection of shipping methods
- `fc_is_substep_complete_shipping_address` - Controls completion of shipping address substep
- `fc_is_substep_complete_shipping_address_field_keys_skip_list` - Defines field keys to skip for shipping address completion
- `fc_is_substep_complete_shipping_method` - Controls completion of shipping method substep
- `fc_is_shipping_address_data_same_as_billing_before` - Allows hijacking shipping address data comparison
- `fc_is_shipping_same_as_billing_checked` - Controls whether shipping same as billing is checked by default
- `fc_save_new_address_data_shipping_skip_update` - Controls whether to skip updating shipping address data

### Address Localization

- `fc_add_phone_localisation_formats` - Controls whether to add phone to address localization formats
- `fc_formatted_address_replacements_custom_field_keys` - Defines custom field keys for address replacements
- `fc_shipping_substep_text_address_data` - Modifies shipping address data for substep text

### Shipping Not Needed

- `fc_shipping_not_needed_shipping_field_keys` - Defines field keys when shipping is not needed
- `fc_copy_billing_to_shipping_address_when_shipping_not_needed` - Controls whether to copy billing to shipping when shipping not needed

## Billing Step

### Billing Address

- `fc_checkout_billing_collapsible_initial_state` - Controls initial state of billing address collapsible section
- `fc_is_billing_address_before_shipping_address` - Controls whether billing address comes before shipping address
- `fc_is_billing_address_forced_same_as_shipping_address` - Controls whether billing address is forced to be same as shipping
- `fc_billing_same_as_shipping_option_label` - Modifies the "Same as shipping address" option label
- `fc_billing_same_as_shipping_skip_fields` - Defines fields to skip when copying shipping to billing
- `fc_billing_same_as_shipping_field_keys` - Defines field keys to copy from shipping to billing
- `fc_output_billing_same_as_shipping_as_hidden_field` - Controls whether to output billing same as shipping as hidden field

### Address Data Management

- `fc_is_billing_address_data_same_as_shipping_before` - Allows hijacking billing address data comparison
- `fc_is_billing_same_as_shipping_checked` - Controls whether billing same as shipping is checked by default
- `fc_default_to_billing_same_as_shipping` - Controls default state of billing same as shipping checkbox
- `fc_save_new_address_data_billing_skip_update` - Controls whether to skip updating billing address data
- `fc_billing_same_as_shipping_field_value` - Modifies field values when copying shipping to billing
- `fc_shipping_same_as_billing_field_value` - Modifies field values when copying billing to shipping

### Billing Address Completion

- `fc_is_substep_complete_billing_address` - Controls completion of billing address substep
- `fc_is_substep_complete_billing_address_field_keys_skip_list` - Defines field keys to skip for billing address completion
- `fc_billing_same_as_shipping_display_substep_review_text_notice` - Controls whether to display "same as shipping" notice in substep text
- `fc_billing_substep_text_address_data` - Modifies billing address data for substep text

### Address Field Management

- `fc_address_field_keys_skip_list` - Defines field keys to skip in address processing
- `fc_address_field_keys` - Modifies address field keys for processing
- `fc_skip_change_customer_address_field_value_from_checkout_data` - Controls whether to skip changing customer address field values
- `fc_skip_checkout_field_value_from_session_or_posted_data` - Controls whether to skip field values from session or posted data

### Address Validation

- `fc_checkout_address_i18n_override_locale_required_attribute` - Controls whether to override locale required attributes
- `fc_checkout_address_i18n_override_locale_attributes` - Modifies locale attributes for address fields

## Payment Step

### Payment Methods

- `fc_payment_method_review_text_*` - Modifies review text for specific payment methods
- `fc_payment_not_needed_message` - Modifies the message when no payment is needed
- `fc_place_order_button_classes` - Adds custom classes to the place order button

### Order Notes

- `fc_no_order_notes_order_review_notice` - Modifies the notice when no order notes are provided
- `fc_no_substep_review_text_notice` - Modifies the notice text for substeps with no review content

### Coupon Codes

- `fc_coupon_code_substep_step_id` - Modifies the step ID for coupon code substep
- `fc_display_coupon_code_section_title` - Controls whether to display coupon code section title
- `fc_coupon_code_substep_priority` - Modifies the priority for coupon code substep
- `fc_coupon_code_displayed_as_substep` - Controls whether coupon codes are displayed as substep
- `fc_substep_coupon_codes_section_title` - Modifies the section title for coupon codes substep
- `fc_checkout_coupons_script_settings` - Modifies JavaScript settings for checkout coupons
- `fc_coupon_code_field_label` - Modifies the coupon code field label
- `fc_coupon_code_field_description` - Modifies the coupon code field description
- `fc_coupon_code_field_placeholder` - Modifies the coupon code field placeholder
- `fc_coupon_code_button_label` - Modifies the coupon code button label
- `fc_coupon_code_field_initially_expanded` - Controls whether coupon code field is initially expanded
- `fc_expansible_section_toggle_label_*` - Modifies toggle labels for expansible sections
- `fc_coupon_code_apply_button_classes` - Adds custom classes to coupon code apply button
- `fc_substep_coupon_codes_text` - Modifies the text content for coupon codes substep
- `fc_coupon_code_error_message_dismiss_button_enabled` - Controls whether to show dismiss button for coupon error messages
- `fc_coupon_code_error_message_dismiss_button` - Modifies the dismiss button for coupon error messages

### Expansible Sections

- `fc_expansible_section_toggle_label_add_optional_text` - Controls whether to add "optional" text to toggle labels
- `fc_expansible_section_toggle_label_*_add_optional_text` - Controls optional text for specific toggle labels
- `fc_substep_change_button_label` - Modifies the "Change" button label for substeps
- `fc_substep_save_button_classes` - Adds custom classes to substep save button
- `fc_substep_save_button_label` - Modifies the "Save changes" button label for substeps

### Hide Optional Fields

- `fc_hide_optional_fields_skip_list` - Defines fields to skip when hiding optional fields
- `fc_hide_optional_fields_skip_field` - Controls whether to skip hiding specific fields
- `fc_hide_optional_fields_skip_types` - Defines field types to skip when hiding optional fields
- `fc_hide_optional_fields_skip_by_class` - Defines CSS classes to skip when hiding optional fields

## Order Summary

### Order Summary Display

- `fc_order_review_title` - Modifies the order review title
- `fc_order_summary_display_desktop_edit_cart_link` - Controls whether to display edit cart link on desktop
- `fc_order_summary_continue_button_classes` - Adds custom classes to order summary continue button
- `fc_checkout_order_review_table_classes` - Adds custom classes to checkout review order table
- `fc_pro_checkout_review_order_table_classes` - Adds custom classes to pro checkout review order table

### Shipping Display

- `fc_checkout_no_shipping_method_chosen_html` - Modifies HTML when no shipping method is chosen
- `fc_order_summary_shipping_package_name` - Modifies the shipping package name in order summary
- `fc_order_summary_shipping_package_price_html` - Modifies the shipping package price HTML in order summary
- `fc_enable_order_summary_cart_item_unit_price` - Controls whether to display unit prices in order summary

### Cart and Product Display

- `fc_checkout_header_cart_link_label_html` - Modifies the cart link label HTML in checkout header
- `fc_subscription_shipping_package_name` - Modifies shipping package name for subscriptions
- `fc_shipping_method_option_start_tag_markup` - Modifies opening tag markup for shipping methods
- `fc_shipping_method_option_end_tag_markup` - Modifies closing tag markup for shipping methods
- `fc_shipping_method_option_markup` - Modifies the markup for shipping method options

### Customer Data Persistence

- `fc_customer_persisted_data_skip_fields` - Defines fields to skip in customer data persistence
- `fc_customer_persisted_data_session_field_keys` - Defines session field keys for customer data
- `fc_set_parsed_posted_data` - Modifies parsed posted data before processing
- `fc_parsed_posted_data_reset_field_keys` - Defines field keys to reset in parsed posted data
- `fc_customer_persisted_data_clear_fields_order_processed` - Defines fields to clear when order is processed
- `fc_customer_meta_data_clear_fields_order_processed` - Defines customer meta fields to clear when order is processed
- `fc_customer_persisted_data_clear_all_fields_skip_list` - Defines fields to skip when clearing all customer data

### Substep Text Display

- `fc_substep_text_display_value_show_field_label` - Controls whether to show field labels in substep text
- `fc_substep_text_display_value_*_char` - Modifies character used for specific field types in substep text
- `fc_substep_text_display_value_show_field_label_*` - Controls field label display for specific field types
- `fc_substep_text_display_value_*` - Modifies display value for specific field types and keys
- `fc_substep_text_display_value_*` - Modifies display value for specific field keys

### Email Templates

- `fc_pro_order_details_customer_billing_address_formatted` - Modifies formatted billing address in order details
- `fc_pro_order_details_customer_shipping_address_formatted` - Modifies formatted shipping address in order details
- `fc_pro_order_details_customer_information_show_shipping` - Controls whether to show shipping information in order details
- `fc_pro_order_details_customer_billing_address_label` - Modifies billing address label in order details
- `fc_pro_order_details_customer_shipping_address_label` - Modifies shipping address label in order details

## Widgets

### Checkout Sidebar

- `fc_checkout_sidebar_attributes` - Adds custom attributes to checkout sidebar
- `fc_checkout_sidebar_attributes_inner` - Adds custom attributes to checkout sidebar inner element

### Design and Styling

- `fc_enable_dark_mode_styles` - Controls whether dark mode styles are enabled
- `fc_apply_button_colors_styles` - Controls whether button color styles are applied
- `fc_apply_button_design_styles` - Controls whether button design styles are applied
- `fc_css_variables` - Modifies CSS variables for styling
- `fc_output_custom_styles` - Adds custom CSS styles

### JavaScript Settings

- `fc_js_settings` - Modifies JavaScript settings globally
- `fc_checkout_script_settings` - Modifies checkout JavaScript settings
- `fc_checkout_update_before_unload` - Controls whether to update checkout before page unload
- `fc_checkout_update_on_visibility_change` - Controls whether to update checkout on visibility change
- `fc_checkout_update_fields_selectors` - Defines field selectors for checkout updates

### Fragments and Updates

- `fc_enable_fragments_refresh` - Controls whether fragments refresh is enabled
- `fc_fragments_update_settings` - Modifies settings for fragments update
- `fc_update_fragments` - Modifies fragments to be updated

### Settings and Admin

- `fc_default_option_values` - Modifies default option values for settings
- `fc_*_settings` - Modifies settings for specific sections
- `fc_*_settings_add` - Adds additional settings for specific sections
- `fc_show_settings_license_keys` - Controls whether to show license keys settings
- `fc_admin_license_keys_group_exists` - Controls whether license keys group already exists
- `fc_admin_field_type_license_exists` - Controls whether license field type already exists
- `fc_admin_tab_fluidcheckout_exists` - Controls whether Fluid Checkout admin tab already exists

### Add Payment Method Page

- `fc_wrapper_classes_add_payment_method_page` - Adds custom classes to add payment method page wrapper
- `fc_add_payment_method_button_classes` - Adds custom classes to add payment method button
