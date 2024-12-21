<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return Order::all(); // Liste toutes les commandes
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'address' => 'required|string',
            'total_price' => 'required|numeric',
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        return Order::create($validated); // Crée une nouvelle commande
    }

    public function show(Order $order)
    {
        return $order; // Retourne une commande spécifique
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'customer_name' => 'sometimes|string|max:255',
            'customer_email' => 'sometimes|email',
            'address' => 'sometimes|string',
            'total_price' => 'sometimes|numeric',
            'status' => 'sometimes|in:pending,processing,completed,cancelled',
        ]);

        $order->update($validated); // Met à jour une commande existante

        return $order;
    }

    public function destroy(Order $order)
    {
        $order->delete(); // Supprime une commande

        return response()->noContent();
    }
}
