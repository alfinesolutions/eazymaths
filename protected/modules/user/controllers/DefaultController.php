<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		if (Yii::app()->user->isGuest) {
			$this->redirect(Yii::app()->controller->module->loginUrl);
		}
		else{
			$this->redirect(Yii::app()->controller->module->returnUrl);
		}
			
	}
}