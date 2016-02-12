<?php


namespace DockerCloud\Model;


use DockerCloud\Model\Service\Binding;
use DockerCloud\Model\Service\EnvironmentVariable;
use DockerCloud\Model\Service\Port;
use DockerCloud\Model\Service\Related;

class Service extends AbstractApplicationModel
{
    const STATE_NOT_RUNNING = 'Not running';
    const STATE_STARTING = 'Starting';
    const STATE_RUNNING = 'Running';
    const STATE_PARTLY_RUNNING = 'Partly running';
    const STATE_SCALING = 'Scaling';
    const STATE_REDEPLOYING = 'Redeploying';
    const STATE_STOPPING = 'Stopping';
    const STATE_STOPPED = 'Stopped';
    const STATE_TERMINATING = 'Terminating';
    const STATE_TERMINATED = 'Terminated';

    const DEPLOYMENT_STRATEGY_EMPTIEST_NODE = 'EMPTIEST_NODE';
    const DEPLOYMENT_STRATEGY_HIGH_AVAILABILITY = 'HIGH_AVAILABILITY';
    const DEPLOYMENT_STRATEGY_EVERY_NODE = 'EVERY_NODE';

    const NETWORK_MODE_BRIDGE = 'bridge';
    const NETWORK_MODE_host = 'host';

    const AUTO_RESTART_OFF = 'OFF';
    const AUTO_RESTART_ON_FAILURE = 'ON_FAILURE';
    const AUTO_RESTART_ALWAYS = 'ALWAYS';

    const AUTO_DESTROY_OFF = 'OFF';
    const AUTO_DESTROY_ON_SUCCESS = 'ON_SUCCESS';
    const AUTO_DESTROY_ALWAYS = 'ALWAYS';

    /**
     * A unique identifier for the service generated automatically on creation
     *
     * @var string
     */
    protected $uuid;

    /**
     * A unique API endpoint that represents the service
     *
     * @var string
     */
    protected $resource_uri;

    /**
     * The Docker image name and tag used for the service containers
     *
     * @var string
     */
    protected $image_name;

    /**
     * A user provided name for the service. This name will be inherited by the
     * service containers and will be used in endpoint URLs, environment variable names, etc.
     *
     * @var string
     */
    protected $name;

    /**
     * An external FQDN that resolves to all IPs of the nodes where the service containers
     * are running on (as an A record with multiple IP entries which will be used by clients
     * in a round-robin fashion). If the service is not publishing any ports, this FQDN will fail to resolve.
     *
     * @var string
     */
    protected $public_dns;

    /**
     * The state of the service. (See const STATE_*)
     *
     * @var string
     */
    protected $state;

    /**
     * Network mode to set on the containers (see table Network Modes below,
     * more information https://docs.docker.com/docker-cloud/feature-reference/service-links/)
     *
     * @var
     */
    protected $net;

    /**
     * Set the PID (Process) Namespace mode for the containers
     * (more information https://docs.docker.com/reference/run/#pid-settings-pid)
     *
     * @var int
     */
    protected $pid;

    /**
     * Flag indicating if the current service definition is synchronized with the current containers.
     *
     * @var bool
     */
    protected $synchronized;

    /**
     * The date and time of the last deployment of the service (if applicable, null otherwise)
     *
     * @var string|null
     */
    protected $deployed_datetime;

    /**
     * The date and time of the last start operation on the service (if applicable, null otherwise)
     *
     * @var string| null
     */
    protected $started_datetime;

    /**
     * The date and time of the last stop operation on the service (if applicable, null otherwise)
     *
     * @var string| null
     */
    protected $stopped_datetime;

    /**
     * The date and time of the terminate operation on the service (if applicable, null otherwise)
     *
     * @var string| null
     */
    protected $destroyed_datetime;

    /**
     * The requested number of containers to deploy for the service
     *
     * @var int
     */
    protected $target_num_containers;

    /**
     * The actual number of containers deployed for the service
     *
     * @var int
     */
    protected $current_num_containers;

    /**
     * The actual number of containers deployed for the service in Running state
     *
     * @var int
     */
    protected $running_num_containers;

    /**
     * The actual number of containers deployed for the service in Stopped state
     *
     * @var int
     */
    protected $stopped_num_containers;

    /**
     * Resource URIs of the stack that the service belongs to
     *
     * @var string
     */
    protected $stack;

    /**
     * List of resource URIs of the containers launched as part of the service
     *
     * @var string[]
     */
    protected $containers = [];

