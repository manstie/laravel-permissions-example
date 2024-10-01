# Retrieve base image from composite key of httpd and alpine versions
ARG HTTPD_VERSION=2.4.61
ARG ALPINE_VERSION=3.20
FROM httpd:${HTTPD_VERSION}-alpine${ALPINE_VERSION}

ARG TZ=UTC

# Update package lists
RUN apk update --no-cache && \
    # Add packages for Laravel and Apache
    apk add --no-cache \
        php83 \
        php83-apache2 \
        php83-ctype \
        php83-curl \
        php83-dom \
        php83-fileinfo \
        php83-mbstring \
        php83-openssl \
        php83-pdo \
        php83-pdo_mysql \
        php83-session \
        php83-sodium \
        php83-tokenizer \
        php83-xml && \
    # Configure timezone
    apk add --no-cache --virtual tz-setup tzdata && \
    cp /usr/share/zoneinfo/$TZ /etc/localtime && \
    echo $TZ > /etc/timezone && \
    apk del tz-setup

COPY ./php.ini /etc/php83/php.ini

# Copy apache and site configs into container
COPY ./httpd.conf /usr/local/apache2/conf/httpd.conf
COPY ./sites-available /etc/apache2/sites-available
RUN cp /etc/apache2/conf.d/php83-module.conf /usr/local/apache2/conf/extra/php83-module.conf && \
    ln -s /usr/lib/apache2/mod_php83.so /usr/local/apache2/modules/mod_php83.so && \
    mkdir /etc/apache2/sites-enabled && \
    ln -s /etc/apache2/sites-available/* /etc/apache2/sites-enabled/

# Send logs to stdout/stderr
RUN ln -sfT /proc/1/fd/2 "/var/log/apache2/error.log" && \
    ln -sfT /proc/1/fd/1 "/var/log/apache2/access.log"

# See RemoteIPInternalProxy in httpd.conf for details. Defaults to an arbitrary private IP range.
ENV LOAD_BALANCER_CIDR="172.16.0.0/12"

# Set up Apache users and permissions
ENV APACHE_RUN_USER=app
ENV APACHE_RUN_GROUP=app
RUN addgroup "$APACHE_RUN_GROUP" && \
    adduser "$APACHE_RUN_USER" -G "$APACHE_RUN_USER" --disabled-password && \
    chown -R "$APACHE_RUN_USER:$APACHE_RUN_GROUP" /var/run/apache2 /var/log/apache2/ "$HTTPD_PREFIX"

ARG APP_CODE_PATH_CONTAINER=/var/www/html
WORKDIR $APP_CODE_PATH_CONTAINER

RUN apk upgrade --no-cache

USER 1000
