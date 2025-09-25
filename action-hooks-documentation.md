# Fluid Checkout - Action Hooks Documentation

This document provides comprehensive documentation for all action hooks available in the Fluid Checkout plugin, based on the codebase analysis.

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

### `fc_checkout_before_main_section_wrapper`
**Description** This action hook fires before the main section wrapper element is rendered in the checkout page template. This hook is used by theme compatibility classes to add theme-specific elements like headers, breadcrumbs, or page titles.
**Parameters** None
**Context** Used in `templates/fc/checkout-page-template/checkout/page-checkout.php` before the main content wrapper
**Example**
```php
/**
 * Add div opening tag
 */
function add_div_opening_tag() {
	echo '<div class="custom-before-main">';
}
add_action( 'fc_checkout_before_main_section_wrapper', 'add_div_opening_tag', 10 );
```

### `fc_checkout_before_main_section`
**Description** This action hook fires before the main section content is rendered in the checkout page template.
**Parameters** None
**Context** Used in checkout template rendering
**Example**
```php
/**
 * Add custom content before main section
 */
function add_before_main_section() {
    echo '<div class="custom-main-intro">Welcome to checkout</div>';
}
add_action( 'fc_checkout_before_main_section', 'add_before_main_section', 10 );
```

### `fc_checkout_after_main_section`
**Description** This action hook fires after the main section content is rendered in the checkout page template.
**Parameters** None
**Context** Used in checkout template rendering
**Example**
```php
/**
 * Add custom content after main section
 */
function add_after_main_section() {
    echo '<div class="custom-main-outro">Thank you for your order</div>';
}
add_action( 'fc_checkout_after_main_section', 'add_after_main_section', 10 );
```

### `fc_checkout_after_main_section_wrapper`
**Description** This action hook fires after the main section wrapper element is rendered in the checkout page template.
**Parameters** None
**Context** Used in checkout template rendering
**Example**
```php
/**
 * Add div closing tag
 */
function add_div_closing_tag() {
	echo '</div>';
}
add_action( 'fc_checkout_after_main_section_wrapper', 'add_div_closing_tag', 10 );
```

### `fc_checkout_before`
**Description** This action hook fires before the checkout process begins in the checkout page template.
**Parameters** None
**Context** Used at the start of checkout process
**Example**
```php
/**
 * Initialize custom checkout features
 */
function init_custom_checkout_features() {
    // Initialize custom checkout functionality
    wp_enqueue_script( 'custom-checkout' );
}
add_action( 'fc_checkout_before', 'init_custom_checkout_features', 10 );
```

### `fc_checkout_after`
**Description** This action hook fires after the checkout process completes in the checkout page template.
**Parameters** None
**Context** Used at the end of checkout process
**Example**
```php
/**
 * Clean up after checkout
 */
function cleanup_after_checkout() {
    // Clear temporary data
    WC()->session->set( 'custom_data', null );
}
add_action( 'fc_checkout_after', 'cleanup_after_checkout', 10 );
```

---

## Checkout Steps Management

### `fc_register_steps`
**Description** This action hook fires during the checkout steps initialization process, allowing plugins to register custom checkout steps or modify existing ones.
**Parameters** None
**Context** Used in `inc/checkout-steps.php` during checkout steps initialization
**Example**
```php
/**
 * Remove the shipping step.
 */
function fluidcheckout_remove_shipping_step() {
    // Bail if steps class not available
    if ( ! class_exists( 'FluidCheckout_Steps' ) ) { return; }

    FluidCheckout_Steps::instance()->unregister_checkout_step( 'shipping' );
}
add_action( 'fc_register_steps', 'fluidcheckout_remove_shipping_step', 300 );
```



### `fc_checkout_before_step`
**Description** This action hook fires before a checkout step starts, allowing you to add custom content or modify the step behavior before the step HTML is output.
**Parameters**
- `$step_id` (string) The step identifier.
- `$step_args` (array) Step configuration arguments
- `$step_index` (int) Zero-based index of the step in the checkout flow
- `$context` (string) Context in which the step is being output (default: 'checkout')
**Context** Used in `inc/checkout-steps.php` before each checkout step HTML output
**Example**
```php
/**
 * Add div opening tag with step-specific attributes
 */
function add_div_opening_tag( $step_id, $step_args, $step_index, $context ) {
    echo '<div class="custom-before-step" data-step-id="' . esc_attr( $step_id ) . '" data-step-index="' . esc_attr( $step_index ) . '">';
}
add_action( 'fc_checkout_before_step', 'add_div_opening_tag', 10, 4 );
```

