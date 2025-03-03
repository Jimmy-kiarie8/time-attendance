import{r as m,T as w,o as y,c as _,w as o,f as t,a as i,b as r,u as l,X as v,n as k}from"./app-DCy3SzMC.js";import{_ as x}from"./Modal-BY0SV6WQ.js";import{_ as c}from"./DangerButton-CQFHyESe.js";import{_ as g}from"./DialogModal-DnraNMNM.js";import{_ as C}from"./InputError-BkFzCHyq.js";import{_ as D}from"./SecondaryButton-Bcq3Kzz_.js";import{_ as b}from"./TextInput-ClrlX9fq.js";import"./SectionTitle-xjosiPCt.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const V={class:"mt-5"},$={class:"mt-4"},z={__name:"DeleteUserForm",setup(A){const a=m(!1),n=m(null),s=w({password:""}),p=()=>{a.value=!0,setTimeout(()=>n.value.focus(),250)},d=()=>{s.delete(route("current-user.destroy"),{preserveScroll:!0,onSuccess:()=>u(),onError:()=>n.value.focus(),onFinish:()=>s.reset()})},u=()=>{a.value=!1,s.reset()};return(U,e)=>(y(),_(x,null,{title:o(()=>e[1]||(e[1]=[t(" Delete Account ")])),description:o(()=>e[2]||(e[2]=[t(" Permanently delete your account. ")])),content:o(()=>[e[8]||(e[8]=i("div",{class:"max-w-xl text-sm text-gray-600"}," Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain. ",-1)),i("div",V,[r(c,{onClick:p},{default:o(()=>e[3]||(e[3]=[t(" Delete Account ")])),_:1})]),r(g,{show:a.value,onClose:u},{title:o(()=>e[4]||(e[4]=[t(" Delete Account ")])),content:o(()=>[e[5]||(e[5]=t(" Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account. ")),i("div",$,[r(b,{ref_key:"passwordInput",ref:n,modelValue:l(s).password,"onUpdate:modelValue":e[0]||(e[0]=f=>l(s).password=f),type:"password",class:"mt-1 block w-3/4",placeholder:"Password",autocomplete:"current-password",onKeyup:v(d,["enter"])},null,8,["modelValue"]),r(C,{message:l(s).errors.password,class:"mt-2"},null,8,["message"])])]),footer:o(()=>[r(D,{onClick:u},{default:o(()=>e[6]||(e[6]=[t(" Cancel ")])),_:1}),r(c,{class:k(["ml-3",{"opacity-25":l(s).processing}]),disabled:l(s).processing,onClick:d},{default:o(()=>e[7]||(e[7]=[t(" Delete Account ")])),_:1},8,["class","disabled"])]),_:1},8,["show"])]),_:1}))}};export{z as default};
