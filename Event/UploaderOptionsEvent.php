<?php
/**
 * Created by PhpStorm.
 * User: ami
 * Date: 11/8/15
 * Time: 11:27 AM
 */

namespace Vx\JsUploadBundle\Event;


class UploaderOptionsEvent extends UploaderEvent
{
    private $options;

    /**
     * UploaderOptionsEvent constructor.
     * @param $options
     */
    public function __construct($options = array())
    {
        $this->options = $options;
    }

    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param mixed $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

}