FROM php:8.1-fpm-alpine

# composer イメージ内から特定のファイルをコピー
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 必要パッケージと PHP 拡張のインストール
RUN apk update && apk add --no-cache \
    git \
    zip unzip \
    && docker-php-ext-install pdo_mysql

# php-fpmをフォアグラウンドで起動するコマンドを追加
CMD ["php-fpm", "-F"]
