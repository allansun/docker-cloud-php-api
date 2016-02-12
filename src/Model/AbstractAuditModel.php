<?php


namespace DockerCloud\Model;


abstract class AbstractAuditModel extends AbstractModel
{
    abstract function getUuid();
}