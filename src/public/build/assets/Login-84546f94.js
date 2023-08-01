import{h as b,i as h,v as w,o as n,f as y,T as x,c as u,w as m,a,u as s,Z as v,t as V,g as c,b as r,j as B,d as f,n as C,e as $}from"./app-a2eb7c7a.js";import{_ as P}from"./GuestLayout-9d440b86.js";import{_ as p,a as g,b as k}from"./TextInput-22e22a2b.js";import{P as q}from"./PrimaryButton-fd984736.js";import"./ApplicationLogo-9f19a864.js";import"./_plugin-vue_export-helper-c27b6911.js";const N=["value"],S={__name:"Checkbox",props:{checked:{type:[Array,Boolean],required:!0},value:{default:null}},emits:["update:checked"],setup(l,{emit:e}){const i=l,d=b({get(){return i.checked},set(t){e("update:checked",t)}});return(t,o)=>h((n(),y("input",{type:"checkbox",value:l.value,"onUpdate:modelValue":o[0]||(o[0]=_=>d.value=_),class:"rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"},null,8,N)),[[w,d.value]])}},U={key:0,class:"mb-4 font-medium text-sm text-green-600"},L=["onSubmit"],R={class:"mt-4"},j={class:"block mt-4"},D={class:"flex items-center"},E=r("span",{class:"ml-2 text-sm text-gray-600 dark:text-gray-400"},"Remember me",-1),F={class:"flex items-center justify-end mt-4"},H={__name:"Login",props:{canResetPassword:{type:Boolean},status:{type:String}},setup(l){const e=x({email:"",password:"",remember:!1}),i=()=>{e.post(route("login"),{onFinish:()=>e.reset("password")})};return(d,t)=>(n(),u(P,null,{default:m(()=>[a(s(v),{title:"Log in"}),l.status?(n(),y("div",U,V(l.status),1)):c("",!0),r("form",{onSubmit:$(i,["prevent"])},[r("div",null,[a(p,{for:"email",value:"Email"}),a(g,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:s(e).email,"onUpdate:modelValue":t[0]||(t[0]=o=>s(e).email=o),required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),a(k,{class:"mt-2",message:s(e).errors.email},null,8,["message"])]),r("div",R,[a(p,{for:"password",value:"Password"}),a(g,{id:"password",type:"password",class:"mt-1 block w-full",modelValue:s(e).password,"onUpdate:modelValue":t[1]||(t[1]=o=>s(e).password=o),required:"",autocomplete:"current-password"},null,8,["modelValue"]),a(k,{class:"mt-2",message:s(e).errors.password},null,8,["message"])]),r("div",j,[r("label",D,[a(S,{name:"remember",checked:s(e).remember,"onUpdate:checked":t[2]||(t[2]=o=>s(e).remember=o)},null,8,["checked"]),E])]),r("div",F,[l.canResetPassword?(n(),u(s(B),{key:0,href:d.route("password.request"),class:"underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"},{default:m(()=>[f(" Forgot your password? ")]),_:1},8,["href"])):c("",!0),a(q,{class:C(["ml-4",{"opacity-25":s(e).processing}]),disabled:s(e).processing},{default:m(()=>[f(" Log in ")]),_:1},8,["class","disabled"])])],40,L)]),_:1}))}};export{H as default};
