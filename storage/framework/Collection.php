<?php

namespace framework;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 *  Implements  better arrays
 **/
class Collection implements IteratorAggregate
{
    protected array $items = [];

    /**
     * Create a new Collection
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * Create a collection with the given range.
     *
     * @param int $from
     * @param int $to
     * @return static<int, int>
     */
    public static function range(int $from, int $to): static
    {
        return new static(range($from, $to));
    }

    /**
     * Return all items of the collection
     * @return array
     */
    public function all(): array
    {
        return $this->items;
    }

    /**
     * Flip items in the collection
     * @return $this
     */
    public function flip(): static
    {
        return new static(array_flip($this->items));
    }

    /**
     * returns first element of collection
     * @return mixed|null
     */
    public function first(): mixed
    {
        return $this->items[0] ?? null;
    }

    /**
     * returns last element of collection
     * @return false|mixed|null
     */
    public function last(): mixed
    {
        return end($this->items) ?? null;
    }

    public function add($item): self
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * return all items as json
     * @return bool|string
     */
    public function json(): bool|string
    {
        return json_encode($this->items);
    }

    /**
     * @inheritDoc
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }
}
