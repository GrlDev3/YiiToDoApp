<?php
namespace app\models;

use yii\base\Model;
use Yii;


class Tasks extends Model
{
    public $id;
    public $title;
    public $timestamp;

    public function rules(){
        return [
            [["title"],"required"],
            [["title"],"string"],
        ];
    }

    private static $filePath = '@app/data/tasks.json';

    public function __construct($id, $title)
    {
        $this->id = $id;
        $this->title = $title;
        $this->timestamp = date("Y-m-d H:i:s");
    }

    public static function getAllTasks()
    {
        $tasks = file_get_contents(\Yii::getAlias(self::$filePath));
        return json_decode($tasks, true) ?: [];
    }

    public static function saveTasks($tasks)
    {
        file_put_contents(\Yii::getAlias(self::$filePath), json_encode($tasks, JSON_PRETTY_PRINT));
    }

    public static function createTask($title)
    {
        $tasks = self::readTasksFromFile();//self::getAllTasks();
        $id = uniqid();//count($tasks) + 1;
        
        $newTask = new self($id, $title);
        //Create a new task

        /*$newTask = [
            'id' => $id,
            'title' => $title,
            'timestamp' => date('Y-m-d H:i:s')
        ];*/
        $tasks[] = $newTask;
        self::saveTasks($tasks);
        return $newTask;
    }

    public static function addTask($title)
{
    $tasks = self::getAllTasks();
    
    // Generate a new ID (find max ID + 1)
    $newId = !empty($tasks) ? max(array_column($tasks, 'id')) + 1 : 1;

    $newTask = ['id' => $newId, 'title' => $title, 'timestamp' => date('Y-m-d H:i:s')];
    $tasks[] = $newTask;

    self::saveTasks($tasks);
    
    return $newTask;
}


public static function updateTask($id, $title)
{
    $tasks = self::getAllTasks();

    foreach ($tasks as &$task) {
        if ($task['id'] == $id) {
            $task['title'] = $title;
            self::saveTasks($tasks);
            return true;
        }
    }

    return false; // Task ID not found
}


    public static function deleteTask($id)
    {
        $tasks = self::getAllTasks();
    
        foreach ($tasks as $key => $task) {
            if ($task['id'] == $id) {
                unset($tasks[$key]);
                self::saveTasks(array_values($tasks)); // Reset indexes
                return true;
            }
        }
    
        return false;
    }
    

    private static function readTasksFromFile()
    {
        $filePath = Yii::getAlias(self::$filePath);
        if(!file_exists($filePath)){
            file_put_contents($filePath, '[]');
        }

        return json_decode(file_get_contents($filePath), true);
    }
}