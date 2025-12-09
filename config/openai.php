<?php

return [

    /*
    |--------------------------------------------------------------------------
    | OpenAI API Key and Organization
    |--------------------------------------------------------------------------
    |
    | Here you may specify your OpenAI API Key and organization. This will be
    | used to authenticate with the OpenAI API - you can find your API key
    | and organization on your OpenAI dashboard, at https://openai.com.
    | For Groq, use your Groq API key from https://console.groq.com
    */

    'api_key' => env('GROQ_API_KEY', env('OPENAI_API_KEY')),
    'organization' => env('OPENAI_ORGANIZATION'),

    /*
    |--------------------------------------------------------------------------
    | OpenAI API Project
    |--------------------------------------------------------------------------
    |
    | Here you may specify your OpenAI API project. This is used optionally in
    | situations where you are using a legacy user API key and need association
    | with a project. This is not required for the newer API keys.
    */
    'project' => env('OPENAI_PROJECT'),

    /*
    |--------------------------------------------------------------------------
    | OpenAI Base URL
    |--------------------------------------------------------------------------
    |
    | Here you may specify your OpenAI API base URL used to make requests. This
    | is needed if using a custom API endpoint. Defaults to: api.openai.com/v1
    | For Groq, use: https://api.groq.com/openai/v1
    */
    'base_uri' => env('OPENAI_BASE_URI', 'https://api.groq.com/openai/v1'),

    /*
    |--------------------------------------------------------------------------
    | Request Timeout
    |--------------------------------------------------------------------------
    |
    | The timeout may be used to specify the maximum number of seconds to wait
    | for a response. By default, the client will time out after 30 seconds.
    */

    'request_timeout' => env('OPENAI_REQUEST_TIMEOUT', 30),

    /*
    |--------------------------------------------------------------------------
    | Model Name
    |--------------------------------------------------------------------------
    |
    | The model to use for chat completions. For Groq, common models include:
    | - llama-3.1-8b-instant (fast, good for simple tasks)
    | - llama-3.1-70b-versatile (more capable, slower)
    | - mixtral-8x7b-32768 (good balance)
    */
    'model' => env('OPENAI_MODEL', 'llama-3.1-8b-instant'),
];
