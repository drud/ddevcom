<?php

$custom_settings = dirname(__FILE__) . '/wp-config-drud.php';
if (file_exists($custom_settings)) {
    require_once($custom_settings);
}

define('DB_NAME', getenv('DB_NAME'));

define('DB_USER', getenv('DB_USER'));

define('DB_PASSWORD', getenv('DB_PASS'));

define('DB_HOST', getenv('DB_HOST'));

define('DB_CHARSET', 'utf8');

define('DB_COLLATE', '');

// define('AUTH_KEY', getenv('WPAUTHKEY'));
// define('SECURE_AUTH_KEY', getenv('WPSECUREAUTHKEY'));
// define('LOGGED_IN_KEY', getenv('WPLOGGEDINKEY'));
// define('NONCE_KEY', getenv('WPNONCEKEY'));
// define('AUTH_SALT', getenv('WPAUTHSALT'));
// define('SECURE_AUTH_SALT', getenv('WPSECUREAUTHSALT'));
// define('LOGGED_IN_SALT', getenv('WPLOGGEDINSALT'));
// define('NONCE_SALT', getenv('WPNONCESALT'));


define('AUTH_KEY', 'le13-2@9z`-~3{s>*{j8s#(0#{`FGJnBaQ%?-)DTb[!uwof[.|0,#-nT9<l>=/k{');
define('SECURE_AUTH_KEY', '8+!u8R1n8|]wmeIXZ#MDfor2Bv*A4p~7Jve8+~+c1!-^n|tvYJmakB9w+Vm96iQZ');
define('LOGGED_IN_KEY', 'hgJ1^QT~m$T4+~n+R5FE8@qUQ,_MjV(f_=?2>K9Rf/?7g)F<Ktf)tvfn$qIg(,+f');
define('NONCE_KEY', 'gR($({L-8mwP<!U*=ZgBKW++JSidU8W5$+6<P:-on=T[oq,EjI/]S~,=@lxkVq74');
define('AUTH_SALT', 'Ic+WM+{Ep+WA3<gnSsx|GTLKset+QU+Krz-^6rO+C`1cO?soy,$nP[|TLlxh rX-');
define('SECURE_AUTH_SALT', 'O`2^tUy+vw~KN:6B7xe!Wq)Hz%<XXT_Gk.(+Q9gk3I$@BqiKI4-sl1YW_*#>)R>L');
define('LOGGED_IN_SALT', 'BCRQxH:GE9DG6V|t$ykx43+=1kC]YI>=ONRxTCRf%))cx^t!+pk/<!:-kSX`&~S/');
define('NONCE_SALT', 'G4_0&7z]+moKz+8_4(4<V7~`q+]BLh!DLrFd<3,R/Pllq&HD(qff:78W;+a-qH-:');


$table_prefix  = 'wp_';

// site URL
define('WP_HOME', 'https://www.drud.com');

// WP URL
define('WP_SITEURL', WP_HOME . '/wp');

// full local path of current directory (no trailing slash)
define('WP_CONTENT_DIR', getcwd() . '/content');

// full URI of current directory (no trailing slash)
define('WP_CONTENT_URL', WP_HOME . '/content');


define('WP_DEBUG', false);
define('DISALLOW_FILE_MODS', true);


if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/wp/');
}

require_once(ABSPATH . 'wp-settings.php');
