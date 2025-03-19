<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PetController extends Controller
{
    private $apiUrl = 'https://petstore.swagger.io/v2/pet';
    private $apiKey = 'special-key';

    public function index()
    {
        $response = Http::withHeaders([
            'Authorization' => $this->apiKey
        ])->get($this->apiUrl . '/findByStatus?status=available');

        if ($response->failed()) {
            return response()->json(['error' => 'Błąd pobierania danych z API'], $response->status());
        }

        return response()->json($response->json(), 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string',
            'status' => 'required|string'
        ]);

        $response = Http::withHeaders([
            'Authorization' => $this->apiKey
        ])->post($this->apiUrl, $validatedData);

        if ($response->failed()) {
            return response()->json(['error' => 'Błąd dodawania zwierzęcia'], $response->status());
        }

        return response()->json($response->json(), 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'status' => 'required|string'
        ]);

        $response = Http::withHeaders([
            'Authorization' => $this->apiKey
        ])->put($this->apiUrl, array_merge(['id' => $id], $validatedData));

        if ($response->failed()) {
            return response()->json(['error' => 'Błąd aktualizacji zwierzęcia'], $response->status());
        }

        return response()->json($response->json(), 200);
    }

    public function destroy($id)
    {
        $response = Http::withHeaders([
            'Authorization' => $this->apiKey
        ])->delete("{$this->apiUrl}/{$id}");

        if ($response->failed()) {
            return response()->json(['error' => 'Błąd usuwania zwierzęcia'], $response->status());
        }

        return response()->json(['message' => 'Zwierzę usunięte'], 200);
    }
}