### `fc_checkout_start_step`
**Description** This action hook fires when a checkout step begins, after the step HTML opening tag and title are output, allowing you to add content inside the step container.
**Parameters**
- `$step_id` (string) The step identifier.
- `$step_args` (array) Step configuration arguments
- `$step_index` (int) Zero-based index of the step in the checkout flow
- `$context` (string) Context in which the step is being output (default: 'checkout')
**Context** Used in `inc/checkout-steps.php` after step opening tag and title
**Example**
```php
/**
 * Add dynamic wrapper div to checkout steps
 */
function fc_add_step_wrapper( $step_id, $step_args, $step_index, $context ) {
    // Build dynamic classes
    $classes = array(
        'fc-step-wrapper',
        'fc-step-' . $step_id,
        'fc-step-index-' . $step_index
    );
    
    // Add context class if not default
    if ( $context !== 'checkout' ) {
        $classes[] = 'fc-step-context-' . $context;
    }
    
    printf( '<div class="%s" data-step="%s">', 
        esc_attr( implode( ' ', $classes ) ), 
        esc_attr( $step_id ) 
    );
}
add_action( 'fc_checkout_start_step', 'fc_add_step_wrapper', 10, 4 );
```

### `fc_checkout_end_step`
**Description** This action hook fires when a checkout step ends, before the step HTML closing tag, allowing you to add content at the end of the step or output placeholders for place order sections.
**Parameters**
- `$step_id` (string) The step identifier.
- `$step_args` (array) Step configuration arguments
- `$step_index` (int) Zero-based index of the step in the checkout flow
- `$context` (string) Context in which the step is being output (default: 'checkout')
**Context** Used in `inc/checkout-steps.php` before step closing tag
**Example**
```php
/**
 * Close dynamic wrapper div for checkout steps
 */
function fc_close_step_wrapper( $step_id, $step_args, $step_index, $context ) {
    // Add closing comment for debugging
    printf( '<!-- End fc-step-%s --></div>', esc_attr( $step_id ) );
}
add_action( 'fc_checkout_end_step', 'fc_close_step_wrapper', 10, 4 );
```

### `fc_checkout_after_step`
**Description** This action hook fires after a checkout step completes, after the step HTML closing tag, allowing you to add content after the step container.
**Parameters**
- `$step_id` (string) The step identifier.
- `$step_args` (array) Step configuration arguments
- `$step_index` (int) Zero-based index of the step in the checkout flow
- `$context` (string) Context in which the step is being output (default: 'checkout')
**Context** Used in `inc/checkout-steps.php` after step closing tag
**Example**
```php
/**
 * Add div closing tag with dynamic comments
 */
function add_div_closing_tag( $step_id, $step_args, $step_index, $context ) {
    $comment = 'End of ' . esc_html( $step_id ) . ' step';
    
    // Add additional context if available
    if ( isset( $step_args['title'] ) ) {
        $comment .= ' - ' . esc_html( $step_args['title'] );
    }
    
    echo '<!-- ' . $comment . ' -->';
    echo '</div>';
}
add_action( 'fc_checkout_after_step', 'add_div_closing_tag', 10, 4 );
```

### `fc_checkout_before_steps`
**Description** This action hook fires before the checkout steps container is rendered, allowing you to add navigation, progress indicators, or other elements above the checkout steps.
**Parameters**
- `$checkout` (WC_Checkout) WooCommerce checkout object
**Context** Used in `templates/fc/checkout-steps/checkout/form-checkout.php` before steps container
**Example**
```php
/**
 * Display checkout information before checkout steps
 */
function display_checkout_info( $checkout ) {
    echo '<p class="notice">Free shipping on orders over $50!</p>';
}
add_action( 'fc_checkout_before_steps', 'display_checkout_info' );
```

### `fc_checkout_steps`
**Description** This action hook fires to render the checkout steps container and all checkout steps. By default, this hook outputs the standard checkout steps, but it can be overridden to provide custom step rendering.
**Parameters** None
**Context** Used in `templates/fc/checkout-steps/checkout/form-checkout.php` to render steps container
**Example**
```php
/**
 * Custom steps output
 */
function custom_steps_output() {
    echo '<div class="custom-steps">Custom steps content</div>';
}
add_action( 'fc_checkout_steps', 'custom_steps_output', 10 );
```

