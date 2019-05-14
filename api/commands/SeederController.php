<?php

namespace app\commands;

use app\models\Area;
use app\models\PhoneBook;
use app\models\Broadcast;
use app\models\category\PhoneBookCategory;
use app\models\category\BroadcastCategory;
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

        echo 'Seeding Categories...' . PHP_EOL;
        $this->actionCategory();

        echo 'Seeding Phonebooks...' . PHP_EOL;
        $this->actionPhoneBook();

        echo 'Seeding Broadcasts...' . PHP_EOL;
        $this->actionBroadcast();
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

    public function actionCategory()
    {
        Yii::$app->db->createCommand('TRUNCATE categories')->execute();

        $sql = file_get_contents(__DIR__ . '/../migrations/seeder/category.sql');
        Yii::$app->db->createCommand($sql)->execute();
    }

    public function actionPhoneBook()
    {
        Yii::$app->db->createCommand('TRUNCATE phonebooks')->execute();

        $sql = file_get_contents(__DIR__ . '/../migrations/seeder/phonebook.sql');
        Yii::$app->db->createCommand($sql)->execute();

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

    public function actionBroadcast()
    {
        Yii::$app->db->createCommand('TRUNCATE broadcasts')->execute();

        $sql = file_get_contents(__DIR__ . '/../migrations/seeder/broadcast.sql');
        Yii::$app->db->createCommand($sql)->execute();
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
