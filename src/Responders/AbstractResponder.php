<?php
namespace Tarcha\WebKernel\Responders;

use Aura\Web\Response;
use Aura\Web_Kernel\AbstractResponder as AuraAbstractResponder;
use Tarcha\WebKernel\Payloads\PayloadInterface;

abstract class AbstractResponder extends AuraAbstractResponder
{

    protected $available = array();

    protected $response;

    protected $payload;

    protected $payload_method = array();


    public function __construct(
        Response $response
    ) {
        $this->response = $response;
        $this->init();
    }

    protected function init()
    {
        if (! isset($this->payload_method['Web_Kernel\Payload\Json'])) {
            $this->payload_method['Tarcha\WebKernel\Payload\Json'] = 'json';
        }
        if (! isset($this->payload_method['Web_Kernel\Payload\NoContent'])) {
            $this->payload_method['Tarcha\WebKernel\Payload\NoContent'] = 'noContent';
        }
        if (! isset($this->payload_method['Web_Kernel\Payload\Error'])) {
            $this->payload_method['Tarcha\WebKernel\Payload\Error'] = 'error';
        }
        if (! isset($this->payload_method['Web_Kernel\Payload\NotFound'])) {
            $this->payload_method['Tarcha\WebKernel\Payload\NotFound'] = 'notFound';
        }
        if (! isset($this->payload_method['Web_Kernel\Payload\NotRecognized'])) {
            $this->payload_method['Tarcha\WebKernel\Payload\NotRecognized'] = 'notRecognized';
        }
        if (! isset($this->payload_method['Web_Kernel\Payload\Success'])) {
            $this->payload_method['Tarcha\WebKernel\Payload\Success'] = 'success';
        }
        
        $this->response->content->setType('application/json');
    }

    public function __invoke()
    {
        $class = get_class($this->payload);
        $method = isset($this->payload_method[$class])
                ? $this->payload_method[$class]
                : 'notRecognized';
        $this->$method();
        return $this->response;
    }

    public function setPayload(PayloadInterface $payload)
    {
        $this->payload = $payload;
    }

    protected function noContent()
    {
        $this->response->status->set(204);
    }

    protected function notRecognized()
    {
        $domain_status = $this->payload->get('status');
        $this->response->status->set('500');
        $this->response->content
            ->set("Unknown domain payload status: '$domain_status'");
        return $this->response;
    }

    protected function notFound()
    {
        $this->response->status->set(404);
    }

    protected function error()
    {
        $e = $this->payload->get('exception');
        $this->response->status->set('500');
        $this->response->content->set($e->getMessage());
    }

    // demograph
    protected function json()
    {
        $data = $this->payload->get();
        $this->response->status->set('200');
        $this->response->content->set(json_encode($data));
        return $this->response;
    }
    
    protected function success()
    {
        $this->response->status->set('200');
        $this->response->content->set('success');
        return $this->response;
    }
}
