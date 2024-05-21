FROM php:cli as builder
RUN apt-get update && apt-get install -y --no-install-recommends \
    unzip
COPY --from=composer /usr/bin/composer /usr/bin/composer
FROM php:cli
WORKDIR /app
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/
COPY --from=builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
ARG TINI_VERSION=v0.19.0
ADD https://github.com/krallin/tini/releases/download/${TINI_VERSION}/tini /usr/local/bin/tini
RUN chmod +x /usr/local/bin/tini \
    && apt-get update && apt-get install -y --no-install-recommends \
        libopenblas-base \
        liblapacke \
        libmagickwand-6.q16-6 \
        libsqlite3-0 \
        libpng16-16 \
        zlib1g \
    && rm -rf /var/lib/apt/lists/* \
    && cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini \
    && sed \
      -e 's/memory_limit = .*/memory_limit = -1/' \
      -e 's/error_reporting = .*/error_reporting = E_ALL/' \
      -i /usr/local/etc/php/php.ini
COPY --from=builder /app /app

ENTRYPOINT ["tini", "--", "/app/bin/cli"]
