<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 4/5/2017
 * Time: 9:05 PM
 */

namespace app\services;


use app\models\AddContractForm;
use app\models\AddDocumentForm;
use app\models\entities\Contract;
use app\models\entities\Document;

class DocumentService
{
    /**
     * @param integer $userId
     * @param integer $subclientId
     * @return array
     */
    public function getDocumentsCalendar($userId, $subclientId = null) {
        $yearsAndMonths = $this->getUserDocumentsYearsAndMonths($userId, $subclientId);
        return $this->createCalendar($yearsAndMonths);
    }

    /**
     * @param integer $userId
     * @param integer $year
     * @param integer $month
     * @param integer|null $subclientId
     * @return array|Document[]
     */
    public function getDocuments($userId, $year, $month, $subclientId) {
        $query = Document::find()
            ->where(['=', 'user_id', $userId])
            ->andFilterWhere(['=', 'year', $year])
            ->andFilterWhere(['=', 'month', $month]);

        if ($subclientId != null) {
            $query = $query
                ->andWhere(['=', 'subclient_id', $subclientId]);
        }

        return $query->all();
    }

    /**
     * @param integer $userId
     * @param integer $year
     * @param integer|null $subclientId
     * @return array|Contract[]
     */
    public function getContracts($userId, $year, $subclientId) {
        $query = Contract::find()
            ->where(['=', 'user_id', $userId])
            ->andFilterWhere(['=', 'year', $year]);

        if ($subclientId != null) {
            $query = $query
                ->andWhere(['=', 'subclient_id', $subclientId]);
        }

        return $query->all();
    }

    /**
     * @param $viewModel AddDocumentForm
     * @param $userId integer
     * @param $subclientId integer
     */
    public function createDocument($viewModel, $userId, $subclientId) {
        $document = new Document();
        $document->month = $viewModel->month;
        $document->year = $viewModel->year;
        $document->path = $viewModel->path;
        $document->user_id = $userId;
        $document->subclient_id = $subclientId;
        $document->filename = $viewModel->filename;
        $document->contract = $viewModel->contract;
        $document->save();
    }

    /**
     * @param $viewModel AddContractForm
     * @param $userId integer
     * @param $subclientId integer
     */
    public function createContract($viewModel, $userId, $subclientId) {
        $contract = new Contract();
        $contract->year = $viewModel->year;
        $contract->user_id = $userId;
        $contract->subclient_id = $subclientId;
        $contract->filename = $viewModel->filename;
        $contract->path = $viewModel->path;
        $contract->save();
    }

    /**
     * @param integer $userId
     * @param integer $subclientId
     * @return array|mixed
     */
    private function getUserDocumentsYearsAndMonths($userId, $subclientId) {
        $query = Document::find()
            ->where(['=', 'user_id', $userId]);

        if ($subclientId != null) {
            $query = $query
                ->where(['=', 'subclient_id', $subclientId]);
        }

        return $query
            ->select(['year', 'month'])
            ->all();
    }

    /**
     * @param array|\DateTime $dates
     * @return array
     */
    private function createCalendar($dates) {
        if (count($dates) == 0) {
            return [];
        }

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