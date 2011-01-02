<?php

namespace p12t\apps\foo\controllers;

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
class FooBarController extends \p12t\apps\foo\AppFooController {

    public $vHelpers = array('Form');
    
    public function index() {
        $model = new \p12t\apps\foo\models\FooBarModel($this);
        $this->set(array('items' => $model->index()));
        $this->render();
    }

    public function view($id) {
        $model = new \p12t\apps\foo\models\FooBarModel($this);
        $this->set(array('item' => $model->view($id)));
        $this->render();
    }

    public function add() {
        $model = new \p12t\apps\foo\models\FooBarModel($this);

        if ($this->data) {
            if ($model->validate()) {
                if ($model->add($this->data)) {
                    $this->redirect('/foo/bar/index');
                }
            }

        }
        $this->render();
    }

    public function edit($id) {
        $model = new \p12t\apps\foo\models\FooBarModel($this);

        if ($this->data) {
            if ($model->validate()) {
                if ($model->edit($id)) {
                    $this->redirect('/foo/bar/index');
                }
            }
        }
        $this->data['foo']['bar'] = $model->view($id);
        $this->set(array('id' => $id));
        $this->render();
    }

    public function del($id) {
        $model = new \p12t\apps\foo\models\FooBarModel($this);
        $model->del($id);
        $this->redirect('/foo/bar/index');
    }
}
