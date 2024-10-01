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
        $tasks = file_get_contents(Yii::getAlias(self::$filePath));
        return json_decode($tasks, true) ?: [];
    }

    public static function saveTasks($tasks)
    {
        file_put_contents(Yii::getAlias(self::$filePath), json_encode($tasks, JSON_PRETTY_PRINT));
    }

    public static function createTask($title)
    {
        $tasks = self::getAllTasks();
        $id = count($tasks) + 1;
        $newTask = new self($id, $title);
        $tasks[] = $newTask;
        self::saveTasks($tasks);
    }

    public static function updateTask($id, $title)
    {
        $tasks = self::getAllTasks();
        $tasks[$id] = $title;
        self::saveTasks($tasks);
    }

    public static function deleteTask($id)
    {
        $tasks = self::getAllTasks();
        $tasks = array_filter($tasks, function($task) use ($id) {
            return $task['id'] != $id;
        });
        self::saveTasks($tasks);
    }
}