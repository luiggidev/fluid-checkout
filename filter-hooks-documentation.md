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

- `fc_enable_checkout_page_template` - Controls whether to use Fluid Checkout page template
- `fc_enable_checkout_shortcode_wrapper` - Controls whether to wrap checkout shortcode with fc-content wrapper
- `fc_override_template_with_theme_file` - Allows theme to override template files
- `fc_add_container_class` - Controls whether to add container class to checkout wrapper
- `fc_content_section_class` - Adds custom classes to the content section wrapper
- `fc_wrapper_classes` - Adds custom classes to the main checkout wrapper
- `fc_checkout_page_title` - Modifies the checkout page title
- `fc_display_checkout_page_title` - Controls whether to display the checkout page title

### Header and Logo

- `fc_checkout_header_logo_home_url` - Modifies the home URL for the checkout header logo
- `fc_checkout_html_custom_attributes` - Adds custom HTML attributes to the checkout page
- `fc_checkout_body_custom_attributes` - Adds custom body attributes to the checkout page

### Layout and Design

- `fc_get_checkout_layout` - Modifies the checkout layout setting
- `fc_is_checkout_layout_multistep` - Controls whether checkout uses multi-step layout
- `fc_checkout_layout_option_image_url` - Modifies the image URL for layout options in admin
- `fc_design_template_option_image_url` - Modifies the image URL for design template options in admin

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

- `fc_register_checkout_step_args` - Modifies arguments when registering checkout steps
- `fc_register_checkout_substep_args` - Modifies arguments when registering checkout substeps
- `fc_get_checkout_steps_before` - Allows hijacking the checkout steps before they are returned
- `fc_is_checkout_page_or_fragment` - Determines if current page is checkout or checkout fragment
- `fc_is_cart_page_or_fragment` - Determines if current page is cart or cart fragment

### Step Titles and Labels

- `fc_step_title_contact` - Modifies the contact step title
- `fc_step_title_shipping` - Modifies the shipping step title  
- `fc_step_title_billing` - Modifies the billing step title
- `fc_step_title_payment` - Modifies the payment step title
- `fc_proceed_to_next_step_button_label` - Modifies the proceed to next step button label
- `fc_next_step_button_label` - Modifies the next step button label
- `fc_next_step_button_classes` - Adds custom classes to the next step button

### Step Completion and Navigation

- `fc_is_step_complete` - Controls whether a step is complete
- `fc_is_step_complete_*` - Controls completion for specific steps
- `fc_is_current_step` - Determines if a step is the current step
- `fc_checkout_maybe_disable_place_order_button` - Controls whether to disable place order button
- `fc_checkout_steps_script_settings` - Modifies JavaScript settings for checkout steps

### Progress Bar

- `fc_checkout_progress_bar_style` - Modifies the progress bar style
- `fc_checkout_progress_bar_attributes` - Adds custom attributes to progress bar
- `fc_checkout_progress_bar_inner_attributes` - Adds custom attributes to progress bar inner element
- `fc_checkout_progress_bar_display_count` - Controls whether to display step count in progress bar
- `fc_checkout_step_attributes` - Adds custom attributes to checkout steps

### Step Positioning and Hooks

- `fc_do_order_notes_hooks_position` - Controls position of order notes hooks
- `fc_do_order_notes_hooks_priority` - Controls priority of order notes hooks
- `fc_billing_step_hook_priority` - Controls priority of billing step hooks
- `fc_billing_address_substep_position_args` - Controls positioning arguments for billing address substep
- `fc_checkout_after_step_shipping_fields_inside` - Defines hook position for after shipping fields inside
- `fc_checkout_wrapper_inside_element_custom_attributes` - Adds custom attributes to checkout wrapper inside element
- `fc_locale_language_variant` - Modifies locale language variants
- `fc_show_shipping_section_highlighted` - Controls whether to highlight shipping section
- `fc_show_billing_section_highlighted` - Controls whether to highlight billing section
- `fc_show_order_totals_row_highlighted` - Controls whether to highlight order totals row

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
