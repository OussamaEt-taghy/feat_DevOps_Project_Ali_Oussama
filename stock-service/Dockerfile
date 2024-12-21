# Utiliser une image de base Node.js
FROM node:20-alpine

# Définir le répertoire de travail dans le conteneur
WORKDIR /app

# Copier les fichiers package.json et package-lock.json pour installer les dépendances
COPY package*.json ./

# Installer les dépendances
RUN npm install

# Copier tous les fichiers du projet dans le conteneur
COPY . .

# Exposer le port sur lequel votre application écoute
EXPOSE 4321

# Commande pour démarrer l'application
CMD ["node", "app.js"]
