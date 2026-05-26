<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Crypt;

class UrlEncryption
{
    /**
     * Encrypt an ID for use in URLs
     * 
     * @param int|string $id
     * @return string
     */
    public static function encryptId($id)
    {
        try {
            // Encrypt the ID and return URL-safe encoded string
            $encrypted = Crypt::encryptString((string) $id);
            // URL encode the encrypted string to make it safe for URLs
         
            return urlencode($encrypted);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Decrypt an ID from URL parameter
     * 
     * @param string $encryptedId
     * @return int|null
     */
    public static function decryptId($encryptedId)
    {
        try {
            // URL decode first
            $decoded = urldecode($encryptedId);
            // Then decrypt
            $decrypted = Crypt::decryptString($decoded);
            return (int) $decrypted;
        } catch (\Exception $e) {
            return null;
        }
    }
}
