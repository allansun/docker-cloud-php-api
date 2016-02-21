<?php


namespace DockerCloud\Model\Response;


use DockerCloud\Model\AbstractModel;

class MetaData extends AbstractModel
{
    /**
     * @var int
     */
    protected $limit;

    /**
     * @var string
     */
    protected $next;

    /**
     * @var int
     */
    protected $offset;

    /**
     * @var string
     */
    protected $previous;

    /**
     * @var int
     */
    protected $total_count;

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return string
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @return string
     */
    public function getPrevious()
    {
        return $this->previous;
    }

    /**
     * @return int
     */
    public function getTotalCount()
    {
        return $this->total_count;
    }

    /**
     * @param int $limit
     *
     * @return $this
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @param string $next
     *
     * @return $this
     */
    public function setNext($next)
    {
        $this->next = $next;

        return $this;
    }

    /**
     * @param int $offset
     *
     * @return $this
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @param string $previous
     *
     * @return $this
     */
    public function setPrevious($previous)
    {
        $this->previous = $previous;

        return $this;
    }

    /**
     * @param int $total_count
     *
     * @return $this
     */
    public function setTotalCount($total_count)
    {
        $this->total_count = $total_count;

        return $this;
    }

}