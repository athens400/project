<?php 
/**
 * This is a Anax frontcontroller.
 *
 */

// Get environment & autoloader.
require __DIR__.'/config_with_app.php'; 

// Add package as service
$di->setShared('db', function() {
    $db = new \Mos\Database\CDatabaseBasic();
    $db->setOptions(require ANAX_APP_PATH . 'config/database_sqlite.php');
    $db->connect();
    return $db;
});

// Theme
$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');

// Set url type
$app->url->setUrlType(\Anax\Url\Curl::URL_CLEAN);

// Home route
$app->router->add('', function() use ($app) {

    $app->theme->setTitle("database");
	
	$app->views->add('grid/page', ['content' => 'text'], 'main');

});

$app->router->add('setup', function() use ($app) {
 
    //$app->db->setVerbose();
 
    $app->db->dropTableIfExists('user')->execute();
 
    $app->db->createTable(
        'user',
        [
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'acronym' => ['varchar(20)', 'unique', 'not null'],
            'email' => ['varchar(80)'],
            'name' => ['varchar(80)'],
            'password' => ['varchar(255)'],
            'created' => ['datetime'],
            'updated' => ['datetime'],
            'deleted' => ['datetime'],
            'active' => ['datetime'],
        ]
    )->execute();
});

// View source route
$app->router->add('source', function() use ($app) {
	
	$app->theme->addStylesheet('css/source_me.css');
	$app->theme->setTitle("Källkod");
	
	$source = new \Mos\Source\CSource([
	    'secure_dir' => '..',
		'base_dir' => '..',
		'add_ignore' => ['.htaccess'],
	]);
	
	$app->views->add('me/source', [
	    'content' => $source->View(),
	]);
	
});



// Check for matching routes and dispatch to controller/handler of route
$app->router->handle();

// Navbar
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');

// Render the page
$app->theme->render();
