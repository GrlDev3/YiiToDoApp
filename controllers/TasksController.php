<?php
namespace app\controllers;

use yii\rest\Controller;
use Yii;
use app\models\Tasks;

class TasksController extends Controller
{
    public function actionIndex()
    {
        // GET: List all tasks
        return Tasks::getAllTasks();
    }

    public function actionCreate()
    {
        // POST: Create a new task
        $request = Yii::$app->request;
        $title = $request->post('title');
        if (empty($title)) {
            Yii::$app->response->statusCode = 400;
            return ['error' => 'Task title cannot be empty'];
        }

        $task = Tasks::createTask($title);
        Yii::$app->response->statusCode = 201;
        return $task;//['success' => true];
    }

    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $data = json_decode($request->getRawBody(), true);
        
        if (!isset($data['title']) || empty($data['title'])) {
            Yii::$app->response->statusCode = 400;
            return ['error' => 'Task title cannot be empty'];
        }
    
        Tasks::updateTask($id, $data['title']);
        Yii::$app->response->statusCode = 200;
    
        return ['success' => true];
    }
    

    public function actionDelete($id)
    {
        // DELETE: Remove a task by ID
        if(Tasks::deleteTask($id)){
        Yii::$app->response->statusCode = 204;
        return null;
        }

        Yii::$app->response->statusCode = 404;
        return ['error' => 'Task not found'];
    }
}
