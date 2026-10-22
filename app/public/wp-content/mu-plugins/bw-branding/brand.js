(()=>{'use strict';document.querySelectorAll('.bw-brand-credit').forEach(credit=>{
 let ancestor=credit.parentElement,bg=null;
 const sibling=credit.previousElementSibling;
 if(sibling){const candidates=[sibling,...sibling.querySelectorAll('*')].reverse();for(const el of candidates){if(el.getBoundingClientRect().width<credit.getBoundingClientRect().width*.6)continue;const values=getComputedStyle(el).backgroundColor.match(/[\d.]+/g)?.map(Number);if(values&&values.length>=3&&(values.length<4||values[3]>.95)){bg=values;break}}}
 while(ancestor&&!bg){const color=getComputedStyle(ancestor).backgroundColor;const values=color.match(/[\d.]+/g)?.map(Number);if(values&&values.length>=3&&(values.length<4||values[3]>.95)){bg=values;break}ancestor=ancestor.parentElement;}
 if(!bg)return;
 const light=(bg[0]*.2126+bg[1]*.7152+bg[2]*.0722)>150;
 credit.style.backgroundColor=`rgb(${bg.slice(0,3).join(',')})`;
 if(light){credit.classList.add('is-light');const img=credit.querySelector('img');img.src=img.src.replace('-white.svg','-black.svg');}
});})();
