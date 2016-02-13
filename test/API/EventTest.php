<?php


namespace DockerCloud\Test\API;


use DockerCloud\API\Event as API;
use DockerCloud\Exception;

class EventTest extends AbstractAPITest
{
    /**
     * @return string
     */
    static public function getMockData()
    {
        return '{
            "type": "action",
            "action": "update",
            "parents": [
                "/api/app/v1/container/0b0e3538-88df-4f07-9aed-3a3cc4175076/"
            ],
            "resource_uri": "/api/app/v1/action/49f0efe8-a704-4a10-b02f-f96344fabadd/",
            "state": "Success"
        }';
    }

    public function testGetList()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Method not allowed');

        $API = new API();
        $API->getList();
    }

    public function testGet()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Method not allowed');

        $API = new API();
        $API->getByUri('none');
    }

    public function testListen()
    {
        $this->mockResponse(200, 'OK');
        $API = new API();
        $API->listen(true, true);
    }
}
