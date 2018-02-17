<?php


namespace DockerCloud\API;


use DockerCloud\Exception;
use DockerCloud\Model\AbstractApplicationModel;
use DockerCloud\Model\Response\AbstractGetResponse;

/**
 * Class AbstractApplicationAPI
 *
 * @package DockerCloud\API
 */
abstract class AbstractApplicationAPI extends AbstractAPI
{
    protected $api_prifix = '/api/app/v1';

    public function __construct()
    {
        parent::__construct();

        if($this->getClient()->getNamespace()){
            $this->api_prifix.= '/' . $this->getClient()->getNamespace();
        }
    }

    /**
     * @param AbstractApplicationModel $Model
     * @param                          $state
     * @param int                      $sleepTime
     * @param int                      $timeOut
     *
     * @return AbstractApplicationModel
     * @throws Exception
     */
    public function waitForState(AbstractApplicationModel $Model, $state, $sleepTime = 10, $timeOut = 600)
    {
        $timer = 0;
        $Model = $this->getByUri($Model->getResourceUri());
        while ($state != $Model->getState()) {
            if ($timer >= $timeOut) {
                throw new Exception(sprintf('Waited resource [%s] to be in state [%s] timed out [%s seconds].',
                    $Model->getResourceUri(), $state, $timer));
            }
            sleep($sleepTime);
            $timer += $sleepTime;
            $Model = $this->getByUri($Model->getResourceUri());
        }

        return $Model;
    }

    /**
     * @param $uri
     *
     * @return AbstractApplicationModel
     */
    abstract function getByUri($uri);

    /**
     * @param $uri
     *
     * @return AbstractGetResponse
     */
    abstract function getListByUri($uri);
}