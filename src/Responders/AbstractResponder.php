<?php
namespace Tarcha\WebKernel\Responders;

use Aura\Web\Response;
use Aura\Web_Kernel\AbstractResponder as AuraAbstractResponder;
use Tarcha\WebKernel\Payloads\PayloadInterface;

abstract class AbstractResponder extends AuraAbstractResponder
{

    protected $available = [];

    protected $response;

    protected $payload;

    protected $payload_methods = [];

    private $kernel_payload_methods = [
        'Tarcha\WebKernel\Payload\NoContent' => 'noContent',
        'Tarcha\WebKernel\Payload\Error' => 'error',
        'Tarcha\WebKernel\Payload\NotFound' => 'notFound',
        'Tarcha\WebKernel\Payload\NotRecognized' => 'notRecognized',
        'Tarcha\WebKernel\Payload\Success' => 'success'
    ];


    public function __construct(
        Response $response
    ) {
        $this->response = $response;
        $this->init();
    }

    protected function init()
    {
        // merge payload methods with builtin defaults
        $this->payload_methods
            = array_merge($this->kernel_Payload_methods, $this->payload_methods);
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
        $this->response->content->setType('application/json');
        return $this->response;
    }

    protected function success()
    {
        $this->response->status->set('200');
        $this->response->content->set('success');
        return $this->response;
    }

    protected function created()
    {
        $data = $this->payload->get();
        $this->response->status->set('201');
        $this->response->content->set($data);
        return $this->response;
    }

    protected function AlreadyExists()
    {
        $data = $this->payload->get('exception');
        $this->response->status->set('422');
        $this->response->content->set($e->getMessage());
        return $this->response;
    }
}
