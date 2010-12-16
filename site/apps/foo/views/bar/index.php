<p><pre>
    <?php print_r($msg) ?>
</pre>
    <?= Form::create('foo/bar/index', array('test'=>'yahh')); ?>
    
    <p>Title: <?= Form::text('foo.bar.title'); ?><p />
    <p>
        Text:
        <?= Form::textarea('foo.bar.text'); ?>
    
    <p />
    <p>
        <?= Form::submit('Submit'); ?>

        <?= Form::reset('Reset'); ?>
    </p>

    <?= Form::end() ?>

</p>