<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/22/2018
 * Time: 2:00 PM
 */

namespace core\dispatchers;

/**
 * Class DeferredEventDispatcher
 * @package core\dispatchers
 * @property bool $defer
 * @property EventDispatcher $next
 * @property array $queue
 */

class DeferredEventDispatcher implements EventDispatcher
{
    private $defer = false;
    private $next;
    private $queue = [];

    public function __construct(EventDispatcher $next)
    {
        $this->next = $next;
    }

    public function dispatch($event): void
    {
        if ($this->defer) {
            $this->queue[] = $event;
        } else {
            $this->next->dispatch($event);
        }
    }

    public function dispatchAll(array $events): void
    {
        foreach ($events as $event) {
            $this->dispatch($event);
        }
    }

    public function defer(): void
    {
        $this->defer = true;
    }

    public function clean(): void
    {
        $this->queue = [];
        $this->defer = false;
    }

    public function release(): void
    {
        foreach ($this->queue as $i => $event) {
            $this->next->dispatch($event);
            unset($this->queue[$i]);
        }
        $this->defer = false;
    }
}