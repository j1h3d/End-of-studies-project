const chartColors = {
    column: {
      series1: '#826af9',
      series2: '#d2b0ff',
      bg: '#f8d3ff',
    },
    success: {
      shade_100: '#7eefc7',
      shade_200: '#06774f',
    },
    donut: {
      series1: '#ffe700',
      series2: '#00d4bd',
      series3: '#826bf8',
      series4: '#2b9bf4',
      series5: '#FFA1A1',
    },
    area: {
      series3: '#a4f8cd',
      series2: '#60f2ca',
      series1: '#2bdac7',
    },
  }
  import axios from "axios"


export default({
state : {
    donutChart: {
    
    series: [],
    chartOptions: {
      legend: {
        show: true,
        position: 'bottom',
        fontSize: '14px',
        fontFamily: 'Montserrat',
      },
      colors: [
        chartColors.donut.series1,
        chartColors.donut.series5,
        chartColors.donut.series3,
        chartColors.donut.series2,
        chartColors.donut.series4,
        
      ],
      dataLabels: {
        enabled: true,
        formatter(val) {
          // eslint-disable-next-line radix
          return `${parseInt(val)}%`
        },
      },
      plotOptions: {
        pie: {
          donut: {
            labels: {
              show: true,
              name: {
                fontSize: '2rem',
                fontFamily: 'Montserrat',
              },
              value: {
                fontSize: '1rem',
                fontFamily: 'Montserrat',
                formatter(val) {
                  // eslint-disable-next-line radix
                  return `${parseInt(val)}%`
                },
              },
              total: {
                show: true,
                fontSize: '1.5rem',
                label: 'Interventions',
                formatter() {
                  return this.state.donutChart.legend.position;
                },
              },
            },
          },
        },
      },
      labels: [ "électricité", "plomberie", "chauffage", "climatisation" ],
      responsive: [
        {
          breakpoint: 992,
          options: {
            chart: {
              height: 380,
            },
            legend: {
              position: 'bottom',
            },
          },
        },
        {
          breakpoint: 576,
          options: {
            chart: {
              height: 320,
            },
            plotOptions: {
              pie: {
                donut: {
                  labels: {
                    show: true,
                    name: {
                      fontSize: '1.5rem',
                    },
                    value: {
                      fontSize: '1rem',
                    },
                    total: {
                      fontSize: '1.5rem',
                    },
                  },
                },
              },
            },
            legend: {
              show: true,
            },
          },
        },
      ],
    },
  },
},
// actions:{
//     getAllPourcentages({commit,dispatch}){
      
//       axios.get('/api/piechart').then(response=>{
//         console.log(response.data);
//         let categories = [];
//         let pourcentages = [];
//         let table = response.data;
//         table.forEach(item => {
//             pourcentages.push(item.pourcentage);
//             categories.push(item.label_categorie);
//         })
//         // console.log('salut',pourcentages);
//         // console.log('salut',categories);

//         commit("getCategories",categories);
//         commit("getPourcentage",pourcentages);
        
        
//         })
//     },
//     // getAllCategories({commit}){
//     //     axios.get('/api/piechart').then(response=>{
//     //       //console.log(response.data);
//     //       let categories = [];
//     //       let tableau = response.data;
//     //       tableau.forEach(item => {
//     //           categories.push(item.label_categorie);
//     //       })
//     //       console.log('salut',categories)
//     //       commit("getCategories",categories);
//     //       })
//     //   },
//     // getCountInterventions({commit}){
//     //     axios.get('api/countinterventions').then(response=>{
//     //         console.log(response.data)
//     //         commit('getInterventions',response.data)
//     //     })
//     // }
   
//   },
//   mutations:{
    
//     // getPourcentage(state,data){
//     //   state.donutChart.series = data;
//     // },
//     getCategories(state,data){
//         state.donutChart.chartOptions.labels = data;
//     },
//     // getInterventions(state,data){
//     //     state.donutChart.countInterventions = data;
//     // },
    
//   },
})