### `fc_checkout_after_steps`
**Description** This action hook fires after the checkout steps container is rendered.
**Parameters** None
**Context** Used after steps container
**Example**
```php
/**
 * Add steps summary with reminder to review information
 */
function add_steps_summary() {
    echo '<div class="steps-summary">You are almost there! Please double check all the information provided before placing your order.</div>';
}
add_action( 'fc_checkout_after_steps', 'add_steps_summary', 10 );
```

---

## Contact Step

### `fc_checkout_before_contact_fields`
**Description** This action hook fires before the contact fields are rendered in the contact step of the checkout process.
**Parameters** None
**Context** Used before contact step fields
**Example**
```php
/**
 * Add custom message
 */
function add_custom_message() {
    echo '<div>Custom message</div>';
}
add_action( 'fc_checkout_before_contact_fields', 'add_custom_message', 10 );
```

### `fc_checkout_contact_before_fields`
**Description** This action hook fires before the contact fields are rendered inside the contact fields wrapper in the contact step.
**Parameters** None
**Context** Used before contact fields container
**Example**
```php
/**
 * Add custom message
 */
function add_custom_message() {
    echo '<div>Custom message</div>';
}
add_action( 'fc_checkout_contact_before_fields', 'add_custom_message', 10 );
```

### `fc_checkout_contact_after_fields`
**Description** This action hook fires after the contact fields are rendered inside the contact fields wrapper in the contact step.
**Parameters** None
**Context** Used after contact fields container
**Example**
```php
/**
 * Add contact fields help text
 */
function add_contact_help() {
    echo '<p class="help-text">We will use this to contact you about your order</p>';
}
add_action( 'fc_checkout_contact_after_fields', 'add_contact_help', 10 );
```

### `fc_checkout_after_contact_fields`
**Description** This action hook fires after the contact fields are rendered in the contact step of the checkout process.
**Parameters** None
**Context** Used after contact step fields
**Example**
```php
/**
 * Add contact step footer
 */
function add_contact_footer() {
    echo '<div class="contact-footer">Contact step completed</div>';
}
add_action( 'fc_checkout_after_contact_fields', 'add_contact_footer', 10 );
```

### `fc_checkout_below_contact_login_cta`
**Description** This action hook fires below the contact login call-to-action in the contact step.
**Parameters** None
**Context** Used below login call-to-action
**Example**
```php
/**
 * Add additional login options
 */
function add_login_options() {
    echo '<div class="additional-login" style="text-align: center;">Quick & secure login</div>';
}
add_action( 'fc_checkout_below_contact_login_cta', 'add_login_options', 10 );
```

---

## Shipping Step

### `fc_checkout_before_step_shipping_fields`
**Description** This action hook fires before the shipping fields step in the checkout process.
**Parameters** None
**Context** Used before shipping step
**Example**
```php
/**
 * Add shipping step header
 */
function add_shipping_header() {
    echo '<h3>Shipping Information</h3>';
}
add_action( 'fc_checkout_before_step_shipping_fields', 'add_shipping_header', 10 );
```

### `fc_checkout_after_step_shipping_fields`
**Description** This action hook fires after the shipping fields step in the checkout process.
**Parameters** None
**Context** Used after shipping step
**Example**
```php
/**
 * Add shipping step footer
 */
function add_shipping_footer() {
    echo '<div class="shipping-footer">Shipping step completed</div>';
}
add_action( 'fc_checkout_after_step_shipping_fields', 'add_shipping_footer', 10 );
```

---

## Shipping Method

### `fc_shipping_methods_before_packages`
**Description** This action hook fires before the shipping packages are displayed in the shipping methods section.
**Parameters** None
**Context** Used before shipping methods display
**Example**
```php
/**
 * Add shipping methods header
 */
function add_shipping_methods_header() {
    echo '<h4>Choose Shipping Method</h4>';
}
add_action( 'fc_shipping_methods_before_packages', 'add_shipping_methods_header', 10 );
```

### `fc_shipping_methods_before_packages_inside`
**Description** This action hook fires before the packages container inside the shipping methods section.
**Parameters** None
**Context** Used before packages container
**Example**
```php
/**
 * Add packages intro
 */
function add_packages_intro() {
    echo '<p>Select your preferred shipping option</p>';
}
add_action( 'fc_shipping_methods_before_packages_inside', 'add_packages_intro', 10 );
```

### `fc_shipping_methods_after_packages_inside`
**Description** This action hook fires after the packages container inside the shipping methods section.
**Parameters** None
**Context** Used after packages container
**Example**
```php
/**
 * Add packages help text
 */
function add_packages_help() {
    echo '<p class="shipping-help">Need help choosing? Contact us!</p>';
}
add_action( 'fc_shipping_methods_after_packages_inside', 'add_packages_help', 10 );
```

