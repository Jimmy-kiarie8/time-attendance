import{_ as f}from"./MainLayout-DCj_4SV5.js";import g from"./billing-Du_tVOgU.js";import x from"./appearance-BvUcHf8b.js";import b from"./account-DCI24vGw.js";import w from"./organization-C2GsbFuY.js";import y from"./settings-C2n15FoJ.js";import V from"./integrations-ChvGuj9I.js";import{_ as h}from"./_plugin-vue_export-helper-DlAUqK2U.js";import{R as B,i as o,o as D,c as O,w as t,b as e,a as m}from"./app-C40yS1Zs.js";const S={__name:"index",props:{formData:Object,email:Object,sms:Object},setup(s){const l=B("settings"),r=[{icon:"mdi-account-circle",text:"Profile",value:"profile"},{icon:"mdi-domain",text:"Organization",value:"organization"},{icon:"mdi-shield-account",text:"Security",value:"security"},{icon:"mdi-eye-arrow-left",text:"Appearance",value:"appearance"},{icon:"mdi-card-account-details",text:"Billings",value:"billings"},{icon:"mdi-handshake-outline",text:"Plan",value:"plan"},{icon:"mdi-cog",text:"System Settings",value:"settings"},{icon:"mdi-math-integral-box",text:"Integrations",value:"integrations"}];return(z,a)=>{const c=o("v-tab"),u=o("v-tabs"),d=o("v-sheet"),i=o("v-window-item"),v=o("v-window"),_=o("v-container"),p=o("v-card");return D(),O(f,{title:"Dashboard"},{default:t(()=>[e(p,null,{default:t(()=>[e(_,{class:"billing-settings"},{default:t(()=>[a[2]||(a[2]=m("h1",{class:"text-h4 mb-2"},"Settings",-1)),a[3]||(a[3]=m("p",{class:"text-subtitle-1 mb-6"},"Manage your account settings and preferences.",-1)),e(d,{elevation:"3",rounded:"lg"},{default:t(()=>[e(u,{modelValue:l.value,"onUpdate:modelValue":a[0]||(a[0]=n=>l.value=n),items:r,"align-tabs":"center",height:"60","slider-color":"#f78166"},{tab:t(({item:n})=>[e(c,{"prepend-icon":n.icon,text:n.text,value:n.value,class:"text-none"},null,8,["prepend-icon","text","value"])]),_:1},8,["modelValue"])]),_:1}),e(v,{modelValue:l.value,"onUpdate:modelValue":a[1]||(a[1]=n=>l.value=n)},{default:t(()=>[e(i,{value:"appearance"},{default:t(()=>[e(x)]),_:1}),e(i,{value:"billings"},{default:t(()=>[e(g)]),_:1}),e(i,{value:"profile"},{default:t(()=>[e(b)]),_:1}),e(i,{value:"organization"},{default:t(()=>[e(w)]),_:1}),e(i,{value:"settings"},{default:t(()=>[e(y,{formData:s.formData},null,8,["formData"])]),_:1}),e(i,{value:"integrations"},{default:t(()=>[e(V,{sms:s.sms,email:s.email},null,8,["sms","email"])]),_:1})]),_:1},8,["modelValue"])]),_:1})]),_:1})]),_:1})}}},$=h(S,[["__scopeId","data-v-83630937"]]);export{$ as default};
