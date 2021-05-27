<?php

namespace app\models;

use Yii;


/**
 * This is the model class for table "information".
 *
 * @property int $emp_code
 * @property string $emp_name
 * @property string $department
 * @property string $dob
 * @property string $joining_date
 */
class Information extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'information';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emp_code', 'emp_name', 'department', 'dob', 'joining_date'], 'required'],
            [['emp_code'], 'integer'],
            [['dob', 'joining_date'], 'safe'],
            [['emp_name', 'department'], 'string', 'max' => 50],
            [['emp_code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'emp_code' => 'Employee code',
            'emp_name' => 'Name',
            'department' => 'Department',
            'dob' => 'Date of Birth ',
            'joining_date' => 'Joining Date',
        ];
    }
	
	 public function age()
	{
		$data = Information::findOne($this->emp_code);
		$dob = $data->dob;
		$diff = (date('Y') - date('Y',strtotime($dob)));
		return $diff;

		 
	}	
	public function experince()
	{
		$data = Information::findOne($this->emp_code);
		$exp = $data->joining_date;
		$datetime1 = new \DateTime(date("Y-m-d"));
		$datetime2 = new \DateTime($exp);
		$interval = $datetime1->diff($datetime2);
		//$diff = (datetime1 - date('Y',strtotime($datetime2)));
		 return  $interval->format('%y years %m months and %d days');
	 
	}	
}
