<?php
    $param = App::get('route.params');
    $param = str_replace('.', '/', $param[0]);
?>
<h1>404 Error: 'File not found'</h1>
<p>The URL <?php echo Html::a($param, $param) ?> that you requested could not be found.</p>
<p>Try som of the following alternatives:</p>
    <ul>
        <li><?php echo Html::a('/', 'Startpage');?></li>
    </ul>