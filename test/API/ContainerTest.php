<?php


namespace DockerCloud\Test\API;


use DockerCloud\API\Container as API;
use DockerCloud\Model\Container as Model;
use DockerCloud\Model\Response\ContainerGetListResponse;

class ContainerTest extends AbstractAPITest
{
    /**
     * @return string
     */
    static public function getMockData()
    {
        return <<<JSON
{
    "autodestroy": "OFF",
    "autorestart": "OFF",
    "bindings": [
        {
            "volume": "/api/infra/v1/volume/1863e34d-6a7d-4945-aefc-8f27a4ab1a9e/",
            "host_path": null,
            "container_path": "/data",
            "rewritable": true
        },
        {
            "volume": null,
            "host_path": "/etc",
            "container_path": "/etc",
            "rewritable": true
        }
    ],
    "cap_add": [
        "ALL"
    ],
    "cap_drop": [
        "NET_ADMIN",
        "SYS_ADMIN"
    ],
    "container_envvars": [
        {
            "key": "DB_1_ENV_DEBIAN_FRONTEND",
            "value": "noninteractive"
        },
        {
            "key": "DB_1_ENV_MYSQL_PASS",
            "value": "**Random**"
        },
        {
            "key": "DB_1_ENV_MYSQL_USER",
            "value": "admin"
        },
        {
            "key": "DB_1_ENV_PATH",
            "value": "/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin"
        },
        {
            "key": "DB_1_ENV_REPLICATION_MASTER",
            "value": "**False**"
        },
        {
            "key": "DB_1_ENV_REPLICATION_PASS",
            "value": "replica"
        },
        {
            "key": "DB_1_ENV_REPLICATION_SLAVE",
            "value": "**False**"
        },
        {
            "key": "DB_1_ENV_REPLICATION_USER",
            "value": "replica"
        },
        {
            "key": "DB_1_PORT",
            "value": "tcp://172.16.0.3:3306"
        },
        {
            "key": "DB_1_PORT_3306_TCP",
            "value": "tcp://172.16.0.3:3306"
        },
        {
            "key": "DB_1_PORT_3306_TCP_ADDR",
            "value": "172.16.0.3"
        },
        {
            "key": "DB_1_PORT_3306_TCP_PORT",
            "value": "3306"
        },
        {
            "key": "DB_1_PORT_3306_TCP_PROTO",
            "value": "tcp"
        },
        {
            "key": "DB_ENV_DEBIAN_FRONTEND",
            "value": "noninteractive"
        },
        {
            "key": "DB_ENV_MYSQL_PASS",
            "value": "**Random**"
        },
        {
            "key": "DB_ENV_MYSQL_USER",
            "value": "admin"
        },
        {
            "key": "DB_ENV_PATH",
            "value": "/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin"
        },
        {
            "key": "DB_ENV_REPLICATION_MASTER",
            "value": "**False**"
        },
        {
            "key": "DB_ENV_REPLICATION_PASS",
            "value": "replica"
        },
        {
            "key": "DB_ENV_REPLICATION_SLAVE",
            "value": "**False**"
        },
        {
            "key": "DB_ENV_REPLICATION_USER",
            "value": "replica"
        },
        {
            "key": "DB_PASS",
            "value": "szVaPz925B7I"
        },
        {
            "key": "DB_PORT",
            "value": "tcp://172.16.0.3:3306"
        },
        {
            "key": "DB_PORT_3306_TCP",
            "value": "tcp://172.16.0.3:3306"
        },
        {
            "key": "DB_PORT_3306_TCP_ADDR",
            "value": "172.16.0.3"
        },
        {
            "key": "DB_PORT_3306_TCP_PORT",
            "value": "3306"
        },
        {
            "key": "DB_PORT_3306_TCP_PROTO",
            "value": "tcp"
        },
        {
            "key": "DB_DOCKERCLOUD_API_URL",
            "value": "https://cloud.docker.com/api/app/v1/service/c0fed1dc-c528-40c9-aa4c-dc00672ebcbf/"
        }
    ],
    "container_ports": [
        {
            "endpoint_uri": "http://wordpress-stackable-1.admin.cont.dockerapp.io:49153/",
            "inner_port": 80,
            "outer_port": 49153,
            "port_name": "http",
            "protocol": "tcp",
            "published": true,
            "uri_protocol": "http"
        }
    ],
    "cpu_shares": 100,
    "cpuset": "0,1",
    "cgroup_name": "m-executor-abcd",
    "deployed_datetime": "Thu, 16 Oct 2014 12:04:08 +0000",
    "destroyed_datetime": null,
    "devices": [
        "/dev/ttyUSB0:/dev/ttyUSB0"
    ],
    "dns": [
        "8.8.8.8"
    ],
    "dns_search": [
        "example.com",
        "c1dd4e1e-1356-411c-8613-e15146633640.local.dockerapp.io"
    ],
    "domainname": "domainname",
    "entrypoint": "",
    "exit_code": null,
    "exit_code_msg": null,
    "extra_hosts": [
        "onehost:50.31.209.229"
    ],
    "hostname": "hostname",
    "image_name": "tutum/wordpress-stackable:latest",
    "labels": {
        "com.example.description": "Accounting webapp",
        "com.example.department": "Finance",
        "com.example.label-with-empty-value": ""
    },
    "last_metric": {
        "cpu": 1.3278507035616,
        "disk": 462479360,
        "memory": 763170816
    },
    "linked_to_container": [
        {
            "endpoints": {
                "3306/tcp": "tcp://172.16.0.3:3306"
            },
            "from_container": "/api/app/v1/container/c1dd4e1e-1356-411c-8613-e15146633640/",
            "name": "DB_1",
            "to_container": "/api/app/v1/container/ba434e1e-1234-411c-8613-e15146633640/"
        }
    ],
    "link_variables": {
        "WORDPRESS_STACKABLE_1_ENV_DB_HOST": "**LinkMe**",
        "WORDPRESS_STACKABLE_1_ENV_DB_NAME": "wordpress",
        "WORDPRESS_STACKABLE_1_ENV_DB_PASS": "szVaPz925B7I",
        "WORDPRESS_STACKABLE_1_ENV_DB_PORT": "**LinkMe**",
        "WORDPRESS_STACKABLE_1_ENV_DB_USER": "admin",
        "WORDPRESS_STACKABLE_1_ENV_DEBIAN_FRONTEND": "noninteractive",
        "WORDPRESS_STACKABLE_1_ENV_HOME": "/",
        "WORDPRESS_STACKABLE_1_ENV_PATH": "/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin",
        "WORDPRESS_STACKABLE_1_PORT": "tcp://172.16.0.2:80",
        "WORDPRESS_STACKABLE_1_PORT_80_TCP": "tcp://172.16.0.2:80",
        "WORDPRESS_STACKABLE_1_PORT_80_TCP_ADDR": "172.16.0.2",
        "WORDPRESS_STACKABLE_1_PORT_80_TCP_PORT": "80",
        "WORDPRESS_STACKABLE_1_PORT_80_TCP_PROTO": "tcp",
        "WORDPRESS_STACKABLE_ENV_DB_HOST": "**LinkMe**",
        "WORDPRESS_STACKABLE_ENV_DB_NAME": "wordpress",
        "WORDPRESS_STACKABLE_ENV_DB_PASS": "szVaPz925B7I",
        "WORDPRESS_STACKABLE_ENV_DB_PORT": "**LinkMe**",
        "WORDPRESS_STACKABLE_ENV_DB_USER": "admin",
        "WORDPRESS_STACKABLE_ENV_DEBIAN_FRONTEND": "noninteractive",
        "WORDPRESS_STACKABLE_ENV_HOME": "/",
        "WORDPRESS_STACKABLE_ENV_PATH": "/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin",
        "WORDPRESS_STACKABLE_PORT": "tcp://172.16.0.2:80",
        "WORDPRESS_STACKABLE_PORT_80_TCP": "tcp://172.16.0.2:80",
        "WORDPRESS_STACKABLE_PORT_80_TCP_ADDR": "172.16.0.2",
        "WORDPRESS_STACKABLE_PORT_80_TCP_PORT": "80",
        "WORDPRESS_STACKABLE_PORT_80_TCP_PROTO": "tcp"
    },
    "mac_address": "02:42:ac:11:65:43",
    "memory": 1024,
    "memory_swap": 4096,
    "name": "wordpress-stackable",
    "net": "bridge",
    "node": "/api/infra/v1/node/9691c44e-3155-4ca2-958d-c9571aac0a14/",
    "pid": "none",
    "private_ip": "10.7.0.1",
    "privileged": false,
    "public_dns": "wordpress-stackable-1.admin.cont.dockerapp.io",
    "read_only": true,
    "resource_uri": "/api/app/v1/container/c1dd4e1e-1356-411c-8613-e15146633640/",
    "roles": ["global"],
    "run_command": "/run-wordpress.sh",
    "security_opt": [
        "label:user:USER",
        "label:role:ROLE"
    ],
    "sequential_deployment": true,
    "service": "/api/app/v1/service/adeebc1b-1b81-4af0-b8f2-cefffc69d7fb/",
    "started_datetime": "Thu, 16 Oct 2014 12:04:08 +0000",
    "state": "Running",
    "stdin_open": false,
    "stopped_datetime": null,
    "synchronized": true,
    "tty": false,
    "user": "root",
    "uuid": "c1dd4e1e-1356-411c-8613-e15146633640",
    "working_dir": "/app"
}
JSON;
    }


