<?php


namespace DockerCloud\Model\NodeCluster\ProviderOption;


use DockerCloud\Model\AbstractModel;

class IAM extends AbstractModel
{
    /**
     * name of the instance profile (container for instance an IAM role) to
     * attach to every node of the cluster (required)
     *
     * @var string
     */
    protected $instance_profile_name;

    /**
     * @return string
     */
    public function getInstanceProfileName()
    {
        return $this->instance_profile_name;
    }

    /**
     * @param string $instance_profile_name
     *
     * @return $this
     */
    public function setInstanceProfileName($instance_profile_name)
    {
        $this->instance_profile_name = $instance_profile_name;

        return $this;
    }
}