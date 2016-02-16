<?php


namespace DockerCloud\API;

use DockerCloud\Model\Repository as Model;
use DockerCloud\Model\Response\RepositoryGetListResponse as GetListResponse;

class Repository extends AbstractRepoAPI
{
    protected $api_namespace = '/repository/';

    protected $allowedGetListFilters = [
        'name', //Filter by image name
        'registory', //Filter by resource URI of the target repository registry
    ];

    /**
     * @param Model $Model
     * @param       $username
     * @param       $passoword
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function create(Model $Model, $username, $passoword)
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
     * @param $name
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function get($name)
    {
        return new Model($this->getClient()->request('GET',
            $this->getAPINameSpace() . $name . '/'
        ));
    }

    /**
     * @param $name
     * @param $username
     * @param $password
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function updateCredentials($name, $username, $password)
    {
        return new Model($this->getClient()->request('PATCH', $this->getAPINameSpace() . $name . '/',
            [
                'body' => \Zend\Json\Json::encode([
                    'username' => $username,
                    'password' => $password,
                ])
            ]
        ));
    }

    /**
     * @param $name
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function delete($name)
    {
        return new Model($this->getClient()->request('DELETE', $this->getAPINameSpace() . $name . '/'));
    }
}