    /**
     * @return Model
     */
    public function testGetList()
    {
        $this->mockGetListResponse(200, $this->getMockData());

        $ContainerAPI         = new API();
        $ContainerGetResponse = $ContainerAPI->getList();
        $containers           = $ContainerGetResponse->getObjects();
        $this->assertInternalType('array', $containers);
        $this->assertGreaterThanOrEqual(1, $ContainerGetResponse->getMeta()->getTotalCount());

        return array_pop($containers);
    }

    /**
     * @param Model $Model
     *
     * @depends testGetList
     */
    public function testGetByUri(Model $Model)
    {
        $this->mockResponse(200, $this->getMockData());

        $API   = new API();
        $Model = $API->getByUri($Model->getResourceUri());
        $this->assertInstanceOf(Model::class, $Model);
    }

    /**
     * @param Model $Model
     *
     * @depends testGetList
     */
    public function testGet(Model $Model)
    {
        $this->mockResponse(200, $this->getMockData());

        $API   = new API();
        $Model = $API->get($Model->getUuid());
        $this->assertInstanceOf(Model::class, $Model);
    }

    /**
     * @param Model $Model
     *
     * @depends testGetList
     */
    public function testLogs(Model $Model)
    {
        $this->mockResponse(200, '{
            "type": "log",
            "log": "Log line from the container",
            "streamType": "stdout",
            "timestamp": 1433779324
        }');

        $API = new API();
        $API->logs($Model->getUuid());
    }

