<?php
/*
Plugin Name: Fruition Force SMTP settings
Plugin URI: http://fruition.net
Description: Force SMTP settings
Author: Fruition
Version: 1
Author URI: http://fruition.net
*/
class FruForceSMTP {
  function apply_options() {
    update_option('swpsmtp_options', [
      "from_email_field" => "wordpress@fruition.net",
      "from_name_field" => "Fruition",
      "reply_to_email" => "wordpress@fruition.net",
      "force_from_name_replace" => 0,
      "smtp_settings" => [
        "host" => (getenv('ENVIRONMENT') == 'DOCKSAL' ? "mail" : "localhost"),
        "port" => 1025,
        "authentication" => "no",
      ]
    ]);
  }

  function __construct() {
    if (strtolower(getenv('ENVIRONMENT')) !== "production") {
      add_action("init", [$this, "apply_options"], 0);
    }
  }
}

new FruForceSMTP();