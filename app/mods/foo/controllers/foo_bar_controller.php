<?php

class FooBarController extends ModFooController {

    public function index() {
        $fooBar = App::loadModel('foo.bar');
        $this->set(array('msg' => $fooBar->index()));
        $this->render();
    }
}
