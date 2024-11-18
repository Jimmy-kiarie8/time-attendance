import{r,D as G,i as o,o as H,c as I,w as a,b as l,f as n,t as w,V as D}from"./app-C40yS1Zs.js";const M={__name:"loan-editor",props:{},emits:["refresh"],setup(J,{expose:F,emit:T}){const B=T,c=r(!1),_=r(!1),g=r("Updated"),x=r("black"),i=r(!1),f=r(!1),m=G({...{}}),d=r({}),k=r([]),V=r([]),t=r("");function N(){f.value=!0}async function j(){try{const u=t.value==="officer"?"users":"branches";if(t.value==="branch"&&V.value.length>0)return;if(t.value==="officer"&&k.value.length>0)return;i.value=!0;const e=await D.get(`${u}?axios=true`);i.value=!1,t.value==="officer"?k.value=e.data.data:V.value=e.data.data}catch(u){i.value=!1,console.error("Failed to fetch data:",u)}}function A(){f.value=!1,i.value=!0,setTimeout(()=>{i.value=!1},4e3);const u=t.value==="branch"?{branch_id:m.id,loan_id:d.value.id,branch_name:d.value.branch.name}:{officer_id:m.id,loan_id:d.value.id,officer_name:d.value.officer.name},e=t.value==="officer"?"loan-officer":"loan-branche";D.post(`/${e}/${d.value.client_id}`,u).then(v=>{_.value=!0,x.value="success",g.value="Created",B("refresh",!1),c.value=!1}).catch(v=>{console.log(v),_.value=!0,x.value="error",g.value="Something went wrong!"})}function E(u,e){console.log(t),c.value=!0,d.value=u,m.id=e=="officer"?u.officer_id:u.branch_id,t.value=e,j()}function O(){c.value=!1}return F({show:E}),(u,e)=>{const v=o("v-divider"),C=o("v-card-title"),W=o("v-select"),y=o("v-card-text"),p=o("v-icon"),b=o("v-btn"),S=o("v-spacer"),U=o("v-card-actions"),$=o("v-card"),h=o("v-dialog"),q=o("v-snackbar"),z=o("v-row");return H(),I(z,{justify:"center"},{default:a(()=>[l(h,{persistent:"",modelValue:c.value,"onUpdate:modelValue":e[1]||(e[1]=s=>c.value=s),width:"400"},{default:a(()=>[l(v),l($,{loading:i.value},{default:a(()=>[l(C,{class:"text-h5"},{default:a(()=>[n(" Edit "+w(t.value),1)]),_:1}),l(y,null,{default:a(()=>[l(W,{chips:"",label:t.value,modelValue:m.id,"onUpdate:modelValue":e[0]||(e[0]=s=>m.id=s),items:t.value==="officer"?k.value:V.value,"item-title":"name","item-value":"id",variant:"outlined"},null,8,["label","modelValue","items"])]),_:1}),l(U,null,{default:a(()=>[l(b,{variant:"outlined",color:"red",onClick:O},{default:a(()=>[l(p,null,{default:a(()=>e[5]||(e[5]=[n("mdi-checkbox-marked")])),_:1}),e[6]||(e[6]=n(" Close "))]),_:1}),l(S),l(b,{variant:"outlined",color:"primary",onClick:N,loading:i.value},{default:a(()=>[l(p,null,{default:a(()=>e[7]||(e[7]=[n("mdi-plus-circle")])),_:1}),e[8]||(e[8]=n(" Submit "))]),_:1},8,["loading"])]),_:1})]),_:1},8,["loading"])]),_:1},8,["modelValue"]),l(q,{modelValue:_.value,"onUpdate:modelValue":e[2]||(e[2]=s=>_.value=s),color:x.value},{default:a(()=>[n(w(g.value),1)]),_:1},8,["modelValue","color"]),l(h,{modelValue:f.value,"onUpdate:modelValue":e[4]||(e[4]=s=>f.value=s),"max-width":"400px"},{default:a(()=>[l($,null,{default:a(()=>[l(C,{class:"text-h5"},{default:a(()=>e[9]||(e[9]=[n("Warning!")])),_:1}),l(v),l(y,null,{default:a(()=>[n(" This will also update the borrower "+w(t.value)+"! ",1)]),_:1}),l(v),l(U,null,{default:a(()=>[l(b,{color:"red-darken-1",variant:"tonal",onClick:e[3]||(e[3]=s=>f.value=!1)},{default:a(()=>[l(p,null,{default:a(()=>e[10]||(e[10]=[n("mdi-close-box")])),_:1}),e[11]||(e[11]=n("Cancel "))]),_:1}),l(S),l(b,{color:"primary",variant:"tonal",onClick:A},{default:a(()=>[l(p,null,{default:a(()=>e[12]||(e[12]=[n("mdi-checkbox-marked")])),_:1}),e[13]||(e[13]=n("Contine "))]),_:1})]),_:1})]),_:1})]),_:1},8,["modelValue"])]),_:1})}}};export{M as default};
