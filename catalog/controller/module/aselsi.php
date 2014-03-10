<?php
class ControllerModuleAselsi extends Controller {
    public function index() {
        $this -> language -> load('module/aselsi');
        $this -> load -> model('module/aselsi');

        $this -> data['heading_title'] = $this -> language -> get('heading_title');
        $this -> data['linkAselsi'] = $this -> url -> link('module/aselsi/show');
        $this -> data['textAselsi'] = $this -> language -> get('heading_title');
        $this -> data['textNoAselsi'] = $this -> language -> get('no_aselsi');

        $this -> data['aselsis'] = $this -> model_module_aselsi -> getAselsis();

        $this -> template = 'default/template/module/aselsi.tpl';
        $this -> response -> setOutput($this -> render());
    }

    public function show() {
        $this -> language -> load('module/aselsi');
        $this -> load -> model('module/aselsi');

        $id = $this -> request -> get['uid'];

        $this -> data['aselsi'] = $this -> model_module_aselsi -> getAselsi($id);

        if (!isset($_SESSION['aselsi_page_read' . $id])) {
            $this -> model_module_aselsi -> readed($id);
            $_SESSION['aselsi_page_read' . $id] = TRUE;
        }
        
        $this -> data['breadcrumbs'] = array();
        $this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('text_home'), 'href' => $this -> url -> link('common/home'), 'separator' => FALSE);
        $this -> data['breadcrumbs'][] = array('text' => $this -> language -> get('heading_title'), 'href' => $this -> url -> link('module/aselsi', '', 'SSL'), 'separator' => $this -> language -> get('text_separator'));

        $this -> template = 'default/template/module/aselsi_show.tpl';
        $this -> children = array('common/column_left', 'common/column_right', 'common/content_top', 'common/content_bottom', 'common/footer', 'common/header');

        $this -> response -> setOutput($this -> render());
    }

    private function printExtender($data) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

}
?>