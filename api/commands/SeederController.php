<?php

namespace app\commands;

use app\models\PhoneBook;
use tebazil\yii2seeder\Seeder;
use Yii;
use yii\console\Controller;
use yii\db\JsonExpression;

class SeederController extends Controller
{
    public function actionIndex()
    {
        echo 'Seeding Areas...' . PHP_EOL;
        $this->actionArea();

        echo 'Seeding Users...' . PHP_EOL;
        $this->actionUser();

        echo 'Seeding Phonebooks...' . PHP_EOL;
        $this->actionPhoneBook();
    }

    public function actionArea()
    {
        Yii::$app->db->createCommand('TRUNCATE areas')->execute();

        $sql = file_get_contents(__DIR__ . '/../migrations/seeder/jawabarat_kabkota_20190320.sql');
        Yii::$app->db->createCommand($sql)->execute();
    }

    public function actionUser()
    {
        Yii::$app->db->createCommand('TRUNCATE auth_assignment')->execute();
        Yii::$app->db->createCommand('TRUNCATE user')->execute();

        Yii::$app->db->createCommand()->batchInsert('user', [
            'id',
            'username',
            'auth_key',
            'access_token_expired_at',
            'password_hash',
            'password_reset_token',
            'email',
            'unconfirmed_email',
            'confirmed_at',
            'registration_ip',
            'last_login_at',
            'last_login_ip',
            'blocked_at',
            'status',
            'role',
            'created_at',
            'updated_at',
            'name',
            'phone',
            'address',
            'rw',
            'kel_id',
            'kec_id',
            'kabkota_id'
        ], [
            [
                1,
                'admin',
                'dVN8fzR_KzJ_lBrymfXI6qyH2QzyXYUU',
                '2017-06-04 00:13:29',
                '$2y$13$9Gouh1ZbewVEh4bQIGsifOs8/RWW/7RIs0CAGNd7tapXFm9.WxiXS',
                null,
                'admin@demo.com',
                'admin@demo.com',
                time(),
                '127.0.0.1',
                time(),
                '127.0.0.1',
                null,
                10,
                99,
                time(),
                time(),
                'Administrator',
                null,
                null,
                null,
                null,
                null,
                null
            ],
            [
                2,
                'staff',
                'Xm-zZRREtAIKsFlINVRLSw3U7llbx_5a',
                '2017-05-30 20:30:31',
                '$2y$13$TKh5pEy0RFTmkC9Kjvb9A.WR/I1QVzYHdfYDw0m7MnHnN0bsv96Jq',
                null,
                'staff@demo.com',
                'staff@demo.com',
                time(),
                '127.0.0.1',
                time(),
                '127.0.0.1',
                null,
                10,
                50,
                time(),
                time(),
                'Staff',
                null,
                null,
                null,
                null,
                null,
                null
            ],
            [
                3,
                'staffprov',
                'E3sUYMd9eNe4uiGlq12Bof3LmQVZCdlb',
                '2017-05-30 20:30:31',
                '$2y$13$UF1u00zQepfWOyhRcjrvIefJ5f6PI5tRTxyOP9Zw6OFBLfo8H8tIu',
                null,
                'staffprov@jabarprov.go.id',
                'staffprov@jabarprov.go.id',
                time(),
                '172.25.0.7',
                time(),
                '172.25.0.7',
                null,
                10,
                90,
                time(),
                time(),
                'Staff Provinsi Jawa Barat',
                '080989999',
                'Jl. Alamat Provinsi Jawa Barat',
                null,
                null,
                null,
                null
            ],
            [
                4,
                'staffkabkota',
                'jL6imKYpV5M5UJAiMA-ioRPqdf8jVqRZ',
                '2017-05-30 20:30:31',
                '$2y$13$ccsrOaUhEabiYQrAtQMkyerNwDir.PvV/V0apzJ0nvz5mJio4KRUG',
                null,
                'staffkabkota@jabarprov.go.id',
                'staffkabkota@jabarprov.go.id',
                time(),
                '172.25.0.7',
                time(),
                '172.25.0.7',
                null,
                10,
                80,
                time(),
                time(),
                'Staff Kota Bandung',
                '080989999',
                'Jl. Alamat Kota Bandung',
                null,
                null,
                null,
                '22'
            ],
            [
                5,
                'staffkec',
                '0zQ5yPvvcT9UUZOSHTawAU-LtyhY9G-b',
                '2017-05-30 20:30:31',
                '$2y$13$PTAepuWNE9bM4IgBFhZdqelBX1FHkoNzOv4iv/6gBQ/.gsnxgOwSm',
                null,
                'staffkec@jabarprov.go.id',
                'staffkec@jabarprov.go.id',
                time(),
                '172.25.0.7',
                time(),
                '172.25.0.7',
                null,
                10,
                70,
                time(),
                time(),
                'Staff Kecamatan Coblong',
                '080989999',
                'Jl. Kecamatan Coblong',
                null,
                null,
                '431',
                '22'
            ],
            [
                6,
                'staffkel',
                'Z9Zbtp9e0RGMlAPcPEyYvfytKXJbXdnb',
                '2017-05-30 20:30:31',
                '$2y$13$KBcgAn9Mk6WM7AbJ/.aeFeigBEVZMyXn7JqjTAUMq6fiT/wOEKRZ2',
                null,
                'staffkel@jabarprov.go.id',
                'staffkel@jabarprov.go.id',
                time(),
                '172.25.0.7',
                time(),
                '172.25.0.7',
                null,
                10,
                60,
                time(),
                time(),
                'Staff Kelurahan Dago',
                '080989999',
                'Jl. Kelurahan Dago',
                null,
                '6093',
                '431',
                '22'
            ],
            [
                7,
                'staffkel2',
                'vUAwdIpFC1D1YMkUO2P9g-R3hk8DJhkr',
                '2017-05-30 20:30:31',
                '$2y$13$wEaZRyZ5D.CWQsisMB58Ku0qLvw20TKdpnCYPAwMOIm19qTPC.VF2',
                null,
                'staffkel2@jabarprov.go.id',
                'staffkel2@jabarprov.go.id',
                time(),
                '172.25.0.7',
                time(),
                '172.25.0.7',
                null,
                10,
                60,
                time(),
                time(),
                'Staff Kelurahan Lebak Siliwangi',
                '080989999',
                'Jl. Kelurahan Lebak Siliwangi',
                null,
                '6094',
                '431',
                '22'
            ],
            [
                8,
                'rw01',
                'vucpmr46v-NmsUevzJYNdb7x5VjWyvrR',
                '2017-05-30 20:30:31',
                '$2y$13$uN8pFkdO6PiybzA7giIY8eZrVBaD1vUJOCMdBBYKH2659U7yvXipu',
                null,
                'rw01@jabarprov.go.id',
                'rw01@jabarprov.go.id',
                time(),
                '172.25.0.7',
                time(),
                '172.25.0.7',
                null,
                10,
                50,
                time(),
                time(),
                'RW 01 Kelurahan Dago',
                '080989999',
                'Jl. RW 01 Kelurahan Dago',
                '1',
                '6093',
                '431',
                '22'
            ],

        ])->execute();

        Yii::$app->db->createCommand()->batchInsert('user', [
            'id',
            'username',
            'auth_key',
            'access_token_expired_at',
            'password_hash',
            'password_reset_token',
            'email',
            'unconfirmed_email',
            'confirmed_at',
            'registration_ip',
            'last_login_at',
            'last_login_ip',
            'blocked_at',
            'status',
            'role',
            'created_at',
            'updated_at',
            'name',
            'phone',
            'address',
            'rw',
            'kel_id',
            'kec_id',
            'kabkota_id',
        ], [
            [
                9,
                'user',
                'rNXSqIas_43RdpG0e5_7d1W06iK8pXJ8',
                '2017-06-04 00:13:02',
                '$2y$13$nd/F3g6jjIa1/Sk6JZxZ5uVq0OpsbOmW1OdnbDG6BpFqgkFbQotjm',
                null,
                'user@demo.com',
                'user@demo.com',
                time(),
                '127.0.0.1',
                time(),
                '127.0.0.1',
                null,
                10,
                10,
                time(),
                time(),
                'User Kota Bandung Satu',
                '0857123456',
                'Jl. Alamat Kota Bandung Satu',
                2,
                6178,
                446,
                22,
            ],
            [
                10,
                'user.bandung',
                'rNXSqIas_43RdpG0e5_7d1W06iK8pXJ8',
                '2017-06-04 00:13:02',
                '$2y$13$nd/F3g6jjIa1/Sk6JZxZ5uVq0OpsbOmW1OdnbDG6BpFqgkFbQotjm',
                null,
                'user.bandung@demo.com',
                'user.bandung@demo.com',
                time(),
                '127.0.0.1',
                time(),
                '127.0.0.1',
                null,
                10,
                10,
                time(),
                time(),
                'User Kota Bandung Dua',
                '0857123456',
                'Jl. Alamat Kota Bandung Dua',
                2,
                6178,
                446,
                22,
            ],
            [
                11,
                'user.bekasi',
                'rNXSqIas_43RdpG0e5_7d1W06iK8pXJ8',
                '2017-06-04 00:13:02',
                '$2y$13$nd/F3g6jjIa1/Sk6JZxZ5uVq0OpsbOmW1OdnbDG6BpFqgkFbQotjm',
                null,
                'user.bekasi@demo.com',
                'user.bekasi@demo.com',
                time(),
                '127.0.0.1',
                time(),
                '127.0.0.1',
                null,
                10,
                10,
                time(),
                time(),
                'User Kota Bekasi',
                '0857123456',
                'Jl. Alamat Kota Bekasi',
                9,
                6228,
                452,
                23,
            ],
            [
                12,
                'user.tasikmalaya',
                'rNXSqIas_43RdpG0e5_7d1W06iK8pXJ8',
                '2017-06-04 00:13:02',
                '$2y$13$nd/F3g6jjIa1/Sk6JZxZ5uVq0OpsbOmW1OdnbDG6BpFqgkFbQotjm',
                null,
                'user.tasikmalaya@demo.com',
                'user.tasikmalaya@demo.com',
                time(),
                '127.0.0.1',
                time(),
                '127.0.0.1',
                null,
                10,
                10,
                time(),
                time(),
                'User Kota Tasikmalaya',
                '0857123456',
                'Jl. Alamat Kota Tasikmalaya',
                11,
                6341,
                466,
                26,
            ],
        ])->execute();

        $auth = Yii::$app->authManager;

        $admin = $auth->getRole('admin');
        $auth->assign($admin, 1);

        $staff = $auth->getRole('staff');
        $auth->assign($staff, 2);

        $staff = $auth->getRole('staffProv');
        $auth->assign($staff, 3);

        $staff = $auth->getRole('staffKabkota');
        $auth->assign($staff, 4);

        $staff = $auth->getRole('staffKec');
        $auth->assign($staff, 5);

        $staff = $auth->getRole('staffKel');
        $auth->assign($staff, 6);
        $auth->assign($staff, 7);

        $staff = $auth->getRole('staffRW');
        $auth->assign($staff, 8);

        $user = $auth->getRole('user');
        $auth->assign($user, 9);
        $auth->assign($user, 10);
        $auth->assign($user, 11);
        $auth->assign($user, 12);
    }

    public function actionPhoneBook()
    {
        Yii::$app->db->createCommand('TRUNCATE phonebooks')->execute();

        $seeder = new Seeder();
        $generator = $seeder->getGeneratorConfigurator();
        $faker = $generator->getFakerConfigurator();

        $kabKota = [22, 23, 26];

        $seeder->table('phonebooks')->columns([
            'id',
            'name' => $faker->company,
            'description' => $faker->text,
            'address' => $faker->address,
            'phone_numbers' => new JsonExpression([
                [
                    'type' => 'phone',
                    'phone_number' => '022-123456',
                ],
                [
                    'type' => 'message',
                    'phone_number' => '022-098763',
                ],
            ]),
            'kabkota_id' => $faker->randomElement($kabKota),
            'status' => PhoneBook::STATUS_ACTIVE,
            'seq' => 1,
            'latitude' => $faker->latitude('-6.148534', '-7.484602'),
            'longitude' => $faker->longitude('106.022438', '108.680921'),
            'cover_image_path' => 'https://dummyimage.com/wsxga',
            'created_at' => time(),
            'updated_at' => time(),
        ])->rowQuantity(50);

        $seeder->refill();
    }
}
