# OAuth 2 Server

## Generating public and private keys

To generate the private key run this command on the terminal:
`openssl genrsa -out private.key 1024`

 extract the public key from the private key:
`openssl rsa -in private.key -pubout -out public.key`

## Generating encryption keys

To generate an encryption key for the AuthorizationServer run the following command in the terminal:

php -r 'echo base64_encode(random_bytes(32)), PHP_EOL;'