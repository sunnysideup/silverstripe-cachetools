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
            for($i = 1; $i < $time; $i = $i + 75) {
                $temp = $time / $time - rand(0,10);
            }
            $result = date('Y-m-d H:i:s');;
            DB::alteration_message('not from cache: '.$result, 'deleted');
            $cache->save($result, 'bar');
        } else {
            DB::alteration_message('from cache: '.$result, 'created');
        }
    }

}
