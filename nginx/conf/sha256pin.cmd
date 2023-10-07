@echo off
openssl x509 -in %~dpn1%~x1 -pubkey -noout >%~dpn1.pub
openssl rsa -pubin < %~dpn1.pub -outform der > %~dpn1.pvk
openssl dgst -sha256 -binary < %~dpn1.pvk >%~dpn1.bin
openssl enc -base64 < %~dpn1.bin >%~dpn1.pin256
type %~dpn1.pin256
del %~dpn1.pub
del %~dpn1.pvk
del %~dpn1.bin