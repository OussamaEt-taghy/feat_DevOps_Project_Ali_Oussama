const mongoose = require("mongoose");

// Définir un schéma pour les produits
const productSchema = new mongoose.Schema({
  name: { type: String, required: true },
  description: { type: String, required: true },
  price: { type: Number, required: true },
  stock: { type: Number, required: true },
  category: { type: String, required: true },
  createdAt: { type: Date, default: Date.now },
  updatedAt: { type: Date, default: Date.now },
});

// Créer un modèle à partir du schéma
const Product = mongoose.model("Product", productSchema);

module.exports = Product;
