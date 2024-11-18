import{r as T,T as w,o as y,c as g,w as t,f as a,a as n,b as o,n as v,u as r}from"./app-CgSA-0rK.js";import{_ as x}from"./Modal-uw4jCYmI.js";import{_ as C}from"./ConfirmationModal-BNCJWOnO.js";import{_ as i}from"./DangerButton-DpZJMfLp.js";import{_ as D}from"./SecondaryButton-C7BkSztv.js";import"./SectionTitle-B7GZpMyC.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const b={class:"mt-5"},j={__name:"DeleteTeamForm",props:{team:Object},setup(m){const d=m,s=T(!1),l=w({}),f=()=>{s.value=!0},u=()=>{l.delete(route("teams.destroy",d.team),{errorBag:"deleteTeam"})};return($,e)=>(y(),g(x,null,{title:t(()=>e[2]||(e[2]=[a(" Delete Team ")])),description:t(()=>e[3]||(e[3]=[a(" Permanently delete this team. ")])),content:t(()=>[e[9]||(e[9]=n("div",{class:"max-w-xl text-sm text-gray-600"}," Once a team is deleted, all of its resources and data will be permanently deleted. Before deleting this team, please download any data or information regarding this team that you wish to retain. ",-1)),n("div",b,[o(i,{onClick:f},{default:t(()=>e[4]||(e[4]=[a(" Delete Team ")])),_:1})]),o(C,{show:s.value,onClose:e[1]||(e[1]=p=>s.value=!1)},{title:t(()=>e[5]||(e[5]=[a(" Delete Team ")])),content:t(()=>e[6]||(e[6]=[a(" Are you sure you want to delete this team? Once a team is deleted, all of its resources and data will be permanently deleted. ")])),footer:t(()=>[o(D,{onClick:e[0]||(e[0]=p=>s.value=!1)},{default:t(()=>e[7]||(e[7]=[a(" Cancel ")])),_:1}),o(i,{class:v(["ml-3",{"opacity-25":r(l).processing}]),disabled:r(l).processing,onClick:u},{default:t(()=>e[8]||(e[8]=[a(" Delete Team ")])),_:1},8,["class","disabled"])]),_:1},8,["show"])]),_:1}))}};export{j as default};