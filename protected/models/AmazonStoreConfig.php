<?php

/**
 * This is the model class for table "amazon_store_config".
 *
 * The followings are the available columns in table 'amazon_store_config':
 * @property string $id
 * @property string $merchant_id
 * @property string $aws_key
 * @property string $aws_secret
 * @property string $name
 * @property string $version
 * @property string $user_id
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Store $id0
 */
class AmazonStoreConfig extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'amazon_store_config';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, merchant_id, aws_key, aws_secret, name, user_id', 'required'),
			array('id', 'length', 'max'=>10),
			array('merchant_id', 'length', 'max'=>16),
			array('aws_key, name, version', 'length', 'max'=>32),
			array('aws_secret', 'length', 'max'=>64),
			array('user_id', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, merchant_id, aws_key, aws_secret, name, version, user_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'id0' => array(self::BELONGS_TO, 'Store', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'merchant_id' => 'Merchant',
			'aws_key' => 'Aws Key',
			'aws_secret' => 'Aws Secret',
			'name' => 'Name',
			'version' => 'Version',
			'user_id' => 'User',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('merchant_id',$this->merchant_id,true);
		$criteria->compare('aws_key',$this->aws_key,true);
		$criteria->compare('aws_secret',$this->aws_secret,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('version',$this->version,true);
		$criteria->compare('user_id',$this->user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AmazonStoreConfig the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
