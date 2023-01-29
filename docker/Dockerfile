FROM php:8.2.0-apache

# Instala os pacotes necessários
RUN apt-get update && apt-get install -y --no-install-recommends \
  libzip-dev \
  wget \
  git \
  unzip && \
  rm -r /var/lib/apt/lists/* && \
  rm -rf /tmp/*

# Instala as extensões do PHP
RUN docker-php-ext-install zip pdo_mysql

# Copia o virtual host para o container
COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf

# Habilita o módulo rewrite do apache
RUN a2enmod rewrite

# Copia o instalador do composer para o container
COPY ./install-composer.sh /usr/local/bin/install-composer.sh

# Copia o php.ini
COPY ./php.ini /usr/local/etc/php/php.ini

# Instala o composer
RUN sh /usr/local/bin/install-composer.sh && rm /usr/local/bin/install-composer.sh

# Muda o diretório de trabalho
WORKDIR /var/www

# adiciona o user www-data ao grupo 1000
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

USER www-data:www-data

COPY . .

EXPOSE 80

ENTRYPOINT ["docker/entrypoint.sh"]

# Inicia o apache em segundo plano
CMD ["apache2-foreground"]
