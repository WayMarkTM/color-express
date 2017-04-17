<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 4/5/2017
 * Time: 9:05 PM
 */

namespace app\services;


use app\models\AddDocumentForm;
use app\models\entities\Document;

class DocumentService
{
    /**
     * @param integer $userId
     * @return array
     */
    public function getDocumentsCalendar($userId) {
        $yearsAndMonths = $this->getUserDocumentsYearsAndMonths($userId);
        return $this->createCalendar($yearsAndMonths);
    }

    /**
     * @param integer $userId
     * @param integer $year
     * @param integer $month
     * @return array|Document[]
     */
    public function getDocuments($userId, $year, $month) {
        return Document::find()
            ->where(['=', 'user_id', $userId])
            ->andFilterWhere(['=', 'year', $year])
            ->andFilterWhere(['=', 'month', $month])
            ->all();
    }

    /**
     * @param $viewModel AddDocumentForm
     * @param $userId integer
     */
    public function createDocument($viewModel, $userId) {
        $document = new Document();
        $document->month = $viewModel->month;
        $document->year = $viewModel->year;
        $document->path = $viewModel->path;
        $document->user_id = $userId;
        $document->save();
    }

    /**
     * @param integer $userId
     * @return array|mixed
     */
    private function getUserDocumentsYearsAndMonths($userId) {
        return Document::find()
            ->where(['=', 'user_id', $userId])
            ->select(['year', 'month'])
            ->all();
    }

    /**
     * @param array|\DateTime $dates
     * @return array
     */
    private function createCalendar($dates) {
        $result = [];
        $minYear = 9999;
        $maxYear = 1;

        foreach($dates as $date) {
            $year = $date['year'];
            $month = $date['month'];

            if ($year < $minYear) {
                $minYear = $year;
            }

            if ($year > $maxYear) {
                $maxYear = $year;
            }

            if (count($result[$year][$month]) == 0) {
                $result[$year][$month] = 0;
            }

            $result[$year][$month] += 1;
        }

        $years = range($minYear, $maxYear);

        foreach($years as $year) {
            if ($result[$year] == null) {
                $result[$year] = false;
            }
        }

        return $result;
    }
}