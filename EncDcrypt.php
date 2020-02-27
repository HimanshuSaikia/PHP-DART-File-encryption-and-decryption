<?php
/**
 * Author: Himanshu Saikia
 * Date: 05-02-2020
 * Time: 01:52 PM
 */
declare(strict_types=1);
$methodObj = new EncDcrypt();
//echo $methodObj->moduleFunctions('encryptText', 'My name is Himanshu Saikia', null);
//echo $methodObj->moduleFunctions('decryptText', '3JWm3o/hj8AIUi7ViuwLgHpss+TbUMxzDSTj8s6YgSA=', null);
//echo $methodObj->moduleFunctions('encryptFile', 'Learning_Objectives.mp4', null);
//echo $methodObj->moduleFunctions('decryptFile', 'Learning_Objectives.himu', null);
class EncDcrypt
{
    protected $receivedText;
    private $encryptedKey;
    private $encryptedIV;

    function __construct() {
        $this->encryptedKey='FCAcEA0HBAoRGyALBQIeCAcaDxYWEQQPBxcXHgAFDgY=';
        $this->encryptedIV='DB4gHxkcBQkKCxoRGBkaFA==';
    }

    function moduleFunctions($functionCall, $received, $outPath){
        switch($functionCall) {
            case 'encryptText' :
                $this->received = $received;
                return $this->encryptText($this->encryptedKey, $this->encryptedIV, $this->received); break;
            case 'decryptText' :
                $this->received = $received;
                return $this->decryptText($this->encryptedKey, $this->encryptedIV, $this->received); break;
            case 'encryptFile' :
                $this->received = $received;
                $this->outPath = $outPath;
                return $this->encryptFile($this->encryptedKey, $this->encryptedIV, $this->received, $this->outPath); break;
            case 'decryptFile' :
                $this->received = $received;
                return $this->decryptFile($this->encryptedKey, $this->encryptedIV, $this->received, $this->outPath); break;
        }
    }

    function __destruct() {

    }

    function encryptText($encKey, $encIV, $text) {
        $key = base64_decode($encKey);
        $iv = base64_decode($encIV);
        $encrypter = 'aes-256-cbc';
        $encrypted = openssl_encrypt($text, $encrypter, $key, 0, $iv);
        return $encrypted;
    }

    function decryptText($encKey, $encIV, $text) {
        $key = base64_decode($encKey);
        $iv = base64_decode($encIV);
        $encrypter = 'aes-256-cbc';
        $decrypted = openssl_decrypt($text, $encrypter, $key, 0, $iv);
        return $decrypted;
    }

    function encryptFile($encKey, $encIV, $inPath, $outPath) {
        $sourceFile=file_get_contents($inPath);
        $key = base64_decode($encKey);
        $iv = base64_decode($encIV);
        $path_parts = pathinfo($inPath);
        $fileName=$path_parts['filename'];
        $outFile=$outPath.$fileName.'.himu';
        $encrypter = 'aes-256-cbc';
        $encryptedString = openssl_encrypt($sourceFile, $encrypter, $key, 0, $iv);
        if(file_put_contents($outFile, $encryptedString)!= false) return 1;
        else return 0;
    }

    function decryptFile($encKey, $encIV, $inPath, $outPath) {
        $encryptedString=file_get_contents($inPath);
        $key = base64_decode($encKey);
        $iv = base64_decode($encIV);
	$path_parts = pathinfo($inPath);
        $fileName=$path_parts['filename'];
        $outFile=$outPath.$fileName.'.mp4';
        $encrypter = 'aes-256-cbc';
        $decrypted = openssl_decrypt($encryptedString, $encrypter, $key, 0, $iv);
        if(file_put_contents($outFile, $decrypted)!= false) return 1;
        else return 0;
    }
}
