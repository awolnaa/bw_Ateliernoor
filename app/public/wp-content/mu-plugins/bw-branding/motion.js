(()=>{'use strict';const reduced=matchMedia('(prefers-reduced-motion: reduce)');let observer;const marked=new Set();
function reset(){observer?.disconnect();document.documentElement.classList.remove('bw-motion-ready');marked.forEach(el=>{el.removeAttribute('data-bw-enter');el.classList.remove('bw-entered');el.style.removeProperty('--bw-delay')});marked.clear()}
function init(){reset();if(reduced.matches||!('IntersectionObserver'in window))return;
 try{document.querySelectorAll('[data-reveal]').forEach(el=>{if(el.matches('[class$="-card"],[class$="-benefit"]'))el.style.setProperty('--delay',`${Math.min(Array.from(el.parentElement.children).indexOf(el)%3,2)*110}ms`)});observer=new IntersectionObserver(entries=>entries.forEach(({target,isIntersecting})=>{if(isIntersecting){target.classList.add('bw-entered');observer.unobserve(target)}}),{threshold:.08,rootMargin:'0px 0px -24px 0px'});
 document.querySelectorAll('main h2, main section > p, main .wp-block-columns > .wp-block-column, main .wp-block-image').forEach(el=>{
 if(el.closest('[data-reveal],[class*="-hero"],form,dialog')||el.querySelector('[data-reveal]'))return;
 el.setAttribute('data-bw-enter','');el.style.setProperty('--bw-delay',`${Math.min(Array.from(el.parentElement.children).indexOf(el)%3,2)*90}ms`);marked.add(el);observer.observe(el);
 });document.documentElement.classList.add('bw-motion-ready');
 }catch{reset()}}
init();reduced.addEventListener('change',init);window.addEventListener('pageshow',e=>{if(e.persisted)init()});})();
