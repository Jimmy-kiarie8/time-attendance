import{_ as c}from"./AppLayout-CIqEW8DM.js";import l from"./DeleteUserForm-BxCYdBtM.js";import f from"./LogoutOtherBrowserSessionsForm-C0sp0NTz.js";import{S as s}from"./SectionBorder-BfaKFW4A.js";import u from"./TwoFactorAuthenticationForm-DcbE1e1N.js";import d from"./UpdatePasswordForm-CAm2eQSt.js";import _ from"./UpdateProfileInformationForm-CbUw70Wa.js";import{o as e,c as h,w as p,a as i,d as r,b as t,e as a,F as g}from"./app-C40yS1Zs.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./Modal-BV6U3s1a.js";import"./SectionTitle-zW0sdYEO.js";import"./DangerButton-DXAgygwr.js";import"./DialogModal-d0J2Osw6.js";import"./InputError-OWRguEfy.js";import"./SecondaryButton-Ci4R0M61.js";import"./TextInput-BDJ7sjrc.js";import"./ActionMessage-p3q9V-rU.js";import"./PrimaryButton-BgYbRSN-.js";import"./InputLabel--klNhgRe.js";import"./FormSection-B35ZZGIf.js";const $={class:"max-w-7xl mx-auto py-10 sm:px-6 lg:px-8"},w={key:0},k={key:1},y={key:2},G={__name:"Show",props:{confirmsTwoFactorAuthentication:Boolean,sessions:Array},setup(m){return(o,n)=>(e(),h(c,{title:"Profile"},{header:p(()=>n[0]||(n[0]=[i("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"}," Profile ",-1)])),default:p(()=>[i("div",null,[i("div",$,[o.$page.props.jetstream.canUpdateProfileInformation?(e(),r("div",w,[t(_,{user:o.$page.props.auth.user},null,8,["user"]),t(s)])):a("",!0),o.$page.props.jetstream.canUpdatePassword?(e(),r("div",k,[t(d,{class:"mt-10 sm:mt-0"}),t(s)])):a("",!0),o.$page.props.jetstream.canManageTwoFactorAuthentication?(e(),r("div",y,[t(u,{"requires-confirmation":m.confirmsTwoFactorAuthentication,class:"mt-10 sm:mt-0"},null,8,["requires-confirmation"]),t(s)])):a("",!0),t(f,{sessions:m.sessions,class:"mt-10 sm:mt-0"},null,8,["sessions"]),o.$page.props.jetstream.hasAccountDeletionFeatures?(e(),r(g,{key:3},[t(s),t(l,{class:"mt-10 sm:mt-0"})],64)):a("",!0)])])]),_:1}))}};export{G as default};