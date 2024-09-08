<?php

declare(strict_types=1);

namespace Maviance\S3PApiClient;

use Exception;

class HMACSignature
{
    /**
     * @param string $method HTTP method
     * @param string $url    URL
     * @param array  $params parameters to include in signature
     */
    public function __construct(
        private readonly string $method,
        private readonly string $url,
        private array $params
    ) {
    }

    /** This method generates the signature based on given parameters */
    public function generate(string $secret): string
    {
        $encodedString = hash_hmac('sha1', $this->getBaseString(), $secret, true);

        return base64_encode($encodedString);
    }

    /** @throws Exception */
    public function verify(string $signature, string $secret): bool
    {
        if ($signature !== $this->generate($secret)) {
            throw new Exception('Signature Does Not Match');
        }

        return true;
    }

    /** compile base string */
    public function getBaseString(): string
    {
        $glue = '&';
        $sorted = $this->getParameterString();

        return
            // capitalize http type
            strtoupper(trim($this->method)) . $glue .
            // urlencoded url
            rawurlencode(trim($this->url)) . $glue .
            // lexically sorted parameter string
            $sorted;
    }

    /** Prepares a string to be signed */
    protected function getParameterString(): string
    {
        $glue = '&';
        $stringToBeSigned = '';
        // lexically sort parameters
        ksort($this->params);
        foreach ($this->params as $key => $value) {
            $stringToBeSigned .= trim((string)$key) . '=' . trim((string)$value) . $glue;
        }

        // urlencoded and remove trailing glue
        return rawurlencode(trim(substr($stringToBeSigned, 0, -1)));
    }
}

// Cette page contient une classe qui gère l'authentification et la signature pour une API.
// Elle fournit des méthodes pour générer et vérifier des signatures, ainsi que pour préparer
// les chaînes de caractères nécessaires à la signature.

// Pour exécuter et générer une signature :
// 1. Instancier la classe (probablement nommée quelque chose comme 'Auth')
// 2. Définir les paramètres nécessaires (méthode, URL, paramètres)
// 3. Appeler la méthode 'generate' avec le secret

// Exemple d'utilisation (hypothétique, car le nom de la classe n'est pas visible) :
// $auth = new Auth('POST', 'https://api.example.com', ['param1' => 'value1', 'param2' => 'value2']);
// $signature = $auth->generate('votre_secret_ici');

// La signature générée peut ensuite être utilisée pour authentifier les requêtes à l'API.