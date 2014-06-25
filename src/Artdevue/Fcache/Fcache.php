<?php namespace Artdevue\Fcache;
/**
 * Created by PhpStorm.
 * User: AtrDevue
 * Date: 25.06.14
 * Time: 10:36
 */
use Illuminate\Cache\StoreInterface,
    Illuminate\Filesystem\Filesystem;

class Fcache implements StoreInterface {

    /**
     * The Illuminate Filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * A string that should be prepended to keys.
     *
     * @var string
     */
    protected $prefix;

    /**
     * The file cache directory
     *
     * @var string
     */
    protected $directory;

    /**
     * Create a new Dummy cache store.
     *
     * @param  string  $prefix
     * @return void
     */
    public function __construct($prefix = '')
    {
        $this->files = new Filesystem;
        $this->prefix = $prefix;
        $this->directory = \Config::get('cache.path');
    }

    /**
     * Retrieve an item from the cache by key.
     *
     * @param  string  $key
     * @return mixed
     */
    public function get($key)
    {
        $path = $this->path($key);

        if ( ! $this->files->exists($path))
        {
            return null;
        }

        try
        {
            $expire = substr($contents = $this->files->get($path), 0, 10);
        }
        catch (\Exception $e)
        {
            return null;
        }

        // If the current time is greater than expiration timestamps we will delete
        // the file and return null. This helps clean up the old files and keeps
        // this directory much cleaner for us as old files aren't hanging out.
        if (time() >= $expire)
        {
            return $this->forget($key);
        }

        return unserialize(substr($contents, 10));
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
        $value = $this->expiration($minutes).serialize($value);

        $this->createCacheDirectory($path = $this->path($key));

        $this->files->put($path, $value);
    }

    /**
     * Create the file cache directory if necessary.
     *
     * @param  string  $path
     * @return void
     */
    protected function createCacheDirectory($path)
    {
        try
        {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }
        catch (\Exception $e)
        {
            //
        }
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
        return $this->put($key, $value, 0);
    }

    /**
     * Remove an item from the cache.
     *
     * @param  string  $key
     * @return void
     */
    public function forget($key)
    {
        $file = $this->path($key);

        if ($this->files->exists($file))
        {
            $this->files->delete($file);
        }
        else
        {
            $folder = substr($file, 0, -6);
            if ($this->files->exists($folder))
            {
                $this->files->deleteDirectory($folder);
            }
        }
    }

    /**
     * Remove all items from the cache.
     *
     * @param  string  $tag
     * @return void
     */
    public function flush()
    {
        foreach ($this->files->directories($this->directory) as $directory)
        {
            $this->files->deleteDirectory($directory);
        }
    }

    /**
     * Get the Filesystem instance.
     *
     * @return \Illuminate\Filesystem\Filesystem
     */
    public function getFilesystem()
    {
        return $this->files;
    }

    /**
     * Get the working directory of the cache.
     *
     * @return string
     */
    public function getDirectory()
    {
        return $this->directory;
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

    /**
     * Get the full path for the given cache key.
     *
     * @param  string  $key
     * @return string
     */
    protected function path($key)
    {
        /*$parts = '';
        $array = explode('/',$key);

        $ph = array_diff($array, array(end($array)));

        if (count($ph > 0))
            $parts = implode('/',$ph) . '/';

        return $this->directory.'/'. $parts . end($array) . '.cache';*/

        $prefix = !empty($this->prefix) ? $this->prefix . '/' : '';

        return $this->directory.'/'. $prefix . trim($key, "/") . '.cache';
    }

    /**
     * Get the expiration time based on the given minutes.
     *
     * @param  int  $minutes
     * @return int
     */
    protected function expiration($minutes)
    {
        if ($minutes === 0) return 9999999999;

        return time() + ($minutes * 60);
    }
}