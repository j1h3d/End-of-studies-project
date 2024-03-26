<template>
  <b-card no-body>
    <b-card-header>
      <!-- title and subtitle -->
      <div>
        <b-card-sub-title class="mb-25">
          Revenue de la semaine
        </b-card-sub-title>
        <b-card-title class="font-weight-bolder">
          $74,382.72
        </b-card-title>
      </div>
      <!--/ title and subtitle -->

      <!-- datepicker -->
      <div class="d-flex align-items-center">
        <feather-icon
          icon="CalendarIcon"
          size="16"
        />
        <flat-pickr
          v-model="rangePicker"
          :config="{ mode: 'range'}"
          class="form-control flat-picker bg-transparent border-0 shadow-none"
          placeholder="YYYY-MM-DD"
        />
      </div>
      <!-- datepicker -->
    </b-card-header>

    <b-card-body>
      <vue-apex-charts
        type="bar"
        height="350"
        :options="barChart.chartOptions"
        :series="barChart.series"
      />
    </b-card-body>
  </b-card>
</template>

<script>
import {
  BCard, BCardHeader, BCardBody, BCardSubTitle, BCardTitle,
} from 'bootstrap-vue'
import VueApexCharts from 'vue-apexcharts'
import flatPickr from 'vue-flatpickr-component'
import axios from 'axios'

export default {
  components: {
    VueApexCharts,
    BCard,
    BCardHeader,
    flatPickr,
    BCardBody,
    BCardSubTitle,
    BCardTitle,
  },
  data() {
    return {
      rangePicker: ['2019-05-01', '2019-05-10'],
      barChart: {
        series: [
          {
            data: [700, 350, 480, 600, 210, 550, 150],
          },
        ],
        chartOptions: {
          chart: {
            toolbar: {
              show: false,
            },
          },
          colors: $themeColors.info,
          plotOptions: {
            bar: {
              horizontal: true,
              barHeight: '30%',
              endingShape: 'rounded',
            },
          },
          grid: {
            xaxis: {
              lines: {
                show: false,
              },
            },
          },
          dataLabels: {
            enabled: false,
          },
          xaxis: {
            categories: ['MON, 11', 'THU, 14', 'FRI, 15', 'MON, 18', 'WED, 20', 'FRI, 21', 'MON, 23'],
          },
          yaxis: {
            // opposite: isRtl,
          }
        }
      }
      }
  },
  mounted(){
    axios.get('api/revenuperdate',{ params : {fromDate : "2021-07-16" , toDate : "2021-07-22" }})
    .then((response)=>{
      console.log(response.data);

      
    });
     console.log(this.barChart.chartOptions)  
  }
}
</script>