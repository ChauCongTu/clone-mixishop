<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $firstNames = [
            'Nguyễn', 'Trần', 'Lê', 'Lý', 'Châu', 'Lưu', 'Đỗ', 'Đặng', 'Hồ', 'Phan', 'Võ', 'Bùi'
        ];
        $lastNames = [
            'Nam', 'Thư', 'Thu', 'Hoài', 'Minh', 'Sang', 'Phúc', 'Tài', 'Diễm', 'Thạch', 'Tấn', 'Sơn', 'Long', 'Thành', 'Hùng', 'Dũng', 'Thịnh', 'Tâm', 'Lan', 'Huệ', 'Hồng', 'Vân', 'Chí', 'Bảo', 'Ngọc', 'Ngân', 'Trâm', 'Trí', 'Tuấn', 'Vũ'
        ];
        $provinces = [
            'An Giang',
            'Bà Rịa - Vũng Tàu',
            'Bắc Giang',
            'Bắc Kạn',
            'Bạc Liêu',
            'Bắc Ninh',
            'Bến Tre',
            'Bình Định',
            'Bình Dương',
            'Bình Phước',
            'Bình Thuận',
            'Cà Mau',
            'Cần Thơ',
            'Cao Bằng',
            'Đà Nẵng',
            'Đắk Lắk',
            'Đắk Nông',
            'Điện Biên',
            'Đồng Nai',
            'Đồng Tháp',
            'Gia Lai',
            'Hà Giang',
            'Hà Nam',
            'Hà Nội',
            'Hà Tĩnh',
            'Hải Dương',
            'Hải Phòng',
            'Hậu Giang',
            'Hòa Bình',
            'Hồ Chí Minh',
            'Hưng Yên',
            'Khánh Hòa',
            'Kiên Giang',
            'Kon Tum',
            'Lai Châu',
            'Lâm Đồng',
            'Lạng Sơn',
            'Lào Cai',
            'Long An',
            'Nam Định',
            'Nghệ An',
            'Ninh Bình',
            'Ninh Thuận',
            'Phú Thọ',
            'Phú Yên',
            'Quảng Bình',
            'Quảng Nam',
            'Quảng Ngãi',
            'Quảng Ninh',
            'Quảng Trị',
            'Sóc Trăng',
            'Sơn La',
            'Tây Ninh',
            'Thái Bình',
            'Thái Nguyên',
            'Thanh Hóa',
            'Thừa Thiên Huế',
            'Tiền Giang',
            'Trà Vinh',
            'Tuyên Quang',
            'Vĩnh Long',
            'Vĩnh Phúc',
            'Yên Bái',
        ];

        for ($i = 0; $i < 50; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $province = $provinces[array_rand($provinces)];

            User::create([
                'name' => $firstName . ' ' . $lastName,
                'email' => Str::random(10) . '@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'Member',
                'gender' => 'Nam',
                'address' => $province,
            ]);
        }
    }
}
