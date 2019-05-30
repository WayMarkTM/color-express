<?php
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Json;
use yii\data\ArrayDataProvider;
use app\models\constants\AdvertisingConstructionStatuses;

/* @var $this yii\web\View */
/* @var integer $id */
/* @var AdvertisingConstructionReservationPeriod[] $periods */
/* @var ReservationDates[] $reservationDates */
/* @var string|bool $isEditable */

$mappedPeriods = array();
foreach ($periods as $period) {
    $arr = [
        'id' => $period->id,
        'from' => $period->from,
        'to' => $period->to,
        'price' => $period->price,
    ];

    array_push($mappedPeriods, $arr);
}

$mappedReservationPeriods = array();
foreach ($reservationDates as $reservationDate) {
  $arr = [
    'reservationId' => $reservationDate->reservationId,
    'dates' => $reservationDate->dates,
  ];

  array_push($mappedReservationPeriods, $arr);
}

$this->registerJs('var periods'.$id.' = '.json_encode($mappedPeriods).';', \yii\web\View::POS_BEGIN);
$this->registerJs('var reservationPeriods'.$id.' = '.json_encode($mappedReservationPeriods).';', \yii\web\View::POS_BEGIN);
$this->registerJs('var reservationId'.$id.' = '.json_encode($id).';', \yii\web\View::POS_BEGIN);

$dataProvider = new ArrayDataProvider([
  'allModels' => $periods,
]);
?>

