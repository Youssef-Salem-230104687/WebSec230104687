@extends('layouts.master')
 @section('title', 'Web Crypto')
 @section('content')
  <script type="text/javascript">
     const iv = window.crypto.getRandomValues(new Uint8Array(16));
 //IV is a common non-secrete vector required by AES-CBC must be known while encrypt or decrypt
 let key = null;
 window.crypto.subtle.generateKey({
    name: "AES-CBC",
    length: 256,
 }, true, [ "encrypt" , "decrypt"]).then(function(key_) {
      key = key_;
    }) 
 .catch(function(error) {
    alert(error);
 });

 function encryptCBC() {
    const plain = document.getElementById("plain");
    const cipher = document.getElementById("cipher");
    const encodedText = new TextEncoder().encode(plain.value);
    window.crypto.subtle.encrypt({
         name: "AES-CBC",
         iv: iv,
    }, key, encodedText)
    .then(function(encryptedData) {
        const encryptedBase64 = btoa(String.fromCharCode(...new Uint8Array(encryptedData)));
        cipher.value = encryptedBase64;
    })
    .catch(function(error) {
        alert(error);
    });
 }

 function decryptCBC() {
    const plain = document.getElementById("plain");
    const cipher = document.getElementById("cipher");

    try {
        const encryptedData = Uint8Array.from(atob(cipher.value), c => c.charCodeAt(0));
        window.crypto.subtle.decrypt({
            name: "AES-CBC",
            iv: iv,
        }, key, encryptedData)
        .then(function(decryptedData) {
            plain.value = new TextDecoder().decode(decryptedData);
        })
        .catch(function(error) {
            alert(error);
        });
    } catch(error) {
        alert("Error processing cipher text: " + error);
    }
 }
</script>

  <div class="card m-4">
    <div class="card-body">
      <div class="row mb-2">
        <div class="col">
            <label for="name" class="form-label">Plain Text</label>
            <textarea id="plain" type="text" class="form-control" placeholder="Data" name="data" required> Welcome to WebCrypto</textarea>
        </div>
      </div>
      <div class="row mb-2">
        <div class="col">
            <button type="button" class="btn btn-primary" onclick="encryptCBC()">Encrypt</button>
            <button type="button" class="btn btn-primary" onclick="decryptCBC()">Decrypt</button>
        </div>
      </div>
      <div class="row mb-2">
        <div class="col">
            <label for="cipher" class="form-label">Cipher</label>
            <textarea id="cipher" type="text" class="form-control" placeholder="Data" name="data" required></textarea>
        </div>
      </div>
    </div>
  </div>


@endsection