<?php
//-----------------------------------------------------
// Newsletter Enhancements for Opencart
// Created by @DmitryNek (Dmitry Shkolyar)
// exmail.Nek@gmail.com
//-----------------------------------------------------

class ModelModuleNe extends Model {

    public function subscribe($data, $salt, $list = array()) {
        if (!isset($data['lastname'])) {
            $data['lastname'] = '';
        }

        if (!isset($data['name'])) {
            $data['name'] = '';
        }

        $this->db->query("INSERT INTO " . DB_PREFIX . "ne_marketing SET email = '" . $this->db->escape($data['email']) . "', firstname = '" . $this->db->escape($data['name']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', code = '" . $this->db->escape(md5($salt . $data['email'])) . "', store_id = '" . (int)$this->config->get('config_store_id') . "', subscribed = 1 ON DUPLICATE KEY UPDATE subscribed = 1, firstname = '" . $this->db->escape($data['name']) . "', lastname = '" . $this->db->escape($data['lastname']) . "'");
        if ($this->db->countAffected() > 0) {
            if ($list) {
                $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ne_marketing WHERE email = '" . $this->db->escape($data['email']) . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");
                $this->db->query("DELETE FROM " . DB_PREFIX . "ne_marketing_to_list WHERE marketing_id = '" . (int)$query->row['marketing_id'] . "'");
                foreach ($list as $id) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "ne_marketing_to_list SET marketing_id = '" . (int)$query->row['marketing_id'] . "', marketing_list_id = '" . (int)$id . "'");
                }
            }
            return true;
        }

        return false;
    }

    public function getSubscribeBox($subscribe_box_id) {
        $subscribe_box_info = $this->cache->get('ne_subscribe_box.' . (int)$subscribe_box_id);
        if (!$subscribe_box_info) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ne_subscribe_box WHERE subscribe_box_id = '" . (int)$subscribe_box_id . "'");
            if ($query->row) {
                $subscribe_box_info = array_merge($query->row, unserialize($query->row['data']));
                unset($subscribe_box_info['data']);
                $this->cache->set('ne_subscribe_box.' . (int)$subscribe_box_id, $subscribe_box_info);
            } else {
                return false;
            }
        }
        return $subscribe_box_info;
    }
}

?>