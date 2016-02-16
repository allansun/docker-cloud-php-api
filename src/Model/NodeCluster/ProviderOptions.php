<?php


namespace DockerCloud\Model\NodeCluster;


use DockerCloud\Model\AbstractModel;
use DockerCloud\Model\NodeCluster\ProviderOption\IAM;
use DockerCloud\Model\NodeCluster\ProviderOption\VPC;

class ProviderOptions extends AbstractModel
{
    /**
     * @var VPC
     */
    protected $vpc;

    /**
     * @var IAM
     */
    protected $iam;

    /**
     * @return VPC
     */
    public function getVpc()
    {
        return $this->vpc;
    }

    /**
     * @param VPC $vpc
     *
     * @return $this
     */
    public function setVpc($vpc)
    {
        if (!($vpc instanceof ProviderOption\VPC)) {
            $vpc = new ProviderOption\VPC($vpc);
        }
        $this->vpc = $vpc;

        return $this;
    }

    /**
     * @return IAM
     */
    public function getIam()
    {
        return $this->iam;
    }

    /**
     * @param IAM $iam
     *
     * @return $this
     */
    public function setIam($iam)
    {
        if (!($iam instanceof ProviderOption\IAM)) {
            $iam = new ProviderOption\IAM($iam);
        }
        $this->iam = $iam;

        return $this;
    }

}