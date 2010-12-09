<?php

/**
 * p12t PHP Framework : /app/settings/router.php
 *
 * @package p12t
 * @author hepper
 * @copyright Copyright (c) 2010, Henrik Persson, Pay if you like it
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

// Default mod route like
// Router::SetInOrder('^/modName/?$', '/modName/controllerName/actionName');
Router::set('^/blog/?$', '/blog/posts/index');
Router::set('^/foo/?$', '/foo/bar/index');

// Route for cms mod
Router::set('^/cms/static/([a-z0-9/]+)', '/cms/static/view/$1');
Router::set('^/cms/static/?$', '/cms/static/view/home');
Router::set('^/cms/?$', '/cms/static/view/home');
Router::set('^/([a-z0-9]+)/([a-z0-9]+)/([a-z0-9/]+)', '/$1/$2/$3');

// Default action
Router::set('^/([a-z0-9]+)/([a-z0-9]+)/?$', '/$1/$2/index');

// Default route
Router::set('^/$', '/cms/static/view/home');

Router::set('^(.*)$', '$1');