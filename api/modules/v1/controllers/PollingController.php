<?php

namespace app\modules\v1\controllers;

use app\filters\auth\HttpBearerAuth;
use app\models\Polling;
use app\models\PollingAnswer;
use app\models\PollingSearch;
use app\models\PollingVote;
use app\models\User;
use Illuminate\Support\Arr;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UnprocessableEntityHttpException;

/**
 * PollingController implements the CRUD actions for Polling model.
 */
class PollingController extends ActiveController
{
    public $modelClass = Polling::class;

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
                'index'         => ['get'],
                'view'          => ['get'],
                'create'        => ['post'],
                'update'        => ['put'],
                'delete'        => ['delete'],
                'vote'          => ['put'],
                'vote-check'    => ['get'],
                'answer-create' => ['post'],
                'answer-update' => ['put'],
                'answer-delete' => ['delete'],
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
            'only'  => [
                'index',
                'view',
                'create',
                'update',
                'delete',
                'vote',
                'vote-check',
                'answer-create',
                'answer-update',
                'answer-delete',
            ],
            'rules' => [
                [
                    'allow'   => true,
                    'actions' => [
                        'index',
                        'view',
                        'create',
                        'update',
                        'delete',
                        'answer-create',
                        'answer-update',
                        'answer-delete',
                    ],
                    'roles'   => ['admin', 'managePolling'],
                ],
                [
                    'allow'   => true,
                    'actions' => ['index', 'view', 'vote', 'vote-check'],
                    'roles'   => ['pollingList'],
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

    /**
     * @return Polling|array
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate()
    {
        $model   = new Polling();
        $request = Yii::$app->getRequest()->getBodyParams();

        $model->load($request, '');

        if ($model->validate() === false) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(422);

            return $model->getErrors();
        }

        if ($model->save(false)) {
            $inputAnswers = Arr::get($request, 'answers');

            foreach ($inputAnswers as $inputAnswer) {
                $answer       = new PollingAnswer();
                $answer->body = Arr::get($inputAnswer, 'body');
                $answer->link('polling', $model);
            }

            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);

            return $model;
        }

        throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        if ($model->validate() === false) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(422);

            return $model->getErrors();
        }

        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(200);

            return $model;
        }

        throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
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

        $this->checkAccess('delete', $model, $id);

        $model->status = Polling::STATUS_DELETED;

        if ($model->save(false) === false) {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }

        $response = Yii::$app->getResponse();
        $response->setStatusCode(204);

        return 'ok';
    }

    public function actionVote($id)
    {
        $request   = Yii::$app->getRequest()->getBodyParams();
        $pollingId = $id;
        $answerId  = Arr::get($request, 'id');
        $userId    = Yii::$app->user->getId();

        $exist = PollingVote::find()
            ->where(['polling_id' => $pollingId, 'answer_id' => $answerId, 'user_id' => $userId])
            ->exists();

        if ($exist) {
            throw new UnprocessableEntityHttpException('Already voted.');
        }

        $model             = new PollingVote();
        $model->polling_id = $id;
        $model->answer_id  = $answerId;
        $model->user_id    = $userId;

        if ($model->save() === false) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        $response = Yii::$app->getResponse();
        $response->setStatusCode(200);

        return 'ok';
    }

    public function actionVoteCheck($id)
    {
        $request   = Yii::$app->getRequest()->getBodyParams();
        $pollingId = $id;
        $answerId  = Arr::get($request, 'id');
        $userId    = Yii::$app->user->getId();

        $exist = PollingVote::find()
            ->where(['polling_id' => $pollingId, 'answer_id' => $answerId, 'user_id' => $userId])
            ->exists();

        $response = Yii::$app->getResponse();
        $response->setStatusCode(200);

        if ($exist) {
            return ['is_voted' => true];
        }

        return ['is_voted' => false];
    }

    public function actionAnswerCreate($id)
    {
        $model   = new PollingAnswer();
        $request = Yii::$app->getRequest()->getBodyParams();

        $model->polling_id = $id;

        $model->load($request, '');

        if ($model->validate() === false) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(422);

            return $model->getErrors();
        }

        if ($model->save(false)) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);

            return $model;
        }

        throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
    }

    public function actionAnswerUpdate($id, $answerId)
    {
        $model = PollingAnswer::find()
            ->where(['id' => $answerId, 'polling_id' => $id])
            ->one();

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        if ($model->validate() === false) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(422);

            return $model->getErrors();
        }

        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(200);

            return $model;
        }

        throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
    }

    public function actionAnswerDelete($id, $answerId)
    {
        $model = PollingAnswer::find()
            ->where(['id' => $answerId, 'polling_id' => $id])
            ->one();

        if ($model->delete() === false) {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }

        Yii::$app->getResponse()->setStatusCode(204);
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
        //
    }

    /**
     * @param $id
     * @return mixed|Polling
     * @throws \yii\web\NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = Polling::find()
            ->where(['id' => $id])
            ->andWhere(['!=', 'status', Polling::STATUS_DELETED])
            ->one();

        if ($model === null) {
            throw new NotFoundHttpException("Object not found: $id");
        }

        return $model;
    }

    public function prepareDataProvider()
    {
        $params = Yii::$app->request->getQueryParams();

        $userId = Yii::$app->user->getId();
        $user   = User::findIdentity($userId);

        $search = new PollingSearch();

        if ($user->role !== User::ROLE_ADMIN) {
            $search->scenario = PollingSearch::SCENARIO_LIST_USER;

            $params['kabkota_id'] = $user->kabkota_id;
            $params['kec_id']     = $user->kec_id;
            $params['kel_id']     = $user->kel_id;
            $params['rw']         = $user->rw;
        }

        return $search->search($params);
    }
}
