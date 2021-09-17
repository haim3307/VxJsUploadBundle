<?php

namespace Vx\JsUploadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Vx\JsUploadBundle\Event\UploaderEvent;
use Vx\JsUploadBundle\Event\UploaderOptionsEvent;
use Vx\JsUploadBundle\Uploader\CustomUploadHandler as UploadHandler;
use Symfony\Component\HttpFoundation\Response;

class UploadController extends Controller
{
    protected function getUploadOptions($profile)
    {
        $profile = strtolower($profile);

        if ($profile != 'default' && !$this->container->hasParameter('vx_js_upload.profile.'.$profile))
            return false;

        return $profile == 'default' ? UploadHandler::getDefaultOptions() 
                            : $this->container->getParameter('vx_js_upload.profile.'.$profile);
    }

    public function uploadAction($profile, $filename)
    {
        $options = $this->getUploadOptions($profile);

        if ($options == false)
            return new Response('Erreur profile: ' . $profile . ' doesn\'t existe');

        $options['filename'] = $filename;
        $options = $this->dispatchOptionsEvent($options, UploaderEvent::EVENT_OPTIONS_UPLOAD);

        $handler = new UploadHandler($this->generateUrl('vx_js_delete', array('profile' => $profile)), $options);
        $resp = new Response(json_encode($handler->post(false)));
        $resp->headers->set('content-type', 'application-json');

        return $resp;
    }

    public function getAction($profile)
    {
        $options = $this->getUploadOptions($profile);

        if ($options == false)
            return new Response('Erreur profile');
        $options = $this->dispatchOptionsEvent($options, UploaderEvent::EVENT_OPTIONS_GET);

        $handler = new UploadHandler($this->generateUrl('vx_js_delete', array('profile' => $profile)), $options);
        $resp = new Response(json_encode($handler->get(false)));
        $resp->headers->set('content-type', 'application-json');

        return $resp;
    }

    public function deleteAction($profile, $filename)
    {
        $options = $this->getUploadOptions($profile);
        if ($options == false)
            return new Response('Erreur: '.$profile.' doesn\'t exists');

        $options['filename'] = $filename;
        $options = $this->dispatchOptionsEvent($options, UploaderEvent::EVENT_OPTIONS_DELETE);

        $handler = new UploadHandler(null, $options);
        $resp = new Response(json_encode($handler->delete(false)));
        $resp->headers->set('content-type', 'application-json');

        return $resp;        
    }


    private function dispatchOptionsEvent($options, $eventType)
    {
        $options = $this->get('event_dispatcher')->dispatch(new UploaderOptionsEvent($options),$eventType)->getOptions();
        return $options;
    }

}
