<?php

namespace app\models;

use Yii;
use yii\base\Model;

class FormModel extends Model
{
    public $emp_code;
    public $emp_name;
	public $department;
	public $dob;
	public $joining_date;
	public $emp_code_index;
	public $emp_name_index;
	public $department_index;
	public $dob_index;
	public $joining_date_index;
	 public $excelData;

   public function rules()
    {
        return [
            [['emp_code', 'emp_name', 'department', 'dob', 'joining_date'], 'required'],
            [['emp_code'], 'integer'],
            [['dob', 'joining_date'], 'safe'],
            [['emp_name', 'department'], 'string', 'max' => 50],
            [['emp_code'], 'unique'],
			[['excelData'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx,csv'],
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
	
	public static function getRowIndex(){
		for($index = 1 ; $index < 6 ; $index++){
			$array[] = $index;
		}
		return $array;
	}
	  public function assignValue(){
		$this->emp_code_index = 1;
		$this->emp_name_index = 0;
		$this->department_index =  2;
		$this->dob_index = 3;
		$this->joining_date_index = 4;
	  }
	  public function orderChange($postData){
		$this->emp_code_index = !empty($postData->emp_code_index) ? $postData->emp_code_index : 1;
		$this->emp_name_index = !empty($postData->emp_name_index) ? $postData->emp_name_index : 0 ;
		$this->department_index =  !empty($postData->department_index) ?  $postData->department_index : 2; 
		$this->dob_index = !empty($postData->dob_index) ?  $postData->dob_index : 3;
		$this->joining_date_index = !empty($postData->joining_date_index) ? $postData->joining_date_index : 4;
		return true;
	  }
	  
	 	
	
}