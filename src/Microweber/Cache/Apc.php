<?php
namespace Microweber\Cache;
$mw_cache_get_content_memory = array();
$mw_skip_memory = array();

class Apc
{
    public $mw_cache_mem = array();


    public $group_prefix = false;
    function __construct(){

        if($this->group_prefix == false and isset($_SERVER["SERVER_NAME"])){
            $this->group_prefix  = 'apc-'.($_SERVER["SERVER_NAME"]);
        }
    }

    public function save($data_to_cache, $cache_id, $cache_group = 'global')
    {

        $cache_group = $this->group_prefix.$cache_group;


        $cache_id = $cache_group . $cache_id;
        static $apc_apc_delete;
        if ($apc_apc_delete == false) {
            $apc_apc_delete = function_exists('apc_delete');
        }
        if ($apc_apc_delete == true) {
            @apc_delete($cache_id);
        }

        $data_to_cache = serialize($data_to_cache);

        $cache = MW_CACHE_CONTENT_PREPEND . $data_to_cache;
        //@apc_delete($cache_id);
        try {
            @apc_store($cache_id, $cache, APC_EXPIRES);
        } catch (Exception $e) {

        }


    }

    public function delete($cache_group = 'global')
    {


        global $mw_cache_deleted_groups;

        if (!is_array($mw_cache_deleted_groups)) {
            $mw_cache_deleted_groups = array();
        }
        if (!in_array($cache_group, $mw_cache_deleted_groups)) {

            $mw_cache_deleted_groups[]= $cache_group;
        }




        $is_cleaning_now = mw_var('is_cleaning_now');

        $apc_no_clear = mw_var('apc_no_clear');

        if ($apc_no_clear == false) {
            $apc_exists = function_exists('apc_clear_cache');
            if ($apc_exists == true) {
                return apc_clear_cache('user');

                //apc_clear_cache('user');
                // d('apc_clear_cache');
                 apc_clear_cache('user');
                //$hits = apc_cache_info('user');
//                if (isset($hits["cache_list"]) and is_array($hits["cache_list"])) {
//
//                    foreach ($hits["cache_list"] as $cache_list_value) {
//                        if (isset($cache_list_value['info'])) {
//                            if (stristr($cache_group, $cache_group)) {
//                                // d($cache_list_value['info']);
//                                apc_delete($cache_list_value['info']);
//                            }
//                            //d($cache_list_value['info']);
//                        }
//                    }
//                }

            }
        } else {
            mw_var('is_cleaning_now', false);

        }

    }

    public function debug()
    {

        return apc_cache_info('user');

    }

    public function get($cache_id, $cache_group = 'global', $time = false)
    {


        global $mw_cache_deleted_groups;

        if (!is_array($mw_cache_deleted_groups)) {
            $mw_cache_deleted_groups = array();
        }
        if (in_array($cache_group, $mw_cache_deleted_groups)) {
            return false;
        }
        $cache_group = $this->group_prefix.$cache_group;


        $cache_id_apc = $cache_group . $cache_id;
        global $mw_cache_get_content_memory;
        if (isset($mw_cache_get_content_memory[$cache_id_apc])) {
            return ($mw_cache_get_content_memory[$cache_id_apc]);
        }

        $cache = apc_fetch($cache_id_apc);

        if ($cache) {
            if (isset($cache) and strval($cache) != '') {

                $search = MW_CACHE_CONTENT_PREPEND;

                $replace = '';

                $count = 1;

                $cache = str_replace($search, $replace, $cache, $count);
                $cache = unserialize($cache);
            }
            $mw_cache_get_content_memory[$cache_id_apc] = $cache;
            //d($cache_id_apc);
            return $cache;
        }
        $mw_cache_get_content_memory[$cache_id_apc] = false;
        return false;
    }

    public function clearcache($gr = false)
    {

        return $this->delete($gr);
    }

    public function purge()
    {

        return $this->clearcache();
    }

    public function OLD_clearcache($group)
    {

        $hits = apc_cache_info('user');
        if (isset($hits["cache_list"]) and is_array($hits["cache_list"])) {

            foreach ($hits["cache_list"] as $cache_list_value) {
                if (isset($cache_list_value['info'])) {
                    //if (strstr($cache_group, $cache_group)) {
                    //d($cache_list_value['info']);
                    apc_delete($cache_list_value['info']);
                    //}

                }
            }
        }


        return apc_clear_cache('user');
    }


    public function delete_all()
    {

        return $this->clearcache();
    }

    //$mw_cache_mem = array();

}
