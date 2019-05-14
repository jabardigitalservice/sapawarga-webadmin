<?php

namespace app\modules\v1\controllers;

use app\filters\auth\HttpBearerAuth;
use app\models\AttachmentForm;
use Illuminate\Support\Arr;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\web\UploadedFile;

class AttachmentController extends ActiveController
{
    public $modelClass = AttachmentForm::class;

    public function actions()
    {
        return [
            'options' => [
                'class' => 'yii\rest\OptionsAction',
            ],
        ];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class'       => CompositeAuth::className(),
            'authMethods' => [
                HttpBearerAuth::className(),
            ],
        ];

        $behaviors['verbs'] = [
            'class'   => \yii\filters\VerbFilter::className(),
            'actions' => [
                'create' => ['post'],
            ],
        ];

        // remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);

        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors'  => [
                'Origin'                         => ['*'],
                'Access-Control-Request-Method'  => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
            ],
        ];

        // re-add authentication filter
        $behaviors['authenticator'] = $auth;
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = ['options', 'public'];

        // setup access
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only'  => ['create'], //only be applied to
            'rules' => [
                [
                    'allow'   => true,
                    'actions' => ['create'],
                    'roles'   => ['admin', 'manageSettings'],
                ],
            ],
        ];

        return $behaviors;
    }

    public function actionCreate()
    {
        $model = new AttachmentForm();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        switch ($model->type) {
            case 'phonebook_photo':
                $model->scenario = AttachmentForm::SCENARIO_PHONE_BOOK_PHOTO_CREATE;
                break;
        }

        $model->file = UploadedFile::getInstanceByName('file');

        if (! $model->validate()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(422);

            return $model->getErrors();
        }

        return 'ok';
    }
}
