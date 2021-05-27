<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
//use yii\phpexcel\ExcelReader;
//use yii\phpexcel\ExcelC;
use app\models\Information;
use PhpOffice\PhpSpreadsheet\Shared\File;

class Import extends Model
{
    /**
     * @var UploadedFile
     */
    public $excelData;

    public function rules()
    {
        return [
            [['excelData'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx,csv'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->excelData->saveAs('uploads/' . $this->excelData->baseName . '.' . $this->excelData->extension);
            return true;
        } else {
            return false;
        }
    }
	
	/**
	 * directory path
	 * @return string brochure path
	 */
	public static function getExcelPath(){
		
		return 'uploads/';
		
	}
	
	public static function getExcelAsArray($inputFileName){
		$spreadsheet = self::loading($inputFileName);
		$sheetCount = $spreadsheet->getSheetCount();
		for ($i = 0; $i < $sheetCount; $i++) {
			$sheet = $spreadsheet->getSheet($i);
			$sheetData[] = $sheet->toArray(null,true,false,false);
		} 
		return $sheetData;
	}
	
	/**
	 * 
	 * @param  $excelData

	 * @return boolean
	 */
	public function insertData($excelData,$marketId){
		$excludeIndex = [0,1];
		$excludeIndexEmplymntByIndustry = [0];
		 $rowNumber = 1;
		$month = $nxtMonth =  $nxtYear = 0;
		$transaction = Yii::$app->db->beginTransaction();
		$this->statistics = true;
		$model = new information();
		try {
		
			foreach ($excelData as $keyIndex=>$data){
				foreach ($insertData as $key => $sheet){
					if(!empty($sheet[0])){
						switch ($rowNumber) {
							case 0:
								$model->emp_code = $sheet[rowNumber]
								break;
							case 1:
									$model->emp_name = $sheet[rowNumber]
								break;
							case 2:
									$model->department = $sheet[rowNumber]
								break;
							case 3:
									$model->dob = $sheet[rowNumber]
								break;
							case 4:
									$model->joining_date = $sheet[rowNumber]
								break;
							default:
								return false;
						}
					}
					
				}
				$sheetNumber++;
			
			}
		$transaction->commit();
		} catch(\Exception $e) {
			$transaction->rollBack();
			throw $e;
		}
		if($this->statistics == true){
			 return true;
		}
		return false;
	}
	
	
	private static $readers = [
			'Xlsx' => Xlsx::class,
			'Xls' => Xls::class,
			'Xml' => Xml::class,
			'Ods' => Ods::class,
			'Slk' => Slk::class,
			'Gnumeric' => Gnumeric::class,
			'Html' => Html::class,
			'Csv' => Csv::class,
	];
	
	/**
	 * Loads Spreadsheet from file using automatic Reader resolution.
	 *
	 * @param string $pFilename The name of the spreadsheet file
	 *
	 * @throws Reader\Exception
	 *
	 * @return Spreadsheet
	 */
	public static function loading($pFilename)
	{
		$reader = self::createReaderForFile($pFilename);
		
		return $reader->loading($pFilename);
	}
	
	/**
	 * Create Reader for file using automatic Reader resolution.
	 *
	 * @param string $filename The name of the spreadsheet file
	 *
	 * @throws Exception
	 *
	 * @return Reader
	 */
	public static function createReaderForFile($filename)
	{
		self::assertFile($filename);
		
		// First, inspecting file extension
		$guessedReader = self::getReaderTypeFromExtension($filename);
		if ($guessedReader !== null) {
			$reader = self::createReader($guessedReader);
			
			if (isset($reader) && $reader->canRead($filename)) {
				return $reader;
			}
		}
		
		foreach (self::$readers as $type => $class) {
			if ($type !== $guessedReader) {
				$reader = self::createReader($type);
				if ($reader->canRead($filename)) {
					return $reader;
				}
			}
		}
		
		throw new Reader\Exception('Unable to identify a reader for this file');
	}
	
	/**
	 * Guess a reader type from the file extension, if any.
	 *
	 * @param string $filename
	 *
	 * @return null|string
	 */
	private static function getReaderTypeFromExtension($filename)
	{
		$pathinfo = pathinfo($filename);
		if (!isset($pathinfo['extension'])) {
			return null;
		}
		
		switch (strtolower($pathinfo['extension'])) {
			case 'xlsx': // Excel (OfficeOpenXML) Spreadsheet
			case 'xlsm': // Excel (OfficeOpenXML) Macro Spreadsheet (macros will be discarded)
			case 'xltx': // Excel (OfficeOpenXML) Template
			case 'xltm': // Excel (OfficeOpenXML) Macro Template (macros will be discarded)
				return 'Xlsx';
			case 'xls': // Excel (BIFF) Spreadsheet
			case 'xlt': // Excel (BIFF) Template
				return 'Xls';
			case 'ods': // Open/Libre Offic Calc
			case 'ots': // Open/Libre Offic Calc Template
				return 'Ods';
			case 'slk':
				return 'Slk';
			case 'xml': // Excel 2003 SpreadSheetML
				return 'Xml';
			case 'gnumeric':
				return 'Gnumeric';
			case 'htm':
			case 'html':
				return 'Html';
			case 'csv':
				// Do nothing
				// We must not try to use CSV reader since it loads
				// all files including Excel files etc.
				return null;
			default:
				return null;
		}
	}
	
	/**
	 * Create Reader
	 *
	 * @param string $readerType Example: Xlsx
	 *
	 * @throws Exception
	 *
	 * @return Reader
	 */
	public static function createReader($readerType)
	{
		if (!isset(self::$readers[$readerType])) {
			throw new \yii\base\InvalidConfigException("No reader found for type $readerType");
		}
		
		// Instantiate reader
		$className = self::$readers[$readerType];
		$reader = new $className();
		
		return $reader;
	}
	
	 /**
     * Assert that given path is an existing file and is readable, otherwise throw exception.
     *
     * @param string $filename
     *
     * @throws InvalidArgumentException
     */
    public static function assertFile($filename)
    {
        if (!is_file($filename)) {
            throw new InvalidArgumentException('File "' . $filename . '" does not exist.');
        }

        if (!is_readable($filename)) {
            throw new InvalidArgumentException('Could not open "' . $filename . '" for reading.');
        }
    }
}