FROM circleci/php:7.3.2-apache

# Install packages
RUN \
  sudo apt-get update || sudo apt-get update && \
  sudo apt-get install -y apt-transport-https lsb-release software-properties-common && \
  sudo apt-get install -y libzip-dev && \
  sudo apt-get install -y zlib1g-dev libicu-dev g++ libpng-dev

# Install packages for php and mysql
RUN \
  sudo apt-get update && \
  sudo docker-php-ext-install zip && \
  sudo docker-php-ext-configure intl && \
  sudo docker-php-ext-install intl && \
  sudo docker-php-ext-install pdo pdo_mysql mysqli && \
  sudo docker-php-ext-install gd && \
  sudo apt-get -y install mysql-client

# Install tools for Wordpress
ADD wp-tests-8.0.0.tar.gz /
RUN \
  sudo mv /wp-tests /opt && \
  sudo chown root:root /opt/wp-tests -R && \
  curl --insecure -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && \
  chmod +x wp-cli.phar && \
  sudo mv wp-cli.phar /usr/local/bin/wp

# Download and configure Wordpress
RUN wp core download --path=/var/www/html --allow-root

# Install dockerize
ARG DOCKERIZE_VERSION=v0.3.0
RUN wget https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz && sudo tar -C /usr/local/bin -xzvf dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz && rm dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz

# Define default command.
CMD ["bash"]
