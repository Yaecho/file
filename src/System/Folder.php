<?php

namespace Yaecho\System;

/**
 * 文件夹
 *
 * @author Yaecho 
 */
class Folder
{
    /**
     * 文件路径
     *
     * @var string
     * @author Yaecho 
     */
    protected $path = '';

    /**
     * 子目录
     *
     * @var array
     * @author Yaecho 
     */
    protected $child = [];

    /**
     * 文件
     *
     * @var array
     * @author Yaecho 
     */
    protected $file = [];

    /**
     * 构造函数
     *
     * @param string $basepath
     * @author Yaecho 
     */
    public function __construct(string $basepath)
    {
        $this->load($basepath);
    }

    /**
     * 加载
     *
     * @param string $basepath 初始路径
     * @return void
     * @author Yaecho 
     */
    public function load(string $basepath) : void
    {
        if (substr($basepath, -1, 1) !== '/') {
            $basepath .= '/';
        }
        $this->path = $basepath;
        if (!$this->isExist()) {
            if (!mkdir($this->path, 0777, true)) {
                throw \Exception('can\'t create folder');
            }
        }
        foreach (scandir($this->path) as $childpath) {
            //去除 . ..
            if (in_array($childpath, ['.', '..'])) {
                continue;
            }
            $truepath = $this->path . $childpath;
            if (is_file($truepath)) {
                $this->file[] = $truepath;
            }
            if (is_dir($truepath)) {
                $this->child[] = new Folder($truepath);
            }
        }
    }

    /**
     * 是否存在
     *
     * @return boolean
     * @author Yaecho 
     */
    public function isExist() : bool
    {
        return is_dir($this->path);
    }

    /**
     * 搜索
     *
     * @param mixed $filename
     * @return array
     * @author Yaecho 
     */
    public function search($filename) : array
    {
        if (is_string($filename)) {
            $filename = array($filename);
        }
        $result = [];
        foreach ($this->file as $single) {
            foreach ($filename as $one) {
                //使用正则匹配忽略大小写
                if (preg_match('/' . $one . '$/Ui',$single)) {
                    $result[] = $single;
                }
            }
        }
        foreach ($this->child as $single) {
            $childResult = $single->search($filename);
            if (is_array($childResult) && !empty($childResult)) {
                $result = array_merge($result, $childResult);
            }
        }

        return array_unique($result);
    }
}
