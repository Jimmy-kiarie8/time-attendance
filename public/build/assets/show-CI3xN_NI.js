import{r as v,D as Y,i as d,o as f,c as _,w as e,e as g,b as t,f as a,a as m,t as o,d as Z,g as h,F as ee,V as le}from"./app-C40yS1Zs.js";import te from"./statement-DGkpOG_O.js";import ae from"./payments-CR_igQO_.js";import ne from"./penalties-Cwf6Ko_F.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const oe={class:"d-flex justify-space-between align-center"},ue={class:"text-right"},de={class:"text-h6"},re={class:"text-subtitle-1"},se={class:"text-subtitle-2"},ie={class:"d-flex"},pe={class:"me-4"},me={class:"text-caption"},ge={__name:"show",props:{modelRoute:{type:String,required:!0}},setup(E,{expose:I}){const N=E,V=v(!1),L=v(!1),P=v("Updated"),$=v("black"),b=v(!1);Y({});const n=v([]),A=v([]),x=v("loan");function U(p){return{Rejected:"error",Approved:"success",Pending:"warning",Active:"primary"}[p]||"grey"}function w(p){return p?new Date(p).toLocaleDateString("en-US",{year:"numeric",month:"short",day:"numeric"}):"N/A"}async function K(p){b.value=!0;try{const l=await le.get(`/${N.modelRoute}/${p}`);n.value=l.data.loan,A.value=l.data.statement,console.log("formData",n.value),b.value=!1}catch(l){console.error("Failed to fetch data:",l),b.value=!1,L.value=!0,$.value="error",P.value="Failed to load data"}}function R(p){console.log(p),V.value=!0,K(p.id)}return v("en-US"),I({show:R}),(p,l)=>{const q=d("v-btn"),F=d("v-tab"),j=d("v-tabs"),H=d("v-toolbar"),k=d("v-card-title"),M=d("v-chip"),T=d("v-card-item"),y=d("v-card"),c=d("v-col"),S=d("v-row"),r=d("v-icon"),s=d("v-list-item-title"),i=d("v-list-item"),C=d("v-list"),D=d("v-card-text"),z=d("v-divider"),O=d("v-container"),B=d("v-window-item"),G=d("v-timeline-item"),J=d("v-timeline"),Q=d("v-window"),W=d("v-dialog"),X=d("v-snackbar");return V.value?(f(),_(S,{key:0,justify:"center"},{default:e(()=>[t(W,{modelValue:V.value,"onUpdate:modelValue":l[3]||(l[3]=u=>V.value=u),transition:"dialog-bottom-transition",fullscreen:""},{default:e(()=>[t(y,{loading:b.value},{default:e(()=>[t(H,{color:"primary",rounded:""},{default:e(()=>[t(q,{icon:"mdi-close",onClick:l[0]||(l[0]=u=>V.value=!1)}),t(j,{modelValue:x.value,"onUpdate:modelValue":l[1]||(l[1]=u=>x.value=u)},{default:e(()=>[t(F,{value:"loan"},{default:e(()=>l[5]||(l[5]=[a("Loan")])),_:1}),t(F,{value:"history"},{default:e(()=>l[6]||(l[6]=[a("Comment&History")])),_:1})]),_:1},8,["modelValue"])]),_:1}),t(D,null,{default:e(()=>[t(Q,{modelValue:x.value,"onUpdate:modelValue":l[2]||(l[2]=u=>x.value=u)},{default:e(()=>[t(B,{value:"loan"},{default:e(()=>[n.value?(f(),_(O,{key:0},{default:e(()=>[t(S,null,{default:e(()=>[t(c,{cols:"12"},{default:e(()=>[t(y,{class:"mb-4"},{default:e(()=>[t(T,null,{default:e(()=>[m("div",oe,[m("div",null,[t(k,{class:"text-h5"},{default:e(()=>[a(" Loan Reference: "+o(n.value.reference),1)]),_:1}),t(M,{color:U(n.value.status),class:"mt-2"},{default:e(()=>[a(o(n.value.status),1)]),_:1},8,["color"])]),m("div",ue,[m("div",de,"Amount: "+o(p.$formatKES(n.value.amount)),1),m("div",re,"Interest: "+o(p.$formatKES(n.value.interest)),1),m("div",se,"Balance: "+o(p.$formatKES(n.value.balance)),1)])])]),_:1})]),_:1})]),_:1})]),_:1}),t(S,null,{default:e(()=>[t(c,{cols:"12",md:"6"},{default:e(()=>[t(y,{variant:"tonal",color:"primary"},{default:e(()=>[t(k,null,{default:e(()=>l[7]||(l[7]=[a("Client Information")])),_:1}),t(D,null,{default:e(()=>[t(C,{color:"primary"},{default:e(()=>[t(i,{color:"primary",rounded:"shaped",value:"name"},{prepend:e(()=>[t(r,null,{default:e(()=>l[8]||(l[8]=[a("mdi-account-multiple")])),_:1})]),append:e(()=>{var u;return[a(o((u=n.value.client)==null?void 0:u.name),1)]}),default:e(()=>[t(s,null,{default:e(()=>l[9]||(l[9]=[a("Client Name")])),_:1})]),_:1}),t(i,{color:"primary",rounded:"shaped",value:"id"},{prepend:e(()=>[t(r,null,{default:e(()=>l[10]||(l[10]=[a("mdi-card-account-details")])),_:1})]),append:e(()=>[a(o(n.value.id_no),1)]),default:e(()=>[t(s,null,{default:e(()=>l[11]||(l[11]=[a("ID Number")])),_:1})]),_:1}),t(i,{color:"primary",rounded:"shaped",value:"branch"},{prepend:e(()=>[t(r,null,{default:e(()=>l[12]||(l[12]=[a("mdi-source-branch-check")])),_:1})]),append:e(()=>{var u;return[a(o((u=n.value.branch)==null?void 0:u.name),1)]}),default:e(()=>[t(s,null,{default:e(()=>l[13]||(l[13]=[a("Branch")])),_:1})]),_:1}),t(i,{color:"primary",rounded:"shaped",value:"loan_officer"},{prepend:e(()=>[t(r,null,{default:e(()=>l[14]||(l[14]=[a("mdi-account-arrow-right")])),_:1})]),append:e(()=>{var u;return[a(o((u=n.value.officer)==null?void 0:u.name),1)]}),default:e(()=>[t(s,null,{default:e(()=>l[15]||(l[15]=[a("Loan Officer")])),_:1})]),_:1})]),_:1})]),_:1})]),_:1})]),_:1}),t(c,{cols:"12",md:"6"},{default:e(()=>[t(y,{variant:"tonal",color:"primary"},{default:e(()=>[t(k,null,{default:e(()=>l[16]||(l[16]=[a("Payment Information")])),_:1}),t(D,null,{default:e(()=>[t(C,{color:"primary"},{default:e(()=>[t(i,{color:"primary",rounded:"shaped",value:"interest_rate"},{prepend:e(()=>[t(r,null,{default:e(()=>l[17]||(l[17]=[a("mdi-hand-coin")])),_:1})]),append:e(()=>[a(o(n.value.installments),1)]),default:e(()=>[t(s,null,{default:e(()=>l[18]||(l[18]=[a("Installments")])),_:1})]),_:1}),t(i,{color:"primary",rounded:"shaped",value:"name"},{prepend:e(()=>[t(r,null,{default:e(()=>l[19]||(l[19]=[a("mdi-cash-fast")])),_:1})]),append:e(()=>[a(o(p.$formatKES(n.value.payment_per_installment)),1)]),default:e(()=>[t(s,null,{default:e(()=>l[20]||(l[20]=[a("Payment Per Month")])),_:1})]),_:1}),t(i,{color:"primary",rounded:"shaped",value:"interest_type"},{prepend:e(()=>[t(r,null,{default:e(()=>l[21]||(l[21]=[a("mdi-power-socket-us")])),_:1})]),append:e(()=>[a(o(p.$formatKES(n.value.processing_fee)),1)]),default:e(()=>[t(s,null,{default:e(()=>l[22]||(l[22]=[a("Processing Fee")])),_:1})]),_:1}),t(i,{color:"primary",rounded:"shaped",value:"frequency"},{prepend:e(()=>[t(r,null,{default:e(()=>l[23]||(l[23]=[a("mdi-clock-remove")])),_:1})]),append:e(()=>[a(o(w(n.value.due_date)),1)]),default:e(()=>[t(s,null,{default:e(()=>l[24]||(l[24]=[a("Due Date")])),_:1})]),_:1})]),_:1})]),_:1})]),_:1})]),_:1}),t(c,{cols:"12",md:"6"},{default:e(()=>[t(y,{variant:"tonal",color:"primary"},{default:e(()=>[t(k,null,{default:e(()=>l[25]||(l[25]=[a("Loan Details")])),_:1}),t(D,null,{default:e(()=>[t(C,{color:"primary"},{default:e(()=>[t(i,{color:"primary",rounded:"shaped",value:"loading"},{prepend:e(()=>[t(r,null,{default:e(()=>l[26]||(l[26]=[a("mdi-feature-search")])),_:1})]),append:e(()=>[a(o(n.value.processing_fee_status),1)]),default:e(()=>[t(s,null,{default:e(()=>l[27]||(l[27]=[a("Processing Fee")])),_:1})]),_:1}),t(i,{color:"primary",rounded:"shaped",value:"balance"},{prepend:e(()=>[t(r,null,{default:e(()=>l[28]||(l[28]=[a("mdi-wallet")])),_:1})]),append:e(()=>[a(o(p.$formatKES(n.value.balance)),1)]),default:e(()=>[t(s,null,{default:e(()=>l[29]||(l[29]=[a("Balance")])),_:1})]),_:1}),t(i,{color:"primary",rounded:"shaped",value:"loantype"},{prepend:e(()=>[t(r,null,{default:e(()=>l[30]||(l[30]=[a("mdi-help-box")])),_:1})]),append:e(()=>{var u;return[a(o((u=n.value.loantype)==null?void 0:u.name),1)]}),default:e(()=>[t(s,null,{default:e(()=>l[31]||(l[31]=[a("Loan Type")])),_:1})]),_:1}),t(i,{color:"primary",rounded:"shaped",value:"interest_rate"},{prepend:e(()=>[t(r,null,{default:e(()=>l[32]||(l[32]=[a("mdi-percent-box")])),_:1})]),append:e(()=>[a(o(n.value.interest_rate),1)]),default:e(()=>[t(s,null,{default:e(()=>l[33]||(l[33]=[a("Interest Rate")])),_:1})]),_:1}),t(i,{color:"primary",rounded:"shaped",value:"frequency"},{prepend:e(()=>[t(r,null,{default:e(()=>l[34]||(l[34]=[a("mdi-sine-wave")])),_:1})]),append:e(()=>[a(o(n.value.frequency),1)]),default:e(()=>[t(s,null,{default:e(()=>l[35]||(l[35]=[a("Frequency")])),_:1})]),_:1})]),_:1})]),_:1})]),_:1})]),_:1}),t(c,{cols:"12",md:"6"},{default:e(()=>[t(y,{variant:"tonal",color:"primary"},{default:e(()=>[t(k,null,{default:e(()=>l[36]||(l[36]=[a("Important Dates")])),_:1}),t(D,null,{default:e(()=>[t(C,{color:"primary"},{default:e(()=>[t(i,{color:"primary",rounded:"shaped",value:"application_date"},{prepend:e(()=>[t(r,null,{default:e(()=>l[37]||(l[37]=[a("mdi-calendar-today")])),_:1})]),append:e(()=>[a(o(w(n.value.application_date)),1)]),default:e(()=>[t(s,null,{default:e(()=>l[38]||(l[38]=[a("Application Date")])),_:1})]),_:1}),t(i,{color:"primary",rounded:"shaped",value:"approved_at"},{prepend:e(()=>[t(r,null,{default:e(()=>l[39]||(l[39]=[a("mdi-calendar-check")])),_:1})]),append:e(()=>[a(o(w(n.value.approved_at)),1)]),default:e(()=>[t(s,null,{default:e(()=>l[40]||(l[40]=[a("Approval Date")])),_:1})]),_:1}),t(i,{color:"primary",rounded:"shaped",value:"interest_rate"},{prepend:e(()=>[t(r,null,{default:e(()=>l[41]||(l[41]=[a("mdi-send-check")])),_:1})]),append:e(()=>[a(o(w(n.value.disbursed_at)),1)]),default:e(()=>[t(s,null,{default:e(()=>l[42]||(l[42]=[a("Disbursed At")])),_:1})]),_:1}),t(i,{color:"primary",rounded:"shaped",value:"last_payment"},{prepend:e(()=>[t(r,null,{default:e(()=>l[43]||(l[43]=[a("mdi-calendar-account")])),_:1})]),append:e(()=>[a(o(w(n.value.last_payment)),1)]),default:e(()=>[t(s,null,{default:e(()=>l[44]||(l[44]=[a("Last Payment")])),_:1})]),_:1}),t(i,{color:"primary",rounded:"shaped",value:"maturity_date"},{prepend:e(()=>[t(r,null,{default:e(()=>l[45]||(l[45]=[a("mdi-calendar-clock")])),_:1})]),append:e(()=>[a(o(w(n.value.maturity_date)),1)]),default:e(()=>[t(s,null,{default:e(()=>l[46]||(l[46]=[a("Maturity Date")])),_:1})]),_:1})]),_:1})]),_:1})]),_:1})]),_:1})]),_:1}),n.value.status!=="Rejected"&&n.value.status!=="Pending"&&n.value.status!=="Approved"?(f(),_(S,{key:0},{default:e(()=>[b.value?g("",!0):(f(),_(c,{key:0,cols:"12",md:"6"},{default:e(()=>[t(te,{statement:A.value,loan:n.value},null,8,["statement","loan"])]),_:1})),b.value?g("",!0):(f(),_(c,{key:1,cols:"12",md:"6"},{default:e(()=>[n.value.payments.length>0?(f(),_(ae,{key:0,payments:n.value.payments,loan:n.value},null,8,["payments","loan"])):g("",!0),l[47]||(l[47]=m("br",null,null,-1)),t(z),l[48]||(l[48]=m("br",null,null,-1)),n.value.penalties.length>0?(f(),_(ne,{key:1,penalties:n.value.penalties,loan:n.value},null,8,["penalties","loan"])):g("",!0)]),_:1}))]),_:1})):g("",!0)]),_:1})):g("",!0)]),_:1}),t(B,{value:"history"},{default:e(()=>[t(y,{width:"700",style:{margin:"auto"},color:"primary",variant:"tonal"},{default:e(()=>[t(k,null,{default:e(()=>l[49]||(l[49]=[a("Loan History")])),_:1}),t(D,null,{default:e(()=>[(f(!0),Z(ee,null,h(n.value.history,u=>(f(),_(J,{align:"start",side:"end",density:"compact"},{default:e(()=>[t(G,{"dot-color":u.color,size:"small"},{default:e(()=>[m("div",ie,[m("strong",pe,o(u.created_at),1),m("div",null,[m("strong",null,o(u.action_type),1),m("div",me,o(u.description),1)])])]),_:2},1032,["dot-color"])]),_:2},1024))),256))]),_:1})]),_:1})]),_:1})]),_:1},8,["modelValue"])]),_:1})]),_:1},8,["loading"])]),_:1},8,["modelValue"]),t(X,{modelValue:L.value,"onUpdate:modelValue":l[4]||(l[4]=u=>L.value=u),color:$.value},{default:e(()=>[a(o(P.value),1)]),_:1},8,["modelValue","color"])]),_:1})):g("",!0)}}};export{ge as default};
