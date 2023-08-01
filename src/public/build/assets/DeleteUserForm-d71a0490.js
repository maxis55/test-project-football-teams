import{o as i,f as u,r as y,k as m,T as w,a as s,w as c,b as t,z as h,d,u as r,A as b,n as k}from"./app-a2eb7c7a.js";import{_ as v}from"./_plugin-vue_export-helper-c27b6911.js";import{_ as $,a as C,b as D}from"./TextInput-22e22a2b.js";import{_ as B}from"./Modal-ac34212f.js";const V={},A={class:"inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"};function S(a,o){return i(),u("button",A,[y(a.$slots,"default")])}const _=v(V,[["render",S]]),U=["type"],K={__name:"SecondaryButton",props:{type:{type:String,default:"button"}},setup(a){return(o,n)=>(i(),u("button",{type:a.type,class:"inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"},[y(o.$slots,"default")],8,U))}},N={class:"space-y-6"},P=t("header",null,[t("h2",{class:"text-lg font-medium text-gray-900 dark:text-gray-100"},"Delete Account"),t("p",{class:"mt-1 text-sm text-gray-600 dark:text-gray-400"}," Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain. ")],-1),T={class:"p-6"},z=t("h2",{class:"text-lg font-medium text-gray-900 dark:text-gray-100"}," Are you sure you want to delete your account? ",-1),E=t("p",{class:"mt-1 text-sm text-gray-600 dark:text-gray-400"}," Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account. ",-1),F={class:"mt-6"},I={class:"mt-6 flex justify-end"},H={__name:"DeleteUserForm",setup(a){const o=m(!1),n=m(null),e=w({password:""}),g=()=>{o.value=!0,h(()=>n.value.focus())},f=()=>{e.delete(route("profile.destroy"),{preserveScroll:!0,onSuccess:()=>l(),onError:()=>n.value.focus(),onFinish:()=>e.reset()})},l=()=>{o.value=!1,e.reset()};return(O,p)=>(i(),u("section",N,[P,s(_,{onClick:g},{default:c(()=>[d("Delete Account")]),_:1}),s(B,{show:o.value,onClose:l},{default:c(()=>[t("div",T,[z,E,t("div",F,[s($,{for:"password",value:"Password",class:"sr-only"}),s(C,{id:"password",ref_key:"passwordInput",ref:n,modelValue:r(e).password,"onUpdate:modelValue":p[0]||(p[0]=x=>r(e).password=x),type:"password",class:"mt-1 block w-3/4",placeholder:"Password",onKeyup:b(f,["enter"])},null,8,["modelValue","onKeyup"]),s(D,{message:r(e).errors.password,class:"mt-2"},null,8,["message"])]),t("div",I,[s(K,{onClick:l},{default:c(()=>[d(" Cancel ")]),_:1}),s(_,{class:k(["ml-3",{"opacity-25":r(e).processing}]),disabled:r(e).processing,onClick:f},{default:c(()=>[d(" Delete Account ")]),_:1},8,["class","disabled"])])])]),_:1},8,["show"])]))}};export{H as default};
