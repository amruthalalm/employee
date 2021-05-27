<?php
use yii\helpers\Html;
use app\models\User;
/* @var $this yii\web\View */

$this->title = 'Employee Database ';
?>
<div class="site-index">

	<header id="header">
				<div class="content">
					<h1><a href="#">Employee Database</a></h1>
					<p>Database management system for</br> uploading and viewing the Employee Details </p>
					<ul class="actions">
						<li>
						<?= Html::a('List the Employee Details', ['/employee/index'], ['class'=>'button primary icon solid fa-download']) ?>
					</li>
						<li>
						
						<?= Html::a('Upload the Employee Data', ['/employee/import'], ['class'=>'button icon solid fa-chevron-down scrolly']) ?>
						</li>
					</ul>
				</div>
				<div class="image phone"><div class="inner"><img src="images/images.png" alt=""></div></div>
	</header>
 </div>
