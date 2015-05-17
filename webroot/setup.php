<?php 
/**
 * This is a Anax frontcontroller.
 *
 */

// Get environment & autoloader.
require __DIR__.'/config_with_app.php'; 

// Add service
$di->setShared('db', function() {
    $db = new \Mos\Database\CDatabaseBasic();
    $db->setOptions(require ANAX_APP_PATH . 'config/database_mysql.php');
    $db->connect();
    return $db;
});

// Theme
$app->theme->configure(ANAX_APP_PATH . 'config/theme-wgtotw.php');

// Set url type
$app->url->setUrlType(\Anax\Url\Curl::URL_CLEAN);


// Setup
$app->router->add('', function() use ($app) {
 
    $app->theme->setTitle("Setup");
 
    $app->db->dropTableIfExists('question2tag')->execute();
    $app->db->dropTableIfExists('tag')->execute();
    $app->db->dropTableIfExists('user')->execute();
    $app->db->dropTableIfExists('comment')->execute();
    $app->db->dropTableIfExists('answer')->execute();
    $app->db->dropTableIfExists('question')->execute();
    
    $app->views->add('grid/page', ['content' => 'Databasen är återställd'], 'main');
    
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
    
    $app->db->insert(
        'user',
        ['acronym', 'email', 'name', 'password', 'created', 'active']
    );
 
    $now = gmdate('Y-m-d H:i:s');
 
    $app->db->execute([
        'admin',
        'admin@dbwebb.se',
        'Administrator',
        password_hash('admin', PASSWORD_DEFAULT),
        $now,
        $now
    ]);
 
    $app->db->execute([
        'doe',
        'doe@dbwebb.se',
        'John/Jane Doe',
        password_hash('doe', PASSWORD_DEFAULT),
        $now,
        $now
    ]);
 
    $app->db->createTable(
        'comment',
        [
            'id'        => ['integer', 'primary key', 'not null', 'auto_increment'],
            'qId'     => ['integer'],
            'aId'       => ['integer'],
            'text'      => ['text', 'not null'],
            'userId'    => ['integer'],
            'created'   => ['datetime'],
            'rank'      => ['integer'],
        ]
    )->execute();
	
	$app->db->insert(
        'comment',
        ['qId', 'aId', 'text', 'userId', 'created']
    );
 
    $now = gmdate('Y-m-d H:i:s');
 
    $app->db->execute([
        1,
        0,
        'kommentar till fråga 1',
        1,
        $now
    ]);
    
    $app->db->execute([
        1,
        0,
        'kommentar 2 till fråga 1',
        1,
        $now
    ]);
 
    $app->db->execute([
        2,
        0,
        'kommentar till fråga 2',
        2,
        $now
    ]);
    
    $app->db->execute([
        1,
        1,
        'kommentar till svar 1 (fråga1?)',
        2,
        $now
    ]);
    
    $app->db->execute([
        1,
        2,
        'kommentar till svar 2 (fråga1?)',
        2,
        $now
    ]);
    
    $app->db->createTable(
        'question',
        [
            'id'        => ['integer', 'primary key', 'not null', 'auto_increment'],
            'title'     => ['varchar(100)'],
            'text'      => ['text', 'not null'],
            'userId'    => ['integer'],
            'created'   => ['datetime'],
            'rank'      => ['integer'],
        ]
    )->execute();
    
    $app->db->insert(
        'question',
        ['title', 'text', 'userId', 'created']
    );
 
    $now = gmdate('Y-m-d H:i:s');
 
    $app->db->execute([
        'testfråga1',
        'testfråga',
        1,
        $now
    ]);
    
    $app->db->execute([
        'testfråga2',
        'testfråga',
        2,
        $now
    ]);
    
    $app->db->execute([
        'testfråga3',
        'testfråga',
        2,
        $now
    ]);
    
    $app->db->execute([
        'testfråga4',
        'testfråga',
        2,
        $now
    ]);
    
    $app->db->execute([
        'testfråga5',
        'testfråga',
        2,
        $now
    ]);
    
    $app->db->execute([
        'testfråga6',
        'testfråga',
        2,
        $now
    ]);
    
    $app->db->execute([
        'testfråga7',
        'testfråga',
        2,
        $now
    ]);
    
    $app->db->execute([
        'testfråga8',
        'testfråga',
        2,
        $now
    ]);
    
    $app->db->execute([
        'testfråga9',
        'testfråga',
        2,
        $now
    ]);
    
    $app->db->execute([
        'Varför säger han i Zelda 2 att han heter ERROR?',
        'Jättekonstig bugg i Zelda 2, en kille säger I AM ERROR. Nån som vet något mer om det?',
        2,
        $now
    ]);
    
    $app->db->execute([
        'Hur klarar man sista bossen i Ninja Gaiden?',
        'Jag fattar inte. Jag försöker och försöker men har ingen chans att klara mig mer än några sekunder. Har ni några tips för att klara sista bossen i Ninja Gaiden?',
        2,
        $now
    ]);
    
    $app->db->createTable(
        'answer',
        [
            'id'        => ['integer', 'primary key', 'not null', 'auto_increment'],
            'qId'       => ['integer'],
            'text'      => ['text', 'not null'],
            'userId'    => ['integer'],
            'created'   => ['datetime'],
            'rank'      => ['integer'],
        ]
    )->execute();
    
    $app->db->insert(
        'answer',
        ['qId', 'text', 'userId', 'created']
    );
 
    $now = gmdate('Y-m-d H:i:s');
    
    $app->db->execute([
        1,
        'svar till fråga 1',
        1,
        $now
    ]);
    
    $app->db->execute([
        1,
        'svar 2 till fråga 1',
        2,
        $now
    ]);
    
    $app->db->execute([
        2,
        'svar till fråga 2',
        2,
        $now
    ]);
    
    $app->db->execute([
        2,
        'svar till fråga 2',
        2,
        $now
    ]);
    
    $app->db->execute([
        3,
        'svar till fråga 3',
        2,
        $now
    ]);
    
    $app->db->execute([
        4,
        'svar till fråga 4',
        2,
        $now
    ]);
    
    $app->db->execute([
        5,
        'svar till fråga 5',
        2,
        $now
    ]);
    
    $app->db->execute([
        6,
        'svar till fråga 6',
        2,
        $now
    ]);
    
    $app->db->execute([
        7,
        'svar till fråga 7',
        2,
        $now
    ]);
    
    $app->db->execute([
        8,
        'svar till fråga 8',
        2,
        $now
    ]);
    
    $app->db->execute([
        9,
        'svar till fråga 9',
        2,
        $now
    ]);
    
    $app->db->execute([
        10,
        'svar till fråga 10',
        2,
        $now
    ]);
    
    $app->db->execute([
        11,
        'svar till fråga 11',
        2,
        $now
    ]);
    
    $app->db->createTable(
        'tag',
        [
            'id'        => ['integer', 'primary key', 'not null', 'auto_increment'],
            'tag'       => ['varchar(80)', 'not null', 'unique']
        ]
    )->execute();
    
    $app->db->insert(
        'tag',
        ['tag']
    );
 
    $app->db->execute([
        'tag1'
    ]);
    
    $app->db->execute([
        'tag2'
    ]);
    
    $app->db->execute([
        'tag3'
    ]);
    
    $app->db->execute([
        'tag4'
    ]);
    
    $app->db->execute([
        'tag5'
    ]);
    
    $app->db->execute([
        'tag6'
    ]);
    
    $app->db->execute([
        'zelda'
    ]);
    
    $app->db->execute([
        'ninja-gaiden'
    ]);
    
    // Create question2movie and insert default values
    $sql = "CREATE TABLE wgtotw_question2tag
(
  idQuestion INT NOT NULL,
  idTag INT NOT NULL,
 
  FOREIGN KEY (idQuestion) REFERENCES wgtotw_question (id),
  FOREIGN KEY (idTag) REFERENCES wgtotw_tag (id),
 
  PRIMARY KEY (idQuestion, idTag)
);";

    $app->db->execute($sql);
    
    $app->db->insert(
        'question2tag',
        ['idQuestion', 'idTag']
    );
    
    $app->db->execute([
        1,5
    ]);
    
    $app->db->execute([
        2,3
    ]);
    
    $app->db->execute([
        3,6
    ]);
    
    $app->db->execute([
        4,3
    ]);
    
    $app->db->execute([
        5,2
    ]);
    
    $app->db->execute([
        6,1
    ]);
    
    $app->db->execute([
        7,1
    ]);
    
    $app->db->execute([
        8,6
    ]);
    
    $app->db->execute([
        9,5
    ]);
    
    $app->db->execute([
        10,2
    ]);
    
    $app->db->execute([
        11,3
    ]);
    
    $app->db->execute([
        1,1
    ]);
    
    $app->db->execute([
        2,2
    ]);
    
    $app->db->execute([
        3,3
    ]);
    
    $app->db->execute([
        4,4
    ]);
    
    $app->db->execute([
        5,4
    ]);
    
    $app->db->execute([
        6,5
    ]);
    
    $app->db->execute([
        7,6
    ]);
    
    $app->db->execute([
        10,7
    ]);
    
    $app->db->execute([
        11,8
    ]);
    
});

// Check for matching routes and dispatch to controller/handler of route
$app->router->handle();

// Navbar
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_wgtotw.php');

// Render the page
$app->theme->render();
