<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/20/2018
 * Time: 12:04 PM
 */

namespace core\entities\DataTransfer;


use Zelenin\yii\behaviors\Slug;

class Country extends \core\entities\sf\Country
{
    public function behaviors()
    {
        return [
            'slug' => [
                'class' => Slug::class,
                'slugAttribute' => 'slug',
                'attribute' => 'name',
                // optional params
                'ensureUnique' => true,
                'replacement' => '-',
                'lowercase' => true,
                'immutable' => false,
                // If intl extension is enabled, see http://userguide.icu-project.org/transforms/general.
                'transliterateOptions' => 'Russian-Latin/BGN; Any-Latin; Latin-ASCII; NFD; [:Nonspacing Mark:] Remove; NFC;'
            ]
        ];
    }
}