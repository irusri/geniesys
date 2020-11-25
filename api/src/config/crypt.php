<?php
class genieCrypt{

    private  $ENCRYPTION_KEY = 'your-long-complex-password-here!!!';
    private  $ENCRYPTION_ALGORITHM = 'AES-256-CBC';
    // Other cipher methods can be used. Identified what is available on your server
    // by visiting: https://www.php.net/manual/en/function.openssl-get-cipher-methods.php
    // END: Define some variable(s)
 
    public function EncryptThis($ClearTextData) {
        // This function encrypts the data passed into it and returns the cipher data with the IV embedded within it.
        // The initialization vector (IV) is appended to the cipher data with 
        // the use of two colons serve to delimited between the two.

        $EncryptionKey = base64_decode($this->ENCRYPTION_KEY);
        $InitializationVector  = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->ENCRYPTION_ALGORITHM));
        $EncryptedText = openssl_encrypt($ClearTextData, $this->ENCRYPTION_ALGORITHM, $EncryptionKey, 0, $InitializationVector);
        return base64_encode($EncryptedText . '::' . $InitializationVector);
    }
    
    public function DecryptThis($CipherData) {
        // This function decrypts the cipher data (with the IV embedded within) passed into it 
        // and returns the clear text (unencrypted) data.
        // The initialization vector (IV) is appended to the cipher data by the EncryptThis function (see above).
        // There are two colons that serve to delimited between the cipher data and the IV.

        $EncryptionKey = base64_decode($this->ENCRYPTION_KEY);
        list($Encrypted_Data, $InitializationVector ) = array_pad(explode('::', base64_decode($CipherData), 2), 2, null);
        return openssl_decrypt($Encrypted_Data, $this->ENCRYPTION_ALGORITHM, $EncryptionKey, 0, $InitializationVector);
    }

}
?>