    /**
     * List of ports to be published on the containers of this service
     *
     * @var Port[]
     */
    protected $container_ports = [];

    /**
     * List of user-defined environment variables to set on the containers of the service,
     * which will override the image environment variables
     *
     * @var EnvironmentVariable[]
     */
    protected $container_envvars = [];

    /**
     * Metadata in form of dictionary used for every container of this service
     *
     * @var \ArrayObject
     */
    protected $labels;

    /**
     * Working directory for running binaries within a container of this service
     *
     * @var string
     */
    protected $working_dir;

    /**
     * Set the user used on containers of this service (root by default)
     *
     * @var string
     */
    protected $user;

    /**
     * Set the hostname used on containers of this service
     *
     * @var string
     */
    protected $hostname;

    /**
     * Set the domainname used on containers of this service
     *
     * @var string
     */
    protected $domainname;

    /**
     * Ethernet device’s MAC address used on containers of this service
     *
     * @var string
     */
    protected $mac_address;

    /**
     * Optional parent cgroup used on containers of this service.
     *
     * @var string
     */
    protected $cgroup_name;

    /**
     * If the containers of this service have the tty enable (false by default)
     *
     * @var bool
     */
    protected $tty = false;

    /**
     * If the containers of this service have stdin opened (false by default)
     *
     * @var bool
     */
    protected $stdin_open = false;

    /**
     * Custom DNS servers for containers of this service
     *
     * @var string[]
     */
    protected $dns = [];

    /**
     * Custom DNS search domain for containers of this service
     *
     * @var string[]
     */
    protected $dns_search = [];

    /**
     * Added capabilities for containers of this service
     *
     * @var string[]
     */
    protected $cap_add = [];

    /**
     * Dropped capabilities for containers of this service
     *
     * @var string[]
     */
    protected $cap_drop = [];

    /**
     * List of device mappings for containers of this service
     *
     * @var string[]
     */
    protected $devices = [];

    /**
     * List of hostname mappings for containers of this service
     *
     * @var string[]
     */
    protected $extra_hosts = [];

    /**
     * Labeling scheme for containers of this service
     *
     * @var string[]
     */
    protected $secuirty_opt = [];

    /**
     * Entrypoint to be set on the containers launched as part of the service,
     * which will override the image entrypoint
     *
     * @var string
     */
    protected $entrypoint;

    /**
     * Run command to be set on the containers launched as part of the service,
     * which will override the image run command
     *
     * @var string
     */
    protected $run_command;

    /**
     * Whether the containers for this service should be deployed in sequence,
     * linking each of them to the previous containers
     *
     * @var bool
     */
    protected $sequential_deployment;

    /**
     * The relative CPU priority of the containers of the service
     *
     * @var int
     */
    protected $cpu_shares;

    /**
     * CPUs in which to allow execution
     *
     * @var string
     */
    protected $cpuset;

    /**
     * The memory limit of the containers of the service in MB
     *
     * @var int
     */
    protected $memory;

    /**
     * Total memory limit (memory + swap) of the containers of the service in MB
     *
     * @var int
     */
    protected $memory_swap;

    /**
     * A list of services that are linked to this one
     *
     * @var Related[]
     */
    protected $linked_from_service = [];

    /**
     * A list of services that the service is linked to
     *
     * @var Related[]
     */
    protected $linked_to_service = [];

    /**
     * A list of volume bindings that the service has mounted
     *
     * @var Binding[]
     */
    protected $bindings = [];

    /**
     * Whether to restart the containers of the service automatically if they stop
     * (See const AUTO_RESTART_*)
     *
     * @var string
     */
    protected $autorestart;

    /**
     * Whether to terminate the containers of the service automatically if they stop
     * (See const AUTO_DESTROY_*)
     *
     * @var string
     */
    protected $autodestroy;

    /**
     * List of Docker Cloud roles assigned to this service
     *
     * @var string[]
     */
    protected $roles = [];

    /**
     * List of environment variables that would be exposed in the containers if they are linked to this service
     *
     * @var \ArrayObject
     */
    protected $link_variables;

    /**
     * Whether to start the containers with Docker’s privileged flag set or not,
     * which allows containers to access all devices on the host among other things
     *
     * @var bool
     */
    protected $privileged;

    /**
     * Whether the filesystem of every service container is read-only or not
     *
     * @var bool
     */
    protected $read_only = false;

    /**
     * Container distribution among nodes (See const DEPLOYMENT_STRATEGY_*)
     *
     * @var string
     */
    protected $deployment_strategy;