    /**
     * @param Model $Model
     *
     * @depends testGetList
     */
    public function testStart(Model $Model)
    {
        $this->mockResponse(200, $this->getMockData());

        $API   = new API();
        $Model = $API->start($Model->getUuid());
        $this->assertInstanceOf(Model::class, $Model);
    }

    /**
     * @param Model $Model
     *
     * @depends testGetList
     */
    public function testStop(Model $Model)
    {
        $this->mockResponse(200, $this->getMockData());

        $API   = new API();
        $Model = $API->stop($Model->getUuid());
        $this->assertInstanceOf(Model::class, $Model);
    }

    /**
     * @param Model $Model
     *
     * @depends testGetList
     */
    public function testRedeploy(Model $Model)
    {
        $this->mockResponse(200, $this->getMockData());

        $API   = new API();
        $Model = $API->redeploy($Model->getUuid());
        $this->assertInstanceOf(Model::class, $Model);
    }

    /**
     * @param Model $Model
     *
     * @depends testGetList
     */
    public function testTerminate(Model $Model)
    {
        $this->mockResponse(200, $this->getMockData());

        $API   = new API();
        $Model = $API->terminate($Model->getUuid());
        $this->assertInstanceOf(Model::class, $Model);
    }

    /**
     * @param Model $Model
     *
     * @depends testGetList
     */
    public function testExec(Model $Model)
    {
        $this->mockResponse(200, 'OK');

        $API = new API();
        $API->exec($Model->getUuid(), 'ls');
    }

    public function testGetListByUri()
    {
        $this->mockGetListResponse(200, $this->getMockData());
        $API = new API();
        $this->assertInstanceOf(ContainerGetListResponse::class, $API->getListByUri('mock_uri'));
    }
}
