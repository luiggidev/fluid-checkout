# Fluid Checkout Hooks - Organized by Functional Areas



## 1. Checkout Flow & Steps

### Lite Version
- **Step Registration & Management**
  - `fc_register_steps` - Register checkout steps
  - `fc_checkout_before_step` - Before a step starts
  - `fc_checkout_start_step` - When a step begins
  - `fc_checkout_end_step` - When a step ends
  - `fc_checkout_after_step` - After a step completes

- **Main Checkout Structure**
  - `fc_checkout_before` - Before checkout begins
  - `fc_checkout_before_steps` - Before checkout steps
  - `fc_checkout_steps` - Output checkout steps
  - `fc_checkout_after_steps` - After checkout steps
  - `fc_checkout_after` - After checkout completes

- **Main Section Wrapper**
  - `fc_checkout_before_main_section_wrapper` - Before main section wrapper
  - `fc_checkout_before_main_section` - Before main section
  - `fc_checkout_after_main_section` - After main section
  - `fc_checkout_after_main_section_wrapper` - After main section wrapper

### Pro Version
- **Order Pay Flow**
  - `fc_pro_order_pay_before` - Before order pay begins
  - `fc_pro_order_pay_before_sections` - Before order pay sections
  - `fc_pro_order_pay_sections` - Output order pay sections
  - `fc_pro_order_pay_after_sections` - After order pay sections
  - `fc_pro_order_pay_after` - After order pay completes



## 2. Address & Contact Fields

### Lite Version
- **Contact Fields**
  - `fc_checkout_before_contact_fields` - Before contact fields
  - `fc_checkout_contact_before_fields` - Before contact fields inside wrapper
  - `fc_checkout_contact_after_fields` - After contact fields inside wrapper
  - `fc_checkout_after_contact_fields` - After contact fields

- **Billing Address Fields**
  - `fc_before_checkout_billing_only_form` - Before billing only form
  - `fc_after_checkout_billing_only_form_inside` - After billing only form inside
  - `fc_checkout_before_step_billing_fields` - Before billing fields step
  - `fc_checkout_after_step_billing_fields` - After billing fields step

- **Shipping Address Fields**
  - `fc_checkout_before_step_shipping_fields` - Before shipping fields step
  - `fc_checkout_after_step_shipping_fields` - After shipping fields step
  - `fc_checkout_before_step_shipping_fields_inside` - Before shipping fields inside
  - `fc_before_checkout_shipping_address_wrapper` - Before shipping address wrapper
  - `fc_before_checkout_shipping_only_form` - Before shipping only form
  - `fc_checkout_after_step_shipping_fields_inside` - After shipping fields inside

### Pro Version
- **Local Pickup**
  - `fc_pro_pickup_point_fields` - Pickup point fields

## 3. Account & Authentication

### Lite Version
- **Account Creation**
  - `fc_checkout_account_before_fields` - Before account fields
  - `fc_checkout_account_after_fields` - After account fields
  - `fc_checkout_account_fields_empty_section` - Empty account section

- **Contact Login**
  - `fc_checkout_below_contact_login_cta` - Below contact login CTA



## 4. Payment & Order Processing

### Lite Version
- **Payment Fields**
  - `fc_checkout_before_step_payment_fields` - Before payment fields step
  - `fc_checkout_payment` - Payment section
  - `fc_checkout_after_step_payment_fields` - After payment fields step

- **Payment Section**
  - `fc_checkout_before_payment` - Before payment section
  - `fc_checkout_after_payment` - After payment section

- **Place Order**
  - `fc_place_order` - Place order section
  - `fc_place_order_custom_buttons` - Custom place order buttons
  - `fc_checkout_place_order_terms` - Terms and conditions

### Pro Version
- **Order Pay Payment**
  - `fc_pro_order_pay_order_review` - Order pay review



## 5. Order Review & Summary

