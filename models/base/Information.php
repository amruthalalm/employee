<?php

namespace app\models\base;

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
            'emp_code' => 'Emp Code',
            'emp_name' => 'Emp Name',
            'department' => 'Department',
            'dob' => 'Dob',
            'joining_date' => 'Joining Date',
        ];
    }
}
