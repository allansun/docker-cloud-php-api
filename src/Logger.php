<?php


namespace DockerCloud;

use Monolog\Handler\NullHandler;
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
        if (getenv('DEBUG')) {
            $this->logger->pushHandler(new StreamHandler('php://stdout'));
        } else {
            $this->logger->pushHandler(new NullHandler());
        }
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

    /**
     * @return \Monolog\Logger
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * This function is only intended to be used in unit test
     * You do not normally need to call it
     *
     * @return Logger
     */
    static public function reInitiate()
    {
        static::$instance = null;

        return self::getInstance();
    }
}