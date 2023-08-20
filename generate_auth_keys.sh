#!/bin/bash
openssl genpkey -algorithm RSA -out private_key.pem
openssl rsa -pubout -in private_key.pem -out public_key.pem

private_key_content=$(cat private_key.pem)
public_key_content=$(cat public_key.pem)
jwt_algo="RS256"
key_content="
JWT_ALGO=\"${jwt_algo}\"
JWT_PUBLIC_KEY=\"${public_key_content}\"
JWT_PRIVATE_KEY=\"${private_key_content}\"
"

echo -e "$key_content" >> .env

echo "Keys appended to .env file"
