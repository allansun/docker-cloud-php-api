<?php


namespace DockerCloud\Model\Common;


use DockerCloud\Model\AbstractModel;

class LastMetric extends AbstractModel
{
    /**
     * CPU percentage usage
     *
     * @var float
     */
    protected $cpu;

    /**
     * Memory usage in bytes
     *
     * @var int
     */
    protected $memory;

    /**
     * Disk storage usage in bytes
     *
     * @var int
     */
    protected $disk;

    /**
     * @return float
     */
    public function getCpu()
    {
        return $this->cpu;
    }

    /**
     * @param float $cpu
     *
     * @return $this
     */
    public function setCpu($cpu)
    {
        $this->cpu = $cpu;

        return $this;
    }

    /**
     * @return int
     */
    public function getMemory()
    {
        return $this->memory;
    }

    /**
     * @param int $memory
     *
     * @return $this
     */
    public function setMemory($memory)
    {
        $this->memory = $memory;

        return $this;
    }

    /**
     * @return int
     */
    public function getDisk()
    {
        return $this->disk;
    }

    /**
     * @param int $disk
     *
     * @return $this
     */
    public function setDisk($disk)
    {
        $this->disk = $disk;

        return $this;
    }
}