### Lite Version
- **Order Review Section**
  - `fc_checkout_order_review_section` - Order review section
  - `fc_checkout_before_order_review` - Before order review
  - `fc_checkout_before_order_review_inside` - Before order review inside
  - `fc_checkout_before_order_review_title_before` - Before order review title
  - `fc_checkout_after_order_review_title_after` - After order review title
  - `fc_checkout_order_review_sidebar_before_actions` - Before sidebar actions
  - `fc_checkout_after_order_review_inside` - After order review inside
  - `fc_checkout_after_order_review` - After order review

- **Order Summary**
  - `fc_order_summary_cart_item_details` - Cart item details
  - `fc_order_summary_cart_item_totals_before` - Before cart item totals
  - `fc_order_summary_cart_item_totals_after` - After cart item totals

- **Shipping & Coupons**
  - `fc_review_order_shipping` - Review order shipping
  - `fc_pro_checkout_review_order_after_coupon_code` - After coupon code in review

### Pro Version
- **Order Pay Review**
  - `fc_pro_order_pay_before_order_review` - Before order pay review
  - `fc_pro_order_pay_before_order_review_inside` - Before order pay review inside
  - `fc_pro_order_pay_before_order_review_heading` - Before order pay review heading
  - `fc_pro_order_pay_section_header_order_summary` - Order summary header
  - `fc_pro_order_pay_before_order_review_table` - Before order review table
  - `fc_pro_order_pay_after_order_review_table` - After order review table
  - `fc_pro_order_pay_after_order_review_inside` - After order pay review inside
  - `fc_pro_order_pay_after_order_review` - After order pay review

- **Order Overview**
  - `fc_pro_order_overview_before` - Before order overview
  - `fc_pro_order_overview_after` - After order overview



## 6. Shipping Methods

### Lite Version
- **Shipping Methods Display**
  - `fc_shipping_methods_before_packages` - Before shipping packages
  - `fc_shipping_methods_before_packages_inside` - Before packages inside
  - `fc_shipping_methods_after_packages_inside` - After packages inside
  - `fc_shipping_methods_after_packages` - After shipping packages



## 7. Coupon Codes

### Lite Version
- **Coupon Code Section**
  - `fc_coupon_code_section_before` - Before coupon code section
  - `fc_coupon_code_section_after` - After coupon code section

- **Coupon Code Text**
  - `fc_substep_coupon_codes_text_before` - Before coupon codes text
  - `fc_substep_coupon_codes_text_after` - After coupon codes text



## 8. Header & Footer Widgets

### Lite Version
- **Checkout Header**
  - `fc_checkout_header` - Checkout header
  - `fc_checkout_header_logo` - Header logo
  - `fc_checkout_header_widgets` - Header widgets
  - `fc_checkout_header_widgets_inside_before` - Before header widgets inside
  - `fc_checkout_header_widgets_inside_after` - After header widgets inside
  - `fc_checkout_header_cart_link` - Header cart link

- **Checkout Footer**
  - `fc_checkout_footer` - Checkout footer
  - `fc_checkout_footer_widgets` - Footer widgets
  - `fc_checkout_footer_widgets_inside_before` - Before footer widgets inside
  - `fc_checkout_footer_widgets_inside_after` - After footer widgets inside

### Pro Version
- **Cart Header**
  - `fc_pro_cart_header` - Cart header
  - `fc_pro_cart_header_widgets_inside_before` - Before cart header widgets inside
  - `fc_pro_cart_header_widgets_inside_after` - After cart header widgets inside

- **Cart Footer**
  - `fc_pro_cart_footer` - Cart footer
  - `fc_pro_cart_footer_widgets_inside_before` - Before cart footer widgets inside
  - `fc_pro_cart_footer_widgets_inside_after` - After cart footer widgets inside



## 9. Cart Page (Pro Only)

### Pro Version
- **Cart Structure**
  - `fc_pro_cart_before` - Before cart begins
  - `fc_pro_cart_before_content` - Before cart content
  - `fc_pro_cart_sections` - Cart sections
  - `fc_pro_cart_after_content` - After cart content
  - `fc_pro_cart_after` - After cart completes

