(()=>{"use strict";const e=window.wp.blocks,t=JSON.parse('{"UU":"create-block/rrze-typesettings"}'),s=window.React,a=window.wp.blockEditor;(0,e.registerBlockType)(t.UU,{edit:({attributes:e,setAttributes:t})=>(0,s.createElement)(a.RichText,{tagName:"p",value:e.content,onChange:e=>t({content:e}),className:"rrze-typesettings-block"}),save:({attributes:e})=>(0,s.createElement)(a.RichText.Content,{tagName:"p",value:e.content,className:"rrze-typesettings-block"})})})();