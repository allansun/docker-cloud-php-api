<?php


namespace DockerCloud\Model;


use DockerCloud\Model\NodeCluster\ProviderOptions;

class NodeCluster extends AbstractInfrastructrueModel
{
    const STATE_INIT = 'Init';
    const STATE_DEPLOYING = 'Deploying';
    const STATE_DEPLOYED = 'Deployed';
    const STATE_PARTLY_DEPLOYED = 'Partly deployed';
    const STATE_SCALING = 'Scaling';
    const STATE_TERMINATING = 'Terminating';
    const STATE_TERMINATED = 'Terminated';
    const STATE_EMPTY_CUSTER = 'Empty cluster';

    /**
     * A unique identifier for the node cluster generated automatically on creation
     *
     * @var string
     */
    protected $uuid;
    /**
     * A unique API endpoint that represents the node cluster
     *
     * @var string
     */
    protected $resource_uri;
    /**
     * A user provided name for the node cluster
     *
     * @var string
     */
    protected $name;
    /**
     * The state of the node cluster. (See const STATE_*)
     *
     * @var string
     */
    protected $state;
    /**
     * The resource URI of the node type used for the node cluster
     *
     * @var string
     */
    protected $node_type;
    /**
     * The size of the disk where images and containers are stored (in GB)
     *
     * @var int
     */
    protected $disk;
    /**
     * A list of resource URIs of the Node objects on the node cluster
     *
     * @var string[]
     */
    protected $nodes;
    /**
     * The resource URI of the Region object where the node cluster is deployed
     *
     * @var string
     */
    protected $region;
    /**
     * The desired number of nodes for the node cluster
     *
     * @var int
     */
    protected $target_num_nodes;
    /**
     * The actual number of nodes in the node cluster.
     * This may differ from target_num_nodes if the node cluster is being deployed or scaled
     *
     * @var int
     */
    protected $current_num_nodes;
    /**
     * The date and time when this node cluster was deployed
     *
     * @var string
     */
    protected $deployed_datetime;
    /**
     * The date and time when this node cluster was terminated (if applicable)
     *
     * @var string
     */
    protected $destroyed_datetime;
    /**
     * List of tags to identify the node cluster nodes when deploying services
     *
     * @var \StdClass[]
     */
    protected $tags;
    /**
     * Provider-specific extra options for the deployment of the node
     *
     * @var ProviderOptions
     */
    protected $provider_options;
    /**
     * A user-friendly name for the node cluster (name by default)
     *
     * @var string
     */
    protected $nickname;

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
    public function getNodeType()
    {
        return $this->node_type;
    }

    /**
     * @param string $node_type
     *
     * @return $this
     */
    public function setNodeType($node_type)
    {
        $this->node_type = $node_type;

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

    /**
     * @return \string[]
     */
    public function getNodes()
    {
        return $this->nodes;
    }

    /**
     * @param \string[] $nodes
     *
     * @return $this
     */
    public function setNodes($nodes)
    {
        $this->nodes = $nodes;

        return $this;
    }

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param string $region
     *
     * @return $this
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return int
     */
    public function getTargetNumNodes()
    {
        return $this->target_num_nodes;
    }

    /**
     * @param int $target_num_nodes
     *
     * @return $this
     */
    public function setTargetNumNodes($target_num_nodes)
    {
        $this->target_num_nodes = $target_num_nodes;

        return $this;
    }

    /**
     * @return int
     */
    public function getCurrentNumNodes()
    {
        return $this->current_num_nodes;
    }

    /**
     * @param int $current_num_nodes
     *
     * @return $this
     */
    public function setCurrentNumNodes($current_num_nodes)
    {
        $this->current_num_nodes = $current_num_nodes;

        return $this;
    }

    /**
     * @return string
     */
    public function getDeployedDatetime()
    {
        return $this->deployed_datetime;
    }

    /**
     * @param string $deployed_datetime
     *
     * @return $this
     */
    public function setDeployedDatetime($deployed_datetime)
    {
        $this->deployed_datetime = $deployed_datetime;

        return $this;
    }

    /**
     * @return string
     */
    public function getDestroyedDatetime()
    {
        return $this->destroyed_datetime;
    }

    /**
     * @param string $destroyed_datetime
     *
     * @return $this
     */
    public function setDestroyedDatetime($destroyed_datetime)
    {
        $this->destroyed_datetime = $destroyed_datetime;

        return $this;
    }

    /**
     * @return \StdClass[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param \StdClass[] $tags
     *
     * @return $this
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return ProviderOptions
     */
    public function getProviderOptions()
    {
        return $this->provider_options;
    }

    /**
     * @param ProviderOptions $provider_options
     *
     * @return $this
     */
    public function setProviderOptions($provider_options)
    {
        if (!($provider_options instanceof ProviderOptions)) {
            $provider_options = new ProviderOptions($provider_options);
        }
        $this->provider_options = $provider_options;

        return $this;
    }

    /**
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     *
     * @return $this
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getArrayCopy($fieldsToInclude = [])
    {
        return parent::getArrayCopy(array_merge($fieldsToInclude, [
            'name',
            'node_type',
            'region',
            'disk',
            'nickname',
            'target_num_nodes',
            'tags',
            'provider_options',
        ]));
    }
}