# PHP developer task

## Task description
Imagine that as a developer in order to choose better open source software you need to compare basic statistics of any public GitHub repositories. Your application should integrate with GitHub API and be written in PHP with a modern framework (or microframework) of your choice. We encourage you to use Symfony.

## Task implementation description
The task was accomplished by using Laravel Lumen micro-framework due to its ability to build the enhanced microservices with REST API faster than other frameworks or micro-frameworks. The implementation is done by following all SOLID rules and implementation of design patterns.
To prepare the statistics on two repositories, several statistics were applied. Mainly:

* Repository with most stars.
* Repository with most forks.
* Repository with most watches.
* Repository with most open issues.
* Additionally, it will give the list of repositories with all information.

In order to increase the performance and save the number of api requests, the repository is cached after first retrieving for like 1 hour(can be easily changed in future). This is done using decorator pattern. This approach gives the possibility for us to change the repository retrieval directly from api without any crucial changes in the code. The only thing is we need to change the service in the service provider.

# Project micro-framework -> Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel/lumen-framework)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://img.shields.io/packagist/v/laravel/lumen-framework)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://img.shields.io/packagist/l/laravel/lumen)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.
The code is easily testable as it mostly uses interfaces, thus it will be easy for us to mock our services and write test cases for our application.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

## Main Directory structure

`app/ApiDataProviders` -> The folder includes the classes that provide our project with external  resources from which we can obtain some information or data.<br/>

`app/Dtos` -> Data transfer object model. They were introduced to increase structure consistency in the system to communicate with external services. Like in case of some properties name change in GitHub api, we need to change in only one place. <br/>

`app/Entities` -> The purpose of them are to keep consistency of the internal project structure.<br/>

`app/Storages` -> These objects are responsible for the storing data in the system by different approach. Mainly caching the data is used. <br/>

`app/Decorators` -> Decorator design pattern implementations. The purpose of decorator was to decrease a number of requests to API, as it is limited for unauthorized users and in order to increase the performance. In fact, we can cache any repository as let's say during 5-10 minutes nothing can be changed in the Repository.

`app/ValidationRules` -> The objects that are the base of the particular request body/data validation logic.

### Used libraries

* predis/predis
* illuminate/redis
* guzzlehttp/guzzle

### System Requirements

* Docker

### Steps to run the application

* step 1: Run command:

```bash
docker run --rm --interactive --tty --volume $PWD:/app  composer install
```

* step 2: Run command:

```bash
docker-compose up -d
```

* step 2: Prepare .env file based on .env.example. As for now you can just copy all content from .env.example
* step 3: Make your first statistics of two repositories.

### API endpoints

**Headers**

|           Name | Required |      value       | Description              |
|---------------:|:--------:|:----------------:|--------------------------|
|       `Accept` | required | application/json | Acceptable response type |
| `Content-type` | required | application/json | Request content type     |

## GET

`localhost:8080/repository-statistics`

**Parameters**

|                        Name | Required |  Type  | Description                                                                               |
|----------------------------:|:--------:|:------:|-------------------------------------------------------------------------------------------|
|              `repositories` | required | array  | array of repositories to compare. It should have at least 2 items and 10 items at most.   |
| `repositories.*.identifier` | required | string | the `repositories` array should include the array of objects with the identifier property |
