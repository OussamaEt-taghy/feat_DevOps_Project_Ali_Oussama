FROM openjdk:17-oracle
VOLUME /tmp
COPY target/*.jar app.jar
LABEL authors="OUSSAMA"
ENTRYPOINT ["java", "-jar", "/app.jar","--spring.profiles.active=prod"]