<?php if ($isEditable == 'true') { ?>
  <div id="periods-editable-container-<?php echo $id; ?>" ng-app="periods" ng-controller="periodsListCtrl as $ctrl">
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th class="text-center">С</th>
          <th class="text-center">По</th>
          <th class="text-center">Стоимость в день, BYN</th>
          <th class="text-center">Стоимость за период, BYN</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="period in $ctrl.periods track by period.from">
          <td class="text-center">
            <input
              type="text"
              class="form-control"
              uib-datepicker-popup="{{$ctrl.format}}"
              ng-model="period.from"
              is-open="popup<?php echo $id; ?>From.opened"
              datepicker-options="period.fromDatePickerOptions"
              ng-focus='popup<?php echo $id; ?>From.opened = true'
              ng-change="$ctrl.onDatePickerValueChanged"
              ng-required="true"
              current-text="Сегодня"
              close-text="Закрыть"
              ng-keydown="$ctrl.onDatePickerKeydown($event)"
            />
          </td>
          <td class="text-center">
            <input
              type="text"
              class="form-control"
              uib-datepicker-popup="{{$ctrl.format}}"
              ng-model="period.to"
              is-open="popup<?php echo $id; ?>To.opened"
              datepicker-options="period.toDatePickerOptions"
              ng-focus='popup<?php echo $id; ?>To.opened = true'
              ng-change="$ctrl.onDatePickerValueChanged"
              ng-required="true"
              current-text="Сегодня"
              close-text="Закрыть"
              ng-keydown="$ctrl.onDatePickerKeydown($event)"
            />
          </td>
          <td class="text-center">
            <input class="form-control full-width" type="text" ng-model="period.price"/>
          </td>
          <td class="text-center" ng-bind="$ctrl.calculateCost(period)"></td>
          <td class="text-center">
            <button
              type="button"
              class="custom-btn sm red"
              ng-click="$ctrl.deletePeriod(period)"
            >
              Удалить
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="row block-row">
      <div class="col-sm-12">
        <button
          type="button"
          class="custom-btn sm white"
          ng-click="$ctrl.addPeriodToStart()"
        >
          Добавить в начало
        </button>
        <button
          type="button"
          class="custom-btn sm white"
          ng-click="$ctrl.addPeriodToEnd()"
        >
          Добавить в конец
        </button>

        <button
          type="button"
          class="custom-btn sm blue"
          ng-click="$ctrl.saveChanges()"
        >
          Сохранить
        </button>
      </div>
    </div>
  </div>    

  <script type="text/javascript">
    var $element = document.querySelector('#periods-editable-container-<?php echo $id; ?>');
    angular.element($element).ready(function () {
      var periodsModule = angular.module('periods', ['ui.bootstrap']);
      periodsModule
          .config(appconfig);

      appconfig.$inject = ['$httpProvider'];

      function appconfig($httpProvider){
          $httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
          $httpProvider.defaults.headers.common['X-CSRF-Token'] = $('meta[name="csrf-token"]').attr('content');
      }

      periodsModule
          .controller('periodsListCtrl', periodsListCtrl);

      periodsListCtrl.$inject = ['$scope', '$http'];

      function periodsListCtrl($scope, $http) {
        var vm = this;

        vm.momentComparisonFormat = 'YYYYMMDD';
        vm.format = 'dd.MM.yyyy';
        vm.$onInit = init;
        vm.saveChanges = saveChanges;
        vm.addPeriodToStart = addPeriodToStart;
        vm.addPeriodToEnd = addPeriodToEnd;
        vm.deletePeriod = deletePeriod;
        vm.calculateCost = calculateCost;
        vm.updateTotalCost = updateTotalCost;
        vm.onDatePickerValueChanged = onDatePickerValueChanged;
        vm.recalculateDatePickerOptions = recalculateDatePickerOptions;
        vm.onDatePickerKeydown = onDatePickerKeydown;

        function init() {
          vm.reservationId = reservationId<?php echo $id; ?>;
          vm.periods = periods<?php echo $id; ?>.map(mapDbPeriodToVm);
          vm.recalculateDatePickerOptions();
          vm.reservedDates = _.chain(reservationPeriods<?php echo $id; ?>)
            .filter(function (period) {
              return period.reservationId != vm.reservationId;
            })
            .map(function (period) {
              return period.dates.map(function (d) { return moment(new Date(d)).format(vm.momentComparisonFormat); });
            })
            .flatten()
            .value();

          $scope.$watch(function() { return vm.periods; }, function (newVal, oldVal) {
            if (!_.isEqual(newVal, oldVal)) {
              var totalCost = _.sumBy(newVal, function (period) {
                return Number(calculateCost(period));
              }).toFixed(2);
              vm.updateTotalCost(totalCost);
              vm.recalculateDatePickerOptions();
            }
          }, true);
        }

        function onDatePickerValueChanged() {
          vm.recalculateDatePickerOptions();
        }

        function recalculateDatePickerOptions() {
          _.forEach(vm.periods, function (period) {
            var minFrom, maxFrom, minTo, minTo;
            var indexOfPeriod = _.indexOf(vm.periods, period);
            minFrom = indexOfPeriod > 0 ?
              vm.periods[indexOfPeriod - 1].to.addDays(1) :
              null;

            maxFrom = period.to.addDays(-1);
            minTo = period.from.addDays(1);

            maxTo = indexOfPeriod < vm.periods.length - 1 ?
              vm.periods[indexOfPeriod + 1].from.addDays(-1) :
              null;

            period.fromDatePickerOptions = getDatePickerOptions(minFrom, maxFrom);
            period.toDatePickerOptions = getDatePickerOptions(minTo, maxTo);
          });
        }

        function getDatePickerOptions(min, max) {
          var params = {
            startingDay: 1,
            dateDisabled: function (params) {
              var result = _.includes(vm.reservedDates, moment(params.date).format(vm.momentComparisonFormat));
              return params.mode === 'day' && result;
            }
          };

          if (min != null) {
            params.minDate = min;
          }

          if (max != null) {
            params.maxDate = max;
          }

          return params;
        }

        function mapDbPeriodToVm(p) {
          return {
              id: p.id,
              from: new Date(p.from),
              to: new Date(p.to),
              price: p.price,
            };
        }

        function calculateCost(period) {
          return (period.price * (moment(period.to).diff(moment(period.from), 'days') + 1)).toFixed(2);
        }

        function addPeriodToStart() {
          var firstPeriod = _.head(vm.periods);
          vm.periods.unshift({
            id: 0,
            price: firstPeriod.price,
            from: firstPeriod.from.addDays(-1),
            to: firstPeriod.from.addDays(-1),
          });
        }

        function addPeriodToEnd() {
          var lastPeriod = _.last(vm.periods);
          vm.periods.push({
            id: 0,
            price: lastPeriod.price,
            from: lastPeriod.to.addDays(1),
            to: lastPeriod.to.addDays(1),
          });
        }

        function deletePeriod(period) {
          var indexToDelete = _.indexOf(vm.periods, period);
          vm.periods.splice(indexToDelete, 1);
        }

        function saveChanges() {
          var submitModels = vm.periods.map(function (period) {
            return {
              id: period.id,
              price: period.price,
              from: moment(period.from).format('YYYY-MM-DD'),
              to: moment(period.to).format('YYYY-MM-DD'),
            };
          });

          var submitModel = {
            reservationId: vm.reservationId,
            periods: submitModels,
          };
          
          return $http.post(GATEWAY_URLS.SAVE_PERIODS, submitModel)
            .then(function (response) {
              if (!response.data.isValid) {
                toastr.error(response.data.message);
                return;
              }

              toastr.success('Заказ успешно обновлен.');
              vm.periods = response.data.periods.map(mapDbPeriodToVm);
              vm.updateTotalCost(response.data.totalCost);
            });
        }

        function updateTotalCost(totalCost) {
          $('#periods-editable-container-<?php echo $id; ?>').closest('tr').prev().find('.cost').html(totalCost);
        }

        function onDatePickerKeydown(e) {
          e.preventDefault();
        }
      }

      angular.bootstrap($element, ['periods']);
    });
  </script>
<?php } else { ?>
  <?php Pjax::begin(['id' => "pjax-{$id}", 'enablePushState' => false]); ?>

  <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'layout' => '{items}',
    'options' => [
      'class' => 'reservation-periods-'.$id
    ],
    'columns' => [
      [
        'label' => 'С',
        'headerOptions' => ['class' => 'text-center'],
        'contentOptions' =>['class' => 'text-center'],
        'value' => function ($model) {
          return $model->from;
        }
      ],
      [
        'label' => 'По',
        'headerOptions' => ['class' => 'text-center'],
        'contentOptions' =>['class' => 'text-center'],
        'value' => function ($model) {
          return $model->to;
        }
      ],
      [
        'label' => 'Стоимость в день, BYN',
        'headerOptions' => ['class' => 'text-center'],
        'contentOptions' =>['class' => 'text-center'],
        'format' => 'raw',
        'value' => function ($model) {
          return number_format($model->price, 2, ".", "");
        }
      ],
      [
        'label' => 'Стоимость за период, BYN',
        'headerOptions' => ['class' => 'text-center'],
        'contentOptions' =>['class' => 'text-center period-cost'],
        'value' => function ($model) {
          $fromDate = new \DateTime($model->from);
          $toDate = new \DateTime($model->to);
          $days = intval($fromDate->diff($toDate)->days + 1);
          return number_format($model->price * $days, 2, ".", "");
        }
      ]
    ]
  ]) ?>

  <?php Pjax::end(); ?>
<?php } ?>

<script type="text/javascript">
  $(document).ready(function () {
    $('.period-price-per-day').on('change', function (e) {
        var price = $(this).val(),
            period = $(this).data('period'),
            $cost = $(this).closest('tr').find('.period-cost');

        $cost.text(Math.round(price*period*100)/100);

        var $table = $('.period-price-per-day').closest('table');
        var $totalCost = $table.closest('tr').prev().find('.cost');
        var totalCost = 0;
        $table.find('.period-cost').each(function() {
          totalCost += Number($(this).html());
        });

        $totalCost.html(Math.round(totalCost*100)/100);
    });
  });
</script>