const Eureka = require("eureka-js-client").Eureka;
require("dotenv").config();
// Configure Eureka client
const client = new Eureka({
  instance: {
    app: "stock-service",
    hostName: "127.0.0.1", // Utilisez l'adresse IP ou le nom d'hôte complet ici
    ipAddr: "127.0.0.1",
    port: {
      $: 4321, // Port du service
      "@enabled": "true",
    },
    vipAddress: "stock-service",
    statusPageUrl: "http://127.0.0.1:4321/status", // URL complète à afficher dans le champ Status
    healthCheckUrl: "http://127.0.0.1:4321/health", // URL de vérification de santé, si nécessaire
    dataCenterInfo: {
      "@class": "com.netflix.appinfo.InstanceInfo$DefaultDataCenterInfo",
      name: "MyOwn",
    },
    metadata: {
      serviceUrl: "http://127.0.0.1:4321", // Métadonnée personnalisée
    },
  },
  eureka: {
    host: "discovery-service", // Adresse du serveur Eureka
    port: 8761, // Port du serveur Eureka
    servicePath: "/eureka/apps/",
  },
});

// Start Eureka client
client.start((error) => {
  if (error) {
    console.error("Eureka client failed to start:", error);
  } else {
    console.log("Eureka client started successfully!");
  }
});
