<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 4/5/2017
 * Time: 9:05 PM
 */

namespace app\services;


use app\models\entities\Document;

class DocumentService
{
    /**
     * @param integer $userId
     * @return array
     */
    public function getDocumentsCalendar($userId) {
        $dates = $this->getUserDocumentsCreationDates($userId);
        return $this->createCalendar($dates);
    }

    /**
     * @param integer $userId
     * @param integer $year
     * @param integer $month
     * @return array|Document[]
     */
    public function getDocuments($userId, $year, $month) {
        $start_date = new \DateTime($year.'-'.$month.'-01');
        $end_date = (new \DateTime($year.'-'.($month+1).'-01'))->modify('-1 second');

        return Document::find()
            ->where(['=', 'user_id', $userId])
            ->andFilterWhere(['>=', 'created_at', $start_date->format(DateService::$FULL_DATE_FORMAT)])
            ->andFilterWhere(['<=', 'created_at', $end_date->format(DateService::$FULL_DATE_FORMAT)])
            ->all();
    }

    /**
     * @param integer $userId
     * @return array|\DateTime
     */
    private function getUserDocumentsCreationDates($userId) {
        $entityDates = Document::find()
            ->where(['=', 'user_id', $userId])
            ->select(['created_at'])
            ->all();

        $dates = array();

        /** @var Document $entityDate */
        foreach($entityDates as $entityDate) {
            array_push($dates, new \DateTime($entityDate->created_at));
        }

        usort($dates, function ($a, $b) {
            return DateService::comparator($a, $b);
        });

        return $dates;
    }

    /**
     * @param array|\DateTime $dates
     * @return array
     */
    private function createCalendar($dates) {
        $result = [];

        foreach($dates as $date) {
            $year = $date->format('Y');
            $month = $date->format('n');
            if (count($result[$year][$month]) == 0) {
                $result[$year][$month] = 0;
            }

            $result[$year][$month] += 1;
        }

        return $result;
    }
}