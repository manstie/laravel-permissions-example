ARG MYSQL_VERSION=latest
FROM mysql:${MYSQL_VERSION}

ARG TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

CMD ["mysqld"]

EXPOSE 3306
