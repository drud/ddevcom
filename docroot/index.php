<?php
echo "We made it to the index.php!";
die;

// WordPress view bootstrapper
define('WP_USE_THEMES', true);
require(dirname(__FILE__) . '/wp/wp-blog-header.php');
