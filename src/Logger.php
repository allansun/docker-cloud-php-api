<?php


namespace DockerCloud;

use Monolog\Handler\StreamHandler;

class Logger
{
    /**
     * @var Logger
     */
    static private $instance;

    /**
     * @var \Monolog\Logger
     */
    private $logger;

    /**
     * Logger constructor.
     */
    private function __construct()
    {
        $this->logger = new \Monolog\Logger('DockerCloud');
        $this->logger->pushHandler(new StreamHandler('php://stdout'));
    }

    /**
     * @return Logger
     */
    static public function getInstance()
    {
        if (!static::$instance) {
            static::$instance = new Logger();
        }

        return static::$instance;
    }

    /**
     * @param       $message
     * @param array $extra
     *
     * @return $this
     */
    public function log($message, $extra = [])
    {
        $this->logger->info($message, $extra);

        return $this;
    }
}