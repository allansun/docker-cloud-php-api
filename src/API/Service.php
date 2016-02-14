<?php


namespace DockerCloud\API;

use DockerCloud\Model\Response\ServiceGetListResponse as GetListResponse;
use DockerCloud\Model\Service as Model;

class Service extends AbstractApplicationAPI
{
    protected $api_namespace = '/service/';

    protected $allowedGetListFilters = [
        'uuid', //Filter by UUID
        'state', //Filter by state
        'name', //Filter by service name
        'stack', //Filter by resource URI of the target stack.
    ];

    /**
     * @param Model $Model
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function create(Model $Model)
    {
        return new Model($this->getClient()->request('POST', $this->getAPINameSpace(),
            [
                'body' => json_encode([
                    'image'                 => $Model->getImageName(),
                    'name'                  => $Model->getName(),
                    'target_num_containers' => $Model->getTargetNumContainers(),
                    'run_command'           => $Model->getRunCommand(),
                    'entrypoint'            => $Model->getEntrypoint(),
                    'container_ports'       => $Model->getContainerPorts(),
                    'container_envvars'     => $Model->getContainerEnvvars(),
                    'linked_to_service'     => $Model->getLinkedToService(),
                    'bindings'              => $Model->getBindings(),
                    'autorestart'           => $Model->getAutorestart(),
                    'autodestroy'           => $Model->getAutodestroy(),
                    'sequential_deployment' => $Model->isSequentialDeployment(),
                    'roles'                 => $Model->getRoles(),
                    'privileged'            => $Model->isPrivileged(),
                    'deployment_strategy'   => $Model->getDeploymentStrategy(),
                    'tags'                  => $Model->getTags(),
                    'autoredeploy'          => $Model->isAutoredeploy(),
                    'net'                   => $Model->getNet(),
                    'pid'                   => $Model->getPid(),
                    'working_dir'           => $Model->getWorkingDir(),
                    'nickname'              => $Model->getNickname(),
                ])
            ]
        ));
    }

    /**
     * @param $uri
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    function getByUri($uri)
    {
        return new Model($this->getClient()->request('GET', $uri));
    }

    /**
     * @param array $filters
     *
     * @return GetListResponse
     * @throws \DockerCloud\Exception
     */
    public function getList($filters = [])
    {
        $this->validateFilter($filters);

        return new GetListResponse($this->getClient()
            ->request('GET', $this->getAPINameSpace()), ['query' => $filters]);
    }


    /**
     * @param $uuid
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function get($uuid)
    {
        return new Model($this->getClient()->request('GET', $this->getAPINameSpace() . $uuid . '/'));
    }

    /**
     * @param       $uuid
     * @param array $filters
     *
     * @return string
     * @throws \DockerCloud\Exception
     */
    public function logs($uuid, $filters = [])
    {
        $this->validateFilter($filters, [
            'tail', //Number of lines to show from the end of the logs (default: 300)
            'follow', //Whether to stream logs or close the connection immediately (default: true)
        ]);

        return $this->getClient()
            ->request('GET', $this->getAPINameSpace() . $uuid . '/logs/', ['query' => $filters], true);
    }

    /**
     * @param Model $Model
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function update(Model $Model)
    {
        return new Model($this->getClient()->request('PATCH',
            $this->getAPINameSpace() . $Model->getUuid() . '/',
            [
                'body' => json_encode([
                    'autorestart'           => $Model->getAutorestart(),
                    'autodestroy'           => $Model->getAutodestroy(),
                    'container_envvars'     => $Model->getContainerEnvvars(),
                    'container_ports'       => $Model->getContainerPorts(),
                    'cpu_shares'            => $Model->getCpuShares(),
                    'entrypoint'            => $Model->getEntrypoint(),
                    'image'                 => $Model->getImageName(),
                    'linked_to_service'     => $Model->getLinkedToService(),
                    'memory'                => $Model->getMemory(),
                    'privileged'            => $Model->isPrivileged(),
                    'roles'                 => $Model->getRoles(),
                    'run_command'           => $Model->getRunCommand(),
                    'sequential_deployment' => $Model->isSequentialDeployment(),
                    'tags'                  => $Model->getTags(),
                    'target_num_containers' => $Model->getTargetNumContainers(),
                    'deployment_strategy'   => $Model->getDeploymentStrategy(),
                    'autoredeploy'          => $Model->isAutoredeploy(),
                    'net'                   => $Model->getNet(),
                    'pid'                   => $Model->getPid(),
                    'working_dir'           => $Model->getWorkingDir(),
                    'nickname'              => $Model->getNickname(),
                ])
            ]
        ));
    }

    /**
     * @param $uuid
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function start($uuid)
    {
        return new Model($this->getClient()->request('POST', $this->getAPINameSpace() . $uuid . '/start/'));
    }

    /**
     * @param $uuid
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function stop($uuid)
    {
        return new Model($this->getClient()->request('POST', $this->getAPINameSpace() . $uuid . '/stop/'));
    }

    /**
     * @param $uuid
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function scale($uuid)
    {
        return new Model($this->getClient()->request('POST', $this->getAPINameSpace() . $uuid . '/scale/'));
    }

    /**
     * @param $uuid
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function redeploy($uuid)
    {
        return new Model($this->getClient()->request('POST', $this->getAPINameSpace() . $uuid . '/redeploy/'));
    }

    /**
     * @param $uuid
     *
     * @return Model
     * @throws \DockerCloud\Exception
     */
    public function terminate($uuid)
    {
        return new Model($this->getClient()->request('DELETE', $this->getAPINameSpace() . $uuid . '/'));
    }
}