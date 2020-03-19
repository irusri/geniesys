<?php

namespace geniesys;

use Exception;

class ConfigManager
{
    /**
     * Full path of the configuration file
     */
    private $targetFile;
    private $Options = [];
    /**
     * multidimensional table containing the configuration data, initially
     * loaded from file
     */
    private $Config = [];
    /**
     * file processors supported by the application
     */
    private $availableDrivers = array('JSON', 'PHP','INI','YML');
    private $defaultSection = 'runtime';

    /**
     * ConfigManager constructor.
     * @param $filename
     * @param $location
     */
    public function __construct( $filename, $location=null )
    {
        $numargs = func_num_args();
        try
        {
            if($numargs > 2)
                throw new Exception('SETUP ERROR: configuration manager can accept only up to 2 parameters,'.$numargs.' given!');
            $this->configureOptions($filename,$location);
            $this->parseConfiguration($this->Options);
        }
        catch(Exception $a)
        {
            trigger_error($a->getMessage(),E_USER_ERROR);
        }
        return $this;
    }

    /**
     * @param $section
     * @param $item
     * @return array|bool|mixed
     */
    public function get($section=null, $item=null)
    {
      

        if($item) $item = trim(strtolower($item));
        if($section) $section = trim(strtolower($section));
        if(!count($this->Config)) return false;
        if(!$section or !strlen($section)) return $this->Config;
        if($section AND $item)
        {
            if(!isset($this->Config[$section]))
            {
                $key = $item;
                $item = $section;
                $section = $this->defaultSection;
                if(!isset($this->Config[$section][$item][$key]))
                    return false;
                return $this->Config[$section][$item][$key];
            }
        }
        elseif(!$item or !strlen($item))
        {
            $item = $section;
            if(isset($this->Config[$item])) return $this->Config[$item];
            $section = $this->defaultSection;
        }
        if(!isset($this->Config[$section][$item])) return false;
        return $this->Config[$section][$item];
    }
    /**
     * @param $section
     * @param $item
     * @param $value
     * @return bool
     */
    public function set($section,$item=null,$value=null)
    {
        ob_start();
        $numarg = func_num_args();
        $arguments=func_get_args();
        switch($numarg)
        {
            case 1:
                if(!is_array($arguments[0])) return false;
                $item=array_change_key_case($arguments[0], CASE_LOWER); $section=null; $value=null;
                break;
            case 2:
                if(is_array($arguments[0])) return false;
                $_arg = strtolower(trim($arguments[0]));
                if(is_array($arguments[1])){ $section=$_arg; $item =array_change_key_case($arguments[1], CASE_LOWER);$value=null;}
                else {$item = $_arg;$value=$arguments[1];$section=null;}
                break;
            default:
                break;
        }
        $section = $section? trim(strtolower($section)) : $this->defaultSection;
        if(!is_array($item))
        {
            if(!$value) return false;
            $item=trim(strtolower($item));
            if(!isset($this->Config[$section][$item]) or !is_array($this->Config[$section][$item])):
                $this->Config[$section][$item]=$value;
            else:
                if(!is_array($value)) $value = array($value);
                $this->Config[$section][$item] = array_merge($this->Config[$section][$item],$value);
            endif;
        }
        else
        {
            if($value) return false;
            $item = array_change_key_case($item, CASE_LOWER);
            $sectionsize = count($this->Config[$section]);
            $itemsize = count($item);
            if($sectionsize)
            {
                if($itemsize=='1')
                {
                    if(isset($this->Config[$section][key($item)]))
                        $this->Config[$section][key($item)] = array_merge($this->Config[$section][key($item)],$item[key($item)]);
                    else if(!is_numeric(key($item))) $this->Config[$section][key($item)]=$item[key($item)];
                }
                else $this->Config[$section] = array_merge($this->Config[$section],$item);
            }
            else $this->Config[$section] = $item;
        }
        $re = $this->Save();
        ob_end_clean();
        return $re;
    }
    /**
     * @param $section
     * @param $item
     * @return bool
     */
    public function del($section, $item=null)
    {
        $section = trim(strtolower($section));
        if($item and strlen($item))
        {
            $item = trim(strtolower($item));
            if(!isset($this->Config[$section]))
            {
                $key = $item;
                $item = $section;
                $section = $this->defaultSection;
                if(isset($this->Config[$section][$item][$key]))
                {
                    $itemSize=count($this->Config[$section][$item]);
                    if($itemSize>1) unset($this->Config[$section][$item][$key]);
                    else unset($this->Config[$section]);
                }
            }
            else
            {
                $sectionSize=count($this->Config[$section]);
                if(isset($this->Config[$section][$item]))
                {
                    if($sectionSize>1) unset($this->Config[$section][$item]);
                    else unset($this->Config[$section]);
                }
            }
        }
        else
        {
            $item = $section;
            if(!isset($this->Config[$item]))
            {
                $section = $this->defaultSection;
                $defaultSectionSize = count($this->Config[$section]);
                if(isset($this->Config[$section][$item]))
                {
                    if($defaultSectionSize>1) unset($this->Config[$section][$item]);
                    else unset($this->Config[$section]);
                }
            }
            else unset($this->Config[$item]);
        }
        return $this->Save();
    }

