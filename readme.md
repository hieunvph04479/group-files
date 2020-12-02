## Hướng dẫn sử dụng ##

**Giới thiệu**: Đây là Package Laravel được dùng để gộp các file lại với nhau.

### Cài đặt để sử dụng ###
- Để có thể sử dụng Package cần require theo lệnh `composer require tubocms/group-files`
- Để sử dụng thì cần phải set `config('filesystems.disks.local.root')` thành `public_path()`
- Publish các file cần thiết sử dụng `php artisan vendor:publish --tag=tubocms/group-files`

### Sử dụng ###

**B1**: Trước khi gộp các file lại với nhau thì cần phải cấu hình các file cần gộp tại `config/TuboGroupFile.php` (Được publish từ trước). Nội dung và cách dùng sẽ được cấu hình như sau:

    <?php 

    return [
        'generate' => [
            [
                // Đường dẫn và tên file sẽ được tại ra sau khi gộp
                'file_path' => 'assets/css/test.min.css',
                // Các file gộp
                'files' => [
                    // Nếu type là config thì link sẽ là đường dẫn được cấu hình tại config. VD: link file được định nghĩa tại config('app.css') thì link sẽ là "app.css"
                    [
                        'type' => 'config',
                        'link' => ''
                    ],
                    // Nếu type là config thì link sẽ là đường dẫn đến file cần gộp.
                    [
                        'type' => 'link',
                        'link' => ''
                    ],
                ]
            ],
            [
                'file_path' => 'assets/css/test.min.js',
                'files' => [
                    [
                        'type' => 'config',
                        'link' => ''
                    ],
                    [
                        'type' => 'link',
                        'link' => ''
                    ],
                ]
            ]
        ],
    ];

**B2**: Sau khi đã hoàn thiện việc cấu hình tại config thì chạy command `php artisan tubocms:groups` để tiến hành gộp file