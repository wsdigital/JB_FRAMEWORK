<?
    ## MYSQL ##
    define('DB_CONN', true);
    define('DB_DRIVER', 'mysql');
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PWD',  '');
    define('DB_DATA', 'jb_framework');

    ## MANAGER ##
    define('USER_CONTROL', 'MANAGER');

    ## PAGE ##
    define('PAGE_TITLE', 'calopsita');
    
    ## PATH ##
    define('URL_REWRITE', true);
    define('PATH_APP', PATH_ROOT.'_app/');
    define('PATH_PAGES', PATH_ROOT.'_pages/');
    define('PATH_UPLOAD', PATH_ROOT.'upload/');

    define('PATH_INVALID', 'jbframework/');
    define('PATH_BASE_HREF', 'http://localhost/jbframework/');

    ## ERROR #
    define('ERROR_DEBUG', 'On'); // On | Off
    define('ERROR_RSS_TITLE', '');
    define('ERROR_RSS_LINK', '');
    define('ERROR_RSS_PASS', '');
    define('PATH_FILE_ERROR', PATH_ROOT.'_log/.error_log');
?>