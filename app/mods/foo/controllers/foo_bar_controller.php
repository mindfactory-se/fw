<?php

class FooBarController extends ModFooController {

    public function index() {
        $model = App::loadModel('foo.bar');
        $model->test();
        $data = array(
            'params' => App::get('router.paramas'),
        );

        $this->set($data);
        $this->render();
    }
}
