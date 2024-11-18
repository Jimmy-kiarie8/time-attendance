import{T as _,r as b,i as n,o as y,d as k,a,b as t,w as r,h as V,u as s,t as v,f as i,j as h}from"./app-C40yS1Zs.js";const B={class:"mt-2",style:{color:"red"}},C={class:"mt-2",style:{color:"red"}},E={__name:"Login",props:{canResetPassword:Boolean,status:String},setup(S){const o=_({email:"",password:"",remember:!1}),d=b(!1),m=()=>{o.transform(p=>({...p,remember:o.remember?"on":""})).post(route("login"),{onFinish:()=>o.reset("password")})};return(p,e)=>{const g=n("v-img"),u=n("v-text-field"),c=n("v-card-text"),f=n("v-card"),x=n("v-btn"),w=n("v-icon");return y(),k("form",{onSubmit:V(m,["prevent"])},[a("div",null,[t(g,{class:"mx-auto my-6","max-width":"228",src:"/images/logo.jpeg"}),t(f,{class:"mx-auto pa-12 pb-8",elevation:"8","max-width":"448",rounded:"lg"},{default:r(()=>[e[6]||(e[6]=a("div",{class:"text-subtitle-1 text-medium-emphasis"},"Account",-1)),t(u,{modelValue:s(o).email,"onUpdate:modelValue":e[0]||(e[0]=l=>s(o).email=l),autocomplete:"email",density:"compact",placeholder:"Email address","prepend-inner-icon":"mdi-email-outline",variant:"outlined"},null,8,["modelValue"]),a("p",B,v(s(o).errors.email),1),e[7]||(e[7]=a("div",{class:"text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between"},[i(" Password "),a("a",{class:"text-caption text-decoration-none text-blue",href:"#",rel:"noopener noreferrer",target:"_blank"}," Forgot login password?")],-1)),t(u,{density:"compact",type:"password",autocomplete:"password",modelValue:s(o).password,"onUpdate:modelValue":e[1]||(e[1]=l=>s(o).password=l),placeholder:"Enter your password","prepend-inner-icon":"mdi-lock-outline",variant:"outlined","onClick:appendInner":e[2]||(e[2]=l=>d.value=!d.value)},null,8,["modelValue"]),a("p",C,v(s(o).errors.password),1),t(f,{class:"mb-12",color:"surface-variant",variant:"tonal"},{default:r(()=>[t(c,{class:"text-medium-emphasis text-caption"},{default:r(()=>e[3]||(e[3]=[i(' Warning: After 3 consecutive failed login attempts, you account will be temporarily locked for three hours. If you must login now, you can also click "Forgot login password?" below to reset the login password. ')])),_:1})]),_:1}),t(x,{block:"",class:"mb-8",color:"blue",size:"large",variant:"tonal",onClick:m,loading:s(o).processing},{default:r(()=>e[4]||(e[4]=[i(" Log In ")])),_:1},8,["loading"]),t(c,{class:"text-center"},{default:r(()=>[t(s(h),{href:"/register",class:"text-blue text-decoration-none"},{default:r(()=>[e[5]||(e[5]=i(" Sign up now ")),t(w,{icon:"mdi-chevron-right"})]),_:1})]),_:1})]),_:1})])],32)}}};export{E as default};
