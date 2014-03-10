<?php

class ControllerBackorderBackorder extends Controller {

    public function index() {
        $this -> language -> load('backorder/backorder');
        $this -> document -> setTitle($this -> language -> get('heading_title'));

        $this -> load -> model('backorder/backorder');

        $this -> load -> model('sale/order');

        if (isset($this -> request -> get['order_id'])) {
            $order_id = $this -> request -> get['order_id'];
        } else {
            $order_id = 0;
        }

        $order_info = $this -> model_sale_order -> getOrder($order_id);

        if ($order_info) {
            // $this->language->load('sale/order');

            $this -> document -> setTitle($this -> language -> get('heading_title'));

            $this -> data['heading_title'] = $this -> language -> get('heading_title');

            $this -> data['text_module'] = $this -> language -> get('text_module');
            $this -> data['button_save'] = $this -> language -> get('button_save');
            $this -> data['button_back'] = $this -> language -> get('button_back');
            $this -> data['button_preview'] = $this -> language -> get('button_preview');
            $this -> data['error_ouid'] = $this -> language -> get('error_ouid');

            $this -> data['text_order_id'] = $this -> language -> get('text_order_id');
            $this -> data['text_invoice_no'] = $this -> language -> get('text_invoice_no');
            $this -> data['text_invoice_date'] = $this -> language -> get('text_invoice_date');
            $this -> data['text_store_name'] = $this -> language -> get('text_store_name');
            $this -> data['text_store_url'] = $this -> language -> get('text_store_url');
            $this -> data['text_customer'] = $this -> language -> get('text_customer');
            $this -> data['text_customer_group'] = $this -> language -> get('text_customer_group');
            $this -> data['text_email'] = $this -> language -> get('text_email');
            $this -> data['text_telephone'] = $this -> language -> get('text_telephone');
            $this -> data['text_fax'] = $this -> language -> get('text_fax');
            $this -> data['text_total'] = $this -> language -> get('text_total');
            $this -> data['text_reward'] = $this -> language -> get('text_reward');
            $this -> data['text_order_status'] = $this -> language -> get('text_order_status');
            $this -> data['text_comment'] = $this -> language -> get('text_comment');
            $this -> data['text_affiliate'] = $this -> language -> get('text_affiliate');
            $this -> data['text_commission'] = $this -> language -> get('text_commission');
            $this -> data['text_ip'] = $this -> language -> get('text_ip');
            $this -> data['text_forwarded_ip'] = $this -> language -> get('text_forwarded_ip');
            $this -> data['text_user_agent'] = $this -> language -> get('text_user_agent');
            $this -> data['text_accept_language'] = $this -> language -> get('text_accept_language');
            $this -> data['text_date_added'] = $this -> language -> get('text_date_added');
            $this -> data['text_date_modified'] = $this -> language -> get('text_date_modified');
            $this -> data['text_firstname'] = $this -> language -> get('text_firstname');
            $this -> data['text_lastname'] = $this -> language -> get('text_lastname');
            $this -> data['text_company'] = $this -> language -> get('text_company');
            $this -> data['text_company_id'] = $this -> language -> get('text_company_id');
            $this -> data['text_tax_id'] = $this -> language -> get('text_tax_id');
            $this -> data['text_address_1'] = $this -> language -> get('text_address_1');
            $this -> data['text_address_2'] = $this -> language -> get('text_address_2');
            $this -> data['text_city'] = $this -> language -> get('text_city');
            $this -> data['text_postcode'] = $this -> language -> get('text_postcode');
            $this -> data['text_zone'] = $this -> language -> get('text_zone');
            $this -> data['text_zone_code'] = $this -> language -> get('text_zone_code');
            $this -> data['text_country'] = $this -> language -> get('text_country');
            $this -> data['text_shipping_method'] = $this -> language -> get('text_shipping_method');
            $this -> data['text_payment_method'] = $this -> language -> get('text_payment_method');
            $this -> data['text_download'] = $this -> language -> get('text_download');
            $this -> data['text_wait'] = $this -> language -> get('text_wait');
            $this -> data['text_generate'] = $this -> language -> get('text_generate');
            $this -> data['text_reward_add'] = $this -> language -> get('text_reward_add');
            $this -> data['text_reward_remove'] = $this -> language -> get('text_reward_remove');
            $this -> data['text_commission_add'] = $this -> language -> get('text_commission_add');
            $this -> data['text_commission_remove'] = $this -> language -> get('text_commission_remove');
            $this -> data['text_credit_add'] = $this -> language -> get('text_credit_add');
            $this -> data['text_credit_remove'] = $this -> language -> get('text_credit_remove');
            $this -> data['text_country_match'] = $this -> language -> get('text_country_match');
            $this -> data['text_country_code'] = $this -> language -> get('text_country_code');
            $this -> data['text_high_risk_country'] = $this -> language -> get('text_high_risk_country');
            $this -> data['text_distance'] = $this -> language -> get('text_distance');
            $this -> data['text_ip_region'] = $this -> language -> get('text_ip_region');
            $this -> data['text_ip_city'] = $this -> language -> get('text_ip_city');
            $this -> data['text_ip_latitude'] = $this -> language -> get('text_ip_latitude');
            $this -> data['text_ip_longitude'] = $this -> language -> get('text_ip_longitude');
            $this -> data['text_ip_isp'] = $this -> language -> get('text_ip_isp');
            $this -> data['text_ip_org'] = $this -> language -> get('text_ip_org');
            $this -> data['text_ip_asnum'] = $this -> language -> get('text_ip_asnum');
            $this -> data['text_ip_user_type'] = $this -> language -> get('text_ip_user_type');
            $this -> data['text_ip_country_confidence'] = $this -> language -> get('text_ip_country_confidence');
            $this -> data['text_ip_region_confidence'] = $this -> language -> get('text_ip_region_confidence');
            $this -> data['text_ip_city_confidence'] = $this -> language -> get('text_ip_city_confidence');
            $this -> data['text_ip_postal_confidence'] = $this -> language -> get('text_ip_postal_confidence');
            $this -> data['text_ip_postal_code'] = $this -> language -> get('text_ip_postal_code');
            $this -> data['text_ip_accuracy_radius'] = $this -> language -> get('text_ip_accuracy_radius');
            $this -> data['text_ip_net_speed_cell'] = $this -> language -> get('text_ip_net_speed_cell');
            $this -> data['text_ip_metro_code'] = $this -> language -> get('text_ip_metro_code');
            $this -> data['text_ip_area_code'] = $this -> language -> get('text_ip_area_code');
            $this -> data['text_ip_time_zone'] = $this -> language -> get('text_ip_time_zone');
            $this -> data['text_ip_region_name'] = $this -> language -> get('text_ip_region_name');
            $this -> data['text_ip_domain'] = $this -> language -> get('text_ip_domain');
            $this -> data['text_ip_country_name'] = $this -> language -> get('text_ip_country_name');
            $this -> data['text_ip_continent_code'] = $this -> language -> get('text_ip_continent_code');
            $this -> data['text_ip_corporate_proxy'] = $this -> language -> get('text_ip_corporate_proxy');
            $this -> data['text_anonymous_proxy'] = $this -> language -> get('text_anonymous_proxy');
            $this -> data['text_proxy_score'] = $this -> language -> get('text_proxy_score');
            $this -> data['text_is_trans_proxy'] = $this -> language -> get('text_is_trans_proxy');
            $this -> data['text_free_mail'] = $this -> language -> get('text_free_mail');
            $this -> data['text_carder_email'] = $this -> language -> get('text_carder_email');
            $this -> data['text_high_risk_username'] = $this -> language -> get('text_high_risk_username');
            $this -> data['text_high_risk_password'] = $this -> language -> get('text_high_risk_password');
            $this -> data['text_bin_match'] = $this -> language -> get('text_bin_match');
            $this -> data['text_bin_country'] = $this -> language -> get('text_bin_country');
            $this -> data['text_bin_name_match'] = $this -> language -> get('text_bin_name_match');
            $this -> data['text_bin_name'] = $this -> language -> get('text_bin_name');
            $this -> data['text_bin_phone_match'] = $this -> language -> get('text_bin_phone_match');
            $this -> data['text_bin_phone'] = $this -> language -> get('text_bin_phone');
            $this -> data['text_customer_phone_in_billing_location'] = $this -> language -> get('text_customer_phone_in_billing_location');
            $this -> data['text_ship_forward'] = $this -> language -> get('text_ship_forward');
            $this -> data['text_city_postal_match'] = $this -> language -> get('text_city_postal_match');
            $this -> data['text_ship_city_postal_match'] = $this -> language -> get('text_ship_city_postal_match');
            $this -> data['text_score'] = $this -> language -> get('text_score');
            $this -> data['text_explanation'] = $this -> language -> get('text_explanation');
            $this -> data['text_risk_score'] = $this -> language -> get('text_risk_score');
            $this -> data['text_queries_remaining'] = $this -> language -> get('text_queries_remaining');
            $this -> data['text_maxmind_id'] = $this -> language -> get('text_maxmind_id');
            $this -> data['text_error'] = $this -> language -> get('text_error');

            $this -> data['column_product'] = $this -> language -> get('column_product');
            $this -> data['column_model'] = $this -> language -> get('column_model');
            $this -> data['column_quantity'] = $this -> language -> get('column_quantity');
            $this -> data['column_price'] = $this -> language -> get('column_price');
            $this -> data['column_total'] = $this -> language -> get('column_total');
            $this -> data['column_download'] = $this -> language -> get('column_download');
            $this -> data['column_filename'] = $this -> language -> get('column_filename');
            $this -> data['column_remaining'] = $this -> language -> get('column_remaining');

            $this -> data['entry_order_status'] = $this -> language -> get('entry_order_status');
            $this -> data['entry_notify'] = $this -> language -> get('entry_notify');
            $this -> data['entry_comment'] = $this -> language -> get('entry_comment');

            $this -> data['button_invoice'] = $this -> language -> get('button_invoice');
            $this -> data['button_cancel'] = $this -> language -> get('button_cancel');
            $this -> data['button_add_history'] = $this -> language -> get('button_add_history');

            $this -> data['tab_order'] = $this -> language -> get('tab_order');
            $this -> data['tab_payment'] = $this -> language -> get('tab_payment');
            $this -> data['tab_shipping'] = $this -> language -> get('tab_shipping');
            $this -> data['tab_product'] = $this -> language -> get('tab_product');
            $this -> data['tab_history'] = $this -> language -> get('tab_history');
            $this -> data['tab_fraud'] = $this -> language -> get('tab_fraud');

            $this -> data['token'] = $this -> session -> data['token'];

            $url = '';

            if (isset($this -> request -> get['filter_order_id'])) {
                $url .= '&filter_order_id=' . $this -> request -> get['filter_order_id'];
            }

            if (isset($this -> request -> get['filter_customer'])) {
                $url .= '&filter_customer=' . urlencode(html_entity_decode($this -> request -> get['filter_customer'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this -> request -> get['filter_order_status_id'])) {
                $url .= '&filter_order_status_id=' . $this -> request -> get['filter_order_status_id'];
            }

            if (isset($this -> request -> get['filter_total'])) {
                $url .= '&filter_total=' . $this -> request -> get['filter_total'];
            }

            if (isset($this -> request -> get['filter_date_added'])) {
                $url .= '&filter_date_added=' . $this -> request -> get['filter_date_added'];
            }

            if (isset($this -> request -> get['filter_date_modified'])) {
                $url .= '&filter_date_modified=' . $this -> request -> get['filter_date_modified'];
            }

            if (isset($this -> request -> get['sort'])) {
                $url .= '&sort=' . $this -> request -> get['sort'];
            }

            if (isset($this -> request -> get['order'])) {
                $url .= '&order=' . $this -> request -> get['order'];
            }

            if (isset($this -> request -> get['page'])) {
                $url .= '&page=' . $this -> request -> get['page'];
            }

            $this -> data['breadcrumbs'] = array();

            $this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('text_home'), 'href' => $this -> url -> link('common/home', 'token=' . $this -> session -> data['token'], 'SSL'), 'separator' => false);

            $this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('heading_title'), 'href' => $this -> url -> link('backorder/backorder', 'token=' . $this -> session -> data['token'] . $url, 'SSL'), 'separator' => ' :: ');

            $this -> data['order_id'] = $this -> request -> get['order_id'];

            if ($order_info['invoice_no']) {
                $this -> data['invoice_no'] = $order_info['invoice_prefix'] . $order_info['invoice_no'];
            } else {
                $this -> data['invoice_no'] = '';
            }

            $this -> data['store_name'] = $order_info['store_name'];
            $this -> data['store_url'] = $order_info['store_url'];
            $this -> data['firstname'] = $order_info['firstname'];
            $this -> data['lastname'] = $order_info['lastname'];

            if ($order_info['customer_id']) {
                $this -> data['customer'] = $this -> url -> link('sale/customer/update', 'token=' . $this -> session -> data['token'] . '&customer_id=' . $order_info['customer_id'], 'SSL');
            } else {
                $this -> data['customer'] = '';
            }

            $this -> load -> model('sale/customer_group');

            $customer_group_info = $this -> model_sale_customer_group -> getCustomerGroup($order_info['customer_group_id']);

            if ($customer_group_info) {
                $this -> data['customer_group'] = $customer_group_info['name'];
            } else {
                $this -> data['customer_group'] = '';
            }

            $this -> data['email'] = $order_info['email'];
            $this -> data['telephone'] = $order_info['telephone'];
            $this -> data['fax'] = $order_info['fax'];
            $this -> data['comment'] = nl2br($order_info['comment']);
            $this -> data['shipping_method'] = $order_info['shipping_method'];
            $this -> data['payment_method'] = $order_info['payment_method'];
            $this -> data['total'] = $this -> currency -> format($order_info['total'], $order_info['currency_code'], $order_info['currency_value']);

            if ($order_info['total'] < 0) {
                $this -> data['credit'] = $order_info['total'];
            } else {
                $this -> data['credit'] = 0;
            }

            $this -> load -> model('sale/customer');

            $this -> data['credit_total'] = $this -> model_sale_customer -> getTotalTransactionsByOrderId($this -> request -> get['order_id']);

            $this -> data['reward'] = $order_info['reward'];

            $this -> data['reward_total'] = $this -> model_sale_customer -> getTotalCustomerRewardsByOrderId($this -> request -> get['order_id']);

            $this -> data['affiliate_firstname'] = $order_info['affiliate_firstname'];
            $this -> data['affiliate_lastname'] = $order_info['affiliate_lastname'];

            if ($order_info['affiliate_id']) {
                $this -> data['affiliate'] = $this -> url -> link('sale/affiliate/update', 'token=' . $this -> session -> data['token'] . '&affiliate_id=' . $order_info['affiliate_id'], 'SSL');
            } else {
                $this -> data['affiliate'] = '';
            }

            $this -> data['commission'] = $this -> currency -> format($order_info['commission'], $order_info['currency_code'], $order_info['currency_value']);

            $this -> load -> model('sale/affiliate');

            $this -> data['commission_total'] = $this -> model_sale_affiliate -> getTotalTransactionsByOrderId($this -> request -> get['order_id']);

            $this -> load -> model('localisation/order_status');

            $order_status_info = $this -> model_localisation_order_status -> getOrderStatus($order_info['order_status_id']);

            if ($order_status_info) {
                $this -> data['order_status'] = $order_status_info['name'];
            } else {
                $this -> data['order_status'] = '';
            }

            $this -> data['ip'] = $order_info['ip'];
            $this -> data['forwarded_ip'] = $order_info['forwarded_ip'];
            $this -> data['user_agent'] = $order_info['user_agent'];
            $this -> data['accept_language'] = $order_info['accept_language'];
            $this -> data['date_added'] = date($this -> language -> get('date_format_short'), strtotime($order_info['date_added']));
            $this -> data['date_modified'] = date($this -> language -> get('date_format_short'), strtotime($order_info['date_modified']));
            $this -> data['payment_firstname'] = $order_info['payment_firstname'];
            $this -> data['payment_lastname'] = $order_info['payment_lastname'];
            $this -> data['payment_company'] = $order_info['payment_company'];
            $this -> data['payment_company_id'] = $order_info['payment_company_id'];
            $this -> data['payment_tax_id'] = $order_info['payment_tax_id'];
            $this -> data['payment_address_1'] = $order_info['payment_address_1'];
            $this -> data['payment_address_2'] = $order_info['payment_address_2'];
            $this -> data['payment_city'] = $order_info['payment_city'];
            $this -> data['payment_postcode'] = $order_info['payment_postcode'];
            $this -> data['payment_zone'] = $order_info['payment_zone'];
            $this -> data['payment_zone_code'] = $order_info['payment_zone_code'];
            $this -> data['payment_country'] = $order_info['payment_country'];
            $this -> data['shipping_firstname'] = $order_info['shipping_firstname'];
            $this -> data['shipping_lastname'] = $order_info['shipping_lastname'];
            $this -> data['shipping_company'] = $order_info['shipping_company'];
            $this -> data['shipping_address_1'] = $order_info['shipping_address_1'];
            $this -> data['shipping_address_2'] = $order_info['shipping_address_2'];
            $this -> data['shipping_city'] = $order_info['shipping_city'];
            $this -> data['shipping_postcode'] = $order_info['shipping_postcode'];
            $this -> data['shipping_zone'] = $order_info['shipping_zone'];
            $this -> data['shipping_zone_code'] = $order_info['shipping_zone_code'];
            $this -> data['shipping_country'] = $order_info['shipping_country'];

            $this -> data['products'] = array();

            $products = $this -> model_sale_order -> getOrderProducts($this -> request -> get['order_id']);

            foreach ($products as $product) {
                $option_data = array();

                $options = $this -> model_sale_order -> getOrderOptions($this -> request -> get['order_id'], $product['order_product_id']);

                foreach ($options as $option) {
                    if ($option['type'] != 'file') {
                        $option_data[] = array('name' => $option['name'], 'value' => $option['value'], 'type' => $option['type']);
                    } else {
                        $option_data[] = array('name' => $option['name'], 'value' => utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.')), 'type' => $option['type'], 'href' => $this -> url -> link('backorder/backorder/download', 'token=' . $this -> session -> data['token'] . '&order_id=' . $this -> request -> get['order_id'] . '&order_option_id=' . $option['order_option_id'], 'SSL'));
                    }
                }

                $this -> data['products'][] = array('order_product_id' => $product['order_product_id'], 'product_id' => $product['product_id'], 'name' => $product['name'], 'model' => $product['model'], 'option' => $option_data, 'quantity' => $product['quantity'], 'price' => $this -> currency -> format($product['price'] + ($this -> config -> get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']), 'total' => $this -> currency -> format($product['total'] + ($this -> config -> get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']), 'href' => $this -> url -> link('catalog/product/update', 'token=' . $this -> session -> data['token'] . '&product_id=' . $product['product_id'], 'SSL'));
            }

            $this -> data['vouchers'] = array();

            $vouchers = $this -> model_sale_order -> getOrderVouchers($this -> request -> get['order_id']);

            foreach ($vouchers as $voucher) {
                $this -> data['vouchers'][] = array('description' => $voucher['description'], 'amount' => $this -> currency -> format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']), 'href' => $this -> url -> link('sale/voucher/update', 'token=' . $this -> session -> data['token'] . '&voucher_id=' . $voucher['voucher_id'], 'SSL'));
            }

            $this -> data['totals'] = $this -> model_sale_order -> getOrderTotals($this -> request -> get['order_id']);

            $this -> data['downloads'] = array();

            foreach ($products as $product) {
                $results = $this -> model_sale_order -> getOrderDownloads($this -> request -> get['order_id'], $product['order_product_id']);

                foreach ($results as $result) {
                    $this -> data['downloads'][] = array('name' => $result['name'], 'filename' => $result['mask'], 'remaining' => $result['remaining']);
                }
            }

            $this -> data['order_statuses'] = $this -> model_localisation_order_status -> getOrderStatuses();

            $this -> data['order_status_id'] = $order_info['order_status_id'];

            // Fraud
            $this -> load -> model('sale/fraud');

            $fraud_info = $this -> model_sale_fraud -> getFraud($order_info['order_id']);

            if ($fraud_info) {
                $this -> data['country_match'] = $fraud_info['country_match'];

                if ($fraud_info['country_code']) {
                    $this -> data['country_code'] = $fraud_info['country_code'];
                } else {
                    $this -> data['country_code'] = '';
                }

                $this -> data['high_risk_country'] = $fraud_info['high_risk_country'];
                $this -> data['distance'] = $fraud_info['distance'];

                if ($fraud_info['ip_region']) {
                    $this -> data['ip_region'] = $fraud_info['ip_region'];
                } else {
                    $this -> data['ip_region'] = '';
                }

                if ($fraud_info['ip_city']) {
                    $this -> data['ip_city'] = $fraud_info['ip_city'];
                } else {
                    $this -> data['ip_city'] = '';
                }

                $this -> data['ip_latitude'] = $fraud_info['ip_latitude'];
                $this -> data['ip_longitude'] = $fraud_info['ip_longitude'];

                if ($fraud_info['ip_isp']) {
                    $this -> data['ip_isp'] = $fraud_info['ip_isp'];
                } else {
                    $this -> data['ip_isp'] = '';
                }

                if ($fraud_info['ip_org']) {
                    $this -> data['ip_org'] = $fraud_info['ip_org'];
                } else {
                    $this -> data['ip_org'] = '';
                }

                $this -> data['ip_asnum'] = $fraud_info['ip_asnum'];

                if ($fraud_info['ip_user_type']) {
                    $this -> data['ip_user_type'] = $fraud_info['ip_user_type'];
                } else {
                    $this -> data['ip_user_type'] = '';
                }

                if ($fraud_info['ip_country_confidence']) {
                    $this -> data['ip_country_confidence'] = $fraud_info['ip_country_confidence'];
                } else {
                    $this -> data['ip_country_confidence'] = '';
                }

                if ($fraud_info['ip_region_confidence']) {
                    $this -> data['ip_region_confidence'] = $fraud_info['ip_region_confidence'];
                } else {
                    $this -> data['ip_region_confidence'] = '';
                }

                if ($fraud_info['ip_city_confidence']) {
                    $this -> data['ip_city_confidence'] = $fraud_info['ip_city_confidence'];
                } else {
                    $this -> data['ip_city_confidence'] = '';
                }

                if ($fraud_info['ip_postal_confidence']) {
                    $this -> data['ip_postal_confidence'] = $fraud_info['ip_postal_confidence'];
                } else {
                    $this -> data['ip_postal_confidence'] = '';
                }

                if ($fraud_info['ip_postal_code']) {
                    $this -> data['ip_postal_code'] = $fraud_info['ip_postal_code'];
                } else {
                    $this -> data['ip_postal_code'] = '';
                }

                $this -> data['ip_accuracy_radius'] = $fraud_info['ip_accuracy_radius'];

                if ($fraud_info['ip_net_speed_cell']) {
                    $this -> data['ip_net_speed_cell'] = $fraud_info['ip_net_speed_cell'];
                } else {
                    $this -> data['ip_net_speed_cell'] = '';
                }

                $this -> data['ip_metro_code'] = $fraud_info['ip_metro_code'];
                $this -> data['ip_area_code'] = $fraud_info['ip_area_code'];

                if ($fraud_info['ip_time_zone']) {
                    $this -> data['ip_time_zone'] = $fraud_info['ip_time_zone'];
                } else {
                    $this -> data['ip_time_zone'] = '';
                }

                if ($fraud_info['ip_region_name']) {
                    $this -> data['ip_region_name'] = $fraud_info['ip_region_name'];
                } else {
                    $this -> data['ip_region_name'] = '';
                }

                if ($fraud_info['ip_domain']) {
                    $this -> data['ip_domain'] = $fraud_info['ip_domain'];
                } else {
                    $this -> data['ip_domain'] = '';
                }

                if ($fraud_info['ip_country_name']) {
                    $this -> data['ip_country_name'] = $fraud_info['ip_country_name'];
                } else {
                    $this -> data['ip_country_name'] = '';
                }

                if ($fraud_info['ip_continent_code']) {
                    $this -> data['ip_continent_code'] = $fraud_info['ip_continent_code'];
                } else {
                    $this -> data['ip_continent_code'] = '';
                }

                if ($fraud_info['ip_corporate_proxy']) {
                    $this -> data['ip_corporate_proxy'] = $fraud_info['ip_corporate_proxy'];
                } else {
                    $this -> data['ip_corporate_proxy'] = '';
                }

                $this -> data['anonymous_proxy'] = $fraud_info['anonymous_proxy'];
                $this -> data['proxy_score'] = $fraud_info['proxy_score'];

                if ($fraud_info['is_trans_proxy']) {
                    $this -> data['is_trans_proxy'] = $fraud_info['is_trans_proxy'];
                } else {
                    $this -> data['is_trans_proxy'] = '';
                }

                $this -> data['free_mail'] = $fraud_info['free_mail'];
                $this -> data['carder_email'] = $fraud_info['carder_email'];

                if ($fraud_info['high_risk_username']) {
                    $this -> data['high_risk_username'] = $fraud_info['high_risk_username'];
                } else {
                    $this -> data['high_risk_username'] = '';
                }

                if ($fraud_info['high_risk_password']) {
                    $this -> data['high_risk_password'] = $fraud_info['high_risk_password'];
                } else {
                    $this -> data['high_risk_password'] = '';
                }

                $this -> data['bin_match'] = $fraud_info['bin_match'];

                if ($fraud_info['bin_country']) {
                    $this -> data['bin_country'] = $fraud_info['bin_country'];
                } else {
                    $this -> data['bin_country'] = '';
                }

                $this -> data['bin_name_match'] = $fraud_info['bin_name_match'];

                if ($fraud_info['bin_name']) {
                    $this -> data['bin_name'] = $fraud_info['bin_name'];
                } else {
                    $this -> data['bin_name'] = '';
                }

                $this -> data['bin_phone_match'] = $fraud_info['bin_phone_match'];

                if ($fraud_info['bin_phone']) {
                    $this -> data['bin_phone'] = $fraud_info['bin_phone'];
                } else {
                    $this -> data['bin_phone'] = '';
                }

                if ($fraud_info['customer_phone_in_billing_location']) {
                    $this -> data['customer_phone_in_billing_location'] = $fraud_info['customer_phone_in_billing_location'];
                } else {
                    $this -> data['customer_phone_in_billing_location'] = '';
                }

                $this -> data['ship_forward'] = $fraud_info['ship_forward'];

                if ($fraud_info['city_postal_match']) {
                    $this -> data['city_postal_match'] = $fraud_info['city_postal_match'];
                } else {
                    $this -> data['city_postal_match'] = '';
                }

                if ($fraud_info['ship_city_postal_match']) {
                    $this -> data['ship_city_postal_match'] = $fraud_info['ship_city_postal_match'];
                } else {
                    $this -> data['ship_city_postal_match'] = '';
                }

                $this -> data['score'] = $fraud_info['score'];
                $this -> data['explanation'] = $fraud_info['explanation'];
                $this -> data['risk_score'] = $fraud_info['risk_score'];
                $this -> data['queries_remaining'] = $fraud_info['queries_remaining'];
                $this -> data['maxmind_id'] = $fraud_info['maxmind_id'];
                $this -> data['error'] = $fraud_info['error'];
            } else {
                $this -> data['maxmind_id'] = '';
            }

            $this -> data['invoice'] = $this -> url -> link('backorder/backorder/invoice', 'token=' . $this -> session -> data['token'] . '&order_id=' . (int)$this -> request -> get['order_id'], 'SSL');
            $this -> data['cancel'] = $this -> url -> link('backorder/backorder', 'token=' . $this -> session -> data['token'] . $url, 'SSL');
            $this -> data['link_save'] = $this -> url -> link('backorder/backorder/save', 'token=' . $this -> session -> data['token'] . '&order_id=' . (int)$this -> request -> get['order_id'], 'SSL');

            $this -> data['text_message_customer'] = $this -> language -> get('text_message_customer');
            $this -> data['text_message_help'] = $this -> language -> get('text_message_help');
            $this -> data['text_new_order_status_1'] = $this -> language -> get('text_new_order_status_1');
            $this -> data['text_new_order_status_2'] = $this -> language -> get('text_new_order_status_2');

            $this -> template = 'backorder/backorder.tpl';
            $this -> children = array('common/header', 'common/footer');

            $this -> response -> setOutput($this -> render());
        } else {
            $this -> language -> load('error/not_found');

            $this -> document -> setTitle($this -> language -> get('heading_title'));

            $this -> data['heading_title'] = $this -> language -> get('heading_title');

            $this -> data['text_not_found'] = $this -> language -> get('text_not_found');

            $this -> data['breadcrumbs'] = array();

            $this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('text_home'), 'href' => $this -> url -> link('common/home', 'token=' . $this -> session -> data['token'], 'SSL'), 'separator' => false);

            $this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('heading_title'), 'href' => $this -> url -> link('error/not_found', 'token=' . $this -> session -> data['token'], 'SSL'), 'separator' => ' :: ');

            $this -> template = 'error/not_found.tpl';
            $this -> children = array('common/header', 'common/footer');

            $this -> response -> setOutput($this -> render());
        }
    }

