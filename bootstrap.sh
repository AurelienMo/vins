
#!/usr/bin/env bash

# VARIABLES
DBPASSWD=root
DBNAME=vins
# Execute build machine virtual
main() {
    update_go
    apache_go
    php_go
    mysql_go
    tools_go
    nodenpm_go
    configure_go
    maildev_go
}

update_go() {
    sudo apt-add-repository ppa:ondrej/php
    sudo apt-get update
    sudo apt install -y sshfs
}

apache_go() {
    apt-get -y install apache2
    a2enmod rewrite
    sed -i "s/AllowOverride None/AllowOverride All/g" /etc/apache2/apache2.conf
    sed -i s/\${APACHE_RUN_USER}/vagrant/g /etc/apache2/apache2.conf
    sed -i s/\${APACHE_RUN_GROUP}/vagrant/g /etc/apache2/apache2.conf
    sed -i "s#DocumentRoot /var/www/html#DocumentRoot /var/www/html/public#g" /etc/apache2/sites-available/000-default.conf
}

mysql_go() {
    debconf-set-selections <<< "mysql-server mysql-server/root_password password $DBPASSWD"
    debconf-set-selections <<< "mysql-server mysql-server/root_password_again password $DBPASSWD"
    debconf-set-selections <<< "phpmyadmin phpmyadmin/dbconfig-install boolean true"
    debconf-set-selections <<< "phpmyadmin phpmyadmin/app-password-confirm password $DBPASSWD"
    debconf-set-selections <<< "phpmyadmin phpmyadmin/mysql/admin-pass password $DBPASSWD"
    debconf-set-selections <<< "phpmyadmin phpmyadmin/mysql/app-pass password $DBPASSWD"
    debconf-set-selections <<< "phpmyadmin phpmyadmin/reconfigure-webserver multiselect none"

    sudo apt-get -y install mysql-server
    sudo apt-get -y install mysql-client
    sudo apt-get -y install phpmyadmin

    mysql -uroot -proot -e "CREATE DATABASE IF NOT EXISTS $DBNAME CHARACTER SET utf8 COLLATE utf8_general_ci;"
}

php_go() {
    sudo apt-get -y install php7.3
    sudo apt-get -y install libapache2-mod-php7.3
    sudo apt-get -y install php7.3-curl
    sudo apt-get -y install php7.3-gd
    sudo apt-get -y install php7.-mysql
    sudo apt-get -y install php7.3-sqlite
    sudo apt-get -y install php7.3-mbstring
    sudo apt-get install -y php7.3-intl
    sudo apt-get install -y php7.3-xsl
    sudo apt-get install -y php7.3-xdebug
    sudo apt-get -y install php7.3-zip
    sudo apt-get -y install php7.3-opcache
    sudo apt-get -y install php-imagick
    sudo apt-get -y install jpegoptim
    sudo apt-get -y install ruby-sass
    cat <<EOT > /etc/php/7.3/apache2/conf.d/30-xdebug.ini
xdebug.remote_enable = 1
xdebug.remote_connect_back = 1
xdebug.remote_port = 9001
xdebug.scream=0
xdebug.cli_color=1
xdebug.show_local_vars=1
EOT
    cat <<EOT > /etc/php/7.3/cli/conf.d/30-xdebug.ini
xdebug.remote_enable = 1
xdebug.remote_connect_back = 1
xdebug.remote_port = 9001
xdebug.scream=0
xdebug.cli_color=1
xdebug.show_local_vars=1
EOT
}

nodenpm_go() {
    sudo apt-get -y install nodejs build-essential
    sudo apt-get -y install npm
}

tools_go() {
    sudo apt-get -y install curl php7.3-cli acl unzip
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
    curl -sL https://deb.nodesource.com/setup_8.x | sudo -E bash -
}

configure_go() {
    if ! grep "cd /var/www/html" /home/vagrant/.bashrc ; then
        echo "cd /var/www/html" >> /home/vagrant/.bashrc
    fi
    cd /var/www/html
    sudo -u vagrant composer install
    sudo npm install
}

maildev_go() {
    sudo apt install -y nodejs-legacy
    npm install -g maildev
}

main
exit 0
