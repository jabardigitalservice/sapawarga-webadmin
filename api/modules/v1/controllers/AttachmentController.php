<?php

namespace app\modules\v1\controllers;

use app\filters\auth\HttpBearerAuth;
use app\models\Attachment\PhoneBookPhotoForm;
use app\models\AttachmentForm;
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
        $type = Yii::$app->request->post('type');

        $model = null;

        switch ($type) {
            case 'phonebook_photo':
                $model = new PhoneBookPhotoForm();
                break;
        }

        if ($model === null) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(400);

            return ['Model type not set.'];
        }

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $model->file = UploadedFile::getInstanceByName('file');

        if (!$model->validate()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(422);

            return $model->getErrors();
        }

        return 'ok';

//        if ($model->upload()) {
//            $relativePath = $model->getRelativeFilePath();
//
//            $responseData = [
//                'path' => $relativePath,
//                'url'  => '',
//            ];
//
//            return $responseData;
//        }

        $response = Yii::$app->getResponse();
        $response->setStatusCode(400);
    }
}
