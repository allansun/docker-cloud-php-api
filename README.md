# DockerCloud API PHP Wrapper

This is a PHP FULL implementation of [DockerCloud](http://cloud.docker.com)'s [API](https://docs.docker.com/apidocs/docker-cloud/)

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.6-8892BF.svg?style=plastic)](https://php.net/)
[![Latest Stable Version](https://poser.pugx.org/dockercloud/api/version)](https://packagist.org/packages/dockercloud/api)
[![Build Status](https://img.shields.io/travis/allansun/docker-cloud-php-api/master.svg?style=plastic)](https://travis-ci.org/allansun/docker-cloud-php-api)
[![Gitter](https://badges.gitter.im/allansun/docker-cloud-php-api.svg?style=plastic)](https://gitter.im/allansun/docker-cloud-php-api?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)

## Installation

Add a dependency on dockercloud/api to your project's `composer.json` by utilizing the [Composer](https://getcomposer
.org/) package manager.

```json
{
    "require-dev": {
        "dockercloud/api": "@stable"
    }
}
```

## Usage instruction

Goto https://cloud.docker.com/account/#container-api-key to generate an API Key first.

Now you need to configure authentication credentials via a static method, (you only need to do this once).

```php
DockerCloud\Client::configure('username','apikey');
```

To get a list of services under your account:

```php
$API = new DockerCloud\API\Service();
$Response = $API->getList();
$MetaData = $Response->getMeta();
$services = $Response->getObjects();
```

- $MetaData is a [MetaData](https://github.com/allansun/docker-cloud-php-api/blob/master/src/Model/Response/MetaData.php) object
- $services contains an array of ['Service'](https://docs.docker.com/apidocs/docker-cloud/?shell#services), 

To create a new service

```php
$Model = new DockerCloud\Model\Service();
$Model->setImageName('tutum/hello-world');

$API = new DockerCloud\API\Service();
$Model = $API->create($Model);
```

## API Implementations

This API Wrapper implements all API endpoints currently provided by DockerCloud, for full documentation on how to use it please refere to [API](https://docs.docker.com/apidocs/docker-cloud/)

- Audit 
	- [Action](https://docs.docker.com/apidocs/docker-cloud/?shell#actions)
	- [Event](https://docs.docker.com/apidocs/docker-cloud/?shell#docker-cloud-events)
- Infrastructure
	- [Provider](https://docs.docker.com/apidocs/docker-cloud/?shell#providers)
	- [Region](https://docs.docker.com/apidocs/docker-cloud/?shell#regions)
	- [Availability Zone](https://docs.docker.com/apidocs/docker-cloud/?shell#availability-zones)
	- [Node Type](https://docs.docker.com/apidocs/docker-cloud/?shell#node-types)
	- [Node Cluster](https://docs.docker.com/apidocs/docker-cloud/?shell#node-clusters)
	- [Node](https://docs.docker.com/apidocs/docker-cloud/?shell#nodes)
- Repositor
	- [Registry](https://docs.docker.com/apidocs/docker-cloud/?shell#registries)
	- [External Repository](https://docs.docker.com/apidocs/docker-cloud/?shell#external-repositories)
- Application
	- [Stack](https://docs.docker.com/apidocs/docker-cloud/?shell#stacks)
	- [Container](https://docs.docker.com/apidocs/docker-cloud/?shell#containers)
	- [Service](https://docs.docker.com/apidocs/docker-cloud/?shell#services)