    public function save() {
        $orderUID = $this -> request -> get['order_id'];
        $pro_nummers = $this -> request -> post['proNummers'];
		$customer_info = $this -> request -> post['customer_info'];
        $order_status_1 = $this -> request -> post['order_status_1'];
        $order_status_2 = $this -> request -> post['order_status_2'];
		$date_added = date('Y-m-d H:i:s');
		
        $proNum = explode("_", $pro_nummers);

        $this -> load -> model('backorder/backorder');
		
		$emailAddr = $this -> model_backorder_backorder -> getEmailAddr($orderUID);
		$emailAddr = $emailAddr['email'];

        $orderUIDNew = $this -> model_backorder_backorder -> copyOrder($orderUID);
        $this -> model_backorder_backorder -> copyOrderHistory($orderUID, $orderUIDNew);
        $this -> model_backorder_backorder -> copyOrderField($orderUID, $orderUIDNew);
        $this -> model_backorder_backorder -> copyOrderIncasso($orderUID, $orderUIDNew);
        $this -> model_backorder_backorder -> copyOrderOption($orderUID, $orderUIDNew);
        $this -> model_backorder_backorder -> copyOrderVoucher($orderUID, $orderUIDNew);
        $this -> model_backorder_backorder -> fixOrderProducts($orderUID, $orderUIDNew, $proNum);
		$this -> model_backorder_backorder -> copyOrderTotal($orderUID, $orderUIDNew);
		
		$newTotalOld = $this -> model_backorder_backorder -> getNewTotal($orderUID);
		$newTotalNew = $this -> model_backorder_backorder -> getNewTotal($orderUIDNew);
		
		$this -> model_backorder_backorder -> fixTotalFirst($orderUID, $newTotalOld);
		$this -> model_backorder_backorder -> fixTotalSecond($orderUIDNew, $newTotalNew);
		
		$customer_info = str_replace('{order_id_1}', $orderUID, $customer_info);
		$customer_info = str_replace('{order_id_2}', $orderUIDNew, $customer_info);
		
		$this -> model_backorder_backorder -> insertNewHistory($orderUID, $order_status_1, '1', $customer_info, $date_added);
		$this -> model_backorder_backorder -> setNewOrderState($orderUID, $order_status_1);
		$this -> model_backorder_backorder -> insertNewHistory($orderUIDNew, $order_status_2, '1', $customer_info, $date_added);
		$this -> model_backorder_backorder -> setNewOrderState($orderUIDNew, $order_status_2);
		
		$this -> model_backorder_backorder -> emailCustomer($emailAddr, $customer_info);
		
		$this -> language -> load('backorder/backorder');
        $this -> document -> setTitle($this -> language -> get('heading_title'));
		
		$this -> data['heading_title'] = $this -> language -> get('heading_title');
		$this -> data['succes_message'] = $this -> language -> get('succes_message');
		
		$this -> data['succes_message'] = str_replace('{order_id_1}', $orderUID, $this -> data['succes_message']);
		$this -> data['succes_message'] = str_replace('{order_id_2}', $orderUIDNew, $this -> data['succes_message']);
		
		$this -> data['breadcrumbs'] = array();
		$this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('text_home'), 'href' => $this -> url -> link('common/home', 'token=' . $this -> session -> data['token'], 'SSL'), 'separator' => false);
		$this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('heading_title'), 'href' => $this -> url -> link('backorder/backorder', 'token=' . $this -> session -> data['token'], 'SSL'), 'separator' => ' :: ');

		
		$this -> template = 'backorder/succes.tpl';
		$this -> children = array('common/header', 'common/footer');
		$this -> response -> setOutput($this -> render());
    }

    private function validate() {
        if (!$this -> user -> hasPermission('modify', 'backorder/backorder')) {
            $this -> error['warning'] = $this -> language -> get('error_permission');
        }

        if (!$this -> request -> post['ouid']) {
            $this -> error['subject'] = $this -> language -> get('error_ouid');
        }

        if (!$this -> error) {
            return true;
        } else {
            return false;
        }
    }

    private function printExtender($arr) {
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
    }

}
?>
