<p><pre>
    <?php print_r($msg) ?>
</pre>
    <?= $this->form->create('foo/bar/index', array('test'=>'yahh')); ?>
    
    <p>Title: <?= $this->form->text('foo.bar.title'); ?><p />
    <p>
        Text:
        <?= $this->form->textarea('foo.bar.text'); ?>
    
    <p />
    <p>
        <?= $this->form->select('foo.bar.select', array('L1'=>'V1', 'L2'=>'V2', 'L3'=>'V3'), true) ?>
    </p>
    <p>
        <?= $this->form->submit('Submit'); ?>

        <?= $this->form->reset('Reset'); ?>
    </p>

    <?= $this->form->end() ?>

</p>