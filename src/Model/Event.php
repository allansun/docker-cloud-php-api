<?php


namespace DockerCloud\Model;


class Event extends AbstractModel
{
    const TYPE_STACK = 'stack';
    const TYPE_SERVICE = 'service';
    const TYPE_CONTAINER = 'container';
    const TYPE_NODECLUSTER = 'nodecluster';
    const TYPE_NODE = 'node';
    const TYPE_ACTION = 'action';
    const TYPE_ERROR = 'error';

    const ACTION_CREATE = 'create';
    const ACTION_UPDATE = 'update';
    const ACTION_DELETE = 'delete';

    /**
     * Type of object that was created or updated. (see const TYPE_*)
     *
     * @var string
     */
    protected $type;
    /**
     * Type of action that was executed on the object. (see const ACTION_*)
     *
     * @var string
     */
    protected $action;
    /**
     * List of resource URIs (REST API) of the parents of the object,
     * according to the “Parent-child hierarchy”
     *
     * @link https://docs.docker.com/apidocs/docker-cloud/?shell#docker-cloud-event
     *
     * @var string[]
     */
    protected $parents;
    /**
     * A unique API endpoint that represents the registry
     *
     * @var string
     */
    protected $resource_uri;
    /**
     * The current state of the object
     *
     * @var string
     */
    protected $state;
    /**
     * A unique identifier for the event
     *
     * @var string
     */
    protected $uuid;
    /**
     * The date and time of the event
     *
     * @var string
     */
    protected $datetime;

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $action
     *
     * @return $this
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getParents()
    {
        return $this->parents;
    }

    /**
     * @param \string[] $parents
     *
     * @return $this
     */
    public function setParents($parents)
    {
        $this->parents = $parents;

        return $this;
    }

    /**
     * @return string
     */
    public function getResourceUri()
    {
        return $this->resource_uri;
    }

    /**
     * @param string $resource_uri
     *
     * @return $this
     */
    public function setResourceUri($resource_uri)
    {
        $this->resource_uri = $resource_uri;

        return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     *
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     *
     * @return $this
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @return string
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * @param string $datetime
     *
     * @return $this
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

}