    /**
     * List of tags to be used to deploy the service
     *
     * @var \ArrayObject[]
     */
    protected $tags = [];

    /**
     * Whether to redeploy the containers of the service when its image is updated in Docker Cloud registr
     *
     * @var bool
     */
    protected $autoredeploy;

    /**
     * A user-friendly name for the service
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
    public function getImageName()
    {
        return $this->image_name;
    }

    /**
     * @param string $image_name
     *
     * @return $this
     */
    public function setImageName($image_name)
    {
        $this->image_name = $image_name;

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
    public function getPublicDns()
    {
        return $this->public_dns;
    }

    /**
     * @param string $public_dns
     *
     * @return $this
     */
    public function setPublicDns($public_dns)
    {
        $this->public_dns = $public_dns;

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
     * @return mixed
     */
    public function getNet()
    {
        return $this->net;
    }

    /**
     * @param mixed $net
     *
     * @return $this
     */
    public function setNet($net)
    {
        $this->net = $net;

        return $this;
    }

    /**
     * @return int
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * @param int $pid
     *
     * @return $this
     */
    public function setPid($pid)
    {
        $this->pid = $pid;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isSynchronized()
    {
        return $this->synchronized;
    }

    /**
     * @param boolean $synchronized
     *
     * @return $this
     */
    public function setSynchronized($synchronized)
    {
        $this->synchronized = $synchronized;

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
    public function getStartedDatetime()
    {
        return $this->started_datetime;
    }

    /**
     * @param null|string $started_datetime
     *
     * @return $this
     */
    public function setStartedDatetime($started_datetime)
    {
        $this->started_datetime = $started_datetime;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getStoppedDatetime()
    {
        return $this->stopped_datetime;
    }

    /**
     * @param null|string $stopped_datetime
     *
     * @return $this
     */
    public function setStoppedDatetime($stopped_datetime)
    {
        $this->stopped_datetime = $stopped_datetime;

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
     * @return int
     */
    public function getTargetNumContainers()
    {
        return $this->target_num_containers;
    }

    /**
     * @param int $target_num_containers
     *
     * @return $this
     */
    public function setTargetNumContainers($target_num_containers)
    {
        $this->target_num_containers = $target_num_containers;

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
     * @return int
     */
    public function getRunningNumContainers()
    {
        return $this->running_num_containers;
    }

    /**
     * @param int $running_num_containers
     *
     * @return $this
     */
    public function setRunningNumContainers($running_num_containers)
    {
        $this->running_num_containers = $running_num_containers;

        return $this;
    }

    /**
     * @return int
     */
    public function getStoppedNumContainers()
    {
        return $this->stopped_num_containers;
    }

    /**
     * @param int $stopped_num_containers
     *
     * @return $this
     */
    public function setStoppedNumContainers($stopped_num_containers)
    {
        $this->stopped_num_containers = $stopped_num_containers;

        return $this;
    }

    /**
     * @return string
     */
    public function getStack()
    {
        return $this->stack;
    }

    /**
     * @param string $stack
     *
     * @return $this
     */
    public function setStack($stack)
    {
        $this->stack = $stack;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getContainers()
    {
        return $this->containers;
    }

    /**
     * @param \string[] $containers
     *
     * @return $this
     */
    public function setContainers($containers)
    {
        $this->containers = (array)$containers;

        return $this;
    }

    /**
     * @return Port[]
     */
    public function getContainerPorts()
    {
        return $this->container_ports;
    }

    /**
     * @param Port[] $container_ports
     *
     * @return $this
     */
    public function setContainerPorts($container_ports)
    {
        $data = [];
        foreach ($container_ports as $container_port) {
            if (!($container_port instanceof Port)) {
                $container_port = new Port($container_port);
            }
            $data[] = $container_port;
        }

        /** @var Port[] $data */
        $this->container_ports = $data;

        return $this;
    }

    /**
     * @return EnvironmentVariable[]
     */
    public function getContainerEnvvars()
    {
        return $this->container_envvars;
    }

    /**
     * @param EnvironmentVariable[] $container_envvars
     *
     * @return $this
     */
    public function setContainerEnvvars($container_envvars)
    {
        $data = [];
        foreach ($container_envvars as $container_envvar) {
            if (!($container_envvar instanceof EnvironmentVariable)) {
                $container_envvar = new EnvironmentVariable($container_envvar);
            }
            $data[] = $container_envvar;
        }

        $this->container_envvars = $data;

        return $this;
    }

    /**
     * @return \ArrayObject
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * @param \ArrayObject $labels
     *
     * @return $this
     */
    public function setLabels($labels)
    {
        $this->labels = $labels;

        return $this;
    }

    /**
     * @return string
     */
    public function getWorkingDir()
    {
        return $this->working_dir;
    }

    /**
     * @param string $working_dir
     *
     * @return $this
     */
    public function setWorkingDir($working_dir)
    {
        $this->working_dir = $working_dir;

        return $this;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $user
     *
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * @param string $hostname
     *
     * @return $this
     */
    public function setHostname($hostname)
    {
        $this->hostname = $hostname;

        return $this;
    }

    /**
     * @return string
     */
    public function getDomainname()
    {
        return $this->domainname;
    }

    /**
     * @param string $domainname
     *
     * @return $this
     */
    public function setDomainname($domainname)
    {
        $this->domainname = $domainname;

        return $this;
    }

    /**
     * @return string
     */
    public function getMacAddress()
    {
        return $this->mac_address;
    }

    /**
     * @param string $mac_address
     *
     * @return $this
     */
    public function setMacAddress($mac_address)
    {
        $this->mac_address = $mac_address;

        return $this;
    }

    /**
     * @return string
     */
    public function getCgroupName()
    {
        return $this->cgroup_name;
    }

    /**
     * @param string $cgroup_name
     *
     * @return $this
     */
    public function setCgroupName($cgroup_name)
    {
        $this->cgroup_name = $cgroup_name;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isTty()
    {
        return $this->tty;
    }

    /**
     * @param boolean $tty
     *
     * @return $this
     */
    public function setTty($tty)
    {
        $this->tty = $tty;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isStdinOpen()
    {
        return $this->stdin_open;
    }

    /**
     * @param boolean $stdin_open
     *
     * @return $this
     */
    public function setStdinOpen($stdin_open)
    {
        $this->stdin_open = $stdin_open;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getDns()
    {
        return $this->dns;
    }

    /**
     * @param \string[] $dns
     *
     * @return $this
     */
    public function setDns($dns)
    {
        $this->dns = (array)$dns;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getDnsSearch()
    {
        return $this->dns_search;
    }

    /**
     * @param \string[] $dns_search
     *
     * @return $this
     */
    public function setDnsSearch($dns_search)
    {
        $this->dns_search = (array)$dns_search;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getCapAdd()
    {
        return $this->cap_add;
    }

    /**
     * @param string[] $cap_add
     *
     * @return $this
     */
    public function setCapAdd($cap_add)
    {
        $this->cap_add = (array)$cap_add;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getCapDrop()
    {
        return $this->cap_drop;
    }

    /**
     * @param \string[] $cap_drop
     *
     * @return $this
     */
    public function setCapDrop($cap_drop)
    {
        $this->cap_drop = (array)$cap_drop;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getDevices()
    {
        return $this->devices;
    }

    /**
     * @param \string[] $devices
     *
     * @return $this
     */
    public function setDevices($devices)
    {
        $this->devices = (array)$devices;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getExtraHosts()
    {
        return $this->extra_hosts;
    }

    /**
     * @param \string[] $extra_hosts
     *
     * @return $this
     */
    public function setExtraHosts($extra_hosts)
    {
        $this->extra_hosts = (array)$extra_hosts;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getSecuirtyOpt()
    {
        return $this->secuirty_opt;
    }

    /**
     * @param \string[] $secuirty_opt
     *
     * @return $this
     */
    public function setSecuirtyOpt($secuirty_opt)
    {
        $this->secuirty_opt = (array)$secuirty_opt;

        return $this;
    }

    /**
     * @return string
     */
    public function getEntrypoint()
    {
        return $this->entrypoint;
    }

    /**
     * @param string $entrypoint
     *
     * @return $this
     */
    public function setEntrypoint($entrypoint)
    {
        $this->entrypoint = $entrypoint;

        return $this;
    }

    /**
     * @return string
     */
    public function getRunCommand()
    {
        return $this->run_command;
    }

    /**
     * @param string $run_command
     *
     * @return $this
     */
    public function setRunCommand($run_command)
    {
        $this->run_command = $run_command;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isSequentialDeployment()
    {
        return $this->sequential_deployment;
    }

    /**
     * @param boolean $sequential_deployment
     *
     * @return $this
     */
    public function setSequentialDeployment($sequential_deployment)
    {
        $this->sequential_deployment = $sequential_deployment;

        return $this;
    }

    /**
     * @return int
     */
    public function getCpuShares()
    {
        return $this->cpu_shares;
    }

    /**
     * @param int $cpu_shares
     *
     * @return $this
     */
    public function setCpuShares($cpu_shares)
    {
        $this->cpu_shares = $cpu_shares;

        return $this;
    }

    /**
     * @return string
     */
    public function getCpuset()
    {
        return $this->cpuset;
    }

    /**
     * @param string $cpuset
     *
     * @return $this
     */
    public function setCpuset($cpuset)
    {
        $this->cpuset = $cpuset;

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
    public function getMemorySwap()
    {
        return $this->memory_swap;
    }

    /**
     * @param int $memory_swap
     *
     * @return $this
     */
    public function setMemorySwap($memory_swap)
    {
        $this->memory_swap = $memory_swap;

        return $this;
    }

    /**
     * @return Related[]
     */
    public function getLinkedFromService()
    {
        return $this->linked_from_service;
    }

    /**
     * @param Related[] $linked_from_services
     *
     * @return $this
     */
    public function setLinkedFromService($linked_from_services)
    {
        $data = [];
        foreach ($linked_from_services as $linked_from_service) {
            if (!($linked_from_service instanceof Related)) {
                $linked_from_service = new Related($linked_from_service);
            }
            $data[] = $linked_from_service;
        }

        $this->linked_from_service = $data;

        return $this;
    }

    /**
     * @return Related[]
     */
    public function getLinkedToService()
    {
        return $this->linked_to_service;
    }

    /**
     * @param Related[] $linked_to_services
     *
     * @return $this
     */
    public function setLinkedToService($linked_to_services)
    {
        $data = [];
        foreach ($linked_to_services as $linked_to_service) {
            if (!($linked_to_service instanceof Related)) {
                $linked_to_service = new Related($linked_to_service);
            }
            $data[] = $linked_to_service;
        }

        $this->linked_to_service = $data;

        return $this;
    }

    /**
     * @return Binding[]
     */
    public function getBindings()
    {
        return $this->bindings;
    }

    /**
     * @param Binding[] $bindings
     *
     * @return $this
     */
    public function setBindings($bindings)
    {
        $data = [];
        foreach ($bindings as $binding) {
            if (!($binding instanceof Binding)) {
                $binding = new Binding($binding);
            }
            $data[] = $binding;
        }

        $this->bindings = $data;

        return $this;
    }

    /**
     * @return string
     */
    public function getAutorestart()
    {
        return $this->autorestart;
    }

    /**
     * @param string $autorestart
     *
     * @return $this
     */
    public function setAutorestart($autorestart)
    {
        $this->autorestart = $autorestart;

        return $this;
    }

    /**
     * @return string
     */
    public function getAutodestroy()
    {
        return $this->autodestroy;
    }

    /**
     * @param string $autodestroy
     *
     * @return $this
     */
    public function setAutodestroy($autodestroy)
    {
        $this->autodestroy = $autodestroy;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param \string[] $roles
     *
     * @return $this
     */
    public function setRoles($roles)
    {
        $this->roles = (array)$roles;

        return $this;
    }

    /**
     * @return \ArrayObject
     */
    public function getLinkVariables()
    {
        return $this->link_variables;
    }

    /**
     * @param \ArrayObject $link_variables
     *
     * @return $this
     */
    public function setLinkVariables($link_variables)
    {
        $this->link_variables = $link_variables;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isPrivileged()
    {
        return $this->privileged;
    }

    /**
     * @param boolean $privileged
     *
     * @return $this
     */
    public function setPrivileged($privileged)
    {
        $this->privileged = $privileged;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isReadOnly()
    {
        return $this->read_only;
    }

    /**
     * @param boolean $read_only
     *
     * @return $this
     */
    public function setReadOnly($read_only)
    {
        $this->read_only = $read_only;

        return $this;
    }

    /**
     * @return string
     */
    public function getDeploymentStrategy()
    {
        return $this->deployment_strategy;
    }

    /**
     * @param string $deployment_strategy
     *
     * @return $this
     */
    public function setDeploymentStrategy($deployment_strategy)
    {
        $this->deployment_strategy = $deployment_strategy;

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
        $this->tags = (array)$tags;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isAutoredeploy()
    {
        return $this->autoredeploy;
    }

    /**
     * @param boolean $autoredeploy
     *
     * @return $this
     */
    public function setAutoredeploy($autoredeploy)
    {
        $this->autoredeploy = $autoredeploy;

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