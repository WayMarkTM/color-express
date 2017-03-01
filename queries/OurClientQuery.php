<?php

namespace app\queries;

/**
 * This is the ActiveQuery class for [[\app\models\entities\OurClient]].
 *
 * @see \app\models\entities\OurClient
 */
class OurClientQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \app\models\entities\OurClient[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\entities\OurClient|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
