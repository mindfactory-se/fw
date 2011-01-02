<p>
    <?= $this->form->create('foo/bar/edit/' . $id); ?>

    <p>Title: <?= $this->form->text('foo.bar.title'); ?></p>
    <p>
        Text:<br />
        <?= $this->form->textarea('foo.bar.text'); ?>

    </p>
    <p>
        <?= $this->form->submit('Submit'); ?>

        <?= $this->form->reset('Reset'); ?>
    </p>
    <?= $this->form->end() ?>

</p>