<?php

namespace p12t\apps\foo\models;

/**
 * p12t PHP Framework : /app/mods/foo/controllers/foo_bar_model.php
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
class FooBarModel extends \p12t\apps\foo\AppFooModel {

    public $validation = array(
        'foo.bar.title' => array(
            'notEmpty' => array('Title could not be empty.'),
        ),
        'foo.bar.text' => array(
            'notEmpty' => array('Text could not be empty.'),
        ),
    );

    public function index() {
        $db = \p12t\core\db::getInstance();
        return $db->query('SELECT * FROM foo_bar');
    }

    public function view($id) {
        $db = \p12t\core\db::getInstance();
        $sql = \sprintf("SELECT * FROM foo_bar WHERE id='%d'", $id);
        return $db->query($sql)->fetch();
    }

    public function add() {
        $db = \p12t\core\db::getInstance();
        $sql = \sprintf("INSERT INTO foo_bar (title, text) VALUES('%s', '%s')",
                $this->data['foo']['bar']['title'],
                $this->data['foo']['bar']['text']);
        return $db->exec($sql) or die(print_r($db->errorInfo(), true));
    }

    public function edit($id) {
        $db = \p12t\core\db::getInstance();
        $sql = \sprintf("UPDATE foo_bar SET title='%s', text='%s' WHERE id=%d",
                $this->data['foo']['bar']['title'],
                $this->data['foo']['bar']['text'],
                $id);
        return $db->exec($sql) or die(print_r($db->errorInfo(), true));
    }

    public function del($id) {
        $db = \p12t\core\db::getInstance();
        $sql = \sprintf("DELETE FROM foo_bar WHERE id=%d", $id);
        return $db->exec($sql) or die(print_r($db->errorInfo(), true));
    }
}