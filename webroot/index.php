<?php 
/**
 * This is a Anax frontcontroller.
 *
 */

// Get environment & autoloader.
require __DIR__.'/config_with_app.php'; 

// Add service
$di->setShared('db', function() {
    $db = new \Anax\Database\CDatabase();
    $db->setOptions(require ANAX_APP_PATH . 'config/database_mysql.php');
    $db->connect();
    return $db;
});

// Use session
$app->session();

// Theme
$app->theme->configure(ANAX_APP_PATH . 'config/theme-wgtotw.php');

// Set url type
$app->url->setUrlType(\Anax\Url\Curl::URL_CLEAN);

// Home route
$app->router->add('', function() use ($app) {

    $app->theme->setTitle("Sista Bossen");
	
    $app->dispatcher->forward([
            'controller' => 'questions',
            'action'     => 'simple',
            'params'     => [5]
        ]);
        
    $app->dispatcher->forward([
            'controller' => 'tags',
            'action'     => 'simple',
            'params'     => [5]
        ]);
        
    $app->dispatcher->forward([
            'controller' => 'users',
            'action'     => 'simple',
            'params'     => [5]
        ]);
    
    $app->views->addString('Home', 'bodyClass')
               ->addString($app->message->getMessage(), 'flash');
});


// Presentation route
$app->router->add('about', function() use ($app) {

    $app->theme->setTitle("Om Sista Bossen");
	
	$content = $app->fileContent->get('about.md');
	$content = $app->textFilter->doFilter($content, 'shortcode, markdown');
	
	$app->views->add('wgtotw/page', [
	    'content' => $content,
	]);
});


// Check for matching routes and dispatch to controller/handler of route
$app->router->handle();

// Navbar
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_wgtotw.php');

// Render the page
$app->theme->render();
