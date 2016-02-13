<?php


namespace DockerCloud\Model;


class Action extends AbstractAuditModel
{
    const STATE_PENDING = 'Pending';
    const STATE_IN_PROGRESS = 'In progress';
    const STATE_CANCELING = 'Canceling';
    const STATE_CANCELED = 'Canceled';
    const STATE_SUCESS = 'Success';
    const STATE_FAILED = 'Failed';

    /**
     * A unique API endpoint that represents the action
     *
     * @var string
     */
    protected $resource_uri;

    /**
     * A unique identifier for the action generated automatically on creation
     *
     * @var string
     */
    protected $uuid;

    /**
     * The API object (resource URI) to which the action applies to
     *
     * @var string
     */
    protected $object;

    /**
     * Name of the operation performed/being performed
     *
     * @var string
     */
    protected $action;

    /**
     * HTTP method used to access the API
     *
     * @var string
     */
    protected $method;

    /**
     * HTTP path of the API accessed
     *
     * @var string
     */
    protected $path;

    /**
     * The user agent provided by the client when accessing the API endpoint
     *
     * @var string
     */
    protected $user_agent;

    /**
     * Date and time when the API call was performed and the operation started processing
     *
     * @var string
     */
    protected $start_date;

    /**
     * Date and time when the API call finished processing
     *
     * @var string
     */
    protected $end_date;

    /**
     * State of the operation (see const STATE_*)
     *
     * @var string
     */
    protected $state;

    /**
     * IP address of the user that performed the API call
     *
     * @var string
     */
    protected $ip;

    /**
     * Geographic location of the IP address of the user that performed the API call
     *
     * @var string
     */
    protected $location;

    /**
     * Data of the API call
     *
     * @var string
     */
    protected $body;

    /**
     * If the action has been triggered by the user
     *
     * @var string
     */
    protected $is_user_action;

    /**
     * If the action can be canceled by the user in the middle of its execution
     *
     * @var bool
     */
    protected $can_be_canceled;

    /**
     * If the action can be retried by the user
     *
     * @var bool
     */
    protected $can_be_retried;

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
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @param string $object
     *
     * @return $this
     */
    public function setObject($object)
    {
        $this->object = $object;

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
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     *
     * @return $this
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     *
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return string
     */
    public function getUserAgent()
    {
        return $this->user_agent;
    }

    /**
     * @param string $user_agent
     *
     * @return $this
     */
    public function setUserAgent($user_agent)
    {
        $this->user_agent = $user_agent;

        return $this;
    }

    /**
     * @return string
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * @param string $start_date
     *
     * @return $this
     */
    public function setStartDate($start_date)
    {
        $this->start_date = $start_date;

        return $this;
    }

    /**
     * @return string
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * @param string $end_date
     *
     * @return $this
     */
    public function setEndDate($end_date)
    {
        $this->end_date = $end_date;

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
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     *
     * @return $this
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     *
     * @return $this
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     *
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return string
     */
    public function getIsUserAction()
    {
        return $this->is_user_action;
    }

    /**
     * @param string $is_user_action
     *
     * @return $this
     */
    public function setIsUserAction($is_user_action)
    {
        $this->is_user_action = $is_user_action;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isCanBeCanceled()
    {
        return $this->can_be_canceled;
    }

    /**
     * @param boolean $can_be_canceled
     *
     * @return $this
     */
    public function setCanBeCanceled($can_be_canceled)
    {
        $this->can_be_canceled = $can_be_canceled;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isCanBeRetried()
    {
        return $this->can_be_retried;
    }

    /**
     * @param boolean $can_be_retried
     *
     * @return $this
     */
    public function setCanBeRetried($can_be_retried)
    {
        $this->can_be_retried = $can_be_retried;

        return $this;
    }

}