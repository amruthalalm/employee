<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Information;
use app\models\FormModel;

?>

<div class = "information-heading">
	

	<div class= "row">
		<div class= "col-md-4">
		<?php $form = \yii\widgets\ActiveForm::begin([
		'id' => 'order-details',
		'action' =>  Url::to ('index.php?r=employee%2Fimport'),
		'method' => 'post',
		'enableAjaxValidation' => true,
	//	'validationUrl' => 'validation-rul',
		'options' => ['enctype' => 'multipart/form-data']
		]); ?>
			<table id="customers">
			  <tr>
				<th>Name</th>
				<th>Order Of the field</th>
			   
			  </tr>
			  <tr>
				<td>Name</td>
				<td> <?= $form->field($query, 'emp_name_index')->dropDownList(FormModel::getRowIndex(), ['prompt'=>'', 'class' => "form-control"])->label(false); ?></td>

			  
			  </tr>
			  <tr>
				<td>Employee code</td>
				<td> <?= $form->field($query, 'emp_code_index')->dropDownList(FormModel::getRowIndex(), ['prompt'=>'', 'class' => "form-control"])->label(false); ?></td>

			  
			  </tr>
				<tr>
				<td>Department</td>
				<td> <?= $form->field($query, 'department_index')->dropDownList(FormModel::getRowIndex(), ['prompt'=>'', 'class' => "form-control"])->label(false); ?></td>

			  
			  </tr>
				<tr>
				<td>Date of Birth </td>
				<td> <?= $form->field($query, 'dob_index')->dropDownList(FormModel::getRowIndex(), ['prompt'=>'', 'class' => "form-control"])->label(false); ?></td>

			  
			  </tr>
				<tr>
				<td>Joining Date</td>
				<td> <?= $form->field($query, 'joining_date_index')->dropDownList(FormModel::getRowIndex(), ['prompt'=>'', 'class' => "form-control"])->label(false); ?></td>
			 
			  </tr>
			 
			</table>
		</div>
		

		<div class= "col-md-6 form-submit-part">
			
				<?= $form->errorSummary($model); ?>


				<?= $form->field($model, 'excelData')->fileInput() ?>

				<button class= "float-right">Submit</button>

			<?php ActiveForm::end() ?>

		</div>
	</div>
</div>

<?php

$this->registerJs(<<<JS
$(document).ready(function(){
   //  $('.form-submit-part').css("pointer-events","none");
   	
	
	
	  
  });
JS
);
?> 
