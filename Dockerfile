# Usa a imagem oficial do PHP 8.2
FROM php:8.2

# Atualiza os pacotes e instala as dependências
RUN apt-get update \
    && apt-get install -y \
        git \
        unzip \
        libpq-dev libzip-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql zip

# Instala o Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Define o diretório de trabalho como /var/www
WORKDIR /var/www

# Exponha a porta 80 (ou a porta que seu aplicativo Laravel usa)
EXPOSE 80

# Nomeia o container como desafio-tecnico-objective-raylan
# Isso é feito ao executar o container com o docker-compose
CMD ["tail", "-f", "/dev/null"]
# CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]

LABEL name="php8-desafio"