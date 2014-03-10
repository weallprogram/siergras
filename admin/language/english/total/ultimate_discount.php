<?php
// Version! DO NOT CHANGE!
$_['_version'] = "125";

/**
 * Ultimate Discount extension for Opencart.
 *
 * @author Anthony Lawrence <freelancer@anthonylawrence.me.uk>
 * @version 1.0
 * @copyright © Anthony Lawrence 2011
 * @license Creative Common's ShareAlike License - http://creativecommons.org/licenses/by-sa/3.0/
 */

// Heading
$_['heading_title']    = 'Ultimate Discount';

// Tabs
$_['tab_general']      = 'General';
$_['tab_store']      = 'Store Wide';
$_['tab_category']      = 'Category Based';
$_['tab_multi']      = 'Multibuy';

// Text
$_['text_total']       = 'Order totals';
$_['text_success']     = 'Success: You have modified the ultimate discount!';

// Entry
$_['entry_category']   = 'Category:';
$_['entry_customer']   = 'Customer Group:';
$_['entry_total']      = 'Minimum Order Total:<span class="help">The minimum order value before discount is applied.</span>';
$_['entry_amount']     = 'Discount Amount:';
$_['entry_type']       = 'Discount Type:';
$_['entry_rule']       = 'Rule:';
$_['entry_rule_amount'] = 'Rule Amount:';
$_['entry_rules_once'] = 'Once after:';
$_['entry_rules_every'] = 'Every:';
$_['entry_date_start'] = 'Start Date:<span class="help">The date from which the discount WILL BE applied.</span>';
$_['entry_date_end']   = 'End Date:<span class="help">The date from which the discount WILL NOT BE applied.</span>';
$_['entry_status']     = 'Status:';
$_['entry_sort_order'] = 'Sort Order:';
$_['entry_multi_override'] = 'Override Multi-Buy Discounts:';

// Descriptions
$_['description_store'] = "If you wish to have graded discounts, for example:<br />
                    <ul>
                        <li>Spend over £500, get 10% off.</li>
                        <li>Spend over £300, get 5% off.</li>
                        <li>Spend over £100, get 3% off.</li>
                    </ul>
                    List all discount bands below with the same date range and the system will automatically choose the highest discount amount at the checkout screen.";
$_['description_category'] = '<strong>If a produce is listed in more than one category, it may receive double discount if you list all categories here! For example, if a camera is listed in
                            "mobile devices" and "cameras", and both have a &pound;10 saving, the camera will attract a &pound;20 discount!</strong>  Choose your categories carefully.';
$_['description_multi'] = 'Any rules listed here will be applied regardless of any other discounts that have been set.';
$_['description_multi_override'] = 'If set to enable, the first possible discount for a multi-buy discount <strong>per-category</strong> will be applied and others will be ignored.';

// Error
$_['error_permission'] = 'Warning: You do not have permission to modify ultimate discounts!';
?>
