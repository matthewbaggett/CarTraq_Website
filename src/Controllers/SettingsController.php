<?php
namespace Horizon\Controllers;

use Horizon\Models\LoadBalancersModel;
use Horizon\Services\AbstractFormService;
use Horizon\TableGateways\LoadBalancersTableGateway;
use Slim\Http\Request;
use Slim\Http\Response;

class SettingsController
{
    /** @var \Slim\Container */
    private $container;
    /** @var AbstractFormService */
    protected $formService;


    //Constructor
    public function __construct(\Slim\Container $container)
    {
        $this->container   = $container;
        $this->formService = $container->get(AbstractFormService::class);
    }

    public function showSettings(Request $request, Response $response, array $args = [])
    {
        /** @var LoadBalancersTableGateway $loadBalancerTableGateway */
        $loadBalancerTableGateway    = $this->container->get(LoadBalancersTableGateway::class);
        list($loadBalancers, $total) = $loadBalancerTableGateway->fetchAll();
        return $this->container->view->render($response, 'settings/settings.html.twig', [
            'loadbalancers' => $loadBalancers
        ]);
    }

    public function showNewLoadBalancer(Request $request, Response $response, array $args = [])
    {
        $faker = $this->container->get("Faker");

        return $this->container->view->render($response, 'settings/loadbalancers/new.html.twig', [
            'mode'                                 => 'new',
            'randomly_generated_loadbalancer_name' => $faker->firstname,
            'csrf'                                 => $this->formService->getCsrfTokenValue($request),
        ]);
    }

    public function saveNewLoadBalancer(Request $request, Response $response, array $args = [])
    {
        /** @var $loadBalancer LoadBalancersModel */
        if ($request->getParam('id')) {
            /** @var LoadBalancersTableGateway $loadBalancerTableGateway */
            $loadBalancerTableGateway = $this->container->get(LoadBalancersTableGateway::class);
            $loadBalancer             = $loadBalancerTableGateway->getById($request->getParam('id'));
        } else {
            $loadBalancer = new LoadBalancersModel();
        }
        $name = $request->getParam('loadbalancer_name');
        $ips  = explode("\n", trim($request->getParam('loadbalancer_addresses')));

        $loadBalancer->setIps(json_encode($ips));
        $loadBalancer->setCreated(date("Y-m-d H:i:s"));
        $loadBalancer->setName($name);
        $loadBalancer->save();

        header("Location: /settings");
        exit;
    }

    public function showEditLoadBalancer(Request $request, Response $response, array $args = [])
    {
        /** @var LoadBalancersTableGateway $loadBalancerTableGateway */
        $loadBalancerTableGateway = $this->container->get(LoadBalancersTableGateway::class);
        /** @var LoadBalancersModel $loadBalancer */
        $loadBalancer = $loadBalancerTableGateway->getById($args['id']);
        $faker        = $this->container->get("Faker");

        return $this->container->view->render($response, 'settings/loadbalancers/new.html.twig', [
            'mode'                                 => 'edit',
            'randomly_generated_loadbalancer_name' => $faker->firstname,
            'id'                                   => $loadBalancer->getId(),
            'name'                                 => $loadBalancer->getName(),
            'ips'                                  => implode("\n", json_decode($loadBalancer->getIps(), true)),
            'csrf'                                 => $this->formService->getCsrfTokenValue($request),
        ]);
    }
}
