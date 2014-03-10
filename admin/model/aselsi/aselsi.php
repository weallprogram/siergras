<?php

class ModelAselsiAselsi extends Model {

    public function getAll() {
        $get = "SELECT `id`, `title`, `msg`, `sort`, `status`, `visited` FROM `" . DB_PREFIX . "aselsi`";
        $result = $this -> db -> query($get);
        return $result -> rows;
    }

    public function getMission($id) {
        $get = "SELECT `id`, `title`, `msg`, `sort`, `status`, `visited` FROM `" . DB_PREFIX . "aselsi` WHERE `id` = " . $id;
        $result = $this -> db -> query($get);
        return $result -> row;
    }

    public function insert($data) {
        $insert = "INSERT INTO `" . DB_PREFIX . "aselsi` (`title`, `msg`, `sort`, `status`) VALUES ('" . $data['title'] . "', '" . $data['msg'] . "', '" . $data['sort'] . "', '" . $data['status'] . "') ";
        $this -> db -> query($insert);
    }

    public function update($data) {
        $update = "UPDATE `" . DB_PREFIX . "aselsi` SET `title` = '" . $data['title'] . "', `msg` = '" . $data['msg'] . "', `sort` = " . $data['sort'] . ", `status` = " . $data['status'] . " WHERE `id` = " . $data['id'];
        $this -> db -> query($update);
    }

    public function delete($id) {
        $delete = "DELETE FROM `" . DB_PREFIX . "aselsi` WHERE `id` = " . $id;
        $this -> db -> query($delete);
    }

}
