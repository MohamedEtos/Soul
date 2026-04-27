/*=========================================================================================
    File Name: dashboard-ecommerce.js
    Description: dashboard ecommerce page content with Apexchart Examples
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(window).on("load", function () {
const vistorsData = (window.dashboardData && window.dashboardData.vistorsChart) ? window.dashboardData.vistorsChart : [0,0,0,0,0,0,0];
const ordersChart = (window.dashboardData && window.dashboardData.ordersChart) ? window.dashboardData.ordersChart : [0,0,0,0,0,0,0];
const ProductChart = (window.dashboardData && window.dashboardData.ProductChart) ? window.dashboardData.ProductChart : [0,0,0,0,0,0,0];
const vistorsHoursChart = (window.dashboardData && window.dashboardData.vistorsHoursChart) ? window.dashboardData.vistorsHoursChart : [0,0,0,0,0,0,0];
const lastMonthSeries = (window.dashboardData && window.dashboardData.lastMonthSeries) ? window.dashboardData.lastMonthSeries : [0,0,0,0,0,0,0];
const thisMonthSeries = (window.dashboardData && window.dashboardData.thisMonthSeries) ? window.dashboardData.thisMonthSeries : [0,0,0,0,0,0,0];
const newClients = (window.dashboardData && window.dashboardData.newClients) ? window.dashboardData.newClients : [0,0,0,0,0,0,0];
const retainedClients = (window.dashboardData && window.dashboardData.retainedClients) ? window.dashboardData.retainedClients : [0,0,0,0,0,0,0];
const DeviceSessionchart = (window.dashboardData && window.dashboardData.DeviceSessionchart) ? window.dashboardData.DeviceSessionchart : [0,0,0,0,0,0,0];
const trafficSourcesLabels = (window.dashboardData && window.dashboardData.trafficSourcesLabels) ? window.dashboardData.trafficSourcesLabels : ['Google','Facebook','Instagram','TikTok','Direct','Other'];
const trafficSourcesSeries = (window.dashboardData && window.dashboardData.trafficSourcesSeries) ? window.dashboardData.trafficSourcesSeries : [0,0,0,0,0,0];


const sourceColorMap = {
  Google: '#4285F4',
  Facebook: '#1877F2',
  Instagram: '#E4405F',
  TikTok: '#000000',
  LinkedIn: '#0A66C2',
  YouTube: '#FF0000',
  'X (Twitter)': '#1DA1F2',
  Telegram: '#0088CC',
  WhatsApp: '#25D366',
  Direct: '#e71b8e',
  Other: '#6B7280'
};

const colors = trafficSourcesLabels.map(l => sourceColorMap[l] || '#9CA3AF');



  var $primary = '#DA0E7D';
  var $success = '#28C76F';
  var $danger = '#EA5455';
  var $warning = '#FF9F43';
  var $info = '#00cfe8';
  var $primary_light = '#A9A2F6';
  var $danger_light = '#f29292';
  var $success_light = '#55DD92';
  var $warning_light = '#ffc085';
  var $secondary_light = '#ebd1b8ff';
  var $secondary  = '#ebd1b8ff';
  var $info_light = '#1fcadb';
  var $strok_color = '#b9c3cd';
  var $label_color = '#e7e7e7';
  var $white = '#fff';




  // Line Area Chart - 1
  // ----------------------------------

  var gainedlineChartoptions = {
    chart: {
      height: 100,
      type: 'area',
      toolbar: {
        show: false,
      },
      sparkline: {
        enabled: true
      },
      grid: {
        show: false,
        padding: {
          left: 0,
          right: 0
        }
      },
    },
    colors: [$primary],
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'smooth',
      width: 2.5
    },
    fill: {
      type: 'gradient',
      gradient: {
        shadeIntensity: 0.9,
        opacityFrom: 0.7,
        opacityTo: 0.5,
        stops: [0, 80, 100]
      }
    },
    series: [{
      name: 'الزوار',
      data: vistorsData
    }],

    xaxis: {
      labels: {
        show: false,
      },
      axisBorder: {
        show: false,
      }
    },
    yaxis: [{
      y: 0,
      offsetX: 0,
      offsetY: 0,
      padding: { left: 0, right: 0 },
    }],
    tooltip: {
      x: { show: false }
    },
  }

  var gainedlineChart = new ApexCharts(
    document.querySelector("#line-area-chart-1"),
    gainedlineChartoptions
  );

  gainedlineChart.render();



  // Line Area Chart - 2
  // ----------------------------------

  var revenuelineChartoptions = {
    chart: {
      height: 100,
      type: 'area',
      toolbar: {
        show: false,
      },
      sparkline: {
        enabled: true
      },
      grid: {
        show: false,
        padding: {
          left: 0,
          right: 0
        }
      },
    },
    colors: [$success],
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'smooth',
      width: 2.5
    },
    fill: {
      type: 'gradient',
      gradient: {
        shadeIntensity: 0.9,
        opacityFrom: 0.7,
        opacityTo: 0.5,
        stops: [0, 80, 100]
      }
    },
    series: [{
      name: 'بالساعات',
      data: vistorsHoursChart
    }],

    xaxis: {
      labels: {
        show: false,
      },
      axisBorder: {
        show: false,
      }
    },
    yaxis: [{
      y: 0,
      offsetX: 0,
      offsetY: 0,
      padding: { left: 0, right: 0 },
    }],
    tooltip: {
      x: { show: false }
    },
  }

  var revenuelineChart = new ApexCharts(
    document.querySelector("#line-area-chart-2"),
    revenuelineChartoptions
  );

  revenuelineChart.render();


  // Line Area Chart - 3
  // ----------------------------------

  var saleslineChartoptions = {
    chart: {
      height: 100,
      type: 'area',
      toolbar: {
        show: false,
      },
      sparkline: {
        enabled: true
      },
      grid: {
        show: false,
        padding: {
          left: 0,
          right: 0
        }
      },
    },
    colors: [$danger],
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'smooth',
      width: 2.5
    },
    fill: {
      type: 'gradient',
      gradient: {
        shadeIntensity: 0.9,
        opacityFrom: 0.7,
        opacityTo: 0.5,
        stops: [0, 80, 100]
      }
    },
    series: [{
      name: 'اوردر',
      data: ordersChart
    }],

    xaxis: {
      labels: {
        show: false,
      },
      axisBorder: {
        show: false,
      }
    },
    yaxis: [{
      y: 0,
      offsetX: 0,
      offsetY: 0,
      padding: { left: 0, right: 0 },
    }],
    tooltip: {
      x: { show: false }
    },
  }

  var saleslineChart = new ApexCharts(
    document.querySelector("#line-area-chart-3"),
    saleslineChartoptions
  );

  saleslineChart.render();

  // Line Area Chart - 4
  // ----------------------------------

  var orderlineChartoptions = {
    chart: {
      height: 100,
      type: 'area',
      toolbar: {
        show: false,
      },
      sparkline: {
        enabled: true
      },
      grid: {
        show: false,
        padding: {
          left: 0,
          right: 0
        }
      },
    },
    colors: [$warning],
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'smooth',
      width: 2.5
    },
    fill: {
      type: 'gradient',
      gradient: {
        shadeIntensity: 0.9,
        opacityFrom: 0.7,
        opacityTo: 0.5,
        stops: [0, 80, 100]
      }
    },
    series: [{
      name: 'منتج',
      data: ProductChart
    }],

    xaxis: {
      labels: {
        show: false,
      },
      axisBorder: {
        show: false,
      }
    },
    yaxis: [{
      y: 0,
      offsetX: 0,
      offsetY: 0,
      padding: { left: 0, right: 0 },
    }],
    tooltip: {
      x: { show: false }
    },
  }

  var orderlineChart = new ApexCharts(
    document.querySelector("#line-area-chart-4"),
    orderlineChartoptions
  );

  orderlineChart.render();

  // revenue-chart Chart
  // -----------------------------

  var revenueChartoptions = {
    chart: {
      height: 330,
      toolbar: { show: false },
      type: 'line',
    },
    stroke: {
      curve: 'smooth',
      dashArray: [0, 8],
      width: [4, 2],
    },
    grid: {
      borderColor: $label_color,
    },
    legend: {
      show: false,
    },
    colors: [$danger_light, $strok_color],

    fill: {
      type: 'gradient',
      gradient: {
        shade: 'dark',
        inverseColors: false,
        gradientToColors: [$primary, $strok_color],
        shadeIntensity: 1,
        type: 'horizontal',
        opacityFrom: 1,
        opacityTo: 1,
        stops: [0, 100, 100, 100]
      },
    },
    markers: {
      size: 0,
      hover: {
        size: 5
      }
    },
    xaxis: {
      labels: {
        style: {
          colors: $strok_color,
        }
      },
      axisTicks: {
        show: false,
      },
      categories: ['01', '05', '09', '13', '17', '21', '26', '31'],
      axisBorder: {
        show: false,
      },
      tickPlacement: 'on',
    },
    yaxis: {
      tickAmount: 5,
      labels: {
        style: {
          color: $strok_color,
        },
        formatter: function (val) {
          return val > 999 ? (val / 1000).toFixed(1) + 'الف' : val;
        }
      }
    },
    tooltip: {
      x: { show: false }
    },
    series: [{
      name: "الشهر الحالي",
      data: thisMonthSeries
    },
    {
      name: "الشهر السابق",
      data: lastMonthSeries
    }
    ],

  }

  var revenueChart = new ApexCharts(
    document.querySelector("#revenue-chart"),
    revenueChartoptions
  );

  revenueChart.render();


  // Goal Overview  Chart
  // -----------------------------

  var goalChartoptions = {
    chart: {
      height: 250,
      type: 'radialBar',
      sparkline: {
        enabled: true,
      },
      dropShadow: {
        enabled: true,
        blur: 3,
        left: 1,
        top: 1,
        opacity: 0.1
      },
    },
    colors: [$success],
    plotOptions: {
      radialBar: {
        size: 110,
        startAngle: -150,
        endAngle: 150,
        hollow: {
          size: '77%',
        },
        track: {
          background: $strok_color,
          strokeWidth: '50%',
        },
        dataLabels: {
          name: {
            show: false
          },
          value: {
            offsetY: 18,
            color: '#99a2ac',
            fontSize: '4rem'
          }
        }
      }
    },
    fill: {
      type: 'gradient',
      gradient: {
        shade: 'dark',
        type: 'horizontal',
        shadeIntensity: 0.5,
        gradientToColors: ['#00b5b5'],
        inverseColors: true,
        opacityFrom: 1,
        opacityTo: 1,
        stops: [0, 100]
      },
    },
    series: [83],
    stroke: {
      lineCap: 'round'
    },

  }

  var goalChart = new ApexCharts(
    document.querySelector("#goal-overview-chart"),
    goalChartoptions
  );

  goalChart.render();

  // Client Retention Chart
  // ----------------------------------

  var clientChartoptions = {
    chart: {
      stacked: true,
      type: 'bar',
      toolbar: { show: false },
      height: 300,
    },
    plotOptions: {
      bar: {
        columnWidth: '10%'
      }
    },
    colors: [$primary, $danger],
    series: [{
      name: 'عملاء جدد',
      data: newClients
    }, {
      name: 'عملاء مستمرين',
      data: retainedClients
    }],
    grid: {
      borderColor: $label_color,
      padding: {
        left: 0,
        right: 0
      }
    },
    legend: {
      show: true,
      position: 'top',
      horizontalAlign: 'left',
      offsetX: 0,
      fontSize: '14px',
      markers: {
        radius: 50,
        width: 10,
        height: 10,
      }
    },
    dataLabels: {
      enabled: false
    },
    xaxis: {
      labels: {
        style: {
          colors: $strok_color,
        }
      },
      axisTicks: {
        show: false,
      },
categories: [
  'ديس',
  'نوف',
  'أكت',
  'سبت',
  'أغس',
  'يول',
  'يون',
  'ماي',
  'أبر',
  'مار',
  'فبر',
  'ينا'
]
,
      axisBorder: {
        show: false,
      },
    },
    yaxis: {
      tickAmount: 5,
      labels: {
        style: {
          color: $strok_color,
        }
      }
    },
    tooltip: {
      x: { show: false }
    },
  }

  var clientChart = new ApexCharts(
    document.querySelector("#client-retention-chart"),
    clientChartoptions
  );

  clientChart.render();

  // Session Chart
  // ----------------------------------

  var sessionChartoptions = {
    chart: {
      type: 'donut',
      height: 325,
      toolbar: {
        show: false
      }
    },
    dataLabels: {
      enabled: false
    },
    series: DeviceSessionchart.series,
    legend: { show: false },
    comparedResult: [2, -3, 8],
    labels: ['Desktop', 'Mobile', 'Tablet'],
    stroke: { width: 0 },
    colors: [$primary, $warning, $danger],
    fill: {
      type: 'gradient',
      gradient: {
        gradientToColors: [$primary_light, $warning_light, $danger_light]
      }
    }
  }

  var sessionChart = new ApexCharts(
    document.querySelector("#session-chart"),
    sessionChartoptions
  );

  sessionChart.render();

  // Customer Chart
  // -----------------------------

  var customerChartoptions = {
    chart: {
      type: 'pie',
      height: 330,
      dropShadow: {
        enabled: false,
        blur: 5,
        left: 1,
        top: 1,
        opacity: 0.2
      },
      toolbar: {
        show: true
      }
    },
    labels: trafficSourcesLabels,
    series: trafficSourcesSeries,
    dataLabels: {
      enabled: false
    },
    legend: { show: false },
    stroke: {
      width: 5
    },
    colors: colors,
    fill: {
      type: 'gradient',
      gradient: {
        gradientToColors: colors

      }
    }
  }



  var customerChart = new ApexCharts(
    document.querySelector("#customer-chart"),
    customerChartoptions
  );

  customerChart.render();

});



// Chat Application
(function ($) {
  "use strict";
  // Chat area
  if ($('.chat-application .user-chats').length > 0) {
    var chat_user = new PerfectScrollbar(".user-chats", { wheelPropagation: false });
  }

})(jQuery);

