import{_ as k}from"./FormComponent-BXJpgamY.js";import{V as D,i as e,o as y,c as C,w as n,b as t,f as l,t as w}from"./app-C40yS1Zs.js";import{_ as V}from"./_plugin-vue_export-helper-DlAUqK2U.js";const S={props:{modelRoute:String,title:String},components:{myForm:k},data(){return{dialog:!1,formData:{},id:null}},mounted(){},methods:{submit(){console.log(this.formData),this.$inertia.patch(`/${this.modelRoute}/${this.id}`,this.formData,{onError:()=>{},onSuccess:()=>{console.log("success")}})},close(){this.dialog=!1},show(s){console.log(s),this.id=s.id,this.dialog=!0,D.get(`${this.modelRoute}/${s.id}/edit`).then(o=>{console.log("🚀 ~ axios.get ~ res:",o),this.formData=o.data}).catch(o=>{console.log("🚀 ~ axios.get ~ error:",o)})},hide(){this.dialog=!1}}};function $(s,o,d,F,i,a){const m=e("v-divider"),_=e("v-card-title"),u=e("myForm"),f=e("v-card-text"),r=e("v-icon"),c=e("v-btn"),p=e("v-spacer"),v=e("v-card-actions"),g=e("v-card"),x=e("v-dialog"),h=e("v-row");return y(),C(h,{justify:"center"},{default:n(()=>[t(x,{persistent:"",modelValue:i.dialog,"onUpdate:modelValue":o[0]||(o[0]=b=>i.dialog=b),width:"1200"},{default:n(()=>[t(m),t(g,null,{default:n(()=>[t(_,{class:"text-h5"},{default:n(()=>[l(" Edit "+w(d.title),1)]),_:1}),t(f,null,{default:n(()=>[t(u,{formData:i.formData},null,8,["formData"])]),_:1}),t(v,null,{default:n(()=>[t(c,{variant:"outlined",color:"red",onClick:a.close},{default:n(()=>[t(r,null,{default:n(()=>o[1]||(o[1]=[l("mdi-close-box-multiple")])),_:1}),o[2]||(o[2]=l(" Close "))]),_:1},8,["onClick"]),t(p),t(c,{variant:"outlined",color:"primary",onClick:a.submit},{default:n(()=>[t(r,null,{default:n(()=>o[3]||(o[3]=[l("mdi-checkbox-marked")])),_:1}),o[4]||(o[4]=l(" Submit "))]),_:1},8,["onClick"])]),_:1})]),_:1})]),_:1},8,["modelValue"])]),_:1})}const N=V(S,[["render",$]]);export{N as default};