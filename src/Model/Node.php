<?php


namespace DockerCloud\Model;


use DockerCloud\Model\Node\LastMetric;

class Node extends AbstractApplicationModel
{
    const STATE_REDEPLOYING = 'Redeploying';
    const STATE_REDEPLOYED = 'Deployed';
    const STATE_UNREACHABLE = 'Unreachable';
    const STATE_UPGRADING = 'Upgrading';
    const STATE_TERMINATING = 'Terminating';
    const STATE_TERMINATED = 'Terminated';

    /**
     * The resource URI of the availability zone where the node is deployed, if any
     *
     * @var string
     */
    protected $availability_zone;
    /**
     * A unique identifier for the node generated automatically on creation
     *
     * @var string
     */
    protected $uuid;

    /**
     * A unique API endpoint that represents the node
     *
     * @var string
     */
    protected $resource_uri;

    /**
     * An automatically generated FQDN for the node. Containers deployed on this node will inherit this FQDN.
     *
     * @var string
     */
    protected $external_fqdn;

    /**
     * The state of the node. (See const STATE_*)
     *
     * @var string
     */
    protected $state;

    /**
     * The resource URI of the node cluster to which this node belongs to (if applicable)
     *
     * @var string
     */
    protected $node_cluster;

    /**
     * The resource URI of the node type used for the node
     *
     * @var string
     */
    protected $node_type;

    /**
     * Docker’s execution driver used in the node
     *
     * @var string
     */
    protected $docker_execdriver;

    /**
     * Docker’s storage driver used in the node
     *
     * @var string
     */
    protected $docker_graphdriver;

    /**
     * Docker’s version used in the node
     *
     * @var string
     */
    protected $docker_version;
    /**
     * Node number of CPUs
     *
     * @var int
     */
    protected $cpu;

    /**
     * Node storage size in GB
     *
     * @var int
     */
    protected $disk;

    /**
     * Node memory in MB
     *
     * @var int
     */
    protected $memory;

    /**
     * Last reported metric from the node
     *
     * @var LastMetric
     */
    protected $last_metric;

    /**
     * The actual number of containers deployed for the node
     *
     * @var int
     */
    protected $current_num_containers;

    /**
     * Date and time of the last time the node was contacted by Docker Cloud
     *
     * @var string
     */
    protected $last_seen;

    /**
     * The public IP allocated to the node
     *
     * @var string
     */
    protected $public_ip;

    /**
     * If the node does not accept incoming connections to port 2375,
     * the address of the reverse tunnel to access the docker daemon, or null otherwise
     *
     * @var string
     */
    protected $tunnel;

    /**
     * The date and time of the last deployment of the node (if applicable, null otherwise)
     *
     * @var string|null
     */
    protected $deployed_datetime;

    /**
     * The date and time of the terminate operation on the node (if applicable, null otherwise)
     *
     * @var string| null
     */
    protected $destroyed_datetime;

    /**
     * List of tags to be used to deploy the node
     *
     * @var \ArrayObject[]
     */
    protected $tags;

    /**
     * A user-friendly name for the node
     *
     * @var string
     */
    protected $nickname;

    /**
     * @return string
     */
    public function getAvailabilityZone()
    {
        return $this->availability_zone;
    }

    /**
     * @param string $availability_zone
     *
     * @return $this
     */
    public function setAvailabilityZone($availability_zone)
    {
        $this->availability_zone = $availability_zone;

        return $this;
    }

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
    public function getExternalFqdn()
    {
        return $this->external_fqdn;
    }

    /**
     * @param string $external_fqdn
     *
     * @return $this
     */
    public function setExternalFqdn($external_fqdn)
    {
        $this->external_fqdn = $external_fqdn;

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
    public function getNodeCluster()
    {
        return $this->node_cluster;
    }

    /**
     * @param string $node_cluster
     *
     * @return $this
     */
    public function setNodeCluster($node_cluster)
    {
        $this->node_cluster = $node_cluster;

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
     * @return string
     */
    public function getDockerExecdriver()
    {
        return $this->docker_execdriver;
    }

    /**
     * @param string $docker_execdriver
     *
     * @return $this
     */
    public function setDockerExecdriver($docker_execdriver)
    {
        $this->docker_execdriver = $docker_execdriver;

        return $this;
    }

    /**
     * @return string
     */
    public function getDockerGraphdriver()
    {
        return $this->docker_graphdriver;
    }

    /**
     * @param string $docker_graphdriver
     *
     * @return $this
     */
    public function setDockerGraphdriver($docker_graphdriver)
    {
        $this->docker_graphdriver = $docker_graphdriver;

        return $this;
    }

    /**
     * @return string
     */
    public function getDockerVersion()
    {
        return $this->docker_version;
    }

    /**
     * @param string $docker_version
     *
     * @return $this
     */
    public function setDockerVersion($docker_version)
    {
        $this->docker_version = $docker_version;

        return $this;
    }

    /**
     * @return int
     */
    public function getCpu()
    {
        return $this->cpu;
    }

    /**
     * @param int $cpu
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
     * @return LastMetric
     */
    public function getLastMetric()
    {
        return $this->last_metric;
    }

    /**
     * @param LastMetric $last_metric
     *
     * @return $this
     */
    public function setLastMetric($last_metric)
    {
        if (!($last_metric instanceof LastMetric)) {
            $last_metric = new LastMetric($last_metric);
        }

        $this->last_metric = $last_metric;

        return $this;
    }

    /**
     * @return int
     */
    public function getCurrentNumContainers()
    {
        return $this->current_num_containers;
    }

    /**
     * @param int $current_num_containers
     *
     * @return $this
     */
    public function setCurrentNumContainers($current_num_containers)
    {
        $this->current_num_containers = $current_num_containers;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastSeen()
    {
        return $this->last_seen;
    }

    /**
     * @param string $last_seen
     *
     * @return $this
     */
    public function setLastSeen($last_seen)
    {
        $this->last_seen = $last_seen;

        return $this;
    }

    /**
     * @return string
     */
    public function getPublicIp()
    {
        return $this->public_ip;
    }

    /**
     * @param string $public_ip
     *
     * @return $this
     */
    public function setPublicIp($public_ip)
    {
        $this->public_ip = $public_ip;

        return $this;
    }

    /**
     * @return string
     */
    public function getTunnel()
    {
        return $this->tunnel;
    }

    /**
     * @param string $tunnel
     *
     * @return $this
     */
    public function setTunnel($tunnel)
    {
        $this->tunnel = $tunnel;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDeployedDatetime()
    {
        return $this->deployed_datetime;
    }

    /**
     * @param null|string $deployed_datetime
     *
     * @return $this
     */
    public function setDeployedDatetime($deployed_datetime)
    {
        $this->deployed_datetime = $deployed_datetime;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDestroyedDatetime()
    {
        return $this->destroyed_datetime;
    }

    /**
     * @param null|string $destroyed_datetime
     *
     * @return $this
     */
    public function setDestroyedDatetime($destroyed_datetime)
    {
        $this->destroyed_datetime = $destroyed_datetime;

        return $this;
    }

    /**
     * @return \ArrayObject[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param \ArrayObject[] $tags
     *
     * @return $this
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

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

}