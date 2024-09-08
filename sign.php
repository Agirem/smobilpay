<?php

require 'auth.php'; // Assurez-vous que le chemin vers auth.php est correct

use Maviance\S3PApiClient\HMACSignature;

// Définir les paramètres nécessaires
$method = 'POST';
$url = 'https://api.example.com';
$params = ['param1' => 'value1', 'param2' => 'value2'];
$secret = 'votre_secret_ici';

// Instancier la classe HMACSignature
$auth = new HMACSignature($method, $url, $params);

// Générer la signature
$signature = $auth->generate($secret);

// Afficher la signature
echo "Signature générée : " . $signature;