<?php


namespace DockerCloud\API;

use DockerCloud\Model\Response\StackGetListResponse as GetListResponse;
use DockerCloud\Model\Stack as Model;
use Symfony\Component\Yaml\Yaml;

class Stack extends AbstractApplicationAPI
{
    protected $api_namespace = '/stack/';

    protected $allowedGetListFilters = [
        'uuid', //Filter by UUID
        'name', //Filter by stack name
    ];

    /**
     * @param $uri
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    function getByUri($uri)
    {
        return new Model($this->getClient()->request('GET', $uri));
    }

    /**
     * @param Model $Model
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function create(Model $Model)
    {
        return new Model($this->getClient()->request('POST', $this->getAPINameSpace(),
            [
                'body' => json_encode([
                    'name'     => $Model->getName(),
                    'services' => $Model->getServices(),
                    'nickname' => $Model->getNickname()
                ])
            ]
        ));
    }

    /**
     * @param array $filters
     *
     * @return GetListResponse
     * @throws \DockerCloud\Exception
     */
    public function getList($filters = [])
    {
        $this->validateFilter($filters);

        return new GetListResponse($this->getClient()
            ->request('GET', $this->getAPINameSpace()), ['query' => $filters]);
    }


    /**
     * @param $uuid
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function get($uuid)
    {
        return new Model($this->getClient()->request('GET', $this->getAPINameSpace() . $uuid . '/'));
    }

    /**
     * @param Model $Model
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function update(Model $Model)
    {
        return new Model($this->getClient()->request('PATCH',
            $this->getAPINameSpace() . $Model->getUuid() . '/',
            [
                'body' => json_encode([
                    'services' => $Model->getServices()
                ])
            ]
        ));
    }

    /**
     * @param $uuid
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function start($uuid)
    {
        return new Model($this->getClient()->request('POST', $this->getAPINameSpace() . $uuid . '/start/'));
    }

    /**
     * @param $uuid
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function stop($uuid)
    {
        return new Model($this->getClient()->request('POST', $this->getAPINameSpace() . $uuid . '/stop/'));
    }

    /**
     * @param $uuid
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function redeploy($uuid)
    {
        return new Model($this->getClient()->request('POST', $this->getAPINameSpace() . $uuid . '/redeploy/'));
    }

    /**
     * @param $uuid
     *
     * @return string
     * @throws \DockerCloud\Exception
     */
    public function export($uuid)
    {
        return Yaml::dump(json_decode(json_encode(
            $this->getClient()->request('POST', $this->getAPINameSpace() . $uuid . '/export/')
        ), true));
    }

    /**
     * @param $uuid
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function terminate($uuid)
    {
        return new Model($this->getClient()->request('DELETE', $this->getAPINameSpace() . $uuid . '/'));
    }

    /**
     * @param $name
     *
     * @return Model|null
     */
    public function findByName($name)
    {
        $GetListResponse = $this->getList(['name' => $name]);
        if (1 == $GetListResponse->getMeta()->getTotalCount()) {
            return $GetListResponse->getObjects()[0];
        }

        return null;
    }
}