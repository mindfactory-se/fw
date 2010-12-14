<?php

/**
 * p12t PHP Framework : /app/settings/router.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @since 0.1.0
 */

// Default mod route like
// Router::SetInOrder('^/modName/?$', '/modName/controllerName/actionName');
Router::set('^/foo/?$', '/foo/bar/index');
Router::set('^/cms/?$', '/cms/file/view/home');

// Route for cms mod
Router::set('^/cms/file/?$', '/cms/file/view/home');
Router::set('^/cms/file/([/a-z0-9_]*)$', '/cms/file/view/$1');
Router::set('^/cms/db/([0-9]*)$', '/cms/db/view/$1');
Router::set('^/cms/db/?$', '/cms/db/view/1');

// Default action
Router::set('^/ ([a-z0-9_]*)/([a-z0-9_]*)/?$', '/$1/$2/index');

// Default route
Router::set('^/$', '/cms/file/view/home');

Router::set('^/([a-z0-9_]*)/([a-z0-9_]*)/([a-z0-9_]*)([/a-z0-9_]*)$', '/$1/$2/$3$4');

Router::set('^(.*)$', '$1');