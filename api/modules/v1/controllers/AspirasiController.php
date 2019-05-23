<?php

namespace app\modules\v1\controllers;

use app\filters\auth\HttpBearerAuth;
use app\models\Aspirasi;
use app\models\AspirasiSearch;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

/**
 * AspirasiController implements the CRUD actions for Aspirasi model.
 */
class AspirasiController extends ActiveController
{
    public $modelClass = Aspirasi::class;

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
                'index'    => ['get'],
                'view'     => ['get'],
                'create'   => ['post'],
                'update'   => ['put'],
                'delete'   => ['delete'],
                'public'   => ['get'],
                'approval' => ['post'],
                'likes'    => ['post'],
                'me'       => ['get'],
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
            'only'  => ['index', 'view', 'create', 'update', 'delete', 'approval', 'likes', 'me'],
            'rules' => [
                [
                    'allow'   => true,
                    'actions' => ['index', 'view', 'create', 'update', 'delete', 'me', 'likes', 'approval'],
                    'roles'   => ['admin', 'manageSettings'],
                ],
                [
                    'allow'   => true,
                    'actions' => ['index', 'view', 'create', 'update', 'delete', 'me', 'likes'],
                    'roles'   => ['user', 'staffRW'],
                ],
            ],
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        // Override Delete Action
        unset($actions['delete']);
        unset($actions['create']);
        unset($actions['update']);

        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        $actions['view']['findModel']            = [$this, 'findModel'];

        return $actions;
    }

    public function actionCreate()
    {
        $model            = new Aspirasi();
        $model->author_id = Yii::$app->user->getId();

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        if ($model->validate() && $model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
        } else {
            // Validation error
            $response = Yii::$app->getResponse();
            $response->setStatusCode(422);

            return $model->getErrors();
        }

        return $model;
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $this->checkAccess('update', $model);

        $model->author_id = Yii::$app->user->getId();

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        if ($model->validate() && $model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(200);
        } else {
            // Validation error
            $response = Yii::$app->getResponse();
            $response->setStatusCode(422);

            return $model->getErrors();
        }

        return $model;
    }

    /**
     * Delete entity with soft delete / status flagging
     *
     * @param $id
     * @return string
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     * @throws \yii\web\ServerErrorHttpException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $this->checkAccess('delete', $model);

        $model->status = Aspirasi::STATUS_DELETED;

        if ($model->save(false) === false) {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }

        $response = Yii::$app->getResponse();
        $response->setStatusCode(204);

        return 'ok';
    }

    public function actionApproval($id)
    {
        $action = Yii::$app->request->post('action');
        $note   = Yii::$app->request->post('note');

        $currentUserId = Yii::$app->user->getId();

        $model = $this->findModel($id);

        if ($model->status !== Aspirasi::STATUS_APPROVAL_PENDING) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(400);

            return 'Bad Request: Invalid Object Status';
        }

        if ($action === 'APPROVE') {
            $model->status      = Aspirasi::STATUS_PUBLISHED;
            $model->approved_by = $currentUserId;
        } elseif ($action === 'REJECT') {
            $model->status        = Aspirasi::STATUS_APPROVAL_REJECTED;
            $model->approval_note = $note;
            $model->approved_by   = $currentUserId;
        } else {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(400);

            return 'Bad Request: Invalid Action';
        }

        if ($model->save(false) === false) {
            throw new ServerErrorHttpException('Failed to process the object for unknown reason.');
        }

        $response = Yii::$app->getResponse();
        $response->setStatusCode(200);

        return 'ok';
    }

    public function actionLikes($id)
    {
        $userId = Yii::$app->user->getId();
        $user   = User::findIdentity($userId);

        /**
         * @var Aspirasi $model
         */
        $model = $this->findModel($id);

        $count = (new \yii\db\Query())
            ->from('aspirasi_likes')
            ->where(['user_id' => $userId, 'aspirasi_id' => $id])
            ->count();

        $alreadyLiked = (int) $count > 0;

        if ($alreadyLiked > 0) {
            $model->unlink('likes', $user, true);
        } else {
            $model->link('likes', $user);
        }

        $response = Yii::$app->getResponse();
        $response->setStatusCode(200);

        return 'ok';
    }

    public function actionMe()
    {
        $userId = Yii::$app->user->getId();
        $user   = User::findIdentity($userId);

        $search            = new AspirasiSearch();
        $search->author_id = $userId;
        $search->user      = $user;

        $params = Yii::$app->request->getQueryParams();

        return $search->search($params);
    }

    /**
     * Checks the privilege of the current user.
     *
     * This method should be overridden to check whether the current user has the privilege
     * to run the specified action against the specified data model.
     * If the user does not have access, a [[ForbiddenHttpException]] should be thrown.
     *
     * @param string $action the ID of the action to be executed
     * @param object $model the model to be accessed. If null, it means no specific model is being accessed.
     * @param array $params additional parameters
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        if (in_array($action, ['update', 'delete']) && $model->author_id !== Yii::$app->user->getId()) {
            throw new ForbiddenHttpException();
        }
    }

    /**
     * @param $id
     * @return mixed|Aspirasi
     * @throws \yii\web\NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = Aspirasi::find()
            ->where(['id' => $id])
            ->andWhere(['!=', 'status', Aspirasi::STATUS_DELETED])
            ->one();

        if ($model === null) {
            throw new NotFoundHttpException("Object not found: $id");
        }

        return $model;
    }

    public function prepareDataProvider()
    {
        $userId = Yii::$app->user->getId();
        $user   = User::findIdentity($userId);

        $search = new AspirasiSearch();
        $params = Yii::$app->request->getQueryParams();

        $search->user = $user;

        return $search->search($params);
    }
}
