<?php
namespace Demograph\Kernel;

use Aura\Web\Response;
use Demograph\Kernel\PayloadInterface;

abstract class AbstractResponder
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
        if (! isset($this->payload_method['Domain\Payload\Error'])) {
            $this->payload_method['Domain\Payload\Error'] = 'error';
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
}
