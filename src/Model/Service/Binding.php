<?php


namespace DockerCloud\Model\Service;

use DockerCloud\Model\Common\Binding as Base;

class Binding extends Base
{
    /**
     * The resource URI of the volume
     *
     * @var string|null
     */
    protected $volumes_from;

    /**
     * @return null|string
     */
    public function getVolumesFrom()
    {
        return $this->volumes_from;
    }

    /**
     * @param null|string $volumes_from
     *
     * @return $this
     */
    public function setVolumesFrom($volumes_from)
    {
        $this->volumes_from = $volumes_from;

        return $this;
    }
}