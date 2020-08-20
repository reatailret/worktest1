<?php
namespace Worktest;

use Cache\Adapter\Memcached\MemcachedCachePool;
use GeoIp2\Database\Reader;
use Torann\GeoIP\Services\MaxMindDatabase;

class Ipfinder
{

    private $cachePool;
    public function __construct()
    {
        $client = new \Memcached();
        $client->addServer(Config::$memcached_host, Config::$memcached_port);
        $this->cachePool = new MemcachedCachePool($client);
    }
/**
 * Find country for given ip
 *
 * @param string $ip
 * @return string
 */
    public function findCountry(string $ip)
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            throw new \Exception("Bad ip format", 1);

        }

        $cacheKey = 'ip--' . str_replace(':','-',$ip);
        $cacheItem = $this->cachePool->getItem($cacheKey);
        $country = $cacheItem->get();

        if (!$country) {

            $reader = new Reader(Config::$geoip_db_path);
            $record = $reader->city($ip);
            $country = $record;
            $cacheItem->set($country);
            $this->cachePool->save($cacheItem);
        }

        return $country;

    }
    /**
     * Download database
     *
     * @param Event $event
     * @return void
     */
    public static function updateDB(\Composer\Script\Event $event)
    {
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        require $vendorDir . '/autoload.php';

        $srv=new MaxMindDatabase();
        $srv->update();
    }

}
