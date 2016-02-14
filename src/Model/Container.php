<?php


namespace DockerCloud\Model;


use DockerCloud\Model\Container\Binding;
use DockerCloud\Model\Container\EnvironmentVariable;
use DockerCloud\Model\Container\LastMetric;
use DockerCloud\Model\Container\Link;
use DockerCloud\Model\Container\Port;

class Container extends AbstractApplicationModel
{
    const STATE_STARTING = 'Starting';
    const STATE_RUNNING = 'Running';
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
     * A unique identifier for the container generated automatically on creation
     *
     * @var string
     */
    protected $uuid;

    /**
     * A unique API endpoint that represents the container
     *
     * @var string
     */
    protected $resource_uri;

    /**
     * The Docker image name and tag used for the container containers
     *
     * @var string
     */
    protected $image_name;

    /**
     * A list of volume bindings that the container has mounted
     *
     * @var Binding[]
     */
    protected $bindings;

    /**
     * A user provided name for the container. This name will be inherited by the
     * container containers and will be used in endpoint URLs, environment variable names, etc.
     *
     * @var string
     */
    protected $name;

    /**
     * The resource URI of the node where this container is running
     *
     * @var string
     */
    protected $node;

    /**
     * The resource URI of the service which this container is part of
     *
     * @var string
     */
    protected $service;

    /**
     * An external FQDN that resolves to all IPs of the nodes where the container containers
     * are running on (as an A record with multiple IP entries which will be used by clients
     * in a round-robin fashion). If the container is not publishing any ports, this FQDN will fail to resolve.
     *
     * @var string
     */
    protected $public_dns;

    /**
     * The state of the container. (See const STATE_*)
     *
     * @var string
     */
    protected $state;

    /**
     * Flag indicating if the current container definition is synchronized with the current containers.
     *
     * @var bool
     */
    protected $synchronized;

    /**
     * The numeric exit code of the container (if applicable, null otherwise)
     *
     * @var int|null
     */
    protected $exit_code;

    /**
     * The date and time of the last deployment of the container (if applicable, null otherwise)
     *
     * @var string|null
     */
    protected $exit_code_msg;

    /**
     * The date and time of the last deployment of the container (if applicable, null otherwise)
     *
     * @var string|null
     */
    protected $deployed_datetime;

    /**
     * The date and time of the last start operation on the container (if applicable, null otherwise)
     *
     * @var string| null
     */
    protected $started_datetime;

    /**
     * The date and time of the last stop operation on the container (if applicable, null otherwise)
     *
     * @var string| null
     */
    protected $stopped_datetime;

    /**
     * The date and time of the terminate operation on the container (if applicable, null otherwise)
     *
     * @var string| null
     */
    protected $destroyed_datetime;

    /**
     * List of ports to be published on the containers of this container
     *
     * @var Port[]
     */
    protected $container_ports;

    /**
     * List of user-defined environment variables to set on the containers of the container,
     * which will override the image environment variables
     *
     * @var EnvironmentVariable[]
     */
    protected $container_envvars;

    /**
     * Metadata in form of dictionary used for every container of this container
     *
     * @var \StdClass
     */
    protected $labels;

    /**
     * Working directory for running binaries within a container of this container
     *
     * @var string
     */
    protected $working_dir;

    /**
     * Set the user used on containers of this container (root by default)
     *
     * @var string
     */
    protected $user;

    /**
     * Set the hostname used on containers of this container
     *
     * @var string
     */
    protected $hostname;

    /**
     * Set the domainname used on containers of this container
     *
     * @var string
     */
    protected $domainname;

    /**
     * Ethernet device’s MAC address used on containers of this container
     *
     * @var string
     */
    protected $mac_address;

    /**
     * Optional parent cgroup used on containers of this container.
     *
     * @var string
     */
    protected $cgroup_name;

    /**
     * If the containers of this container have the tty enable (false by default)
     *
     * @var bool
     */
    protected $tty = false;

    /**
     * If the containers of this container have stdin opened (false by default)
     *
     * @var bool
     */
    protected $stdin_open = false;

    /**
     * Custom DNS servers for containers of this container
     *
     * @var string[]
     */
    protected $dns;

    /**
     * Custom DNS search domain for containers of this container
     *
     * @var string[]
     */
    protected $dns_search;

    /**
     * Added capabilities for containers of this container
     *
     * @var string[]
     */
    protected $cap_add;

    /**
     * Dropped capabilities for containers of this container
     *
     * @var string[]
     */
    protected $cap_drop;

    /**
     * List of device mappings for containers of this container
     *
     * @var string[]
     */
    protected $devices;

    /**
     * List of hostname mappings for containers of this container
     *
     * @var string[]
     */
    protected $extra_hosts;

    /**
     * Labeling scheme for containers of this container
     *
     * @var string[]
     */
    protected $security_opt;

