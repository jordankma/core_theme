<?php
namespace Contest\Contest\App;


class ApiHash
{
    private $string = '';
//    protected $secret_key = 't+m:*meo6h}b?{~';
//    protected $secret_iv = '*[Py49<>n@-VYr1';
    protected $secret_key = '8bgCi@gsLbtGhO)1';
    protected $secret_iv = ')FQKRL57zFYdtn^!';
    protected $encrypt_method = "AES-256-CBC";

    public function encrypt( $string) {
        $this->string = $string;
        $key = substr( hash( 'sha256',  $this->secret_key ), 0 ,32);
        $iv = substr( hash( 'sha256',  $this->secret_iv ), 0, 16 );
        $output = base64_encode( openssl_encrypt( $this->string, $this->encrypt_method, $key, 0, $iv ) );
        return $output;
    }
    public function decrypt( $string) {
        $this->string = $string;
        $key = substr( hash( 'sha256',  $this->secret_key ), 0 ,32);
        $iv = substr( hash( 'sha256',  $this->secret_iv ), 0, 16 );
        $output = openssl_decrypt( base64_decode( $this->string ), $this->encrypt_method, $key, 0, $iv );
        return $output;
    }

}