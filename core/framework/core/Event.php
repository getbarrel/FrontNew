<?php

/**
 * Description of Evnet
 *
 * @author hoksi
 */
class CI_Event
{
    private $eventMan;
    private $listners = [];
    private $target   = false;

    public function __construct()
    {
        $this->eventMan = new \Zend\EventManager\EventManager();
    }

    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * 이벤트 리스너에 이벤트 등록.
     * @param string $eventName
     * @param callable $listener
     * @param int $priority
     * @return $this
     */
    public function on($eventName, $listener, $priority = 1)
    {
        if ($this->target !== false) {
            $this->listners[] = $this->eventMan->attach($this->target.'::'.$eventName, $listener, $priority);
            $this->target     = false;
        } else {
            $this->listners[] = $this->eventMan->attach($eventName, $listener, $priority);
        }

        return $this;
    }

    /**
     * 이벤트 리스너의 이벤트 해제.
     * @param string $eventName
     * @return $this
     */
    public function off($eventName)
    {
        foreach ($this->listners as $listner) {
            $this->eventMan->detach($listner, $eventName);
        }

        return $this;
    }

    /**
     * 이벤트 전파 (이전 버전 호환용)
     * @param string $eventName
     * @param array $argv
     * @return int
     */
    public function emmit($eventName, $argv = [])
    {
        return $this->trigger($eventName, $argv);
    }

    /**
     * 이벤트 전파.
     * @param string $eventName
     * @param array $argv
     * @return int
     */
    public function trigger($eventName, $argv = [])
    {
        if ($this->target !== false) {
            $eventCnt     = $this->eventMan->trigger($this->target.'::'.$eventName, $this->target, $argv)->count();
            $this->target = false;
        } else {
            /*echo "1<br>";
            print_r($eventName);
            echo "<hr>";*/
            $eventCnt = $this->eventMan->trigger($eventName, null, $argv)->count();
        }

        return $eventCnt;
    }
}