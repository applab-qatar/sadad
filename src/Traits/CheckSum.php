<?php
namespace Applab\Sadad\Traits;

trait CheckSum
{
    public static function processData($data)
    {
        $checksum_array1 = array();
        $sAry1 = array();
        foreach ($data as $pK => $pV) {
            if ($pK == 'checksumhash') continue;
            if (is_array($pV)) {
                $prodSize = sizeof($pV);
                for ($i = 0; $i < $prodSize; $i++) {
                    foreach ($pV[$i] as $innK =>
                             $innV) {
                        $sAry1[] = "";
                        $checksum_array1['productdetail'][$i][$innK] = trim($innV);
                    }
                }
            } else {
                $sAry1[] = "";
                $checksum_array1[$pK] =
                    trim($pV);
            }
        }
        return $checksum_array1;
    }
    public static function getFromString($str, $key)
    {
        $salt = self::generateSalt_e(4);
        $finalString = $str . "|" . $salt;
        $hash = hash("sha256", $finalString);
        $hashString = $hash . $salt;
        return self::encrypt_e($hashString, $key);
    }

    private static function generateSalt_e($length)
    {
        $random = "";
        srand((double)microtime() * 1000000);
        $data = "AbcDE123IJKLMN67QRSTUVWXYZ";
        $data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
        $data .= "0FGH45OP89";
        for ($i = 0; $i < $length; $i++) {
            $random .= substr($data, (rand() % (strlen($data))), 1);
        }
        return $random;
    }

    private static function encrypt_e($input, $ky)
    {
        $ky = html_entity_decode($ky);
        $iv = "@@@@&&&&####$$$$";
        $data = openssl_encrypt($input, "AES-128-CBC", $ky, 0, $iv);
        return $data;
    }



    public static function verifyFromString($str, $key, $checkSumValue)
    {
        $sadadHash = self::decrypt_e($checkSumValue, $key);
        $salt = substr($sadadHash, -4);
        $finalString = $str . "|" . $salt;
        $website_hash = hash("sha256", $finalString);
        $website_hash .= $salt;
        $validFlag = "FALSE";
        if ($website_hash == $sadadHash) {
            $validFlag = "TRUE";
        } else {
            $validFlag = "FALSE";
        }
        return $validFlag;
    }

    private static function decrypt_e($crypt, $ky)
    {
        $ky = html_entity_decode($ky);
        $iv = "@@@@&&&&####$$$$";
        $data = openssl_decrypt($crypt, "AES-128-CBC", $ky, 0, $iv);
        return $data;
    }
}