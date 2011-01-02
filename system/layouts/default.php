<?= $this->html->docType()?>

<html>
    <head>
        <?= $this->html->charset()?>
        
        <?= $this->html->css('reset')?>

        <?= $this->html->css('p12t')?>
        
        <title></title>
    </head>
    <body>
        <div id="page-container">
            <div id="header">
                <?= $this->html->a('/', $this->html->img('p12t/logo.png', 'p12t logo'))?>

            </div>
            <div id="nav-top-container">
                <div id="nav-top">

                </div>
                <div id="nav-breadcrump">
                    <? $this->html->a('/', 'Home'); ?>
                </div>
            </div>
            <div id="main-container">
                <div id="nav-left-container">
                    <div class="colum-header"></div>
                    <div id="nav-left">
                        <ul>
                            <li>Item 1</li>
                            <li>Item 2</li>
                            <li>Item 3</li>
                            <li>Item 4</li>
                            <li>Item 5</li>
                        </ul>
                    </div>
                </div>
                <?= $content; ?>

            </div>
            <div id="footer" style="clear: both">
                Footer
            </div>
        </div>
    </body>
</html>