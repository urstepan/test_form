<?php 

namespace app\models;

use Yii;
use yii\base\Model;


class AddContractor extends Model
{
    public $text;
    public function rules()
    {
        return [
            [
                [
                    'text'
                ],
                'string'
            ]
        ];
    }
}

?>