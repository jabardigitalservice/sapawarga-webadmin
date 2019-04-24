<?php

namespace app\commands;

use app\models\Area;
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

        echo 'Seeding Phonebooks Categories...' . PHP_EOL;
        $this->actionPhoneBookCategories();

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

        $sql = file_get_contents(__DIR__ . '/../migrations/seeder/staff_user_role_permission_20190423.sql');
        Yii::$app->db->createCommand($sql)->execute();
    }

    public function actionPhoneBookCategories()
    {
        Yii::$app->db->createCommand('TRUNCATE phonebooks_categories')->execute();

        Yii::$app->db->createCommand()->batchInsert('phonebooks_categories', [
            'name',
            'status',
            'created_at',
            'updated_at',
        ], [
            [
                'Kesehatan',
                10,
                time(),
                time(),
            ],
            [
                'Ekonomi',
                10,
                time(),
                time(),
            ],
            [
                'Keamanan',
                10,
                time(),
                time(),
            ],
            [
                'Transportasi',
                10,
                time(),
                time(),
            ],
        ])->execute();
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
            'cover_image_path' => $faker->optional()->imageUrl(800, 480, 'city'),
            'category_id' => $faker->randomElement([1, 2, 3, 4]),
            'created_at' => time(),
            'updated_at' => time(),
        ])->rowQuantity(500);

        $seeder->refill();

        $this->setRandomKecamatan();

        // Khusus Call Center
        Yii::$app->db->createCommand()->batchInsert('phonebooks', [
            'name',
            'phone_numbers',
            'status',
            'seq',
            'created_at',
            'updated_at',
        ], [
            [
                '112 Kepolisian',
                new JsonExpression([
                    [
                        'type' => 'phone',
                        'phone_number' => '022-112',
                    ],
                ]),
                10,
                1000,
                time(),
                time(),
            ],
            [
                '119 Quick Response',
                new JsonExpression([
                    [
                        'type' => 'phone',
                        'phone_number' => '022-110',
                    ],
                ]),
                10,
                1000,
                time(),
                time(),
            ],
            [
                '123 Pemadam Kebakaran',
                new JsonExpression([
                    [
                        'type' => 'phone',
                        'phone_number' => '022-123',
                    ],
                ]),
                10,
                1000,
                time(),
                time(),
            ],
        ])->execute();
    }

    protected function setRandomKecamatan()
    {
        echo 'Set Phonebooks - Kecamatan...' . PHP_EOL;

        $phonebooks = PhoneBook::find()->all();

        foreach ($phonebooks as $phonebook) {
            $kecamatan = Area::find()->where(['parent_id' => $phonebook->kabkota_id])
                ->orderBy(new \yii\db\Expression('rand()'))
                ->one();

            $phonebook->kec_id = $kecamatan->id;
            $phonebook->save(false);
        }
    }
}
