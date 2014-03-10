<?php
//-----------------------------------------------------
// Newsletter Enhancements for Opencart
// Created by @DmitryNek (Dmitry Shkolyar)
// exmail.Nek@gmail.com
//-----------------------------------------------------

class ModelNeNewsletter extends Model {

    public function send($data) {

        require_once(DIR_SYSTEM . 'library/mail_ne.php');

        $message  = '<html dir="ltr" lang="en">' . PHP_EOL;
        $message .= '<head>' . PHP_EOL;
        $message .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . PHP_EOL;
        $message .= '<title>' . $data['subject'] . '</title>' . PHP_EOL;
        if (!empty($data['custom_css'])) {
            $message .= html_entity_decode($data['custom_css'], ENT_COMPAT, 'UTF-8') . PHP_EOL;
        }
        $message .= '</head>' . PHP_EOL;
        $message .= '<body style="padding:0;margin:0;">' . html_entity_decode($data['message'], ENT_COMPAT, 'UTF-8') . '</body>' . PHP_EOL;
        $message .= '</html>' . PHP_EOL;

        $message = str_replace(array(chr(3), '&'), array('', '&amp;'), $message);

        $newsletter_id = (int)$data['newsletter_id'];

        $attachments = array();
        $attachments_count = count($data['attachments_upload']);

        if ($newsletter_id && $attachments_count && $data['attachments_count']) {
            for ($i=0; $i < $attachments_count; $i++) {
                if (is_uploaded_file($data['attachments_upload']['attachment_'.$i]['tmp_name'])) {
                    $filename = $data['attachments_upload']['attachment_'.$i]['name'];

                    $path = dirname(DIR_DOWNLOAD) . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . $newsletter_id;

                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }

                    if (is_dir($path)) {
                        move_uploaded_file($data['attachments_upload']['attachment_'.$i]['tmp_name'], $path . DIRECTORY_SEPARATOR . $filename);
                    }

                    if (file_exists($path . DIRECTORY_SEPARATOR . $filename)) {
                        $attachments[] = array(
                            'filename' => $filename,
                            'path'     => $path . DIRECTORY_SEPARATOR . $filename
                        );
                    }
                }
            }
        }

        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $store_url = (defined('HTTPS_CATALOG') ? HTTPS_CATALOG : HTTP_CATALOG);
        } else {
            $store_url = HTTP_CATALOG;
        }

        if (isset($data['store_id']) && $data['store_id'] > 0) {
            $this->load->model('setting/store');
            $store = $this->model_setting_store->getStore($this->request->post['store_id']);
            if ($store) {
                $url = rtrim($store['url'], '/') . '/';
            } else {
                $url = $store_url;
            }
        } else {
            $url = $store_url;
        }

        libxml_use_internal_errors(true);
        $dom = new DOMDocument;
        $dom->loadHTML($message);
        foreach ($dom->getElementsByTagName('a') as $node) {
            if ($node->hasAttribute('href')) {
                $link = $node->getAttribute('href');
                if ((strpos($link, 'http://') === 0) || (strpos($link, 'https://') === 0)) {
                    $add_key = ((strpos($link, '{key}') !== false) || (strpos($link, '%7Bkey%7D') !== false));
                    $node->setAttribute('href', $url . 'index.php?route=ne/track/click&amp;link=' . urlencode(base64_encode($link)) . '&amp;uid={uid}&amp;language=' . $data['language_code'] . ($add_key ? '&amp;key={key}' : ''));
                }
            }
        }

        if ($this->config->get('ne_embedded_images')) {
            if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
                $server = defined('HTTPS_IMAGE') ? HTTPS_IMAGE : HTTPS_SERVER . 'image/';
            } else {
                $server = defined('HTTP_IMAGE') ? HTTP_IMAGE : HTTP_SERVER . 'image/';
            }

            foreach ($dom->getElementsByTagName('img') as $node) {
                if ($node->hasAttribute('src')) {
                    $src = $node->getAttribute('src');
                    $src = str_replace($server, DIR_IMAGE, $src);
                    $node->setAttribute('src', $this->base64_encode_image($src));
                }
            }
        }

        $message = $dom->saveHTML();
        libxml_clear_errors();

        $message .= '<div><img width="0" height="0" alt="" src="' . $url . 'index.php?route=ne/track/gif&amp;uid={uid}" /></div>';

        $this->load->model('setting/store');

        $store_info = $this->model_setting_store->getStore($data['store_id']);
        if ($store_info) {
            $store_name = $store_info['name'];
        } else {
            $store_name = $this->config->get('config_name');
        }

        $this->load->model('setting/setting');
        $store_info = $this->model_setting_setting->getSetting('config', $data['store_id']);

        foreach ($data['emails'] as $email => $info) {

            if ($this->config->get('ne_throttle') && $email != 'check@isnotspam.com' && $newsletter_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "ne_queue SET email = '" . $this->db->escape($email) . "', firstname = '" . $this->db->escape($info['firstname']) . "', lastname = '" . $this->db->escape($info['lastname']) . "', history_id = '" . $this->db->escape($newsletter_id) . "'");
                continue;
            }

            $mail = new Mail_NE();
            if ($this->config->get('ne_use_smtp')) {
                $mail_config = $this->config->get('ne_smtp');
                $mail->protocol = $mail_config[$data['store_id']]['protocol'];
                $mail->parameter = $mail_config[$data['store_id']]['parameter'];
                $mail->hostname = $mail_config[$data['store_id']]['host'];
                $mail->username = $mail_config[$data['store_id']]['username'];
                $mail->password = $mail_config[$data['store_id']]['password'];
                $mail->port = $mail_config[$data['store_id']]['port'];
                $mail->timeout = $mail_config[$data['store_id']]['timeout'];
                $mail->setFrom($mail_config[$data['store_id']]['email']);
            } else {
                $mail->protocol = $this->config->get('config_mail_protocol');
                $mail->parameter = $this->config->get('config_mail_parameter');
                $mail->hostname = $this->config->get('config_smtp_host');
                $mail->username = $this->config->get('config_smtp_username');
                $mail->password = $this->config->get('config_smtp_password');
                $mail->port = $this->config->get('config_smtp_port');
                $mail->timeout = $this->config->get('config_smtp_timeout');
                $mail->setFrom($store_info['config_email']);
            }
            $mail->setTo($email);
            if ($this->config->get('ne_bounce')) {
                $mail->setReturn($this->config->get('ne_bounce_email'));
            }
            $mail->setSender($store_name);

            foreach ($attachments as $attachment) {
                $mail->addAttachment($attachment['path'], $attachment['filename']);
            }

            $subject_to_send = $data['subject'];
            $message_to_send = str_replace(array('{key}', '%7Bkey%7D'), md5($this->config->get('ne_key') . $email), $message);

            if ($info) {
                $firstname = mb_convert_case($info['firstname'], MB_CASE_TITLE, 'UTF-8');
                $lastname = mb_convert_case($info['lastname'], MB_CASE_TITLE, 'UTF-8');

                $subject_to_send = str_replace(array('{name}', '{lastname}', '{email}'), array($firstname, $lastname, $email), $subject_to_send);
                $message_to_send = str_replace(array('{name}', '{lastname}', '{email}'), array($firstname, $lastname, $email), $message_to_send);

                if (isset($info['reward'])) {
                    $subject_to_send = str_replace('{reward}', $info['reward'], $subject_to_send);
                    $message_to_send = str_replace('{reward}', $info['reward'], $message_to_send);
                }
            }

            if ($newsletter_id) {
                $this->db->query("INSERT IGNORE INTO " . DB_PREFIX . "ne_stats_personal SET history_id = '" . (int)$newsletter_id . "', email = '" . $this->db->escape($email) . "', views = '0'");
                $personal_id = $this->db->getLastId();

                if (!$personal_id) {
                    $personal_id = $this->db->query("SELECT stats_personal_id FROM " . DB_PREFIX . "ne_stats_personal WHERE history_id = '" . (int)$newsletter_id . "' AND email = '" . $this->db->escape($email) . "'")->row;
                    if ($personal_id) {
                        $personal_id = $personal_id['stats_personal_id'];
                    }
                }

                if ($personal_id) {
                    $uid = urlencode(base64_encode($email . '|' . $personal_id));
                    $message_to_send = str_replace(array('{uid}', '%7Buid%7D'), $uid, $message_to_send);
                    $mail->addHeader('X-NEMail', $uid);
                }
            }

            $message_to_send = html_entity_decode($message_to_send, ENT_QUOTES, 'UTF-8');
            $mail->setSubject($subject_to_send);

            if ($data['text_message_products']) {
                $data['text_message'] .= (PHP_EOL . PHP_EOL . $url . 'index.php?route=ne/show&uid=' . (isset($uid) ? $uid : ''));
            }
            if ($data['text_message']) {
                $mail->setText($data['text_message']);
            }

            $mail->setHtml($message_to_send);

            $send_ok = $mail->send();

            $reties = (int)$this->config->get('ne_sent_retries');
            while (!$send_ok && $reties) {
                $send_ok = $mail->send();
                $reties--;
            }

            if (!$send_ok) {
                $this->db->query("UPDATE " . DB_PREFIX . "ne_stats_personal SET `success` = '0' WHERE stats_personal_id = '" . (int)$personal_id . "'");
            }
        }
    }

    public function addHistory($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "ne_history SET `to` = '" . $this->db->escape($data['to']) . "', public_id = '" . $this->db->escape(md5($data['subject'] . time())). "', store_id = '" . (int)$data['store_id'] . "', template_id = '" . (int)$data['template_id'] . "', language_id = '" . (int)$data['language_id'] . "', subject = '" . $this->db->escape($data['subject']) . "', message = '" . $this->db->escape($data['message']) . "', text_message = '" . $this->db->escape($data['text_message']) . "', text_message_products = '" . (int)$data['text_message_products'] . "'");
        return $this->db->getLastId();
    }

    public function addHistoryQueue($newsletter_id, $data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "ne_stats SET history_id = '" . $this->db->escape($newsletter_id) . "', queue = '" . (int)$data['queue'] . "', recipients = '" . (int)$data['recipients'] . "', views = '0'");
    }

    private function base64_encode_image($image) {
        if (file_exists($image)) {
            $filename = htmlentities($image);
        } else {
            return '';
        }

        $imgtype = array('jpg' => 'jpeg', 'jpeg' => 'jpeg', 'gif' => 'gif', 'png' => 'png');

        $filetype = pathinfo($filename, PATHINFO_EXTENSION);

        if (array_key_exists($filetype, $imgtype)) {
            $imgbinary = fread(fopen($filename, "r"), filesize($filename));
        } else {
            return '';
        }

        return 'data:image/' . $imgtype[$filetype] . ';base64,' . base64_encode($imgbinary);
    }

    public function getEmailsByProductsOrdered($products) {
        $implode = array();

        foreach ($products as $product_id) {
            $implode[] = "op.product_id = '" . $product_id . "'";
        }

        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id) LEFT JOIN " . DB_PREFIX . "ne_language_map lm ON (o.email = lm.c_email) WHERE (" . implode(" OR ", $implode) . ") AND o.order_status_id <> '0' AND NOT EXISTS (SELECT 1 FROM " . DB_PREFIX . "ne_blacklist bl WHERE bl.email = o.email) GROUP BY o.email");

        return $query->rows;
    }

    public function checkBounced() {
        if ($this->config->get('ne_bounce') && $this->config->get('ne_bounce_email') && $this->config->get('ne_bounce_pop3_server') && $this->config->get('ne_bounce_pop3_user') && $this->config->get('ne_bounce_pop3_password')) {
            require_once(DIR_SYSTEM . 'library/pop3_ne.php');
            $pop3 = new POP3();

            if (!@$pop3->connect($this->config->get('ne_bounce_pop3_server'), $this->config->get('ne_bounce_pop3_port') ? $this->config->get('ne_bounce_pop3_port') : 110) || !$pop3->user($this->config->get('ne_bounce_pop3_user')))
                return false;

            $count = @$pop3->pass($this->config->get('ne_bounce_pop3_password'));

            if (false === $count)
                return false;

            if (0 === $count) {
                $pop3->quit();
                return false;
            }

            for ($i = 1; $i <= $count; $i++) {
                $message = $pop3->get($i);

                foreach ($message as $line) {
                    if (preg_match('/X-NEMail: /i', $line)) {
                        $hash = trim(str_replace('X-NEMail: ', '', $line));
                    }
                }

                if (isset($hash) && $hash) {
                    $hash = base64_decode(urldecode($hash));
                    $test = explode('|', $hash);
                    if (count($test) == 2) {
                        $data = array(
                            'uid' => $test[1],
                            'email' => $test[0],
                        );
                        $query = $this->db->query("UPDATE `" . DB_PREFIX . "ne_stats_personal` SET bounced = '1' WHERE stats_personal_id = '" . (int)$data['uid'] . "' AND email = '" . $this->db->escape($data['email']) . "'");
                        if ($query) {
                            $pop3->delete($i);
                        } else {
                            $pop3->reset();
                        }
                    }
                }else {
                    if ($this->config->get('ne_bounce_delete')) {
                        $pop3->delete($i);
                    }
                }
            }
            $pop3->quit();
        }
    }

    public function getRecipientsWithRewardPoints($data = array()) {
        $sql = "SELECT c.customer_id, c.firstname, c.lastname, c.email, cr.points FROM `" . DB_PREFIX . "customer` AS c INNER JOIN (SELECT customer_id, SUM(points) AS points FROM " . DB_PREFIX . "customer_reward GROUP BY customer_id) AS cr ON cr.customer_id = c.customer_id AND cr.points > '0' LEFT JOIN " . DB_PREFIX . "ne_language_map lm ON c.email = lm.c_email WHERE NOT EXISTS (SELECT 1 FROM " . DB_PREFIX . "ne_blacklist bl WHERE bl.email = c.email)";

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getSubscribedRecipientsWithRewardPoints($data = array()) {
        $sql = "SELECT c.customer_id, c.firstname, c.lastname, c.email, cr.points FROM `" . DB_PREFIX . "customer` AS c INNER JOIN (SELECT customer_id, SUM(points) AS points FROM " . DB_PREFIX . "customer_reward GROUP BY customer_id) AS cr ON cr.customer_id = c.customer_id AND cr.points > '0' LEFT JOIN " . DB_PREFIX . "ne_language_map lm ON c.email = lm.c_email WHERE c.newsletter = '1' AND NOT EXISTS (SELECT 1 FROM " . DB_PREFIX . "ne_blacklist bl WHERE bl.email = c.email)";

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getCustomers($data = array()) {
        $sql = "SELECT *, CONCAT(c.firstname, ' ', c.lastname) AS name, cgd.name AS customer_group FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (c.customer_group_id = cgd.customer_group_id) LEFT JOIN " . DB_PREFIX . "ne_language_map lm ON c.email = lm.c_email WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

        $implode = array();

        if (!empty($data['filter_name'])) {
            $implode[] = "CONCAT(c.firstname, ' ', c.lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
        }

        if (!empty($data['filter_email'])) {
            $implode[] = "c.email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
        }

        if (isset($data['filter_newsletter']) && !is_null($data['filter_newsletter'])) {
            $implode[] = "c.newsletter = '" . (int)$data['filter_newsletter'] . "'";
        }

        if (!empty($data['filter_customer_group_id'])) {
            $implode[] = "c.customer_group_id = '" . (int)$data['filter_customer_group_id'] . "'";
        }

        if (!empty($data['filter_ip'])) {
            $implode[] = "c.customer_id IN (SELECT customer_id FROM " . DB_PREFIX . "customer_ip WHERE ip = '" . $this->db->escape($data['filter_ip']) . "')";
        }

        if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
            $implode[] = "c.status = '" . (int)$data['filter_status'] . "'";
        }

        if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
            $implode[] = "c.approved = '" . (int)$data['filter_approved'] . "'";
        }

        if (!empty($data['filter_date_added'])) {
            $implode[] = "DATE(c.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
        }

        $implode[] = "NOT EXISTS (SELECT 1 FROM " . DB_PREFIX . "ne_blacklist bl WHERE bl.email = c.email)";

        if ($implode) {
            $sql .= " AND " . implode(" AND ", $implode);
        }

        $sort_data = array(
            'name',
            'c.email',
            'customer_group',
            'c.status',
            'c.approved',
            'c.ip',
            'c.date_added'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY name";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getCustomer($customer_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "ne_language_map lm ON c.email = lm.c_email WHERE c.customer_id = '" . (int)$customer_id . "' AND NOT EXISTS (SELECT 1 FROM " . DB_PREFIX . "ne_blacklist bl WHERE bl.email = c.email)");

        return $query->row;
    }

    public function getAffiliates($data = array()) {
        $sql = "SELECT *, CONCAT(a.firstname, ' ', a.lastname) AS name, (SELECT SUM(at.amount) FROM " . DB_PREFIX . "affiliate_transaction at WHERE at.affiliate_id = a.affiliate_id GROUP BY at.affiliate_id) AS balance FROM " . DB_PREFIX . "affiliate a LEFT JOIN " . DB_PREFIX . "ne_language_map lm ON a.email = lm.c_email";

        $implode = array();

        if (!empty($data['filter_name'])) {
            $implode[] = "CONCAT(a.firstname, ' ', a.lastname) LIKE '" . $this->db->escape($data['filter_name']) . "%'";
        }

        if (!empty($data['filter_email'])) {
            $implode[] = "LCASE(a.email) = '" . $this->db->escape(utf8_strtolower($data['filter_email'])) . "'";
        }

        if (!empty($data['filter_code'])) {
            $implode[] = "a.code = '" . $this->db->escape($data['filter_code']) . "'";
        }

        if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
            $implode[] = "a.status = '" . (int)$data['filter_status'] . "'";
        }

        if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
            $implode[] = "a.approved = '" . (int)$data['filter_approved'] . "'";
        }

        if (!empty($data['filter_date_added'])) {
            $implode[] = "DATE(a.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
        }

        $implode[] = "NOT EXISTS (SELECT 1 FROM " . DB_PREFIX . "ne_blacklist bl WHERE bl.email = a.email)";

        if ($implode) {
            $sql .= " WHERE " . implode(" AND ", $implode);
        }

        $sort_data = array(
            'name',
            'a.email',
            'a.code',
            'a.status',
            'a.approved',
            'a.date_added'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY name";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getAffiliate($affiliate_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "affiliate a LEFT JOIN " . DB_PREFIX . "ne_language_map lm ON a.email = lm.c_email WHERE affiliate_id = '" . (int)$affiliate_id . "' AND NOT EXISTS (SELECT 1 FROM " . DB_PREFIX . "ne_blacklist bl WHERE bl.email = a.email)");

        return $query->row;
    }

}

?>