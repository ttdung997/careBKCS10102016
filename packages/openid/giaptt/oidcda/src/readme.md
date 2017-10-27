##
B1. 
- cấu hình Auto-load trong file main composer.json

- chạy lệnh composer dump-autoload

B2.
- cấu hình Service Provider trong file config/app.php

B3.
- Cấu hình OP, RP trong file config/OpenidConnect.php. Nếu chưa có thì chạy lệnh
php artisan vendor:publish

B4.
- cấu hình tên cookie trong Middleware/EncryptCookie để cookie này ko bị mã hóa.
tên cookie gồm : 'session_state' và 'sess_stt'

##
Các chỗ chỉnh sửa:
- admin/layout/master.blade.php : Authen::getCurrentUser()
- admin/index.blade.php : Authen::getCurrentUserName()

- layout của bác sĩ viện ngoài: thêm đoạn JS gửi msg cho check session endpoint 
của OP.
