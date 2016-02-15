<?php


namespace DockerCloud\Model\Common;

use DockerCloud\Model\AbstractModel;

class Binding extends AbstractModel
{
    /**
     * The host path of the volume
     *
     * @var string
     */
    protected $host_path;

    /**
     * The container path where the volume is mounted
     *
     * @var string
     */
    protected $container_path;

    /**
     * true is the volume has writable permissions
     *
     * @var bool
     */
    protected $rewritable = true;

    /**
     * The resource URI of the volume
     *
     * @var string|null
     */
    protected $volume;

    /**
     * @return string
     */
    public function getHostPath()
    {
        return $this->host_path;
    }

    /**
     * @param string $host_path
     *
     * @return $this
     */
    public function setHostPath($host_path)
    {
        $this->host_path = $host_path;

        return $this;
    }

    /**
     * @return string
     */
    public function getContainerPath()
    {
        return $this->container_path;
    }

    /**
     * @param string $container_path
     *
     * @return $this
     */
    public function setContainerPath($container_path)
    {
        $this->container_path = $container_path;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isRewritable()
    {
        return $this->rewritable;
    }

    /**
     * @param boolean $rewritable
     *
     * @return $this
     */
    public function setRewritable($rewritable)
    {
        $this->rewritable = $rewritable;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * @param null|string $volume
     *
     * @return $this
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;

        return $this;
    }

}