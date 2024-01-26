FROM git.techstackapps.com:5050/it/docker-images/php:8.1-fpm-bullseye

COPY src/ /data/
USER root

RUN chmod -R 777 /data/storage && chmod -R 777 /data/bootstrap/cache
RUN chmod u+x /data/artisan

EXPOSE 9000
CMD ["php-fpm"]
