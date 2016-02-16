<?php


namespace DockerCloud\API;

use DockerCloud\Model\Response\ServiceTriggerGetListResponse as GetListResponse;
use DockerCloud\Model\ServiceTrigger as Model;

class ServiceTrigger extends AbstractAPI
{
    protected $api_prifix = '/api/app/v1/service/';
    protected $api_namespace = '/trigger/';
    protected $allowedGetListFilters = [];

    /**
     * The UUID of the service the triggers are associated to
     *
     * @var string
     */
    protected $uuid;

    public function __construct($uuid)
    {
        parent::__construct();

        $this->uuid = $uuid;
    }

    /**
     * @return string
     */
    protected function getAPINameSpace()
    {
        return $this->api_prifix . $this->uuid . $this->api_namespace;
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
     * @param $uri
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function delete($uri)
    {
        return new Model($this->getClient()->request('DELETE', $uri));
    }

    /**
     * @param      $uri
     * @param null $numOfContainers
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function call($uri, $numOfContainers = null)
    {
        if ($numOfContainers) {
            $uri .= $numOfContainers . '/';
        }

        return new Model($this->getClient()->request('POST', $uri));
    }
}