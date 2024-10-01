# Build from provided image argument
ARG FROM
FROM $FROM

USER root

ARG COMPOSER_VERSION=2.7.7

# Add curl for pulling, and phar / xmlwriter for running Composer
RUN apk update --no-cache && \
    apk add --no-cache \
        curl \
        git \
        php-phar \
        php-xmlwriter

# Use a more permissive ini so that composer can run
COPY ./workspace-php.ini /etc/php83/conf.d/workspace-php.ini

# Pull the composer installer and it's assosciated checksum
RUN curl -so composer-setup.php https://getcomposer.org/installer && \
    EXPECTED_CHECKSUM=$(curl -s https://composer.github.io/installer.sig) && \
    # Calculate the checksum of the installer
    ACTUAL_CHECKSUM="$(php -r "echo hash_file('sha384', 'composer-setup.php');")" && \
    # Compare the expected and actual checksum, print to error and exit if they don't match
    if [ "$EXPECTED_CHECKSUM" != "$ACTUAL_CHECKSUM" ]; then >&2 echo 'ERROR: Invalid installer checksum'; exit 1; fi && \
    # Run the setup, remove the installer, and return the exit code from setup
    php -d allow_url_fopen=On composer-setup.php --install-dir=/usr/local/bin --filename=composer --version=${COMPOSER_VERSION} && \
    RESULT=$? && \
    rm composer-setup.php && \
    exit $RESULT

CMD sh

USER 1000
