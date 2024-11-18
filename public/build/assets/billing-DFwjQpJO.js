import{_ as P}from"./_plugin-vue_export-helper-DlAUqK2U.js";import{r as i,i as a,o as D,d as E,a as o,b as e,w as l,f as d,t as R,y as k}from"./app-CgSA-0rK.js";const H={__name:"billing",setup(I){i("billings");const c=i("Mayad Ahmed"),v=i("02 / 2028"),b=i("8269 9620 9292 2538"),f=i(""),g=i("existing"),w=[{title:"Invoice",align:"start",key:"invoice"},{title:"Date",key:"date"},{title:"Amount",key:"amount"},{title:"Status",key:"status"},{title:"Tracking & Address",key:"tracking"},{title:"Actions",key:"actions",sortable:!1}],C=[{invoice:"Account Sale",date:"Apr 14, 2004",amount:"$3,050",status:"Pending",tracking:"LM580405575CN 313 Kent Road, Sunderland"},{invoice:"Account Sale",date:"Jun 24, 2008",amount:"$1,050",status:"Cancelled",tracking:"AZ938540353US 99 Grange Road, Peterborough"},{invoice:"Netflix Subscription",date:"Feb 28, 2004",amount:"$800",status:"Refund",tracking:"3S331605904US 2 New Street, Harrogate"}],A=_=>{switch(_){case"Pending":return"warning";case"Cancelled":return"error";case"Refund":return"success";default:return"grey"}};return(_,t)=>{const y=a("v-divider"),r=a("v-btn"),s=a("v-col"),u=a("v-text-field"),m=a("v-row"),x=a("v-radio"),N=a("v-radio-group"),U=a("v-chip"),V=a("v-icon"),S=a("v-tooltip"),B=a("v-data-table");return D(),E("div",null,[t[14]||(t[14]=o("h2",{class:"text-h6 mb-2"},"Payment Method",-1)),t[15]||(t[15]=o("p",{class:"text-caption mb-4"},"Update your billing details and address.",-1)),e(y),t[16]||(t[16]=o("br",null,null,-1)),e(m,null,{default:l(()=>[e(s,{cols:"12",sm:"3"},{default:l(()=>[t[6]||(t[6]=o("h3",{class:"text-subtitle-1 mb-2"},"Card Details",-1)),t[7]||(t[7]=o("p",{class:"text-caption mb-4"},"Update your billing details and address.",-1)),e(r,{"prepend-icon":"mdi-plus-circle",variant:"tonal"},{default:l(()=>t[5]||(t[5]=[d(" Add another card ")])),_:1})]),_:1}),e(s,{cols:"12",sm:"8"},{default:l(()=>[e(m,null,{default:l(()=>[e(s,{cols:"12",sm:"6"},{default:l(()=>[e(u,{density:"compact",variant:"outlined",label:"Card Number",modelValue:b.value,"onUpdate:modelValue":t[0]||(t[0]=n=>b.value=n),outlined:"",dense:"","prepend-inner-icon":"mdi-credit-card"},null,8,["modelValue"])]),_:1}),e(s,{cols:"12",sm:"6"},{default:l(()=>[e(u,{density:"compact",variant:"outlined",label:"CVV",modelValue:f.value,"onUpdate:modelValue":t[1]||(t[1]=n=>f.value=n),outlined:"",dense:"",type:"password"},null,8,["modelValue"])]),_:1}),e(s,{cols:"12",sm:"6"},{default:l(()=>[e(u,{density:"compact",variant:"outlined",label:"Name on your Card",modelValue:c.value,"onUpdate:modelValue":t[2]||(t[2]=n=>c.value=n),outlined:"",dense:""},null,8,["modelValue"])]),_:1}),e(s,{cols:"12",sm:"6"},{default:l(()=>[e(u,{density:"compact",variant:"outlined",label:"Expiry",modelValue:v.value,"onUpdate:modelValue":t[3]||(t[3]=n=>v.value=n),outlined:"",dense:""},null,8,["modelValue"])]),_:1})]),_:1})]),_:1})]),_:1}),e(y),t[17]||(t[17]=o("br",null,null,-1)),e(m,null,{default:l(()=>[e(s,{cols:"12",sm:"3"},{default:l(()=>t[8]||(t[8]=[o("h3",{class:"text-subtitle-1 mb-2"},"Contact email",-1),o("p",{class:"text-caption mb-4"},"Where should invoices be sent?",-1)])),_:1}),e(s,{cols:"12",sm:"3"},{default:l(()=>[e(N,{modelValue:g.value,"onUpdate:modelValue":t[4]||(t[4]=n=>g.value=n)},{default:l(()=>[e(x,{label:"Send to the existing email",value:"existing"},{label:l(()=>t[9]||(t[9]=[o("div",null,[d(" Send to the existing email "),o("div",{class:"text-caption text-grey"},"mayad.ahmed@infobase.co")],-1)])),_:1}),e(x,{label:"Add another email address",value:"new"})]),_:1},8,["modelValue"])]),_:1})]),_:1}),t[18]||(t[18]=o("h3",{class:"text-subtitle-1 mt-6 mb-2"},"Billing History",-1)),t[19]||(t[19]=o("p",{class:"text-caption mb-4"},"See the transactions you made",-1)),e(B,{headers:w,items:C,"items-per-page":5,class:"elevation-1"},{"item.status":l(({item:n})=>[e(U,{color:A(n.status),"text-color":"white",small:""},{default:l(()=>[d(R(n.status),1)]),_:2},1032,["color"])]),"item.actions":l(({item:n})=>[e(S,{location:"bottom"},{activator:l(({props:p})=>[e(r,k({icon:""},p),{default:l(()=>[e(V,{color:"primary"},{default:l(()=>t[10]||(t[10]=[d(" mdi-eye ")])),_:1})]),_:2},1040)]),default:l(()=>[t[11]||(t[11]=o("span",null,"View",-1))]),_:1}),e(S,{location:"bottom"},{activator:l(({props:p})=>[e(r,k({icon:""},p),{default:l(()=>[e(V,{color:"secondary"},{default:l(()=>t[12]||(t[12]=[d(" mdi-file-pdf-box ")])),_:1})]),_:2},1040)]),default:l(()=>[t[13]||(t[13]=o("span",null,"Download Invoice",-1))]),_:1})]),_:1})])}}},T=P(H,[["__scopeId","data-v-19aa1280"]]);export{T as default};