### `fc_shipping_methods_after_packages`
**Description** This action hook fires after the shipping packages are displayed in the shipping methods section.
**Parameters** None
**Context** Used after shipping methods display
**Example**
```php
/**
 * Add shipping methods footer
 */
function add_shipping_methods_footer() {
    echo '<div class="shipping-methods-footer">Shipping methods loaded</div>';
}
add_action( 'fc_shipping_methods_after_packages', 'add_shipping_methods_footer', 10 );
```

### `fc_review_order_shipping`
**Description** This action hook fires in the shipping section of the order review.
**Parameters** None
**Context** Used in order review section
**Example**
```php
/**
 * Add shipping review content
 */
function add_shipping_review() {
    // Global variable to track if content has been output
    global $fc_shipping_review_output_done;
    
    // Only output once to prevent duplicates
    if ( true ===$fc_shipping_review_output_done )  {
        return;
    }
    
    echo '<div class="shipping-review">Review your shipping details</div>';
    $fc_shipping_review_output_done = true;
}
add_action( 'fc_review_order_shipping', 'add_shipping_review', 10 );
```

---

## Shipping Address

### `fc_checkout_before_step_shipping_fields_inside`
**Description** This action hook fires before the shipping fields container inside the shipping step.
**Parameters** None
**Context** Used before shipping fields container
**Example**
```php
/**
 * Add shipping fields intro
 */
function add_shipping_fields_intro() {
    echo '<p>Enter your shipping address</p>';
}
add_action( 'fc_checkout_before_step_shipping_fields_inside', 'add_shipping_fields_intro', 10 );
```

### `fc_before_checkout_shipping_address_wrapper`
**Description** This action hook fires before the shipping address wrapper in the shipping step.
**Parameters** None
**Context** Used before shipping address container
**Example**
```php
/**
 * Add shipping fields intro
 */
function add_shipping_fields_intro() {
    echo '<p>Please make sure to double check your information!</p>';
}
add_action( 'fc_before_checkout_shipping_address_wrapper', 'add_shipping_fields_intro', 10 );
```

### `fc_before_checkout_shipping_only_form`
**Description** This action hook fires before the shipping-only form in the shipping step.
**Parameters** 
- `$checkout` (WC_Checkout) The WooCommerce checkout object
**Context** Used before shipping form
**Example**
```php
/**
 * Add shipping form intro
 */
function add_shipping_form_intro( $checkout ) {
    echo '<div style="margin-top: 2rem;">Complete your shipping information</div>';
}
add_action( 'fc_before_checkout_shipping_only_form', 'add_shipping_form_intro', 10 );
```

### `fc_checkout_after_step_shipping_fields_inside`
**Description** This action hook fires after the shipping fields container inside the shipping step.
**Parameters** None
**Context** Used after shipping fields container
**Example**
```php
/**
 * Add shipping fields help
 */
function add_shipping_fields_help() {
    echo '<p class="shipping-help">Make sure your address is correct</p>';
}
add_action( 'fc_checkout_after_step_shipping_fields_inside', 'add_shipping_fields_help', 10 );
```

---

## Billing Step

### `fc_before_checkout_billing_only_form`
**Description** This action hook fires before the billing-only form in the billing step.
**Parameters** 
- `$checkout` (WC_Checkout) The WooCommerce checkout object
**Context** Used before billing form
**Example**
```php
/**
 * Add Custom message to Billing only form
 */
function add_custom_message( $checkout ) {
    echo '<div>Custom message</div>';
}
add_action( 'fc_before_checkout_billing_only_form', 'add_custom_message', 10, 1 );
```

### `fc_after_checkout_billing_only_form_inside`
**Description** This action hook fires after the billing form container inside the billing step.
**Parameters** None
**Context** Used after billing form container
**Example**
```php
/**
 * Add billing form help
 */
function add_billing_form_help() {
    echo '<p class="billing-help">Billing information is required</p>';
}
add_action( 'fc_after_checkout_billing_only_form_inside', 'add_billing_form_help', 10 );
```

### `fc_checkout_before_step_billing_fields`
**Description** This action hook fires before the billing fields step in the checkout process.
**Parameters** None
**Context** Used before billing step
**Example**
```php
/**
 * Add billing step header
 */
function add_billing_header() {
    echo '<h3>Billing Information</h3>';
}
add_action( 'fc_checkout_before_step_billing_fields', 'add_billing_header', 10 );
```

