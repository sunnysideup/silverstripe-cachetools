<?php

class BuildTaskTestCache extends BuildTask
{
    protected $title = 'Test Silverstripe Cache';

    protected $description = '
        Basic test for the Sillverstripe Cache.
        It will show the date and time the cache was made.';

    public function run($request)
    {
        $cache = SS_Cache::factory('foo');
        $result = $cache->load('bar');
        if (!$result || isset($_GET['reload'])) {
            $time = time();
            for ($i = 1; $i < $time; $i = $i + 75) {
                $temp = $time / $time - rand(0, 10);
            }
            $result = date('Y-m-d H:i:s');
            ;
            DB::alteration_message('not from cache: '.$result, 'deleted');
            $cache->save($result, 'bar');
        } else {
            DB::alteration_message('from cache: '.$result, 'created');
        }

        if (isset($_GET['setm'])) {
            foreach (array('11211', '11212', '11213', '11214') as $port) {
                echo "<h1>SETTING: $port</h1>";
                $memcache = new Memcache;
                $cacheAvailable = $memcache->connect('127.0.0.1', $port);
                if ($cacheAvailable) {
                    $memcache->set('test_memcache', 'set at: '.date('Y-m-d H:i:s'));
                    echo "SET";
                } else {
                    echo "NOT SET";
                }
            }
        } elseif (isset($_GET['getm'])) {
            foreach (array('11211', '11212', '11213', '11214') as $port) {
                echo "<h1>GETTING: $port</h1>";
                $memcache = new Memcache;
                $cacheAvailable = $memcache->connect('127.0.0.1', $port);
                if ($cacheAvailable) {
                    $outcome = $memcache->get('test_memcache');
                    echo $outcome;
                } else {
                    echo "COULD NOT GET";
                }
            }
        }
    }
}
