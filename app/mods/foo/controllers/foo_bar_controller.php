<?php

class FooBarController extends ModFooController {

    public function index() {
        $model = App::loadModel('foo.bar');
        $model->test();
        $data = array(
            'params' => 'testing',
        );

        $this->set($data);
        $this->render();
    }
}
