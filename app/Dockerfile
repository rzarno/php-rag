FROM php:8.3-apache
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN apt-get update && \
    apt-get install -y wget gnupg2 libpq-dev && docker-php-ext-install pdo pdo_pgsql
RUN echo "deb http://apt.postgresql.org/pub/repos/apt/ jammy-pgdg main 15.0" > /etc/apt/sources.list.d/pgdg.list
RUN wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | \
   apt-key add -
RUN apt-get update
RUN apt-get install -y postgresql-client-15
COPY ./wait-for-postgres.sh wait-for-postgres.sh
RUN chmod +x wait-for-postgres.sh 
COPY src/ /var/www/html