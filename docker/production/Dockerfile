FROM php:8.2.0-apache

ARG KEY_PASSPHRASE

# Copia o virtual host para o container
COPY /docker/production/000-default.conf /etc/apache2/sites-available/000-default.conf

# Habilita o módulo rewrite do apache
RUN a2enmod rewrite

# Instala os pacotes necessários
RUN apt-get update && \
    apt-get install \
    gpg \
    libzip-dev \
    wget \
    git \
    unzip \
    -y --no-install-recommends

# Instala as extensões do PHP \
RUN docker-php-ext-install zip pdo_mysql

# Copia o instaalador do composer para o container
COPY /docker/install-composer.sh ./

# Copia o php.ini
COPY /docker/production/php.ini /usr/local/etc/php/php.ini

# Limpa e instala os pacotes do container
RUN apt-get purge -y g++ \
    && apt-get autoremove -y \
    && rm -r /var/lib/apt/lists/* \
    && rm -rf /tmp/* \
    && sh ./install-composer.sh \
    && rm ./install-composer.sh

# Muda o diretório de trabalho
WORKDIR /var/www

# Intala as dependências do projeto
COPY /composer.json /composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader

# Copia o código fonte do projeto
COPY / .

# Descriptografa o prod.env.gpg
RUN gpg --quiet --batch --yes --decrypt --passphrase="$KEY_PASSPHRASE" --output .env config/prod.env.gpg

# Gera o autoload do projeto
RUN composer dump-autoload --optimize

# Executa as migrations symfony
RUN php bin/console doctrine:migrations:migrate --no-interaction

# Alterar o proprietário da raiz do documento contêiner
RUN chown -R www-data:www-data /var/www