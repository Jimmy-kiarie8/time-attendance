import{a as i}from"./Modal-BV6U3s1a.js";import{o as n,c as d,w as r,a as t,A as o}from"./app-C40yS1Zs.js";const m={class:"px-6 py-4"},h={class:"text-lg font-medium text-gray-900"},f={class:"mt-4 text-sm text-gray-600"},x={class:"flex flex-row justify-end px-6 py-4 bg-gray-100 text-right"},w={__name:"DialogModal",props:{show:{type:Boolean,default:!1},maxWidth:{type:String,default:"2xl"},closeable:{type:Boolean,default:!0}},emits:["close"],setup(e,{emit:a}){const l=a,c=()=>{l("close")};return(s,_)=>(n(),d(i,{show:e.show,"max-width":e.maxWidth,closeable:e.closeable,onClose:c},{default:r(()=>[t("div",m,[t("div",h,[o(s.$slots,"title")]),t("div",f,[o(s.$slots,"content")])]),t("div",x,[o(s.$slots,"footer")])]),_:3},8,["show","max-width","closeable"]))}};export{w as _};