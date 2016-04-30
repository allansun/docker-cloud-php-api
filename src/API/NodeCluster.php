<?php


namespace DockerCloud\API;

use DockerCloud\Model\NodeCluster as Model;
use DockerCloud\Model\Response\NodeClusterGetListResponse as GetListResponse;

class NodeCluster extends AbstractInfrastructrueAPI
{
    protected $api_namespace = '/nodecluster/';


    protected $allowedGetListFilters = [
        'uuid', //Filter by UUID
        'state', //Filter by state.
        'name', //Filter by node cluster name
        'region', //Filter by resource URI of the target region
        'node_type', //Filter by resource URI of the target node type
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
                'body' => $Model->toJson()
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
            ->request('GET', $this->getAPINameSpace(), ['query' => $filters]));
    }


    /**
     * @param $uuid
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function get($uuid)
    {
        return new Model($this->getClient()->request('GET',
            $this->getAPINameSpace() . $uuid . '/'
        ));
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
                'body' => \Zend\Json\Json::encode([
                    'target_num_nodes' => $Model->getTargetNumNodes(),
                    'tags'             => $Model->getTags()
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
    public function deploy($uuid)
    {
        return new Model($this->getClient()->request('POST', $this->getAPINameSpace() . $uuid . '/deploy/'));
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
     * @param $uri
     *
     * @return GetListResponse
     * @throws \DockerCloud\Exception
     */
    function getListByUri($uri)
    {
        return new GetListResponse($this->getClient()->request('GET', $uri));
    }
}