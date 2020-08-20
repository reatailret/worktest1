<?php
namespace Worktest;

class Config
{

    public static $memcached_host = 'localhost';
    public static $memcached_port = 11211;

    public static $geoip_db_path = 'storage/geoip.mmdb.';
    public static $geoip_update_url='https://download.maxmind.com/app/geoip_download?edition_id=GeoLite2-City&license_key=2st82h3ghLV9A9qA&suffix=tar.gz';
}
