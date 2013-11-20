<?php

namespace Microweber;


class Application
{


    public $config = array();
    public $config_file; //indicates if config is being loaded from file
    public $table_prefix = null;
    public $providers = array();
    public static $instance;

    public static function getInstance($constuctor_params = null)
    {
        if (self::$instance == NULL) self::$instance = new Application($constuctor_params);
        return self::$instance;
    }

    public function __construct($config = false)
    {

        if (empty($this->config)) {
            if ($config != false) {
                if (is_string($config)) {
                    $this->loadConfigFromFile($config);
                } else if (!empty($config)) {
                    $this->config = $config;
                }
            } else {

                $this->loadConfigFromFile();
            }

        }


        if (!defined('MW_TABLE_PREFIX')) {

            if (!defined('MW_TABLE_PREFIX')) {
                if (!isset($this->config['installed']) or trim($this->config['installed']) != 'yes') {
                    if (isset($_REQUEST['table_prefix'])) {
                        $table_prefix = strip_tags($_REQUEST['table_prefix']);
                        $table_prefix = str_replace(array(' ', '.', '*', ';'), '-', $table_prefix);
                        define('MW_TABLE_PREFIX', $table_prefix);
                    }
                }
            }
            if (!defined('MW_TABLE_PREFIX')) {
                if (isset($this->config['table_prefix'])) {
                    $pre = $this->config['table_prefix'];
                    //var_dump($pre);
                    //exit(1);
                    define('MW_TABLE_PREFIX', $pre);
                }
            }

            if (!defined('MW_TABLE_PREFIX')) {
                define('MW_TABLE_PREFIX', null);
            }
        }

        if (defined('MW_TABLE_PREFIX')) {
            $this->table_prefix = MW_TABLE_PREFIX;
        }


        global $_mw_global_object;
        //  if (!is_object($_mw_global_object)) {
        $_mw_global_object = $this;
        //}


    }

    public function config($k, $no_static = false)
    {
        return $this->c($k, $no_static);
    }


    public function c($k, $no_static = false)
    {

        if ($no_static == true) {
            $this->config = false;
        }

        if (isset($this->config[$k])) {
            return $this->config[$k];
        } else {
            $load_cfg = false;
            if ($this->config_file != false
                and is_file($this->config_file)
            ) {


                $load_cfg = $this->config_file;
            } else
                if (defined('MW_CONFIG_FILE') and MW_CONFIG_FILE != false and is_file(MW_CONFIG_FILE)) {
                    //try to get from the constant
                    $load_cfg = MW_CONFIG_FILE;
                }

            if ($load_cfg != false) {
                include_once ($load_cfg);
                if (isset($config)) {
                    $this->config = $config;
                    if (isset($this->config[$k])) {

                        return $this->config[$k];
                    }
                } else {
                    include (MW_CONFIG_FILE);
                    if (isset($config)) {
                        $this->config = $config;
                        if (isset($this->config[$k])) {

                            return $this->config[$k];
                        }
                    }
                }
            }
        }
    }

    public function loadConfigFromFile($path_to_file = false, $reload = false)
    {

        if (defined('MW_CONFIG_FILE')) {
            $path_to_file = MW_CONFIG_FILE;
        } else {

            $path_to_file = MW_ROOTPATH . 'config.php';
            define('MW_CONFIG_FILE', $path_to_file);
        }


        if ($reload == false and $this->config_file != $path_to_file
            and is_file($path_to_file)
        ) {

            include_once ($path_to_file);
            $this->config_file = $path_to_file;
            if (isset($config)) {

                $this->config = $config;
                return $this->config;
            }
        } else if ($reload == true and is_file($path_to_file)) {
            include  ($path_to_file);
            $this->config_file = $path_to_file;
            if (isset($config)) {

                $this->config = $config;
                return $this->config;
            }

        }
    }


    public function __get($property)
    {

        $property_orig_case = $property;
        $property = ucfirst($property);
        $property2 = strtolower($property);
        if (isset($this->$property2)) {

            return $this->$property2;
        } else if (isset($this->$property)) {

            return $this->$property;
        } else if (isset($this->providers[$property])) {
            return $this->providers[$property];
        } elseif (isset($this->providers[$property2])) {
            return $this->providers[$property2];
        } else if (property_exists($this, $property2)) {
            return $this->$property2;
        }


        if (property_exists($this, $property)) {
            return $this->$property;
        } else if (property_exists($this, $property2)) {
            return $this->$property2;
        } else {


            try {


                //autoload the class
                if (class_exists($property, 1)) {

                    $mw = $property;
                } else {
                    $ns = __NAMESPACE__;
                    $mw = $ns . '\\' . $property;
                    $mw = str_ireplace(array('/', '\\\\', $ns . '\\' . $ns), array('\\', '\\', $ns), $mw);

                }


                $prop = new $mw($this);
            } catch (Exception $e) {
                $prop = new $property($this);
            }
            if (isset($prop)) {

                return $this->$property = $this->providers[$property] = $this->$property_orig_case = $prop;
            }

        }
    }

    public function get($provider, $args = null)
    {
        // A.k.a call
        return $this->call($provider, $args);
    }

    public function call($provider, $args = null)
    {


        if (!method_exists($this, $provider)) {
            if (!isset($this->providers[$provider])) {
                if (!is_object($provider)) {
                    if ($args != null) {
                        $this->providers[$provider] = new $provider($args);

                    } else {
                        $this->providers[$provider] = new $provider;

                    }
                }
                return $this->providers[$provider];

            } else {

                return $this->$provider($args);
            }
        }

        if (isset($this->$provider)) {
            return $this->$provider;
        } elseif (isset($this->providers[$provider])) {
            return $this->providers[$provider];
        }


    }

    public function __call($class, $constructor_params)
    {


        if (!method_exists($this, $class)) {


            $class_name = strtolower($class);

            $class = ucfirst($class);
            $class = str_replace('/', '\\', $class);


            $ns = __NAMESPACE__;
            $mw = $ns . '\\' . $class;
            $mw = str_ireplace(array('/', '\\\\', $ns . '\\' . $ns), array('\\', '\\', $ns), $mw);


            if (!isset($this->providers[$class_name])) {
                if ($constructor_params == false) {

                    try {
                        $prop = new $mw($constructor_params);
                    } catch (Exception $e) {
                        $prop = new $class($constructor_params);
                    }
                    if (isset($prop)) {
                        $this->providers[$class_name] = $prop;
                    }
                } else {

                    try {
                        $prop = new $mw($constructor_params);

                    } catch (Exception $e) {
                        $prop = new $class($constructor_params);
                    }
                    if (isset($prop)) {

                        $this->providers[$class_name] = $prop;
                    }

                }

            }
            return $this->providers[$class_name];


        }


    }

    public function __set($property, $value)
    {


        if (!property_exists($this, $property) and !isset($this->providers[$property])) {

            $property = ucfirst($property);
            $property2 = strtolower($property);

            return $this->$property = $this->$property2 = $this->providers[$property] = $this->providers[$property2] = $value;

        }
    }


}