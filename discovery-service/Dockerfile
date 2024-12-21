# Utilise l'image de base OpenJDK 17 avec Oracle Linux
FROM openjdk:17-oracle

# Définit un volume pour stocker des données temporaires (utilisé par certaines applications Spring Boot)
VOLUME /tmp

# Copie le fichier JAR généré (situé dans "target") dans le conteneur et le nomme "app.jar"
COPY target/*.jar app.jar

# Ajoute une métadonnée indiquant l'auteur du conteneur
LABEL authors="OUSSAMA"

# Définit la commande à exécuter lorsque le conteneur démarre
# Lance l'application Java (app.jar) avec le profil Spring "prod" (production)
ENTRYPOINT ["java", "-jar", "/app.jar", "--spring.profiles.active=prod"]
