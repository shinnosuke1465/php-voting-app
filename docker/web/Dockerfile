#使用するdocker imageの指定。php:8.0.16-apacheを使用して環境を構築。phpとapacheを同時に入れる
FROM php:8.0.16-apache

RUN a2enmod rewrite

ENV TZ Asia/Tokyo

# webに公開するファイルの指定APACHE_DOCUMENT_ROOTとは/var/www/html。下記で/var/www/htmlを/php/voting-app/htdocsに置換している
ENV APACHE_DOCUMENT_ROOT /php-voting-app/app/htdocs

#コンテナ内の作業用ディレクトリの作成と指定
RUN mkdir /php-voting-app
WORKDIR /php-voting-app

#php.iniを指定の場所にコピーする
COPY ./php.ini /usr/local/etc/php/conf.d/php.ini

#timezoneの設定。日本時刻を使用
RUN ln -snf /usr/share/zoneinfo/${TZ} /etc/localtime \
  && echo ${TZ} > /etc/timezone

#phpなどを実行するために必要なソフトウェアのインストール
RUN apt-get update \
  && apt-get install -y \
    cron \
    vim \
  && docker-php-ext-install pdo_mysql

#/etc/apache2/sites-available/*.confの全ての設定ファイルの/var/www/htmlをAPACHE_DOCUMENT_ROOTに置換する
RUN sed -ri -e \
  's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
  /etc/apache2/sites-available/*.conf

RUN sed -ri -e \
  's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' \
  /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

#PDOをインストール
RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql
