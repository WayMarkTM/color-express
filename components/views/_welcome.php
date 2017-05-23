<?php
/**
 * Created by PhpStorm.
 * User: yansa
 * Date: 14.05.2017
 * Time: 18:36
 */
use \app\models\SignupForm;
?>
<div class="welcome-container">
    <div class="block-row"><span>Добро пожаловать,</span></div>
    <div class="name"><span class="edit-user pointer" data-user-id="<?= Yii::$app->user->getId() ?>"><?= $name ?></span>!</div>
</div>
<?php
Yii::$app->view->on(\yii\web\View::EVENT_END_BODY, function () {
    $scenario = SignupForm::SCENARIO_EmployeeEditClient;
    if (Yii::$app->user->can('employee')) {
        $scenario = SignupForm::SCENARIO_EDIT_EMPLOYEE;
    }
    echo $this->render('@app/views/layouts/_partial/_modalClientData', [
        'title' => 'Изменить данные компании',
        'scenario' => $scenario,
        'class' => 'edit-user'
    ]);
});
?>
