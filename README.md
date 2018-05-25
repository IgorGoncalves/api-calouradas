![PHP from Packagist](https://img.shields.io/packagist/php-v/symfony/symfony.svg?style=for-the-badge)
![Vue from Packagist](https://img.shields.io/badge/VueJs-2-brightgreen.svg?longCache=true&style=for-the-badge)

# api-calouradas

Projeto que visa criar uma API que gerencia dados sobre eventos festivos conhecidos como "Calouradas" realizados na Universidade Federal de Sergipe.

## A proposta
Utilizando o microframework PHP <a href="https://lumen.laravel.com/" target="_blank">Lumen</a>, a API faz acesso a dados cadastrados em um calendário
vinculado ao Google Calendar via <a href="https://developers.google.com/calendar/" target="_blank">Calendar API</a>, facilitando o desenvolvimento de clients
como WebApps e bots, utilizando conceitos de arquitetura RESTFul


## Como executar o projeto

1. Após executar ``` git clone  ``` é necessário baixar as dependencias do projeto. Utilize o gerenciador de dependencias <a href="https://getcomposer.org/" target="_blank">Composer</a>,
por meio do comando ``` composer install ```.

2. Agora, renomei o arquivo exemple.env para .env, nesse arquivo você precisa adicionar alguns dados de configuração, as informações
estão descritas no arquivo exemple

3. Adicione os arquivos de client_secret.json e credentials.json, para obter esses arquivos, acesse o console de aplicações do Google
e adicione uma chave da Calendar API ao seu App

4. Execute o servidor interno do PHP pelo comando ``` php -S localhost:8000 -t public/ ```
