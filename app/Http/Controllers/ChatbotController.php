<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
use GuzzleHttp\Client;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        // Validate the request
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = $request->input('message');

        // Check if API key is configured
        $apiKey = config('openai.api_key');
        if (empty($apiKey)) {
            \Log::error('Chatbot: API key is not configured');
            return response()->json([
                'reply' => 'Chatbot service is not configured. Please contact the administrator.'
            ], 500);
        }

        // This is the "Knowledge Base" to feed the AI
        $systemPrompt = "
            You are a helpful assistant for the Dhaka E-Municipal website.
            You only answer questions about Bangladesh Festivals and Human Support.

            If the user asks about anything else, politely say you can only help with festivals or support contacts.

            DATA:
            - New Year Day: January 1
            - Language Martyrs Day / International Mother Language Day: February 21
            - Sheikh Mujibur Rahman Birthday / National Children Day: March 17
            - Independence Day: March 26
            - Pohela Boishakh (Bangla New Year): April 14
            - May Day (Labour Day): May 1
            - National Mourning Day: August 15
            - Victory Day: December 16
            - Christmas Day: December 25
            - Shab-e-Meraj: Date varies (Islamic calendar)
            - Shab-e-Barat: Date varies
            - Ramadan: Month varies
            - Shab-e-Qadr: Date varies (last 10 nights of Ramadan)
            - Eid-ul-Fitr: Date varies
            - Eid-ul-Adha: Date varies
            - Islamic New Year: Date varies
            - Ashura (10 Muharram): Date varies
            - Eid-e-Milad-un-Nabi: Date varies
            - Saraswati Puja: January/February (date varies)
            - Durga Puja: September/October (date varies)
            - Kali Puja: October/November (date varies)
            - Janmashtami: August (date varies)
            - Buddha Purnima: May (date varies)
            - Christmas: December 25
            - Amar Ekushey Book Fair: Entire month of February
            - Pohela Falgun / Spring Festival: February 13
            - Basanta Utsab (Charukola): February 13
            - Mangal Shobhajatra (Pohela Boishakh procession): April 14
            - Dhaka International Trade Fair (DITF): January to February
            - Dhaka Art Summit: Every 2 years (January/February)
            - Dhaka Lit Fest: Varies (usually January)
            - Bengal Classical Music Festival: Varies (not every year)
            - Nobanno Utsab: Early November
            - Pitha Utsab (Winter Cake Festival): December to January (date varies)

            CONTACT INFO (Provide this only if asked for human help/support):
            - Officer Name: MD WALID SHAHRIAR
            - Phone: +880 1568 485268
            - Email: support@dhaka.gov.bd
            - Address: Dhanmondi, Dhaka
        ";

        try {
            // For local development, use custom HTTP client with SSL verification disabled
            // to fix cURL error 60 (SSL certificate problem)
            if (app()->environment('local')) {
                $httpClientOptions = [
                    'verify' => false, // Disable SSL verification for local development
                    'timeout' => config('openai.request_timeout', 30),
                ];
                $response = $this->makeOpenAIRequest($apiKey, $systemPrompt, $userMessage, $httpClientOptions);
            } else {
                // For production, use the standard OpenAI facade
                $response = OpenAI::chat()->create([
                    'model' => config('openai.model', 'llama-3.1-8b-instant'),
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $userMessage],
                    ],
                ]);
            }

            return response()->json([
                'reply' => $response->choices[0]->message->content
            ]);
        } catch (\Exception $e) {
            // Log the actual error for debugging
            \Log::error('Chatbot error: ' . $e->getMessage());

            // Return a more helpful error message
            $errorMessage = 'Sorry, I am having trouble connecting right now.';
            if (config('app.debug')) {
                $errorMessage .= ' Error: ' . $e->getMessage();
            }

            return response()->json(['reply' => $errorMessage], 500);
        }
    }

    /**
     * Make OpenAI request with custom HTTP client for local development
     */
    private function makeOpenAIRequest($apiKey, $systemPrompt, $userMessage, $httpClientOptions)
    {
        $httpClient = new Client($httpClientOptions);

        $response = $httpClient->post(config('openai.base_uri') . '/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => config('openai.model', 'llama-3.1-8b-instant'),
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $userMessage],
                ],
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        // Return in the same format as OpenAI SDK
        return (object) [
            'choices' => [
                (object) [
                    'message' => (object) [
                        'content' => $data['choices'][0]['message']['content']
                    ]
                ]
            ]
        ];
    }
}
