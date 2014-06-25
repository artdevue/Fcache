<?php namespace Artdevue\Fcache;
/**
 * Created by PhpStorm.
 * User: AtrDevue
 * Date: 25.06.14
 * Time: 10:36
 */
use Illuminate\Cache\StoreInterface;

class Fcache implements StoreInterface {

    /**
     * A string that should be prepended to keys.
     *
     * @var string
     */
    protected $prefix;

    /**
     * Create a new Dummy cache store.
     *
     * @param  string  $prefix
     * @return void
     */
    public function __construct($prefix = '')
    {
        $this->prefix = $prefix;
    }

    /**
     * Retrieve an item from the cache by key.
     *
     * @param  string  $key
     * @return mixed
     */
    public function get($key)
    {
        return null;    // never retrieve an item
    }

    /**
     * Store an item in the cache for a given number of minutes.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @param  int     $minutes
     * @return void
     */
    public function put($key, $value, $minutes)
    {
        // do nothing
    }

    /**
     * Increment the value of an item in the cache.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     *
     * @throws \LogicException
     */
    public function increment($key, $value = 1)
    {
        throw new \LogicException("Not supported by this driver.");
    }

    /**
     * Increment the value of an item in the cache.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     *
     * @throws \LogicException
     */
    public function decrement($key, $value = 1)
    {
        throw new \LogicException("Not supported by this driver.");
    }

    /**
     * Store an item in the cache indefinitely.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function forever($key, $value)
    {
        // do nothing
    }

    /**
     * Remove an item from the cache.
     *
     * @param  string  $key
     * @return void
     */
    public function forget($key)
    {
        // do nothing
    }

    /**
     * Remove all items from the cache.
     *
     * @return void
     */
    public function flush()
    {
        // do nothing
    }

    /**
     * Get the cache key prefix.
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }
}