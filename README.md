# README

## About

SAiTechPro Assignment of Vue.js with PHP/Laravel

## Docker images

* php:7.4-apache  
  https://hub.docker.com/_/php
* mysql:8.0  
  https://hub.docker.com/_/mysql

## Framework

* Laravel Framework 7.15.0  
  https://laravel.com/docs/7.x/readme

## How to use

1. Build and run containers.

    ```bash
    $ docker-compose up -d --build
    ```

2. Copy CONTAINER ID of the container run up from the image, "laravel7-news_web".

    ```bash
    $ docker ps # then copy id from stdout.
    ```

3. In "laravel7-news-spa_web" container, copy .env file.  
   After that, install dependencies using composer and npm.

    ```bash
    $ docker exec -it <container-id> bash

    # cp .env.example .env
    # composer install
    # npm install
    # exit
    ```

4. Launch your web browser and open http://localhost:8080/.  
   Press "Generate app key" button, then refresh the page.
