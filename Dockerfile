FROM registry.fruition.net/fruition-internal/base-images:7.4-apache as base

ENV WRITEABLE_DIRS docroot/app/uploads|docroot/app/wp-rocket-config|docroot/app/w3tc-config|docroot/app/wflogs

#COPY docker_config/crontab.sh /etc/cron.d/wordpress
#RUN chmod +x /etc/cron.d/wordpress

COPY docker_config/php.ini $PHP_INI_DIR/php.ini

COPY docker_config/400-scaffold.sh /usr/lib/fruition/bootstrap/400-scaffold.sh

FROM base as deploy

COPY . /var/www/html
