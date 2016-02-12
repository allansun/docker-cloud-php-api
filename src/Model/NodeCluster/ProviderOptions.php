<?php


namespace DockerCloud\Model\NodeCluster;


use DockerCloud\Model\AbstractModel;

class ProviderOptions extends AbstractModel
{
    /**
     * @var ProviderOption\VPC
     */
    protected $vpc;

    /**
     * @var ProviderOption\IAM
     */
    protected $iam;

    /**
     * @return ProviderOption\VPC
     */
    public function getVpc()
    {
        return $this->vpc;
    }

    /**
     * @param ProviderOption\VPC $vpc
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
     * @return ProviderOption\IAM
     */
    public function getIam()
    {
        return $this->iam;
    }

    /**
     * @param ProviderOption\IAM $iam
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