### `fc_checkout_after_step_billing_fields`
**Description** This action hook fires after the billing fields step in the checkout process.
**Parameters** None
**Context** Used after billing step
**Example**
```php
/**
 * Add billing step footer
 */
function add_billing_footer() {
    echo '<div class="billing-footer">Billing step completed</div>';
}
add_action( 'fc_checkout_after_step_billing_fields', 'add_billing_footer', 10 );
```

### `fc_checkout_account_before_fields`
**Description** This action hook fires before the account fields in the billing step.
**Parameters** None
**Context** Used before account fields
**Example**
```php
/**
 * Add account fields header
 */
function add_account_header() {
    echo '<h4>Account Information</h4>';
}
add_action( 'fc_checkout_account_before_fields', 'add_account_header', 10 );
```

### `fc_checkout_account_after_fields`
**Description** This action hook fires after the account fields in the billing step.
**Parameters** None
**Context** Used after account fields
**Example**
```php
/**
 * Add account fields help
 */
function add_account_help() {
    echo '<p class="account-help">Create an account for faster checkout</p>';
}
add_action( 'fc_checkout_account_after_fields', 'add_account_help', 10 );
```

### `fc_checkout_account_fields_empty_section`
**Description** This action hook fires when the account section is empty in the billing step.
**Parameters** None
**Context** Used when account section is empty
**Example**
```php
/**
 * Add empty account section content
 */
function add_empty_account_content() {
    echo '<div class="empty-account">No account fields to display</div>';
}
add_action( 'fc_checkout_account_fields_empty_section', 'add_empty_account_content', 10 );
```

---

## Payment Step

### `fc_checkout_before_step_payment_fields`
**Description** This action hook fires before the payment fields step in the checkout process.
**Parameters** None
**Context** Used before payment step
**Example**
```php
/**
 * Add payment step header
 */
function add_payment_header() {
    echo '<h3>Payment Information</h3>';
}
add_action( 'fc_checkout_before_step_payment_fields', 'add_payment_header', 10 );
```

### `fc_checkout_payment`
**Description** This action hook fires in the payment section of the checkout process.
**Parameters** None
**Context** Used in payment section
**Example**
```php
/**
 * Add payment section content
 */
function add_payment_content() {
    echo '<div class="payment-info">Choose your payment method</div>';
}
add_action( 'fc_checkout_payment', 'add_payment_content', 10 );
```

### `fc_checkout_after_step_payment_fields`
**Description** This action hook fires after the payment fields step in the checkout process.
**Parameters** None
**Context** Used after payment step
**Example**
```php
/**
 * Add payment step footer
 */
function add_payment_footer() {
     echo '<p>Please review your payment information before proceeding</p>';
}
add_action( 'fc_checkout_after_step_payment_fields', 'add_payment_footer', 10 );
```

### `fc_checkout_before_payment`
**Description** This action hook fires before the payment section in the checkout process.
**Parameters** None
**Context** Used before payment section
**Example**
```php
/**
 * Add payment intro
 */
function add_payment_intro( $checkout ) {
    echo '<p>Select your payment method</p>';
}
add_action( 'fc_checkout_before_payment', 'add_payment_intro', 1, 10 );
```

### `fc_checkout_after_payment`
**Description** This action hook fires after the payment section in the checkout process.
**Parameters** None
**Context** Used after payment section
**Example**
```php
/**
 * Add payment step footer
 */
function add_payment_footer( $checkout ) {
     echo '<p>Please review your payment information before proceeding</p>';
}
add_action( 'fc_checkout_after_payment', 'add_payment_footer', 1, 10 );
```

### `fc_place_order`
**Description** This action hook fires in the place order section of the checkout process.
**Parameters** 
- `$step_id` (string) - The ID of the step in which the place order section is rendered
- `$is_sidebar` (boolean) - Whether the place order section is being rendered in the sidebar
**Context** Used in place order section
**Example**
```php
/**
 * Add place order content
 */
function add_place_order_content( $step_id, $is_sidebar ) {
    $location_class = $is_sidebar ? 'place-order-sidebar' : 'place-order-main';
    echo '<div class="place-order-info ' . esc_attr( $location_class ) . '">Review and place your order!</div>';
}
add_action( 'fc_place_order', 'add_place_order_content', 2, 10 );
```

