<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Helpers\DatabaseSchemaHelper;

class QueryController extends Controller
{
    protected $fastApiUrl;

    public function __construct()
    {
        $this->fastApiUrl = env('FASTAPI_URL', 'http://localhost:8000');
    }

    private function cleanSqlQuery(string $query): string
    {
        // Remove markdown code block syntax and trim whitespace
        $cleaned = preg_replace('/```sql\s*|\s*```/', '', $query);
        return trim($cleaned);
    }

    public function processQuery(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'query' => 'required|string|max:500',
            ]);

            // Get database schema
            $schemaString = DatabaseSchemaHelper::getSchemaAsString();

            Log::info('Database schema:', ['schema' => $schemaString]);

            // Send the query to FastAPI service with schema
            $response = Http::post($this->fastApiUrl . '/generate-sql', [
                'query' => $validated['query'],
                'schema' => $schemaString
            ]);

            if (!$response->successful()) {
                Log::error('FastAPI error:', ['response' => $response->json()]);
                return response()->json([
                    'error' => 'Failed to generate SQL query',
                    'details' => $response->json()
                ], 500);
            }

            // Clean the SQL query
            $sqlQuery = $this->cleanSqlQuery($response->json()['sql_query']);
            
            // Log the generated SQL query
            Log::info('Generated SQL query:', ['sql' => $sqlQuery]);

            // Execute the SQL query
            $results = DB::select($sqlQuery);

            // Return the results
            return response()->json([
                'success' => true,
                'data' => $results,
                'sql_query' => $sqlQuery // Include the cleaned SQL query in response
            ]);

        } catch (\Exception $e) {
            Log::error('Query processing error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while processing your query',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
