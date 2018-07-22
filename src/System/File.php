<?php

namespace Yaecho\System;

/**
 * 文件类
 *
 * @author Yaecho 
 */
class File
{
    /**
     * 文件名
     *
     * @var string
     * @author Yaecho 
     */
    protected $filename = '';

    /**
     * 文件路径
     *
     * @var string
     * @author Yaecho 
     */
    protected $path = '';

    /**
     * 文件后缀
     *
     * @var string
     * @author Yaecho 
     */
    protected $ext = '';

    /**
     * 是否存在
     *
     * @return boolean
     * @author Yaecho 
     */
    public function isExist() : bool
    {
        return is_file($this->path);
    }

    /**
     * 读取文件
     *
     * @return string
     * @author Yaecho 
     */
    public function read() : string
    {
        return file_get_contents($this->path);
    }


    /**
     * 写入文件
     *
     * @param string $data 写入内容
     * @return boolean
     * @author Yaecho 
     */
    public function write(string $data) : bool
    {
        return false !== file_put_contents($this->path, $data, FILE_APPEND | LOCK_EX);
    }

    /**
     * 加载文件
     *
     * @param string $file 文件路径
     * @return boolean
     * @author Yaecho 
     */
    public function load(string $file) : void
    {
        $pathinfo = pathinfo($file);
        $this->path = $file;
        $this->filename = $pathinfo['basename'];
        $this->ext = $pathinfo['extension'];
    }

    /**
     * 构造函数
     *
     * @param string $file 文件路径
     * @author Yaecho 
     */
    public function __construct(string $file)
    {
        $this->load($file);
    }
}