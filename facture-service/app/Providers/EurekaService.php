<?php

namespace App\Providers;

use Eureka\EurekaClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class EurekaService
{
    private $eurekaUrl;
    private $appName;
    private $instanceId;
    private $port;

    public function __construct()
    {
        // Chargement des configurations depuis .env
        $this->eurekaUrl = rtrim(env('EUREKA_SERVER', 'http://discovery-service:8761/'), '/') . '/eureka/apps/';
        $this->appName = strtoupper(env('APP_NAME', 'FACTURE-SERVICE')); // Noms en majuscules
        $this->port = env('APP_PORT', '80');
        $this->ipAddress = gethostbyname(gethostname()); // Récupère l'IP de l'hôte
        $this->instanceId = $this->ipAddress . ':' . $this->port;
    }

    public function register()
    {
        // Initialisation du client Eureka
        $client = new EurekaClient([
            'eurekaDefaultUrl' => $this->eurekaUrl,
            'hostName' => gethostname(),
            'appName' => strtoupper($this->appName), // Les noms des applications dans Eureka sont en majuscules.
            'ip' => gethostbyname(gethostname()),
            'port' => [$this->port, true],
            'homePageUrl' => 'http://' . $this->ipAddress . ':' . $this->port,
            'statusPageUrl' => 'http://' . $this->ipAddress . ':' . $this->port . '/info',
            'healthCheckUrl' => 'http://' . $this->ipAddress . ':' . $this->port . '/health'
        ]);

        try {
            $client->register();
            logger()->info('Service successfully registered with Eureka.');
        } catch (\Exception $e) {
            // Log l'erreur pour le débogage
            logger()->error('Eureka registration failed: ' . $e->getMessage());
        }
    }

    public function sendHeartbeat()
    {
        // Utilisation de Guzzle pour envoyer un battement de cœur
        $client = new Client();

        try {
            $response = $client->put(
                $this->eurekaUrl . strtoupper($this->appName) . '/' . $this->instanceId,
                [
                    'headers' => ['Content-Type' => 'application/json']
                ]
            );

            logger()->info('Heartbeat sent successfully to Eureka.');
            return $response->getStatusCode();
        } catch (RequestException $e) {
            // Log l'erreur pour le débogage
            logger()->error('Eureka heartbeat failed: ' . $e->getMessage());
            return $e->getResponse() ? $e->getResponse()->getStatusCode() : 500;
        }
    }
}
