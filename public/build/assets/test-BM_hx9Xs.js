import{C as p,r as l,L as c,u}from"./index-D98agcq4.js";import{_ as d}from"./_plugin-vue_export-helper-DlAUqK2U.js";import{C as f,i as m,o as C,d as h,b as _,y as g,r as n,l as b}from"./app-C40yS1Zs.js";p.register(...l);const v=f({name:"App",components:{LineChart:c},setup(){const e=n([30,40,60,70,5]),t=b(()=>({labels:["Paris","Nîmes","Toulon","Perpignan","Autre"],datasets:[{data:e.value,borderColor:"#0079AF",backgroundColor:"rgba(0, 121, 175, 0.3)"}]})),{lineChartProps:o,lineChartRef:s}=u({chartData:t}),r=n({responsive:!0,plugins:{legend:{position:"top"},title:{display:!0,text:"Delivered"}},scales:{x:{display:!0},y:{beginAtZero:!0}}});function a(){e.value=shuffle(e.value)}return{shuffleData:a,lineChartProps:o,lineChartRef:s,options:r}}}),L={id:"app"};function P(e,t,o,s,r,a){const i=m("LineChart");return C(),h("div",L,[_(i,g(e.lineChartProps,{options:e.options}),null,16,["options"])])}const k=d(v,[["render",P]]);export{k as default};