    /**
     * Entrypoint to be set on the containers launched as part of the container,
     * which will override the image entrypoint
     *
     * @var string
     */
    protected $entrypoint;

    /**
     * Run command to be set on the containers launched as part of the container,
     * which will override the image run command
     *
     * @var string
     */
    protected $run_command;

    /**
     * Whether the containers for this container should be deployed in sequence,
     * linking each of them to the previous containers
     *
     * @var bool
     */
    protected $sequential_deployment;

    /**
     * The relative CPU priority of the containers of the container
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
     * The memory limit of the containers of the container in MB
     *
     * @var int
     */
    protected $memory;

    /**
     * Total memory limit (memory + swap) of the containers of the container in MB
     *
     * @var int
     */
    protected $memory_swap;

    /**
     * Last reported metric for the container
     *
     * @var LastMetric
     */
    protected $last_metric;

    /**
     * Whether to restart the containers of the container automatically if they stop
     * (See const AUTO_RESTART_*)
     *
     * @var string
     */
    protected $autorestart;

    /**
     * Whether to terminate the containers of the container automatically if they stop
     * (See const AUTO_DESTROY_*)
     *
     * @var string
     */
    protected $autodestroy;

    /**
     * List of Docker Cloud roles assigned to this container
     *
     * @var string[]
     */
    protected $roles;

    /**
     * A list of containers that the container is linked to
     *
     * @var Link[]
     */
    protected $linked_to_container;

    /**
     * List of environment variables that would be exposed in the containers if they are linked to this container
     *
     * @var \StdClass
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
     * Whether the filesystem of every container container is read-only or not
     *
     * @var bool
     */
    protected $read_only = false;

    /**
     * IP address of the container on the overlay network. This IP will be reachable from any other container.
     *
     * @var string
     */
    protected $private_ip;

    /**
     * Network mode set on the container (See const NETWORK_MODE_*)
     * (more information https://docs.docker.com/reference/run/#network-settings)
     *
     * @var string
     */
    protected $net;

    /**
     * PID (Process) Namespace mode for the container
     * (more information https://docs.docker.com/reference/run/#pid-settings-pid)
     *
     * @var string
     */
    protected $pid;

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
    public function getNode()
    {
        return $this->node;
    }

    /**
     * @param string $node
     *
     * @return $this
     */
    public function setNode($node)
    {
        $this->node = $node;

        return $this;
    }

    /**
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param string $service
     *
     * @return $this
     */
    public function setService($service)
    {
        $this->service = $service;

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
     * @return int|null
     */
    public function getExitCode()
    {
        return $this->exit_code;
    }

    /**
     * @param int|null $exit_code
     *
     * @return $this
     */
    public function setExitCode($exit_code)
    {
        $this->exit_code = $exit_code;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getExitCodeMsg()
    {
        return $this->exit_code_msg;
    }

    /**
     * @param null|string $exit_code_msg
     *
     * @return $this
     */
    public function setExitCodeMsg($exit_code_msg)
    {
        $this->exit_code_msg = $exit_code_msg;

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
     * @return \StdClass
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * @param \StdClass $labels
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
        $this->dns = $dns;

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
        $this->dns_search = $dns_search;

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
        $this->cap_add = $cap_add;

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
        $this->cap_drop = $cap_drop;

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
        $this->devices = $devices;

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
        $this->extra_hosts = $extra_hosts;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getSecurityOpt()
    {
        return $this->security_opt;
    }

    /**
     * @param \string[] $security_opt
     *
     * @return $this
     */
    public function setSecurityOpt($security_opt)
    {
        $this->security_opt = $security_opt;

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
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Link[]
     */
    public function getLinkedToContainer()
    {
        return $this->linked_to_container;
    }

    /**
     * @param Link[] $linked_to_container
     *
     * @return $this
     */
    public function setLinkedToContainer($linked_to_containers)
    {
        $data = [];
        foreach ($linked_to_containers as $linked_to_container) {
            if (!($linked_to_container instanceof Link)) {
                $linked_to_container = new Link($linked_to_container);
            }
            $data[] = $linked_to_container;
        }

        $this->linked_to_container = $data;

        return $this;
    }

    /**
     * @return \StdClass
     */
    public function getLinkVariables()
    {
        return $this->link_variables;
    }

    /**
     * @param \StdClass $link_variables
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
    public function getPrivateIp()
    {
        return $this->private_ip;
    }

    /**
     * @param string $private_ip
     *
     * @return $this
     */
    public function setPrivateIp($private_ip)
    {
        $this->private_ip = $private_ip;

        return $this;
    }

    /**
     * @return string
     */
    public function getNet()
    {
        return $this->net;
    }

    /**
     * @param string $net
     *
     * @return $this
     */
    public function setNet($net)
    {
        $this->net = $net;

        return $this;
    }

    /**
     * @return string
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * @param string $pid
     *
     * @return $this
     */
    public function setPid($pid)
    {
        $this->pid = $pid;

        return $this;
    }

}