- **Cart Main Section**
  - `fc_pro_cart_before_main_section_wrapper` - Before main section wrapper
  - `fc_pro_cart_before_main_section` - Before main section
  - `fc_pro_cart_after_main_section` - After main section
  - `fc_pro_cart_after_main_section_wrapper` - After main section wrapper

- **Cart Items**
  - `fc_pro_cart_items_table` - Cart items table
  - `fc_pro_cart_item_details` - Cart item details
  - `fc_pro_cart_item_totals_before` - Before cart item totals
  - `fc_pro_cart_item_totals_after` - After cart item totals
  - `fc_pro_cart_item_actions` - Cart item actions
  - `fc_pro_cart_item_actions_buttons` - Cart item action buttons

- **Cart Actions & Sidebar**
  - `fc_pro_cart_actions` - Cart actions
  - `fc_pro_cart_sidebar_sections` - Cart sidebar sections

- **Cart Order Review**
  - `fc_pro_cart_before_order_review` - Before cart order review
  - `fc_pro_cart_before_order_review_inside` - Before cart order review inside
  - `fc_pro_cart_before_order_review_heading` - Before cart order review heading
  - `fc_pro_cart_section_header_order_summary` - Cart order summary header
  - `fc_pro_cart_before_order_review_table` - Before cart order review table
  - `fc_pro_cart_order_review` - Cart order review
  - `fc_pro_cart_after_order_review_table` - After cart order review table
  - `fc_pro_cart_order_review_sidebar_before_actions` - Before cart sidebar actions
  - `fc_pro_cart_after_order_review_inside` - After cart order review inside
  - `fc_pro_cart_after_order_review` - After cart order review

- **Cart Shipping & Coupons**
  - `fc_pro_cart_review_order_shipping` - Cart review order shipping
  - `fc_pro_cart_review_order_after_coupon_code` - After coupon code in cart review
  - `fc_pro_cart_review_order_shipping_inside_row` - Inside cart shipping row

- **Cart Shipping Calculator**
  - `fc_pro_before_shipping_calculator` - Before cart shipping calculator
  - `fc_pro_after_shipping_calculator` - After cart shipping calculator

- **Cross Sells**
  - `fc_pro_cross_sell_item_details_inner_before` - Before cross sell item details
  - `fc_pro_cross_sell_item_details_inner_after` - After cross sell item details
  - `fc_pro_cart_cross_sell_item_actions` - Cross sell item actions



## 10. Order Received Page (Pro Only)

### Pro Version
- **Order Received Structure**
  - `fc_pro_order_received_before` - Before order received
  - `fc_pro_order_received_before_content` - Before order received content
  - `fc_pro_order_received_after_content` - After order received content
  - `fc_pro_order_received_after` - After order received

- **Order Received Notices**
  - `fc_pro_order_received_notice_before` - Before order received notice
  - `fc_pro_order_received_notice_after` - After order received notice

- **Order Received States**
  - `fc_pro_order_received_failed` - Order received failed
  - `fc_pro_order_received_successful` - Order received successful
  - `fc_pro_order_received_successful_no_order_details` - Successful with no order details

- **Order Received Sidebar**
  - `fc_pro_order_received_sidebar_sections` - Order received sidebar sections



## 11. Plugin Compatibility

### Pro Version
- **FooEvents**
  - `fc_pro_woocommerce_attendee_details_after_fields` - After attendee details fields

- **Iconic WooCommerce Delivery Slots**
  - `fc_pro_woo_delivery_slots_after_fields` - After delivery slots fields

- **WooCommerce Germanized**
  - `fc_pro_woocommerce_germanized_preferred_delivery_after_fields` - After preferred delivery fields

- **WooCommerce Order Delivery**
  - `fc_pro_woocommerce_order_delivery_before_fields` - Before order delivery fields
  - `fc_pro_woocommerce_order_delivery_after_fields` - After order delivery fields