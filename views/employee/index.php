
<div class = "information-heading">
<div>
<p> Employee List View</p>
</div>
	<?php

		use yii\grid\GridView; 

		//echo '<pre>'; print_r($dataProvider);die();
		echo GridView::widget([
			'dataProvider' => $dataProvider,
		   // 'filterModel' => $searchModel,
			'columns' => [			   
			 ['class' => 'yii\grid\SerialColumn'],
			   'emp_code',
			   'emp_name',
			   'department',
			  [
			   'label' => 'Age',
			  'value' => function ($model) {
           return $model->age();
       }], [
			   'label' => 'Experience in the organization',
			  'value' => function ($model) {
           return $model->experince();
       }],
			  
			   
				]]); 
	?>
		
</div>