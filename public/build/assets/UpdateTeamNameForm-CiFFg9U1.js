import{T as u,o as p,c as _,$ as v,w as m,b as o,f as r,u as n,n as g,a as t,t as l}from"./app-CgSA-0rK.js";import{_ as T}from"./ActionMessage-oQ3P0RKJ.js";import{_ as b}from"./FormSection-BESqo1_1.js";import{_ as w}from"./InputError-BRY1IGpQ.js";import{_ as d}from"./InputLabel-BIu7Pwh0.js";import{_ as x}from"./PrimaryButton-B7gQScCG.js";import{_ as N}from"./TextInput--dm0Igjd.js";import"./SectionTitle-B7GZpMyC.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const y={class:"col-span-6"},S={class:"flex items-center mt-2"},$=["src","alt"],V={class:"ml-4 leading-tight"},k={class:"text-gray-900"},B={class:"text-gray-700 text-sm"},U={class:"col-span-6 sm:col-span-4"},G={__name:"UpdateTeamNameForm",props:{team:Object,permissions:Object},setup(a){const i=a,s=u({name:i.team.name}),c=()=>{s.put(route("teams.update",i.team),{errorBag:"updateTeamName",preserveScroll:!0})};return(h,e)=>(p(),_(b,{onSubmitted:c},v({title:m(()=>[e[1]||(e[1]=r(" Team Name "))]),description:m(()=>[e[2]||(e[2]=r(" The team's name and owner information. "))]),form:m(()=>[t("div",y,[o(d,{value:"Team Owner"}),t("div",S,[t("img",{class:"w-12 h-12 rounded-full object-cover",src:a.team.owner.profile_photo_url,alt:a.team.owner.name},null,8,$),t("div",V,[t("div",k,l(a.team.owner.name),1),t("div",B,l(a.team.owner.email),1)])])]),t("div",U,[o(d,{for:"name",value:"Team Name"}),o(N,{id:"name",modelValue:n(s).name,"onUpdate:modelValue":e[0]||(e[0]=f=>n(s).name=f),type:"text",class:"mt-1 block w-full",disabled:!a.permissions.canUpdateTeam},null,8,["modelValue","disabled"]),o(w,{message:n(s).errors.name,class:"mt-2"},null,8,["message"])])]),_:2},[a.permissions.canUpdateTeam?{name:"actions",fn:m(()=>[o(T,{on:n(s).recentlySuccessful,class:"mr-3"},{default:m(()=>e[3]||(e[3]=[r(" Saved. ")])),_:1},8,["on"]),o(x,{class:g({"opacity-25":n(s).processing}),disabled:n(s).processing},{default:m(()=>e[4]||(e[4]=[r(" Save ")])),_:1},8,["class","disabled"])]),key:"0"}:void 0]),1024))}};export{G as default};
