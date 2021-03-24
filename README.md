# lib-user-auth-google-signin

Adalah module yang bisa digunakan untuk verifikasi token google login.

## Instalasi

Jalankan perintah di bawah di folder aplikasi:

```
mim app install lib-user-auth-google-signin
```

## Konfigurasi

Tambahkan konfigurasi seperti di bawah pada konfigurasi aplikasi untuk menentukan
google client id yang akan digunakan untuk verifikasi data token user.

```php
<?php

return [
    'libUserAuthGoogleSignin' => [
        'client' => [
            'id' => '...'
        ]
    ]
];
```

## Penggunaan

Module ini menambah satu libray dengan nama `LibUserAuthGoogleSignin\Library\GoogleLogin`
yang bisa digunakan untuk verifikasi token yang dikirimkan oleh user untuk mendapatkan
informasi google user yang sedang mencoba untuk login.

```php
use LibUserAuthGoogleSignin\Library\GoogleLogin;

$token = $_POST['token'];

$gu = GoogleLogin::getUser($token);

if(!$token)
    die('invalid token');

$user = $gu->user;
if(!$user) {
    $user_id = User::create([....]);
    $user = User::getOne(['id' => $user_id]);
    GoogleLogin::assignUser($user, $gu->google->id);
}
```

## Method

### static function assignUser(object $user, string $google_user): void

Meng-assign google user ke google account. Panggil fungsi ini ketika user baru
berhasil dibuat dari data google account.

### static function getUser(string $token): ?object

Mengambil informasi user berdasarkan token google login yang didapat dari client.

Fungsi ini akan mengembalikan null jika token invalid, dan akan mengembalikan data
object seperti di bawah jika berhasil di verifikasi:

```php
$result = (object)[
    'google' => (object)[
        'id' => string,
        'email' => (object)[
            'address' => string,
            'verified' => bool
        ],
        'name' => string,
        'avatar' => string
    ],
    'user' => object
];
```

Properti `$.google` diambil dari data token, sementara properti `$.user` adalah
informasi user berdasarkan database hanya jika user dengan google account tersebut
sudah pernah di-assign.
