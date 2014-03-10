<?php

class ControllerAselsiAselsi extends Controller {

    public function index() {
        $this -> language -> load('aselsi/aselsi');
        $this -> load -> model('aselsi/aselsi');

        $this -> document -> setTitle($this -> language -> get('heading_title'));
        $this -> data['heading_title'] = $this -> language -> get('heading_title');
        $this -> data['button_add'] = $this -> language -> get('button_add');
        $this -> data['link_add'] = $this -> url -> link('aselsi/aselsi/add', 'token=' . $this -> session -> data['token'], 'SSL');
        $this -> data['missions'] = $this -> model_aselsi_aselsi -> getAll();

        $this -> data['breadcrumbs'] = array();
        $this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('text_home'), 'href' => $this -> url -> link('common/home', 'token=' . $this -> session -> data['token'], 'SSL'), 'separator' => false);
        $this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('heading_title'), 'href' => $this -> url -> link('aselsi/aselsi', 'token=' . $this -> session -> data['token'], 'SSL'), 'separator' => ' :: ');

        $this -> template = 'aselsi/aselsi.tpl';
        $this -> children = array('common/header', 'common/footer');
        $this -> response -> setOutput($this -> render());

    }

    public function add() {
        $this -> language -> load('aselsi/aselsi');

        $this -> data['heading_title'] = $this -> language -> get('heading_title');
        $this -> data['button_save'] = $this -> language -> get('button_save');

        $this -> data['breadcrumbs'] = array();
        $this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('text_home'), 'href' => $this -> url -> link('common/home', 'token=' . $this -> session -> data['token'], 'SSL'), 'separator' => false);
        $this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('heading_title'), 'href' => $this -> url -> link('aselsi/aselsi', 'token=' . $this -> session -> data['token'], 'SSL'), 'separator' => ' :: ');

        $this -> template = 'aselsi/add.tpl';
        $this -> children = array('common/header', 'common/footer');
        $this -> response -> setOutput($this -> render());
    }

    public function insert() {
        $this -> load -> model('aselsi/aselsi');
        $this -> model_aselsi_aselsi -> insert($this -> request -> post);
        header("Location: " . html_entity_decode($this -> url -> link('aselsi/aselsi', 'token=' . $this -> session -> data['token'], 'SSL')));
    }

    public function edit() {
        $this -> language -> load('aselsi/aselsi');
        $this -> load -> model('aselsi/aselsi');

        $mission_id = $this -> request -> get['id'];

        $this -> data['heading_title'] = $this -> language -> get('heading_title');
        $this -> data['button_save'] = $this -> language -> get('button_save');
        $this -> data['mission'] = $this -> model_aselsi_aselsi -> getMission($mission_id);

        $this -> data['breadcrumbs'] = array();
        $this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('text_home'), 'href' => $this -> url -> link('common/home', 'token=' . $this -> session -> data['token'], 'SSL'), 'separator' => false);
        $this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('heading_title'), 'href' => $this -> url -> link('aselsi/aselsi', 'token=' . $this -> session -> data['token'], 'SSL'), 'separator' => ' :: ');

        $this -> template = 'aselsi/edit.tpl';
        $this -> children = array('common/header', 'common/footer');
        $this -> response -> setOutput($this -> render());
    }

    public function update() {
        $this -> load -> model('aselsi/aselsi');
        $this -> model_aselsi_aselsi -> update($this -> request -> post);
        header("Location: " . html_entity_decode($this -> url -> link('aselsi/aselsi', 'token=' . $this -> session -> data['token'], 'SSL')));
    }

    public function delete() {
        $this -> load -> model('aselsi/aselsi');
        $this -> model_aselsi_aselsi -> delete($this -> request -> get['id']);
        header("Location: " . html_entity_decode($this -> url -> link('aselsi/aselsi', 'token=' . $this -> session -> data['token'], 'SSL')));
    }

    function printExtender($array) {
        echo "<pre>";
        print_r($array);
        echo "</pre>";

    }

}
