<?php

namespace Vx\JsUploadBundle\Event;


use Symfony\Contracts\EventDispatcher\Event;

class UploaderEvent extends Event
{
    const EVENT_OPTIONS_UPLOAD = 'vx_js_upload.event.options.upload';
    const EVENT_OPTIONS_GET = 'vx_js_upload.event.options.get';
    const EVENT_OPTIONS_DELETE = 'vx_js_upload.event.options.delete';
}
