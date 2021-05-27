<?php

namespace app\controllers;

use Yii;
use app\models\Information;
use app\models\FormModel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use app\models\import;



use app\models\Image;

/**
 * ProjectController implements the CRUD actions for Project model.
 */
class EmployeeController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Project models.
     * @return mixed
     */
    public function actionIndex()
    {

		$model = new FormModel();
        $query = Information::find();
		 $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
       
        return $this->render('index', [
            
            'dataProvider' => $dataProvider,
			 'model' => $model,
			
        ]);
    }
	 
      /**
     * To import the value
     * @return Ambigous <string, string>
     */
    public function actionImport(){
    	
    	$model = new Import();
			$query = new FormModel();
			$query->assignValue();
        if (Yii::$app->request->isPost) {
            $model->excelData = UploadedFile::getInstance($model, 'excelData');
            if ($model->upload()) {
				if($model->validate()){
				$targetFolder = $model->getExcelPath();
    			FileHelper::createDirectory($targetFolder,"0755");
    			$model->excelData->saveAs($targetFolder. $model->excelData->baseName . '.' . $model->excelData->extension);
    			$excelData = Import::getExcelAsArray($targetFolder.$model->excelData->name);
			
    				$statistics = $model->insertData($excelData);
    				if($statistics){
    					$this->setFlash('info', ['type'=>'success', 'body' =>'Data imported successfully']);
    				}else{
    					$this->setFlash('warning', ['type'=>'warning', 'body' =>'No records are updated!!']);
    				}
                // file is uploaded successfully
				 return $this->render('import', ['model' => $model]);
                return;
				}
            }
        }

        return $this->render('import', ['model' => $model, 'query' => $query,]);
    	
    }
	  /**
     * To import the change order
     * @return Ambigous <string, string>
     */
    public function actionChangeorder(){
		$formModel = new FormModel();
		$model = new Import();
		if (Yii::$app->request->isPost) {
			$postData= Yii::$app->request->post();
            $formModel->orderChange($postData);           
    }
	  return $this->render('import', ['model' => $model, 'query' => $formModel,]);

    	    
    	
    }
    
    
  
}
