<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 01.05.2017
 * Time: 12:40
 */

namespace app\services;


class JsonService
{

    /**
     * takes an array of models and their attributes names and outputs them as json. works with relations unlike CJSON::encode()
     * @param $models array an array of models, consider using $dataProvider->getData() here
     * @param $attributeNames string a comma delimited list of attribute names to output, for relations use relationName.attributeName
     * @return string json object
     */

    public static function database_model_to_array(array $models, $attributeNames) {
        $attributeNames = explode(',', $attributeNames);

        $rows = array(); //the rows to output
        foreach ($models as $model) {
            $row = array(); //you will be copying in model attribute values to this array
            foreach ($attributeNames as $name) {
                $name = trim($name); //in case of spaces around commas
                $row[$name] = $model[$name]; //this function walks the relations
            }
            $rows[] = $row;
        }

        return $rows;
    }

    public static function json_encode_database_models(array $models, $attributeNames) {
        return json_encode(JsonService::database_model_to_array($models, $attributeNames));
    }
}