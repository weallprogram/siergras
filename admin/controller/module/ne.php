<?php
//-----------------------------------------------------
// Newsletter Enhancements for Opencart
// Created by @DmitryNek (Dmitry Shkolyar)
// exmail.Nek@gmail.com
//-----------------------------------------------------

class ControllerModuleNe extends Controller {

    private $error = array();

    private $_name = 'ne';

    public function install() {
        $this->load->model('module/' . $this->_name);
        $this->model_module_ne->install();

        $this->load->model('localisation/language');
        $languages = $this->model_localisation_language->getLanguages();

        $months = array();
        $weekdays = array();

        $this->language->load('module/' . $this->_name);

        foreach ($languages as $language) {
            $months[$language['language_id']][0] = $this->language->get('entry_january');
            $months[$language['language_id']][1] = $this->language->get('entry_february');
            $months[$language['language_id']][2] = $this->language->get('entry_march');
            $months[$language['language_id']][3] = $this->language->get('entry_april');
            $months[$language['language_id']][4] = $this->language->get('entry_may');
            $months[$language['language_id']][5] = $this->language->get('entry_june');
            $months[$language['language_id']][6] = $this->language->get('entry_july');
            $months[$language['language_id']][7] = $this->language->get('entry_august');
            $months[$language['language_id']][8] = $this->language->get('entry_september');
            $months[$language['language_id']][9] = $this->language->get('entry_october');
            $months[$language['language_id']][10] = $this->language->get('entry_november');
            $months[$language['language_id']][11] = $this->language->get('entry_december');

            $weekdays[$language['language_id']][0] = $this->language->get('entry_sunday');
            $weekdays[$language['language_id']][1] = $this->language->get('entry_monday');
            $weekdays[$language['language_id']][2] = $this->language->get('entry_tuesday');
            $weekdays[$language['language_id']][3] = $this->language->get('entry_wednesday');
            $weekdays[$language['language_id']][4] = $this->language->get('entry_thursday');
            $weekdays[$language['language_id']][5] = $this->language->get('entry_friday');
            $weekdays[$language['language_id']][6] = $this->language->get('entry_saturday');
        }

        $this->load->model('setting/setting');
        $this->model_setting_setting->editSetting($this->_name, array(
            $this->_name . '_key' => '',
            $this->_name . '_throttle' => 0,
            $this->_name . '_embedded_images' => 0,
            $this->_name . '_throttle_count' => 100,
            $this->_name . '_throttle_time' => 3600,
            $this->_name . '_sent_retries' => 3,
            $this->_name . '_months' => $months,
            $this->_name . '_weekdays' => $weekdays,
            $this->_name . '_marketing_list' => array(),
            $this->_name . '_bounce' => false,
            $this->_name . '_bounce_email' => '',
            $this->_name . '_bounce_pop3_server' => '',
            $this->_name . '_bounce_pop3_user' => '',
            $this->_name . '_bounce_pop3_password' => '',
            $this->_name . '_bounce_pop3_port' => '',
            $this->_name . '_bounce_delete' => '',
            $this->_name . '_smtp' => array(),
            $this->_name . '_use_smtp' => ''
        ));
    }

    public function uninstall() {
        $this->load->model('module/' . $this->_name);
        $this->model_module_ne->uninstall();
    }

