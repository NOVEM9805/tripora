'use strict';
document.querySelectorAll('[data-destination-gallery]').forEach(gallery=>{
  const main=gallery.querySelector('[data-gallery-main]'),stage=gallery.querySelector('[data-gallery-stage]');
  const thumbs=[...gallery.querySelectorAll('[data-gallery-thumbnail]')],prev=gallery.querySelector('[data-gallery-prev]'),next=gallery.querySelector('[data-gallery-next]');
  const counter=gallery.querySelector('[data-gallery-count]'),feedback=gallery.querySelector('[data-gallery-feedback]');
  if(!main||!stage)return;
  if(thumbs.length<2){thumbs.forEach(thumb=>thumb.addEventListener('click',event=>event.preventDefault()));return;}
  let index=0,requested=0,revision=0,touch=null;
  const move=target=>{
    requested=(target+thumbs.length)%thumbs.length;const selected=requested,current=++revision;
    stage.setAttribute('aria-busy','true');feedback.textContent='';
    const loader=new Image();
    loader.onload=()=>{
      if(current!==revision)return;
      main.src=thumbs[selected].dataset.src;main.alt=thumbs[selected].dataset.alt;index=selected;
      thumbs.forEach((thumb,i)=>{thumb.classList.toggle('active',i===index);thumb.setAttribute('aria-current',String(i===index));});
      counter.textContent=(index+1)+' / '+thumbs.length;stage.removeAttribute('aria-busy');
      thumbs[selected].scrollIntoView?.({block:'nearest',inline:'nearest'});
    };
    loader.onerror=()=>{
      if(current!==revision)return;requested=index;stage.removeAttribute('aria-busy');
      feedback.textContent=gallery.dataset.loadError;
    };
    loader.src=thumbs[selected].dataset.src;
  };
  thumbs.forEach((thumb,i)=>thumb.addEventListener('click',event=>{event.preventDefault();move(i);}));
  prev.hidden=false;next.hidden=false;
  prev.addEventListener('click',()=>move(requested-1));next.addEventListener('click',()=>move(requested+1));
  stage.addEventListener('keydown',event=>{
    if(event.key==='ArrowLeft'||event.key==='ArrowRight'){event.preventDefault();move(requested+(event.key==='ArrowLeft'?-1:1));}
    else if(event.key==='Home'||event.key==='End'){event.preventDefault();move(event.key==='Home'?0:thumbs.length-1);}
  });
  stage.addEventListener('touchstart',event=>{touch=event.touches.length===1?{x:event.touches[0].clientX,y:event.touches[0].clientY}:null;},{passive:true});
  stage.addEventListener('touchend',event=>{
    if(!touch||!event.changedTouches.length)return;
    const dx=event.changedTouches[0].clientX-touch.x,dy=event.changedTouches[0].clientY-touch.y;touch=null;
    if(Math.abs(dx)>45&&Math.abs(dx)>Math.abs(dy)*1.4)move(requested+(dx<0?1:-1));
  },{passive:true});
  stage.addEventListener('touchcancel',()=>{touch=null;},{passive:true});
});
