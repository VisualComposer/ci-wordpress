FROM cypress/browsers:node16.5.0-chrome94-ff93

# Install packages
RUN \
  apt-get update || apt-get update && \
  apt-get install -y apt-transport-https lsb-release software-properties-common && \
  apt-get install -y libzip-dev && \
  apt-get install -y wget && \
  apt-get install -y unzip && \
  apt-get install -y zlib1g-dev libicu-dev g++ libpng-dev curl

RUN apt-get install -y git

# Install apache
RUN apt-get install -y apache2 apache2-utils && \
# iptables -I INPUT -p tcp --dport 80 -j ACCEPT && \
# ufw allow http && \
  echo "ServerName localhost" >> /etc/apache2/conf-available/servername.conf > /dev/null && \
  a2enconf servername.conf

# Install mysql client
RUN \
  apt-get update && \
  apt-get install -y default-mysql-client

# Install PHP 7.4
RUN \
  apt-get install -y apt-transport-https lsb-release ca-certificates wget && \
  wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg && \
  echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" >> /etc/apt/sources.list.d/php.list && \
  apt-get update

RUN apt-get install -y php7.4 \
                    libapache2-mod-php7.4 \
                    php7.4-mysql \
                    php-common \
                    php7.4-cli \
                    php7.4-common \
                    php7.4-json \
                    php7.4-opcache \
                    php7.4-readline \
                    php7.4-exif \
                    php7.4-curl

RUN a2enmod php7.4
RUN php --version

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


# Define default command.
CMD ["/usr/sbin/apache2ctl", "-DFOREGROUND"]
