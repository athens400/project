<?php
/**
 * Config-file for navigation bar.
 *
 */
return [

    // Use for styling the menu
    'class' => 'navbar',
 
    // Here comes the menu strcture
    'items' => [

        // This is a menu item
        'home'  => [
            'text'  => 'Home',
            'url'   => $this->di->get('url')->create(''),
            'title' => 'Home'
        ],
        
        'qa'  => [
            'text'  => 'QA',
            'url'   => $this->di->get('url')->create('QA'),
            'title' => 'Home'
        ],
        
        'login'  => [
            'text'  => 'Login',
            'url'   => $this->di->get('url')->create('users/login'),
            'title' => 'Login'
        ],
        
        'logout'  => [
            'text'  => 'Logout',
            'url'   => $this->di->get('url')->create('users/logout'),
            'title' => 'Login'
        ],
        
        'setup'  => [
            'text'  => 'setup',
            'url'   => $this->di->get('url')->create('setup.php'),
            'title' => 'Flash'
        ],
        
        // This is a menu item
        'presentation'  => [
            'text'  => 'Redovisning',
            'url'   => $this->di->get('url')->create('presentation'),
            'title' => 'Redovisning',
        ],
 
        // This is a menu item
        'source' => [
            'text'  =>'Visa källkod',
            'url'   => $this->di->get('url')->create('source'),
            'title' => 'Visa källkod',
        ],
    ],
 


    /**
     * Callback tracing the current selected menu item base on scriptname
     *
     */
    'callback' => function ($url) {
        if ($url == $this->di->get('request')->getCurrentUrl(false)) {
            return true;
        }
    },



    /**
     * Callback to check if current page is a decendant of the menuitem, this check applies for those
     * menuitems that has the setting 'mark-if-parent' set to true.
     *
     */
    'is_parent' => function ($parent) {
        $route = $this->di->get('request')->getRoute();
        return !substr_compare($parent, $route, 0, strlen($parent));
    },



   /**
     * Callback to create the url, if needed, else comment out.
     *
     */
   /*
    'create_url' => function ($url) {
        return $this->di->get('url')->create($url);
    },
    */
];
