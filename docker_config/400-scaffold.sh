#!/usr/bin/env bash

set -e

if [[ $ENVIRONMENT == "STAGING" ]]; then
  cd /var/www/html/docroot
  #../vendor/bin/wp plugin install stage-file-proxy --activate --allow-root
  #../vendor/bin/wp option update stage-file-proxy-settings '{"source_domain": "https://www.XXXXXX.com","method": "redirect"}' --format=json --allow-root
  #../vendor/bin/wp option update uploads_use_yearmonth_folders 1 --allow-root
fi