### `fc_place_order_custom_buttons`
**Description** This action hook fires for custom place order buttons in the checkout process.
**Parameters** 
- `$step_id` (string) - The ID of the step in which the place order section is rendered
- `$is_sidebar` (boolean) - Whether the place order section is being rendered in the sidebar
**Context** Used for custom order buttons
**Example**
```php
/**
 * Add custom order buttons
 */
function add_custom_order_buttons( $step_id, $is_sidebar ) {
    $location_class = $is_sidebar ? 'custom-order-button-sidebar' : 'custom-order-button-main';
    echo '<button type="submit" class="button alt fc-place-order-button ' . esc_attr( $location_class ) . '">Custom Order Button</button>';
}
add_action( 'fc_place_order_custom_buttons', 'add_custom_order_buttons', 10, 2 );
```

### `fc_checkout_place_order_terms`
**Description** This action hook fires for terms and conditions in the checkout process.
**Parameters** None
**Context** Used for terms display
**Example**
```php
/**
 * Add terms and conditions
 */
function add_terms_conditions() {
    echo '<div class="terms-conditions">By placing an order, you agree to our terms</div>';
}
add_action( 'fc_checkout_place_order_terms', 'add_terms_conditions', 10 );
```

---

## Order Summary

### `fc_checkout_order_review_section`
**Description** This action hook fires in the order review section of the checkout process.
**Parameters** None
**Context** Used in order review
**Example**
```php
/**
 * Add order review content
 */
function add_order_review_content() {
    echo '<div class="order-review-info">Review your order details</div>';
}
add_action( 'fc_checkout_order_review_section', 'add_order_review_content', 10 );
```

### `fc_checkout_before_order_review`
**Description** This action hook fires before the order review section in the checkout process.
**Parameters** None
**Context** Used before order review
**Example**
```php
/**
 * Add order review content
 */
function add_order_review_content() {
    echo '<div class="order-review-info">Review your order details</div>';
}
add_action( 'fc_checkout_before_order_review', 'add_order_review_content', 10 );
```

### `fc_checkout_before_order_review_inside`
**Description** This action hook fires before the order review container inside the order review section.
**Parameters** None
**Context** Used before order review container
**Example**
```php
/**
 * Add order review intro
 */
function add_order_review_intro() {
    echo '<p>Please review your order before proceeding</p>';
}
add_action( 'fc_checkout_before_order_review_inside', 'add_order_review_intro', 10 );
```

### `fc_checkout_after_order_review_title_before`
**Description** This action hook fires before the order review title in the order review section.
**Parameters** None
**Context** Used before order review title
**Example**
```php
/**
 * Add order review intro
 */
function add_order_review_intro() {
    echo '<div style="display: inline-block;">Please review your order before proceeding</div>';
}
add_action( 'fc_checkout_after_order_review_title_before', 'add_order_review_intro', 10 );
```

### `fc_checkout_after_order_review_title_after`
**Description** This action hook fires after the order review title in the order review section.
**Parameters** None
**Context** Used after order review title
**Example**
```php
/**
 * Add order review title suffix
 */
function add_order_review_title_suffix() {
    echo '<span class="title-suffix"> - Final Review</span>';
}
add_action( 'fc_checkout_after_order_review_title_after', 'add_order_review_title_suffix', 10 );
```

### `fc_checkout_order_review_sidebar_before_actions`
**Description** This action hook fires before the sidebar actions in the order review section.
**Parameters** None
**Context** Used before sidebar actions
**Example**
```php
/**
 * Add sidebar actions
 */
function add_sidebar_before_actions() {
    echo '<div class="sidebar-actions">Please review your order before proceeding</div>';
}
add_action( 'fc_checkout_order_review_sidebar_before_actions', 'add_sidebar_before_actions', 10 );
```

### `fc_checkout_after_order_review_inside`
**Description** This action hook fires after the order review container inside the order review section.
**Parameters** None
**Context** Used after order review container
**Example**
```php
/**
 * Add order review content
 */
function add_order_review_content() {
    echo '<div class="order-review-info">Custom content</div>';
}
add_action( 'fc_checkout_after_order_review_inside', 'add_order_review_content', 10 );
```

### `fc_checkout_after_order_review`
**Description** This action hook fires after the order review section in the checkout process.
**Parameters** None
**Context** Used after order review
**Example**
```php
/**
 * Add order review content
 */
function add_order_review_content() {
    echo '<div class="order-review-info">Custom content</div>';
}
add_action( 'fc_checkout_after_order_review', 'add_order_review_content', 10 );
```

