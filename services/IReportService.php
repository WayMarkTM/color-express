<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 5/23/2017
 * Time: 12:51 AM
 */

namespace app\services;

interface iReportService {
    public function generate($year, $fromMonth, $monthCount, $queryParams);
}