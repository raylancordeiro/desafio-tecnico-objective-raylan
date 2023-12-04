FROM php:8.2

# Atualiza os pacotes e instala as dependências
RUN apt-get update \
    && apt-get install -y \
        git \
        unzip \
        libpq-dev libzip-dev \
        mariadb-client \
    && docker-php-ext-install pdo_mysql pdo_pgsql zip

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Define o diretório de trabalho
WORKDIR /var/www

# Exponha a porta 80
EXPOSE 80

# Comando executado ao subir container
CMD ["tail", "-f", "/dev/null"]

LABEL name="php8-desafio"
