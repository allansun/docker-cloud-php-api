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
            "state": "Success",
            "uuid": "c1dd4e1e-1356-411c-8613-e15146633640",
            "datetime": "Thu, 16 Oct 2014 12:04:08 +0000"
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

    public function testGetListByUri()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Method not allowed');

        $API = new API();
        $API->getList();
    }
}
