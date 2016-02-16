<?php


namespace DockerCloud\Model\NodeCluster\ProviderOption;


use DockerCloud\Model\AbstractModel;

class VPC extends AbstractModel
{
    /**
     * AWS VPC identifier of the target VPC where the nodes of the cluster will be deployed (required)
     *
     * @var string
     */
    protected $id;

    /**
     * a list of target subnet indentifiers inside selected VPC. If you specify more than one subnet,
     * Docker Cloud will balance among all of them following a high-availability schema (optional)
     *
     * @var string[]
     */
    protected $subnets;

    /**
     * the security group that will be applied to every node of the cluster (optional)
     *
     * @var string[]
     */
    protected $security_groups;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getSubnets()
    {
        return $this->subnets;
    }

    /**
     * @param \string[] $subnets
     *
     * @return $this
     */
    public function setSubnets($subnets)
    {
        $this->subnets = $subnets;

        return $this;
    }

    /**
     * @return string
     */
    public function getSecurityGroups()
    {
        return $this->security_groups;
    }

    /**
     * @param string $security_groups
     *
     * @return $this
     */
    public function setSecurityGroups($security_groups)
    {
        $this->security_groups = $security_groups;

        return $this;
    }

}