FROM cimg/php:7.4-browsers

# Install tools for Wordpress
ADD wp-tests-8.0.1.tar.gz /
RUN \
  sudo mv /wp-tests /opt && \
  sudo chown root:root /opt/wp-tests -R && \
  curl --insecure -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && \
  chmod +x wp-cli.phar && \
  sudo mv wp-cli.phar /usr/local/bin/wp

# install php7.4-fpm
RUN sudo apt-get update && sudo apt-get install -y php7.4-fpm php7.4-mysql php7.4-curl php7.4-gd php7.4-mbstring php7.4-xml php7.4-zip php7.4-xdebug php7.4-dev php7.4-pear
# install nginx and copy ./nginx-hosts to /etc/nginx/sites-available/default
RUN sudo apt-get update && sudo apt-get install -y nginx && sudo rm -rf /etc/nginx/sites-available/default
COPY ./nginx-hosts /etc/nginx/sites-available/default

# clear /var/www/html folder and install wordpress
RUN sudo rm -rf /var/www/html && sudo mkdir /var/www/html && sudo chown -R www-data:www-data /var/www/html && sudo chmod -R 755 /var/www/html
RUN sudo wp core download --path=/var/www/html --allow-root
# Download and configure Wordpress
#RUN sudo wp core download --path=/var/www/html --allow-root

# Install dockerize
ARG DOCKERIZE_VERSION=v0.6.1
RUN wget https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz && sudo tar -C /usr/local/bin -xzvf dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz && rm dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz

#ADD vcv-auto-authorize.php /var/www/html/wp-content/plugins/
# Define default command.
CMD ["bash"]
