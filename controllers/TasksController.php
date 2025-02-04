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
        $request = Yii::$app->request;
        $data = json_decode($request->getRawBody(), true);
    
        if (!isset($data['title']) || empty($data['title'])) {
            Yii::$app->response->statusCode = 400;
            return ['error' => 'Task title cannot be empty'];
        }
    
        $newTask = Tasks::addTask($data['title']);
        
        if ($newTask) {
            Yii::$app->response->statusCode = 201; // Created
            return ['success' => true, 'task' => $newTask];
        }
    
        Yii::$app->response->statusCode = 500; // Internal Server Error
        return ['error' => 'Failed to create task'];
    }
    

    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $data = json_decode($request->getRawBody(), true);
    
        if (!isset($data['title']) || empty($data['title'])) {
            Yii::$app->response->statusCode = 400;
            return ['error' => 'Task title cannot be empty'];
        }
    
        $updated = Tasks::updateTask($id, $data['title']);
    
        if ($updated) {
            Yii::$app->response->statusCode = 200;
            return ['success' => true];
        }
    
        Yii::$app->response->statusCode = 404; // Not Found
        return ['error' => 'Task not found'];
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
