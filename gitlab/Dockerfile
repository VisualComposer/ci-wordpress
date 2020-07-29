FROM php:7.3.2-apache

# Install packages
RUN \
  apt-get update || apt-get update && \
  apt-get install -y apt-transport-https lsb-release software-properties-common && \
  apt-get install -y libzip-dev && \
  apt-get install -y wget && \
  apt-get install -y unzip && \
  apt-get install -y zlib1g-dev libicu-dev g++ libpng-dev

RUN apt-get install -y git

# Install packages for php and mysql
RUN \
  apt-get update && \
  docker-php-ext-install zip && \
  docker-php-ext-configure intl && \
  docker-php-ext-install intl && \
  docker-php-ext-install pdo pdo_mysql mysqli && \
  docker-php-ext-install gd && \
  apt-get -y install mysql-client

# Enable Exif PHP extentions requirements
RUN \
    docker-php-ext-install exif && \
    docker-php-ext-enable exif

ADD docker-php-memlimit.ini /usr/local/etc/php/conf.d/

# Install tools for Wordpress
RUN \
  curl --insecure -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && \
  chmod +x wp-cli.phar && \
  mv wp-cli.phar /usr/local/bin/wp

# Download and configure Wordpress
RUN wp core download --path=/var/www/html --allow-root

# Install dockerize
ARG DOCKERIZE_VERSION=v0.3.0
RUN wget https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz && tar -C /usr/local/bin -xzvf dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz && rm dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz

# Install node and chrome
RUN \
  apt-get -y install libpython-stdlib nodejs python python-minimal python2.7 python2.7-minimal && \
  curl -sL https://deb.nodesource.com/setup_14.x | bash - && \
  apt-get install nodejs && \
  npm install -g yarn && \
  wget -q -O - https://dl-ssl.google.com/linux/linux_signing_key.pub | apt-key add - && \
  echo "deb http://dl.google.com/linux/chrome/deb/ stable main" | tee -a /etc/apt/sources.list.d/google.list && \
  apt-get update && \
  apt-get install -y dbus-x11 google-chrome-stable

# Install required libs for cypress
RUN \
  rm -rf /var/lib/apt/lists/* && \
  apt-get update && apt-get install -y libgtk2.0-0 libnotify-dev libgconf-2-4 libnss3 libxss1 libasound2 xvfb && \
  export DBUS_SESSION_BUS_ADDRESS=/dev/null && \
  export TERM=xterm && \
  export npm_config_loglevel=warn && \
  export npm_config_unsafe_perm=true

# Define default command.
CMD ["bash"]
