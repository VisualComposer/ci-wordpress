FROM cimg/php:7.4-browsers

# Install tools for Wordpress
RUN \
  curl --insecure -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && \
  chmod +x wp-cli.phar && \
  sudo mv wp-cli.phar /usr/local/bin/wp

# install mariadb
RUN sudo apt-get update && sudo apt-get install -y mariadb-server mariadb-client
# setup the mariadb
RUN sudo mysql_install_db --user=mysql --ldata=/var/lib/mysql
RUN sudo service mysql start && sudo mysql -e "CREATE DATABASE wordpress;" \
     && sudo mysql -e "CREATE USER 'wordpress'@'localhost' IDENTIFIED BY 'wordpress';" \
     && sudo mysql -e "GRANT ALL PRIVILEGES ON wordpress.* TO 'wordpress'@'localhost';" \
     && sudo mysql -e "FLUSH PRIVILEGES;"
RUN sudo apt-get update && sudo apt-get install libgtk2.0-0 libgtk-3-0 libgbm-dev libnotify-dev libgconf-2-4 libnss3 libxss1 libasound2 libxtst6 xauth xvfb

USER circleci
# clear /var/www/html folder and install wordpress
RUN sudo rm -rf /var/www/html && sudo mkdir -p /var/www/html && sudo chown -R circleci:circleci /var/www/html && sudo chmod -R 755 /var/www/html
RUN wp core download --path=/var/www/html --allow-root
RUN sudo chmod -R 755 /var/www/html

# Install dockerize
ARG DOCKERIZE_VERSION=v0.6.1
RUN wget https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz && sudo tar -C /usr/local/bin -xzvf dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz && rm dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz

ADD vcv-auto-authorize.php /var/www/html/wp-content/plugins/
# run php built in server with multithreads PHP_CLI_SERVER_WORKERS=30 php -s localhost:80 -t /var/www/html
RUN sudo service mysql start && wp core config --path=/var/www/html --dbname=wordpress --dbuser=wordpress --dbpass=wordpress --dbhost=0.0.0.0 --allow-root
RUN sudo service mysql start && wp core install --path=/var/www/html --url=http://localhost --title=wordpress --admin_user=admin --admin_password=admin --admin_email=admin@local.local --skip-email --allow-root

RUN sed -i '1i\
<?php \
#Identify the relevant protocol for the current request\
\$protocol = (!empty(\$_SERVER["HTTPS"]) && \$_SERVER["HTTPS"] !== "off" || \$_SERVER["SERVER_PORT"] == 443) ? "https" : "http";\
# Set SITEURL and HOME using a dynamic protocol.\
define("WP_SITEURL", \$protocol . "://" . \$_SERVER["HTTP_HOST"]);\
define("WP_HOME", \$protocol . "://" . \$_SERVER["HTTP_HOST"]); ?>' /var/www/html/wp-config.php

#ENV PHP_CLI_SERVER_WORKERS=30
CMD sudo service mysql start && sudo dockerize -wait tcp://localhost:3306 -timeout 60s && PHP_CLI_SERVER_WORKERS=30 php -S 0.0.0.0:80 -t /var/www/html