### `fc_order_summary_cart_item_details`
**Description** This action hook fires for cart item details in the order summary.
**Parameters** 
- `$cart_item` (array) - The cart item array containing product data, quantity, and other cart item information
- `$cart_item_key` (string) - The unique key for this cart item
- `$product` (WC_Product) - The WooCommerce product object for this cart item
**Context** Used in cart item display within the order summary section of the checkout
**Example**
```php
/**
 * Add product SKU to cart item details
 */
function add_cart_item_sku( $cart_item, $cart_item_key, $product ) {
    if ( $product->get_sku() ) {
        echo '<div class="cart-item__element cart-item__sku">SKU: ' . esc_html( $product->get_sku() ) . '</div>';
    }
}
add_action( 'fc_order_summary_cart_item_details', 'add_cart_item_sku', 20, 3 );
```

### `fc_order_summary_cart_item_totals_before`
**Description** This action hook fires before the cart item totals in the order summary.
**Parameters** None
**Context** Used before cart totals
**Example**
```php
/**
 * Add cart totals header
 */
function add_cart_totals_header( $cart_item, $cart_item_key, $product ) {
    echo '<div>Product total</div>';
}
add_action( 'fc_order_summary_cart_item_totals_before', 'add_cart_totals_header',  10, 3  );
```

### `fc_order_summary_cart_item_totals_after`
**Description** This action hook fires after the cart item totals in the order summary.
**Parameters** None
**Context** Used after cart totals
**Example**
```php
/**
 * Add cart totals footer
 */
function add_cart_totals_footer() {
    echo '<div class="cart-totals-footer">Totals calculated</div>';
}
add_action( 'fc_order_summary_cart_item_totals_after', 'add_cart_totals_footer', 10 );
```

### `fc_coupon_code_section_before`
**Description** This action hook fires before the coupon code section in the order summary.
**Parameters** None
**Context** Used before coupon section
**Example**
```php
/**
 * Add coupon section header
 */
function add_coupon_header() {
    echo '<div>Discount Codes</div>';
}
add_action( 'fc_coupon_code_section_before', 'add_coupon_header', 10 );
```

### `fc_coupon_code_section_after`
**Description** This action hook fires after the coupon code section in the order summary.
**Parameters** None
**Context** Used after coupon section
**Example**
```php
/**
 * Add coupon section footer
 */
function add_coupon_footer() {
    echo '<div class="coupon-footer">Coupon section completed</div>';
}
add_action( 'fc_coupon_code_section_after', 'add_coupon_footer', 10 );
```

### `fc_substep_coupon_codes_text_before`
**Description** This action hook fires before the coupon codes list in the checkout order summary substep. It triggers within the output buffer before any applied coupon codes are displayed, allowing you to add introductory content or headers.
**Parameters** None
**Context** Used in the coupon codes substep before the loop that displays applied coupons. This hook fires within the `get_substep_text_coupon_codes()` method, specifically before the foreach loop that renders each coupon code and amount. The hook only triggers when coupons are enabled and there are applied coupons in the cart.
**Example**
```php
/**
 * Add introductory text before coupon codes display
 */
function add_coupon_codes_intro_text() {
    // Only show if there are coupons applied
    if ( WC()->cart->get_coupons() ) {
        echo '<div class="fc-coupon-codes-intro">Applied coupon codes:</div>';
    }
}
add_action( 'fc_substep_coupon_codes_text_before', 'add_coupon_codes_intro_text', 10 );
```

### `fc_substep_coupon_codes_text_after`
**Description** This action hook fires after the coupon codes list in the checkout order summary substep. It triggers within the output buffer after all applied coupon codes have been displayed, but before the substep content is finalized.
**Parameters** None
**Context** Used in the coupon codes substep after the loop that displays applied coupons. This hook fires within the `get_substep_text_coupon_codes()` method, specifically after the foreach loop that renders each coupon code and amount. The hook only triggers when coupons are enabled and there are applied coupons in the cart.
**Example**
```php
/**
 * Add promotional text after coupon codes display
 */
function add_coupon_codes_promotional_text() {
    // Only show if there are coupons applied
    if ( WC()->cart->get_coupons() ) {
        echo '<div class="fc-coupon-codes-promo">You\'re saving money!</div>';
    }
}
add_action( 'fc_substep_coupon_codes_text_after', 'add_coupon_codes_promotional_text', 10 );
```

---

## Widgets

