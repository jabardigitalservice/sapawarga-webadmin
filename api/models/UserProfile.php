<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_profiles".
 *
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $address
 * @property string $rw
 * @property integer $kel_id
 * @property integer $kec_id
 * @property integer $kokab_id
 */
class UserProfile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_profiles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['name', 'string', 'max' => 64],
            [['name', 'rw', 'kel_id', 'kec_id', 'kokab_id'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'phone' => 'Phone',
            'address' => 'Address'
            'rw' => 'RW'
            'kel_id' => 'Kelurahan'
            'kec_id' => 'Kecamatan'
            'kokab_id' => 'Kota/Kabupaten'
        ];
    }
}
