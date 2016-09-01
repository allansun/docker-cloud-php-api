<?php


namespace DockerCloud\Model\Container;

use DockerCloud\Model\Common\Binding as Base;

class Binding extends Base
{
    /**
     * The resource URI of the volume
     *
     * @var string|null
     */
    protected $volume;

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