### `fc_checkout_header`
**Description** This action hook fires in the checkout header section.
**Parameters** None
**Context** Used in checkout header
**Example**
```php
/**
 * Add checkout header content
 */
function add_checkout_header_content() {
    echo '<div class="checkout-header" style="text-align: center;">Welcome to checkout</div>';
}
add_action( 'fc_checkout_header', 'add_checkout_header_content', 10 );
```

### `fc_checkout_header_logo`
**Description** This action hook fires for the header logo in the checkout header when no custom logo is set in the plugin settings.
**Parameters** None
**Context** Used as a fallback option for header logo when custom logo setting is empty
**Example**
```php
/**
 * Add custom header logo
 */
function add_custom_header_logo() {
    $home_url = apply_filters( 'fc_checkout_header_logo_home_url', home_url( '/' ) );
    echo sprintf(
        '<a href="%s" class="custom-logo-link" rel="home">%s</a>',
        esc_url( $home_url ),
        '<img src="custom-logo.png" alt="Custom Logo" class="header-logo">'
    );
}
add_action( 'fc_checkout_header_logo', 'add_custom_header_logo', 10 );
```

### `fc_checkout_header_widgets`
**Description** This action hook fires for the header widgets in the checkout header.
**Parameters** None
**Context** Used for header widgets
**Example**
```php
/**
 * Add header widgets
 */
function add_header_widgets() {
    echo '<div class="header-widgets">Header widgets content</div>';
}
add_action( 'fc_checkout_header_widgets', 'add_header_widgets', 10 );
```

### `fc_checkout_header_widgets_inside_before`
**Description** This action hook fires before the header widgets container inside the checkout header.
**Parameters** None
**Context** Used before header widgets container
**Example**
```php
/**
 * Add header widgets intro
 */
function add_header_widgets_intro() {
    echo '<div class="widgets-intro">Header widgets</div>';
}
add_action( 'fc_checkout_header_widgets_inside_before', 'add_header_widgets_intro', 10 );
```

### `fc_checkout_header_widgets_inside_after`
**Description** This action hook fires after the header widgets container inside the checkout header.
**Parameters** None
**Context** Used after header widgets container
**Example**
```php
/**
 * Add header widgets footer
 */
function add_header_widgets_footer() {
    echo '<div class="widgets-footer">Widgets loaded</div>';
}
add_action( 'fc_checkout_header_widgets_inside_after', 'add_header_widgets_footer', 10 );
```

### `fc_checkout_header_cart_link`
**Description** This action hook fires for the header cart link in the checkout header.
**Parameters** None
**Context** Used for header cart link
**Example**
```php
/**
 * Add custom content to header cart link
 */
function add_custom_header_content() {
    echo '<div class="custom-content">Custom content here</div>';
}
add_action( 'fc_checkout_header_cart_link', 'add_custom_header_content', 10 );
```

### `fc_checkout_footer`
**Description** This action hook fires in the checkout footer section.
**Parameters** None
**Context** Used in checkout footer
**Example**
```php
/**
 * Add checkout footer content
 */
function add_checkout_footer_content() {
    echo '<div class="checkout-footer">Thank you for shopping with us</div>';
}
add_action( 'fc_checkout_footer', 'add_checkout_footer_content', 10 );
```

### `fc_checkout_footer_widgets`
**Description** This action hook fires for the footer widgets in the checkout footer.
**Parameters** None
**Context** Used for footer widgets
**Example**
```php
/**
 * Add footer widgets
 */
function add_footer_widgets() {
    echo '<div class="footer-widgets">Footer widgets content</div>';
}
add_action( 'fc_checkout_footer_widgets', 'add_footer_widgets', 10 );
```

### `fc_checkout_footer_widgets_inside_before`
**Description** This action hook fires before the footer widgets container inside the checkout footer.
**Parameters** None
**Context** Used before footer widgets container
**Example**
```php
/**
 * Add footer widgets intro
 */
function add_footer_widgets_intro() {
    echo '<div class="footer-widgets-intro">Footer widgets</div>';
}
add_action( 'fc_checkout_footer_widgets_inside_before', 'add_footer_widgets_intro', 10 );
```

### `fc_checkout_footer_widgets_inside_after`
**Description** This action hook fires after the footer widgets container inside the checkout footer.
**Parameters** None
**Context** Used after footer widgets container
**Example**
```php
/**
 * Add footer widgets footer
 */
function add_footer_widgets_footer() {
    echo '<div class="footer-widgets-footer">Footer widgets loaded</div>';
}
add_action( 'fc_checkout_footer_widgets_inside_after', 'add_footer_widgets_footer', 10 );
```