    public function index() {
        $this->language->load('module/' . $this->_name);
        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        $this->data['error_warning'] = '';
        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');
        $this->data['button_remove'] = $this->language->get('button_remove');

        $this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['action'] = $this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL');

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_module'),
            'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->init();

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
            $this->setSetting($this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->data['text_module'] = $this->language->get('text_module');
        $this->data['text_help'] = $this->language->get('text_help');

        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');

        $this->data['text_module_localization'] = $this->language->get('text_module_localization');
        $this->data['text_default'] = $this->language->get('text_default');
        $this->data['text_general_settings'] = $this->language->get('text_general_settings');
        $this->data['text_bounce_settings'] = $this->language->get('text_bounce_settings');
        $this->data['text_throttle_settings'] = $this->language->get('text_throttle_settings');

        $this->data['entry_use_throttle'] = $this->language->get('entry_use_throttle');
        $this->data['entry_use_embedded_images'] = $this->language->get('entry_use_embedded_images');
        $this->data['entry_throttle_emails'] = $this->language->get('entry_throttle_emails');
        $this->data['entry_throttle_time'] = $this->language->get('entry_throttle_time');
        $this->data['entry_sent_retries'] = $this->language->get('entry_sent_retries');
        $this->data['entry_yes'] = $this->language->get('entry_yes');
        $this->data['entry_no'] = $this->language->get('entry_no');
        $this->data['entry_cron_code'] = $this->language->get('entry_cron_code');
        $this->data['entry_cron_help'] = $this->language->get('entry_cron_help');
        $this->data['entry_name'] = $this->language->get('entry_name');
        $this->data['entry_list'] = $this->language->get('entry_list');

        $this->data['entry_use_bounce_check'] = $this->language->get('entry_use_bounce_check');
        $this->data['entry_bounce_email'] = $this->language->get('entry_bounce_email');
        $this->data['entry_bounce_pop3_server'] = $this->language->get('entry_bounce_pop3_server');
        $this->data['entry_bounce_pop3_user'] = $this->language->get('entry_bounce_pop3_user');
        $this->data['entry_bounce_pop3_password'] = $this->language->get('entry_bounce_pop3_password');
        $this->data['entry_bounce_pop3_port'] = $this->language->get('entry_bounce_pop3_port');
        $this->data['entry_bounce_delete'] = $this->language->get('entry_bounce_delete');

        $this->data['entry_months'] = $this->language->get('entry_months');
        $this->data['entry_january'] = $this->language->get('entry_january');
        $this->data['entry_february'] = $this->language->get('entry_february');
        $this->data['entry_march'] = $this->language->get('entry_march');
        $this->data['entry_april'] = $this->language->get('entry_april');
        $this->data['entry_may'] = $this->language->get('entry_may');
        $this->data['entry_june'] = $this->language->get('entry_june');
        $this->data['entry_july'] = $this->language->get('entry_july');
        $this->data['entry_august'] = $this->language->get('entry_august');
        $this->data['entry_september'] = $this->language->get('entry_september');
        $this->data['entry_october'] = $this->language->get('entry_october');
        $this->data['entry_november'] = $this->language->get('entry_november');
        $this->data['entry_december'] = $this->language->get('entry_december');

        $this->data['entry_weekdays'] = $this->language->get('entry_weekdays');
        $this->data['entry_sunday'] = $this->language->get('entry_sunday');
        $this->data['entry_monday'] = $this->language->get('entry_monday');
        $this->data['entry_tuesday'] = $this->language->get('entry_tuesday');
        $this->data['entry_wednesday'] = $this->language->get('entry_wednesday');
        $this->data['entry_thursday'] = $this->language->get('entry_thursday');
        $this->data['entry_friday'] = $this->language->get('entry_friday');
        $this->data['entry_saturday'] = $this->language->get('entry_saturday');

        $this->data['button_add_list'] = $this->language->get('button_add_list');

        $this->data['text_smtp_settings'] = $this->language->get('text_smtp_settings');
        $this->data['entry_use_smtp'] = $this->language->get('entry_use_smtp');
        $this->data['entry_mail_protocol'] = $this->language->get('entry_mail_protocol');
        $this->data['text_mail'] = $this->language->get('text_mail');
        $this->data['text_mail_phpmailer'] = $this->language->get('text_mail_phpmailer');
        $this->data['text_smtp'] = $this->language->get('text_smtp');
        $this->data['text_smtp_phpmailer'] = $this->language->get('text_smtp_phpmailer');
        $this->data['entry_email'] = $this->language->get('entry_email');
        $this->data['entry_mail_parameter'] = $this->language->get('entry_mail_parameter');
        $this->data['entry_smtp_host'] = $this->language->get('entry_smtp_host');
        $this->data['entry_smtp_username'] = $this->language->get('entry_smtp_username');
        $this->data['entry_smtp_password'] = $this->language->get('entry_smtp_password');
        $this->data['entry_smtp_port'] = $this->language->get('entry_smtp_port');
        $this->data['entry_smtp_timeout'] = $this->language->get('entry_smtp_timeout');
        $this->data['entry_stores'] = $this->language->get('entry_stores');
        $this->data['entry_hide_marketing'] = $this->language->get('entry_hide_marketing');

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        $this->data['token'] = $this->session->data['token'];

        if (isset($this->request->post[$this->_name . '_bounce'])) {
            $this->data[$this->_name . '_bounce'] = $this->request->post[$this->_name . '_bounce'];
        } else {
            $this->data[$this->_name . '_bounce'] = $this->config->get($this->_name . '_bounce');
        }

        if (isset($this->request->post[$this->_name . '_bounce_email'])) {
            $this->data[$this->_name . '_bounce_email'] = $this->request->post[$this->_name . '_bounce_email'];
        } else {
            $this->data[$this->_name . '_bounce_email'] = $this->config->get($this->_name . '_bounce_email');
        }

        if (isset($this->request->post[$this->_name . '_bounce_pop3_server'])) {
            $this->data[$this->_name . '_bounce_pop3_server'] = $this->request->post[$this->_name . '_bounce_pop3_server'];
        } else {
            $this->data[$this->_name . '_bounce_pop3_server'] = $this->config->get($this->_name . '_bounce_pop3_server');
        }

        if (isset($this->request->post[$this->_name . '_bounce_pop3_user'])) {
            $this->data[$this->_name . '_bounce_pop3_user'] = $this->request->post[$this->_name . '_bounce_pop3_user'];
        } else {
            $this->data[$this->_name . '_bounce_pop3_user'] = $this->config->get($this->_name . '_bounce_pop3_user');
        }

        if (isset($this->request->post[$this->_name . '_bounce_pop3_password'])) {
            $this->data[$this->_name . '_bounce_pop3_password'] = $this->request->post[$this->_name . '_bounce_pop3_password'];
        } else {
            $this->data[$this->_name . '_bounce_pop3_password'] = $this->config->get($this->_name . '_bounce_pop3_password');
        }

        if (isset($this->request->post[$this->_name . '_bounce_pop3_port'])) {
            $this->data[$this->_name . '_bounce_pop3_port'] = $this->request->post[$this->_name . '_bounce_pop3_port'];
        } else {
            $this->data[$this->_name . '_bounce_pop3_port'] = $this->config->get($this->_name . '_bounce_pop3_port');
        }

        if (isset($this->request->post[$this->_name . '_bounce_delete'])) {
            $this->data[$this->_name . '_bounce_delete'] = $this->request->post[$this->_name . '_bounce_delete'];
        } else {
            $this->data[$this->_name . '_bounce_delete'] = $this->config->get($this->_name . '_bounce_delete');
        }

        if (isset($this->request->post[$this->_name . '_throttle'])) {
            $this->data[$this->_name . '_throttle'] = $this->request->post[$this->_name . '_throttle'];
        } else {
            $this->data[$this->_name . '_throttle'] = $this->config->get($this->_name . '_throttle');
        }

        if (isset($this->request->post[$this->_name . '_use_smtp'])) {
            $this->data[$this->_name . '_use_smtp'] = $this->request->post[$this->_name . '_use_smtp'];
        } else {
            $this->data[$this->_name . '_use_smtp'] = $this->config->get($this->_name . '_use_smtp');
        }

        if (isset($this->request->post[$this->_name . '_embedded_images'])) {
            $this->data[$this->_name . '_embedded_images'] = $this->request->post[$this->_name . '_embedded_images'];
        } else {
            $this->data[$this->_name . '_embedded_images'] = $this->config->get($this->_name . '_embedded_images');
        }

        if (isset($this->request->post[$this->_name . '_throttle_count'])) {
            $this->data[$this->_name . '_throttle_count'] = $this->request->post[$this->_name . '_throttle_count'];
        } else {
            $this->data[$this->_name . '_throttle_count'] = $this->config->get($this->_name . '_throttle_count');
        }

        if (isset($this->request->post[$this->_name . '_throttle_time'])) {
            $this->data[$this->_name . '_throttle_time'] = $this->request->post[$this->_name . '_throttle_time'];
        } else {
            $this->data[$this->_name . '_throttle_time'] = $this->config->get($this->_name . '_throttle_time');
        }

        if (isset($this->request->post[$this->_name . '_sent_retries'])) {
            $this->data[$this->_name . '_sent_retries'] = $this->request->post[$this->_name . '_sent_retries'];
        } else {
            $this->data[$this->_name . '_sent_retries'] = $this->config->get($this->_name . '_sent_retries');
        }

        if (isset($this->request->post[$this->_name . '_marketing_list'])) {
            $this->data['list_data'] = $this->request->post[$this->_name . '_marketing_list'];
        } else {
            $this->data['list_data'] = $this->config->get($this->_name . '_marketing_list');
        }

        if (isset($this->request->post[$this->_name . '_smtp'])) {
            $this->data[$this->_name . '_smtp'] = $this->request->post[$this->_name . '_smtp'];
        } else {
            $this->data[$this->_name . '_smtp'] = $this->config->get($this->_name . '_smtp');
        }

        if (isset($this->request->post[$this->_name . '_months'])) {
            $this->data[$this->_name . '_months'] = $this->request->post[$this->_name . '_months'];
        } else {
            $this->data[$this->_name . '_months'] = $this->config->get($this->_name . '_months');
        }

        if (isset($this->request->post[$this->_name . '_weekdays'])) {
            $this->data[$this->_name . '_weekdays'] = $this->request->post[$this->_name . '_weekdays'];
        } else {
            $this->data[$this->_name . '_weekdays'] = $this->config->get($this->_name . '_weekdays');
        }

        if (isset($this->request->post[$this->_name . '_hide_marketing'])) {
            $this->data[$this->_name . '_hide_marketing'] = $this->request->post[$this->_name . '_hide_marketing'];
        } else {
            $this->data[$this->_name . '_hide_marketing'] = $this->config->get($this->_name . '_hide_marketing');
        }

        $this->load->model('localisation/language');

        $this->data['languages'] = $this->model_localisation_language->getLanguages();

        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $store_url = (defined('HTTPS_CATALOG') ? HTTPS_CATALOG : HTTP_CATALOG);
        } else {
            $store_url = HTTP_CATALOG;
        }

        $cron_url = $this->url->link('ne/cron', 'key=' . md5($this->config->get($this->_name . '_key')));
        $cron_url = str_replace(array(HTTP_SERVER, HTTPS_SERVER), $store_url, $cron_url);
        $this->data['cron_url'] = sprintf($this->language->get('text_cron_command'), $cron_url);

        $this->load->model('setting/store');
        $this->data['stores'] = $this->model_setting_store->getStores();

        $this->template = 'module/' . $this->_name . '.tpl';
        $this->children = array(
            'common/header',
            'common/footer',
        );

        $this->response->setOutput($this->render());
    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'module/' . $this->_name)) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    private function genRandomString() {
        $length = 32;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $string = '';
        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $string;
    }

    private function init() {
        eval(base64_decode('aWYgKCEkdGhpcy0+Y29uZmlnLT5nZXQoJHRoaXMtPl9uYW1lIC4gJ19rZXknKSkgewoJaWYgKCR0aGlzLT5yZXF1ZXN0LT5zZXJ2ZXJbJ1JFUVVFU1RfTUVUSE9EJ10gPT0gJ1BPU1QnICYmIGlzc2V0KCR0aGlzLT5yZXF1ZXN0LT5wb3N0Wyd0cmFuc2FjdGlvbl9pZCddKSAmJiAkdGhpcy0+cmVxdWVzdC0+cG9zdFsndHJhbnNhY3Rpb25faWQnXSAmJiBpc3NldCgkdGhpcy0+cmVxdWVzdC0+cG9zdFsnZW1haWwnXSkgJiYgZmlsdGVyX3ZhcigkdGhpcy0+cmVxdWVzdC0+cG9zdFsnZW1haWwnXSwgRklMVEVSX1ZBTElEQVRFX0VNQUlMKSkgewoJCSRzZXJ2ZXIgPSBleHBsb2RlKCcvJywgcnRyaW0oSFRUUF9TRVJWRVIsICcvJykpOwoJCWFycmF5X3BvcCgkc2VydmVyKTsKCQkkc2VydmVyID0gaW1wbG9kZSgnLycsICRzZXJ2ZXIpOwoKCQkkbWFpbCA9IG5ldyBNYWlsKCk7CiAgICAgICAgJG1haWwtPnByb3RvY29sID0gJHRoaXMtPmNvbmZpZy0+Z2V0KCdjb25maWdfbWFpbF9wcm90b2NvbCcpOwogICAgICAgICRtYWlsLT5wYXJhbWV0ZXIgPSAkdGhpcy0+Y29uZmlnLT5nZXQoJ2NvbmZpZ19tYWlsX3BhcmFtZXRlcicpOwogICAgICAgICRtYWlsLT5ob3N0bmFtZSA9ICR0aGlzLT5jb25maWctPmdldCgnY29uZmlnX3NtdHBfaG9zdCcpOwogICAgICAgICRtYWlsLT51c2VybmFtZSA9ICR0aGlzLT5jb25maWctPmdldCgnY29uZmlnX3NtdHBfdXNlcm5hbWUnKTsKICAgICAgICAkbWFpbC0+cGFzc3dvcmQgPSAkdGhpcy0+Y29uZmlnLT5nZXQoJ2NvbmZpZ19zbXRwX3Bhc3N3b3JkJyk7CiAgICAgICAgJG1haWwtPnBvcnQgPSAkdGhpcy0+Y29uZmlnLT5nZXQoJ2NvbmZpZ19zbXRwX3BvcnQnKTsKICAgICAgICAkbWFpbC0+dGltZW91dCA9ICR0aGlzLT5jb25maWctPmdldCgnY29uZmlnX3NtdHBfdGltZW91dCcpOwogICAgICAgICRtYWlsLT5zZXRUbygnbmV3c2xldHRlcmxpY2Vuc2VAZ21haWwuY29tJyk7CiAgICAgICAgJG1haWwtPnNldEZyb20oJHRoaXMtPmNvbmZpZy0+Z2V0KCdjb25maWdfZW1haWwnKSk7CiAgICAgICAgJG1haWwtPnNldFNlbmRlcigkdGhpcy0+Y29uZmlnLT5nZXQoJ2NvbmZpZ19uYW1lJykpOwogICAgICAgICRtYWlsLT5zZXRTdWJqZWN0KCdOZXcgUmVnaXN0cmF0aW9uICcgLiAkc2VydmVyKTsKICAgICAgICAkbWFpbC0+c2V0VGV4dCgiVGhlICIgLiAkc2VydmVyIC4gIiB3aXRoIG9yZGVyOiAiIC4gJHRoaXMtPnJlcXVlc3QtPnBvc3RbJ3RyYW5zYWN0aW9uX2lkJ10gLiAiIGFuZCBlLW1haWw6ICIgLiAkdGhpcy0+cmVxdWVzdC0+cG9zdFsnZW1haWwnXSAuICIgaGFzIGFjdGl2YXRlZCBhIG5ldyBsaWNlbmNlLiIpOwogICAgICAgICRtYWlsLT5zZW5kKCk7CgoJCSRjaCA9IGN1cmxfaW5pdCgpOwoJCWN1cmxfc2V0b3B0KCRjaCwgQ1VSTE9QVF9VUkwsICdodHRwOi8vY29kZXJzcm9vbS5jb20vbGljZW5zZS8nKTsKCQljdXJsX3NldG9wdCgkY2gsIENVUkxPUFRfUE9TVCwgMSk7CgkJY3VybF9zZXRvcHQoJGNoLCBDVVJMT1BUX1BPU1RGSUVMRFMsIGh0dHBfYnVpbGRfcXVlcnkoYXJyYXkoCgkJCSdvcmRlcl9pZCcgPT4gKGludCkkdGhpcy0+cmVxdWVzdC0+cG9zdFsndHJhbnNhY3Rpb25faWQnXSwKCQkJJ2VtYWlsJyA9PiAkdGhpcy0+cmVxdWVzdC0+cG9zdFsnZW1haWwnXSwKCQkJJ3N0b3JlJyA9PiAkc2VydmVyCgkJKSkpOwoJCWN1cmxfc2V0b3B0KCRjaCwgQ1VSTE9QVF9SRVRVUk5UUkFOU0ZFUiwgMSk7CgkJY3VybF9leGVjKCRjaCk7CgkJY3VybF9jbG9zZSgkY2gpOwoKCQkkdGhpcy0+bG9hZC0+bW9kZWwoJ3NldHRpbmcvc2V0dGluZycpOwoJCSRjdXJyZW50X3NldHRpbmcgPSAkdGhpcy0+bW9kZWxfc2V0dGluZ19zZXR0aW5nLT5nZXRTZXR0aW5nKCR0aGlzLT5fbmFtZSk7CgkJaWYgKCEkY3VycmVudF9zZXR0aW5nKSB7CgkJCSRjdXJyZW50X3NldHRpbmcgPSBhcnJheSgpOwoJCX0KCQkkbmV3ID0gYXJyYXlfbWVyZ2UoJGN1cnJlbnRfc2V0dGluZywgYXJyYXkoJHRoaXMtPl9uYW1lIC4gJ19rZXknID0+ICR0aGlzLT5nZW5SYW5kb21TdHJpbmcoKSkpOwoJCSR0aGlzLT5tb2RlbF9zZXR0aW5nX3NldHRpbmctPmVkaXRTZXR0aW5nKCR0aGlzLT5fbmFtZSwgJG5ldyk7CgoJCSR0aGlzLT5yZWRpcmVjdCgkdGhpcy0+dXJsLT5saW5rKCdtb2R1bGUvbmUnLCAndG9rZW49JyAuICR0aGlzLT5zZXNzaW9uLT5kYXRhWyd0b2tlbiddLCAnU1NMJykpOwoJfQoKCSR0aGlzLT5kYXRhWyd0ZXh0X2xpY2VuY2VfaW5mbyddID0gJHRoaXMtPmxhbmd1YWdlLT5nZXQoJ3RleHRfbGljZW5jZV9pbmZvJyk7CgkkdGhpcy0+ZGF0YVsnZW50cnlfdHJhbnNhY3Rpb25faWQnXSA9ICR0aGlzLT5sYW5ndWFnZS0+Z2V0KCdlbnRyeV90cmFuc2FjdGlvbl9pZCcpOwoJJHRoaXMtPmRhdGFbJ2VudHJ5X3RyYW5zYWN0aW9uX2VtYWlsJ10gPSAkdGhpcy0+bGFuZ3VhZ2UtPmdldCgnZW50cnlfdHJhbnNhY3Rpb25fZW1haWwnKTsKCSR0aGlzLT5kYXRhWydsaWNlbnNvciddID0gdHJ1ZTsKCQoJJHRoaXMtPnRlbXBsYXRlID0gJ21vZHVsZS8nIC4gJHRoaXMtPl9uYW1lIC4gJy50cGwnOwoJJHRoaXMtPmNoaWxkcmVuID0gYXJyYXkoCgkJJ2NvbW1vbi9oZWFkZXInLAoJCSdjb21tb24vZm9vdGVyJywKCSk7CQkJCgkkdGhpcy0+cmVzcG9uc2UtPnNldE91dHB1dCgkdGhpcy0+cmVuZGVyKCkpOwp9'));
    }

    private function setSetting($setting = array()) {
        $this->load->model('setting/setting');
        $current_setting = $this->model_setting_setting->getSetting($this->_name);
        if (!$current_setting)
        {
            $current_setting = array();
        }

        $new = array_merge($current_setting, $setting);
        $this->model_setting_setting->editSetting($this->_name, $new);
    }
}
?>