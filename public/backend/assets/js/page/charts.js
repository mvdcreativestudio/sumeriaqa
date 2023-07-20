"use strict";

// // Gráfica Dashboard E-Commerce

// document.addEventListener("DOMContentLoaded", function() {
//   // Obtén el contexto del lienzo de la gráfica
//   var balance_chart = document.getElementById("balance-chart").getContext('2d');

//   var balance_chart_bg_color = balance_chart.createLinearGradient(0, 0, 0, 70);
//   balance_chart_bg_color.addColorStop(0, 'rgba(63,82,227,.2)');
//   balance_chart_bg_color.addColorStop(1, 'rgba(63,82,227,0)');

//   var labels = Object.keys(salesData).slice(-10); // Obtén los últimos 10 días como etiquetas
//   var data = Object.values(salesData).slice(-10); // Obtén los ingresos de los últimos 10 días

//   var myChart = new Chart(balance_chart, {
//     type: 'line',
//     data: {
//       labels: labels,
//       datasets: [{
//         data: data,
//         backgroundColor: balance_chart_bg_color,
//         borderWidth: 2,
//         borderColor: '#393e46',
//         pointBorderWidth: 0,
//         pointBorderColor: 'transparent',
//         pointRadius: 3,
//         pointBackgroundColor: 'transparent',
//         pointHoverBackgroundColor: 'rgba(63,82,227,1)',
//         tension: 0 // Añade esta opción para eliminar la curva de la línea
//       }]
//     },
//     options: {
//       scales: {
//         y: {
//           display: false, // Oculta el eje y
//           beginAtZero: true
//         },
//         x: {
//           display: false, // Oculta el eje x
//           grid: {
//             display: false
//           },
//           ticks: {
//             display: false
//           }
//         }
//       },
//       elements: {
//         line: {
//           fill: 'start', // Rellena la línea hasta el inicio del gráfico
//           borderWidth: 0 // Elimina el borde de la línea
//         },
//         point: {
//           radius: 0, // Elimina el punto en los datos
//           hoverRadius: 3, // Define el radio del punto al pasar el cursor sobre él
//           backgroundColor: 'rgba(63,82,227,1)',
//           hoverBackgroundColor: 'rgba(63,82,227,1)'
//         }
//       },
//       plugins: {
//         tooltip: {
//           enabled: false // Desactiva el tooltip al pasar el cursor sobre los datos
//         },
//         legend: {
//           display: false // Oculta la leyenda
//         }
//       },
//       layout: {
//         padding: {
//           top: 10,
//           right: 10,
//           bottom: 10,
//           left: 10
//         }
//       }
//     }
//   });
// });


