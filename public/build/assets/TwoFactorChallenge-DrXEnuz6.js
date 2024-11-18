import{r as d,T as I,i as a,o as r,d as u,b as n,w as l,h as k,f as c,c as g,u as t,a as x,t as b,F as w,k as T}from"./app-C40yS1Zs.js";const B={class:"mt-2",style:{color:"red"}},U={class:"mt-2",style:{color:"red"}},z={__name:"TwoFactorChallenge",setup(F){const s=d(!1),e=I({code:"",recovery_code:""}),p=d(null),m=d(null);d(!1);const V=async()=>{s.value^=!0,await T(),s.value?(p.value.focus(),e.code=""):(m.value.focus(),e.recovery_code="")},f=()=>{e.post(route("two-factor.login"))};return(N,o)=>{const h=a("v-card-title"),v=a("v-card-text"),_=a("v-text-field"),y=a("v-btn"),C=a("v-card");return r(),u("form",{onSubmit:k(f,["prevent"])},[n(C,{class:"mx-auto",elevation:"1","max-width":"500"},{default:l(()=>[n(h,{class:"py-5 font-weight-black"},{default:l(()=>o[2]||(o[2]=[c("Securely access your tax form")])),_:1}),n(v,null,{default:l(()=>o[3]||(o[3]=[c(" To continue, enter a code sent to your phone or use the Google Authenticator app. If you can't access this, use the recovery code. ")])),_:1}),n(v,null,{default:l(()=>[s.value?(r(),g(_,{key:1,id:"recovery_code",ref_key:"recoveryCodeInput",ref:p,modelValue:t(e).recovery_code,"onUpdate:modelValue":o[1]||(o[1]=i=>t(e).recovery_code=i),variant:"outlined",type:"text",class:"mt-1 block w-full",autocomplete:"one-time-code",placeholder:"Recovery","prepend-inner-icon":"mdi-refresh"},null,8,["modelValue"])):(r(),g(_,{key:0,id:"code",label:"Enter code",ref_key:"codeInput",ref:m,"single-line":"",modelValue:t(e).code,"onUpdate:modelValue":o[0]||(o[0]=i=>t(e).code=i),type:"text",inputmode:"numeric",variant:"outlined",class:"mt-1 block w-full",autofocus:"",autocomplete:"one-time-code",density:"compact",placeholder:"Code","prepend-inner-icon":"mdi-lock-clock"},null,8,["modelValue"])),x("p",B,b(t(e).errors.password),1),x("p",U,b(t(e).errors.code),1),n(y,{disabled:t(e).processing,loading:t(e).processing,block:"",class:"text-none mb-4",color:"indigo-darken-3",size:"x-large",variant:"flat",onClick:f},{default:l(()=>o[4]||(o[4]=[c(" Verify and continue ")])),_:1},8,["disabled","loading"]),n(y,{block:"",class:"text-none",color:"grey-lighten-3",size:"x-large",variant:"flat",onClick:k(V,["prevent"])},{default:l(()=>[s.value?(r(),u(w,{key:1},[c(" Use an authentication code ")],64)):(r(),u(w,{key:0},[c(" Use a recovery code ")],64))]),_:1})]),_:1})]),_:1})],32)}}};export{z as default};