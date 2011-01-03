<?php

namespace p12t\apps\foo;

/**
 * p12t PHP Framework : /app/mods/foo/controllers/foo_bar_controller.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Example app to show file structure and basic usage.
 *
 * @since 0.1.0
 * @access public
 */
class BarController extends AppController {

    public $vHelpers = array('Form');
    
    public function index() {
        $model = new models\BarModel($this);
        $this->set(array('items' => $model->index()));
        $this->render();
    }

    public function view($id) {
        $model = new models\BarModel($this);
        $this->set(array('item' => $model->view($id)));
        $this->render();
    }

    public function add() {
        $model = new models\BarModel($this);

        if ($this->data) {
            if ($model->validate()) {
                if ($model->add($this->data)) {
                    $this->redirect('/foo/bar');
                }
            }

        }
        $this->render();
    }

    public function edit($id) {
        $model = new models\BarModel($this);

        if ($this->data) {
            if ($model->validate()) {
                if ($model->edit($id)) {
                    $this->redirect('/foo/bar');
                }
            }
        }
        $this->data['foo']['bar'] = $model->view($id);
        $this->set(array('id' => $id));
        $this->render();
    }

    public function del($id) {
        $model = new models\BarModel($this);
        $model->del($id);
        $this->redirect('/foo/bar');
    }
}