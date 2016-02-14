<?php


namespace DockerCloud\API;

use DockerCloud\Model\Action as Model;
use DockerCloud\Model\Response\ActionGetListResponse as GetListResponse;

class Action extends AbstractAuditAPI
{
    protected $api_namespace = '/action/';

    protected $allowedGetListFilters = [
        'uuid', //Filter by UUID
        'state', //Filter by state.
        /**
         * Filter by start date. Valid filtering values are start_date__gte (after or on the date supplied)
         * and start_date__lte (before or on the date supplied)
         */
        'start_date',
        /**
         * Filter by end date. Valid filtering values are end_date__gte (after or on the date supplied)
         * and end_date__lte (before or on the date supplied)
         */
        'end_date',
        /**
         * Filter by resource URI of the related object.
         * This filter can only be combined with ‘include_related’ filter
         */
        'object',
        /**
         * There is a parent-child relationship between Docker Cloud objects, described in table Relationships
         * between Docker Cloud objects. If set to 'true’, will include the actions of the related objects to
         * the object specified in “object” filter parameter. Possible values: 'true’ or 'false’
         */
        'include_related',
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
        return new Model($this->getClient()->request('GET',
            $this->getAPINameSpace() . $uuid . '/'
        ));
    }


    /**
     * @param $uuid
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function cancel($uuid)
    {
        return new Model($this->getClient()->request('POST', $this->getAPINameSpace() . $uuid . '/cancel/'));
    }

    /**
     * @param $uuid
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function retry($uuid)
    {
        return new Model($this->getClient()->request('POST', $this->getAPINameSpace() . $uuid . '/retry/'));
    }
}