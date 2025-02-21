<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    // Read the Excel file and convert it to an array
    public function readExcel()
    {
        $filePath = storage_path('app/students_data_20250216_132712.xlsx');
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        $data = [];
        foreach ($sheet->getRowIterator() as $rowIndex => $row) {
            if ($rowIndex == 1) continue; // Skip headers

            $student = [];
            foreach ($row->getCellIterator() as $cell) {
                $student[] = $cell->getValue();
            }
            $data[] = $student;
        }

        return $data;
    }

    // Generate embeddings for the data
    public function embedData($data)
    {
        $embeddingResults = [];
        
        foreach ($data as $item) {
            $text = implode(' ', $item); // Combine all fields into a single string
            
            // Send text to the DeepSeek API to get embeddings
            $response = Http::post('https://openrouter.ai/api/v1/chat/completions', [
                'text' => $text,
                'api_key' => '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' // Replace with your actual API key
            ]);

            $embeddingResults[] = $response->json()['embedding']; // Store the embeddings
        }

        return $embeddingResults; // These embeddings will be used for storing in a vector DB
    }

    // Store embeddings in the database
    public function storeEmbeddings($embeddings)
    {
        foreach ($embeddings as $embedding) {
            DB::table('embeddings')->insert([
                'embedding' => json_encode($embedding), // Store embeddings as JSON
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    // Retrieve relevant data based on a query
    public function retrieveData($query)
    {
        // Convert query into vector using DeepSeek API
        $response = Http::post('https://openrouter.ai/api/v1/chat/completions', [
            'text' => $query,
            'api_key' => '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' // Replace with your actual API key
        ]);

        $queryEmbedding = $response->json()['embedding'];

        // Retrieve documents based on similarity with the query embedding
        $results = DB::table('embeddings')->get(); // Fetch stored embeddings

        $similarities = [];
        foreach ($results as $result) {
            $documentEmbedding = json_decode($result->embedding);
            $similarity = $this->calculateCosineSimilarity($queryEmbedding, $documentEmbedding);
            $similarities[] = $similarity;
        }

        // Return the most relevant document (highest similarity score)
        $bestMatchIndex = array_search(max($similarities), $similarities);
        return $results[$bestMatchIndex];
    }

    // Calculate cosine similarity between two vectors
    private function calculateCosineSimilarity($vec1, $vec2)
    {
        $dotProduct = 0;
        $normA = 0;
        $normB = 0;
        
        foreach ($vec1 as $key => $value) {
            $dotProduct += $value * $vec2[$key];
            $normA += $value * $value;
            $normB += $vec2[$key] * $vec2[$key];
        }
        
        return $dotProduct / (sqrt($normA) * sqrt($normB));
    }

    // Handle incoming query from frontend and generate a response
    public function query(Request $request)
    {
        $query = $request->input('query');  // Get the query from the user

        // Validate if the query is provided
        if (empty($query)) {
            return response()->json(['error' => 'Query cannot be empty'], 400);
        }

        // Retrieve relevant data based on the query using the RAG system
        $relevantData = $this->retrieveData($query);

        // Generate a response based on the retrieved data
        $response = $this->generateResponse($relevantData);

        // Return the response to the frontend
        return response()->json(['response' => $response]);
    }

    // Generate the response based on the retrieved data
    public function generateResponse($relevantData)
    {
        $response = Http::post('https://openrouter.ai/api/v1/chat/completions', [
            'Authorization' => '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', // Replace with your actual API key
            'model' => 'deepseek/deepseek-r1:free',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are a helpful assistant.'
                ],
                [
                    'role' => 'user',
                    'content' => 'Answer the following question using this context: ' . $relevantData
                ]
            ]
        ]);

        return $response->json()['choices'][0]['message']['content']; // The AI response
    }
}
