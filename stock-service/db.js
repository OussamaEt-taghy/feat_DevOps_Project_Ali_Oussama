const mongoose = require("mongoose");

// URL de connexion à MongoDB (en local ou sur MongoDB Atlas)
const dbURL = process.env.MONGO_URI || "mongodb://mongo-db:27017/stock";
// Connexion à MongoDB
const connectDB = async () => {
  try {
    // Connexion à MongoDB sans options dépréciées
    await mongoose.connect(dbURL);
    console.log("Connexion à MongoDB réussie ".dbURL);
  } catch (err) {
    console.error("Erreur de connexion à MongoDB:", err);
    process.exit(1); // Arrêter le processus en cas d'échec de connexion
  }
};

connectDB(); // Appel de la fonction pour établir la connexion

module.exports = connectDB;
