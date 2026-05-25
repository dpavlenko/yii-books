    FROM alpine:3.21

    ARG USERNAME=docker-nginx
    ARG GROUPNAME=docker-nginx
    ARG UID
    ARG GID

    RUN addgroup --gid $GID $GROUPNAME && adduser -u $UID -D -G $GROUPNAME $USERNAME

    RUN apk update && apk upgrade

    RUN apk add --no-cache \
        bash \
        openrc \
        dcron \
        git \
        libmcrypt-dev \
        libltdl

    COPY crontab /etc/crontabs/root

    RUN chown root:root /etc/crontabs/root && chmod 775 /etc/crontabs/root


    RUN apk add --no-cache \
        php83 \
        php83-fpm \
        php83-opcache \
        php83-gd \
        php83-zlib \
        php83-curl \
        php83-bcmath \
        php83-ctype \
        php83-iconv \
        php83-intl \
        php83-json \
        php83-mbstring \
        php83-mysqlnd \
        php83-openssl \
        php83-pdo \
        php83-pdo_mysql \
        php83-pdo_pgsql \
        php83-pdo_sqlite \
        php83-phar \
        php83-posix \
        php83-session \
        php83-soap \
        php83-xml \
        php83-xmlreader \
        php83-xmlwriter \
        php83-simplexml \
        php83-zip \
        php83-fileinfo \
        php83-tokenizer \
        php83-imap \
        php83-pecl-xdebug

    # Далее установим nginx по гайду с официального сайте nginx.
    # https://docs.nginx.com/nginx/admin-guide/installing-nginx/installing-nginx-open-source/
    RUN apk add openssl curl ca-certificates

    # Чтобы настроить репозиторий apk для стабильных версий пакетов nginx, выполните команду:
    RUN printf "%s%s%s\n" \
    "http://nginx.org/packages/alpine/v" \
    `egrep -o '^[0-9]+\.[0-9]+' /etc/alpine-release` \
    "/main" \
    | tee -a /etc/apk/repositories

    # Импортируйте официальный ключ подписи nginx, чтобы apk мог проверить подлинность пакетов.
    RUN curl -o /tmp/nginx_signing.rsa.pub https://nginx.org/keys/nginx_signing.rsa.pub

    # Проверяем, что загруженный файл содержит правильный ключ
    RUN openssl rsa -pubin -in /tmp/nginx_signing.rsa.pub -text -noout

    # Переместите ключ в хранилище доверенных ключей apk
    RUN mv /tmp/nginx_signing.rsa.pub /etc/apk/keys/

    # Теперь, устанавливаем nginx
    RUN apk add nginx

    RUN  git config --global user.email "staffliner@example.com" && git config --global user.name "Staffliner App"

    # Установите PHP Composer
    RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

    # Устанавливаем консоль Symfony
    RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash && apk add symfony-cli

    # Копируем файлы проекта внутрь контейнера
    #COPY ../project /usr/share/nginx/html/project

    # Скопируйте конфигурацию по умолчанию и вставьте ее в путь к конфигурации nginx внутри docker.
    #COPY ./conf/nginx-configs/default.conf /etc/nginx/conf.d/default.conf

    # Открываем порты так, чтобы они были снаружи контейнера.
#    EXPOSE 80
#    EXPOSE 443

    #RUN touch /var/log/crontab.log

    # чтобы указать, что контейнер будет корректно завершать работу при получении сигнала SIGTERM.
    STOPSIGNAL SIGTERM

    # Выполните команду запуска.
    # Запустите php-fpm8 и nginx через терминал bash.
    CMD ["/bin/bash", "-c", "crond -s  /etc/crontabs/root  -b && php-fpm83 && chmod 755 /usr/share/nginx/html/* && nginx -g 'daemon off;'"]