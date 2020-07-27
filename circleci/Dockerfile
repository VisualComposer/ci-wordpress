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

# Enable Exif PHP extentions requirements
RUN \
    sudo docker-php-ext-install exif && \
    sudo docker-php-ext-enable exif

# Install tools for Wordpress
ADD wp-tests-8.0.1.tar.gz /
RUN \
  sudo mv /wp-tests /opt && \
  sudo chown root:root /opt/wp-tests -R && \
  curl --insecure -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && \
  chmod +x wp-cli.phar && \
  sudo mv wp-cli.phar /usr/local/bin/wp

# Install GO (required for phpgrep)
RUN sudo curl -O https://dl.google.com/go/go1.13.linux-amd64.tar.gz \
    && sudo tar -C /usr/local -xzf go1.13.linux-amd64.tar.gz
RUN sudo /usr/local/go/bin/go get -v github.com/quasilyte/phpgrep/cmd/phpgrep && sudo chmod +x /root/go/bin/phpgrep && sudo mv /root/go/bin/phpgrep /usr/local/bin/phpgrep

# Download and configure Wordpress
RUN wp core download --path=/var/www/html --allow-root

# Install dockerize
ARG DOCKERIZE_VERSION=v0.3.0
RUN wget https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz && sudo tar -C /usr/local/bin -xzvf dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz && rm dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz

# Install node and chrome
RUN \
  sudo curl -sL https://deb.nodesource.com/setup_14.x | sudo bash - && \
  sudo apt-get install nodejs && \
  sudo npm install -g yarn && \
  wget -q -O - https://dl-ssl.google.com/linux/linux_signing_key.pub | sudo apt-key add - && \
  echo "deb http://dl.google.com/linux/chrome/deb/ stable main" | sudo tee -a /etc/apt/sources.list.d/google.list && \
  sudo apt-get update && \
  sudo apt-get install -y dbus-x11 google-chrome-stable

# Install required libs for cypress
RUN \
  sudo rm -rf /var/lib/apt/lists/* && \
  sudo apt-get update && sudo apt-get install -y libgtk2.0-0 libnotify-dev libgconf-2-4 libnss3 libxss1 libasound2 xvfb && \
  export DBUS_SESSION_BUS_ADDRESS=/dev/null && \
  export TERM=xterm && \
  export npm_config_loglevel=warn && \
  export npm_config_unsafe_perm=true

ADD vcv-auto-authorize.php /var/www/html/wp-content/plugins/
# Define default command.
CMD ["bash"]
