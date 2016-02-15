<?php


namespace DockerCloud\Model\Service;


use DockerCloud\Model\AbstractModel;
use DockerCloud\Model\Service;

class Link extends AbstractModel
{
    /**
     * The link name
     *
     * @var string
     */
    protected $name;

    /**
     * The resource URI of the origin of the link
     *
     * @var string
     */
    protected $from_service;

    /**
     * The resource URI of the target of the link
     *
     * @var string
     */
    protected $to_service;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getFromService()
    {
        return $this->from_service;
    }

    /**
     * @param string|Service $from_service
     *
     * @return $this
     */
    public function setFromService($from_service)
    {
        if ($from_service instanceof Service) {
            $from_service = $from_service->getResourceUri();
        }
        $this->from_service = $from_service;

        return $this;
    }

    /**
     * @return string
     */
    public function getToService()
    {
        return $this->to_service;
    }

    /**
     * @param string|Service $to_service
     *
     * @return $this
     */
    public function setToService($to_service)
    {
        if ($to_service instanceof Service) {
            $to_service = $to_service->getResourceUri();
        }
        $this->to_service = $to_service;

        return $this;
    }

    /**
     * @param string|Service $fromService
     * @param string|Service $toService
     * @param string         $aliasName
     *
     * @return static
     */
    static public function build($fromService, $toService, $aliasName)
    {
        $Port = new static();
        $Port->setFromService($fromService);
        $Port->setToService($toService);
        $Port->setName($aliasName);

        return $Port;
    }
}