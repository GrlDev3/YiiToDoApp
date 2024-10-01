<?php   //tasks view

/** @var yii\web\View $this */

$this->title = 'To Do Application';

$this->registerJsFile('@web/js/tasks.js', ['depends' => [yii\web\JqueryAsset::class]]);
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">To Do:</h1>
    </div>

    <div class="body-content">

        <form class="text-center" id="task-form">
            <input class="form-control-dark" type="text" id="task-title" placeholder="New task" required />
            <button class="btn btn-dark" type="submit">Add Task</button>
        </form>
        <div id="task-list"></div>

    </div>
</div>