    /**
     * @param $file
     * @param $location
     * @return array
     * @throws Exception
     */
    private function configureOptions($file,$location=null){
        if(!is_string($file) or ($location and !is_string($location)))
            throw new Exception('SETUP ERROR: configuration manager can accept string only parameters');
        $default=[
            'driver' => 'PHP',
            'filename' => null,
            'directory' => __DIR__,
        ];
        $Options = [];
        if($location)
            $Options['directory']=rtrim($this->normalize($location),DIRECTORY_SEPARATOR);
        else{
            if(basename($file)!==$file)
                $Options['directory']= rtrim($this->normalize(pathinfo($file,PATHINFO_DIRNAME)),DIRECTORY_SEPARATOR);
        }
        $Options['filename'] = basename($file);
        if(strpos($Options['filename'],'.')!==false)
            $Options['driver'] = strtoupper(pathinfo($Options['filename'], PATHINFO_EXTENSION));
        else
            $Options['filename']= $Options['filename'].'.'.strtolower($default['driver']);
        if(!in_array($Options['driver'],$this->availableDrivers))
            throw new Exception('ERROR: driver "'.$Options['driver'].'" not supported');
        $this->Options = array_merge($default,$Options);
        return $this->Options;
    }

    /**
     * @param $path
     * @param $relativeTo
     * @return bool|string
     */
    private function normalize($path, $relativeTo = null) {
        $path = rtrim(preg_replace('#[/\\\\]+#', DIRECTORY_SEPARATOR, $path), DIRECTORY_SEPARATOR);
        $isAbsolute = stripos(PHP_OS, 'win')===0 ? preg_match('/^[A-Za-z]+:/', $path): !strncmp($path, DIRECTORY_SEPARATOR, 1);
        if (!$isAbsolute)
        {
            if (!$relativeTo) $relativeTo = getcwd();
            $path = $relativeTo.DIRECTORY_SEPARATOR.$path;
        }
        if (is_link($path) and ($parentPath = realpath(dirname($path))))
            return $parentPath.DIRECTORY_SEPARATOR.$path;
        if ($realpath = realpath($path))  return $realpath;
        $parts = explode(DIRECTORY_SEPARATOR, trim($path, DIRECTORY_SEPARATOR));
        while (end($parts) !== false)
        {
            array_pop($parts);
            $attempt = stripos(PHP_OS, 'win')===0 ? implode(DIRECTORY_SEPARATOR, $parts): DIRECTORY_SEPARATOR.implode(DIRECTORY_SEPARATOR, $parts);
            if ($realpaths = realpath($attempt))
            {
                $path = $realpaths.substr($path, strlen($attempt));
                break;
            }
        }
        return $path;
    }

    /**
     * @param array $options
     * @return array|bool|mixed
     */
    
    private function parseConfiguration($options=[])
    {
        try
        {  $this->targetFile = $this->normalize($options['directory'].DIRECTORY_SEPARATOR.$options['filename']);
            if(!file_exists($this->targetFile))
                file_put_contents($this->targetFile,'',LOCK_EX);
            switch($this->Options['driver'])
            {
                case 'JSON':
                    $this->Config = unserialize(json_decode(file_get_contents($this->targetFile), true));
                    break;
                case 'INI':
                    $this->Config = parse_ini_file($this->targetFile, true);
                    break;
                case 'YML':
                    $ndocs=0;
                    $this->Config = yaml_parse_file($this->targetFile,0,$ndocs);
                    break;
                default:
                    if(!$this->Config = include $this->targetFile) $this->Config = [];
                    break;
            }
        }
        catch(Exception $b)
        {
            trigger_error($b->getMessage(),E_USER_ERROR);
        }
        return $this->Config;
    }

    /**
     * @return bool
     */
    private function Save()
    {
        try {
            $content = null;
            switch($this->Options['driver'])
            {
                case 'JSON':
                    $content .= json_encode(serialize($this->Config));
                    break;
                case 'INI':
                    $content .= '; @file generator: geniesys Php "'.get_class($this).'" Class'.PHP_EOL;
                    $content .= '; @Last Update: '.date('Y-m-d H:i:s').PHP_EOL;
                    $content .= PHP_EOL;
                    foreach($this->Config as $section => $array)
                    {
                        is_array($array) or $array = array($array);
                        $content .= '[' . $section . ']'.PHP_EOL;
                        foreach( $array as $key => $value )
                            $content .= $key.' = '.$value.PHP_EOL;
                        $content .= PHP_EOL;
                    }
                    break;
                case 'YML':
                    $content .= yaml_emit ($this->Config, YAML_UTF8_ENCODING , YAML_LN_BREAK );
                    break;
                default:
                    $content .= '<?php'.PHP_EOL;
                    $content .= 'return ';
                    $content .= var_export($this->Config, true) . ';';
                    $content = preg_replace('/array\s+\(/', '[', $content);
                    $content = preg_replace('/,(\s+)\)/', '$1]', $content);
                    break;
            }
            file_put_contents($this->targetFile, $content, LOCK_EX);
        }
        catch (Exception $e)
        {  trigger_error($e->getMessage(),E_USER_ERROR);}
        return true;
    }
    /**
     * end of class
     */
}
