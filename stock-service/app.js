const express = require("express");
const connectDB = require("./db"); // Importez la fonction de connexion MongoDB
const Product = require("./productModel"); // Importez le modèle Product
const app = express();

require("./eureka");
// Middleware pour parser les requêtes JSON
app.use(express.json());

// Connexion à MongoDB
connectDB();

// Créer un nouveau produit
app.post("/products", async (req, res) => {
  try {
    const { name, description, price, stock, category } = req.body;

    const newProduct = new Product({
      name,
      description,
      price,
      stock,
      category,
    });

    await newProduct.save();
    res
      .status(201)
      .json({ message: "Produit créé avec succès", product: newProduct });
  } catch (err) {
    res
      .status(500)
      .json({ message: "Erreur lors de la création du produit", error: err });
  }
});

// Obtenir tous les produits
app.get("/products", async (req, res) => {
  try {
    const products = await Product.find();
    res.status(200).json(products);
  } catch (err) {
    res.status(500).json({
      message: "Erreur lors de la récupération des produits",
      error: err,
    });
  }
});

app.get("/", async (req, res) => {
  try {
    // Récupérer tous les produits depuis la base de données
    const products = await Product.find();
    res.status(200).json(products); // Renvoie les produits dans la réponse JSON
  } catch (err) {
    res.status(500).json({
      message: "Erreur lors de la récupération des produits",
      error: err,
    });
  }
});

// Mettre à jour un produit
app.put("/products/:id", async (req, res) => {
  try {
    const { name, description, price, stock, category } = req.body;
    const updatedProduct = await Product.findByIdAndUpdate(
      req.params.id,
      {
        name,
        description,
        price,
        stock,
        category,
      },
      { new: true }
    );

    if (!updatedProduct) {
      return res.status(404).json({ message: "Produit non trouvé" });
    }

    res.status(200).json({
      message: "Produit mis à jour avec succès",
      product: updatedProduct,
    });
  } catch (err) {
    res.status(500).json({
      message: "Erreur lors de la mise à jour du produit",
      error: err,
    });
  }
});

// Supprimer un produit
app.delete("/products/:id", async (req, res) => {
  try {
    const deletedProduct = await Product.findByIdAndDelete(req.params.id);

    if (!deletedProduct) {
      return res.status(404).json({ message: "Produit non trouvé" });
    }

    res.status(200).json({ message: "Produit supprimé avec succès" });
  } catch (err) {
    res.status(500).json({
      message: "Erreur lors de la suppression du produit",
      error: err,
    });
  }
});

app.get("/eureka", async (req, res) => {
  try {
    const serviceUrl = await getServiceUrl("another-service");
    const response = await axios.get(`${serviceUrl}/api`);
    res.send(`Response from another service: ${response.data}`);
  } catch (error) {
    res.status(500).send("Error discovering service: " + error.message);
  }
});
const PORT = process.env.PORT || 4321;
// Lancer le serveur Express
app.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});
