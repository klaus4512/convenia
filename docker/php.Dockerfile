FROM php:8.3-fpm-alpine

# Instalar autoconf e outras dependências necessárias
RUN apk add --no-cache autoconf g++ make

# Adicionar arquivos de configuração
ADD ./docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./docker/php/uploads.ini /usr/local/etc/php/conf.d/uploads.ini

# Instalar a extensão Redis
RUN pecl install redis \
    && docker-php-ext-enable redis

# Adicionar grupo e usuário laravel
RUN addgroup -g 1000 laravel && adduser -G laravel -g laravel -s /bin/sh -D laravel

# Criar diretório para a aplicação
RUN mkdir -p /var/www/html

# Copiar código da aplicação para o contêiner
ADD ./ /var/www/html

# Instalar extensões PHP adicionais
RUN docker-php-ext-install pdo pdo_mysql

# Ajustar permissões
RUN chown -R laravel:laravel /var/www/html
