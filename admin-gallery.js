'use strict';
document.querySelectorAll('[data-admin-gallery]').forEach(panel=>{
  const dialog=panel.closest('[data-record-editor]'),form=panel.closest('form'),add=panel.querySelector('[data-gallery-add]');
  const list=panel.querySelector('[data-admin-gallery-list]'),controls=panel.querySelector('[data-gallery-controls]'),first=panel.querySelector('[data-gallery-save-first]'),feedback=panel.querySelector('[data-admin-gallery-feedback]');
  const save=form.querySelector('[data-record-save]');let destination=Number(form.querySelector('[name="id"]').value),revision=0,request=null,pending=false;
  function enable(busy){pending=busy;if(save)save.disabled=busy;panel.querySelectorAll('input,button').forEach(field=>field.disabled=busy);}
  function render(images){
    list.replaceChildren();
    images.forEach((photo,index)=>{
      const row=document.createElement('div');row.className='admin-gallery-photo';
      const image=document.createElement('img');image.src=photo.src;image.alt=tr('Gallery photo')+' '+(index+1);image.width=64;image.height=48;image.loading='lazy';
      const label=document.createElement('label');label.className='gallery-replace';label.append(document.createTextNode(tr('Replace')));
      const replace=document.createElement('input');replace.type='file';replace.accept='image/jpeg,image/png,image/webp';
      replace.addEventListener('change',()=>replace.files[0]?upload('replace',[replace.files[0]],photo.id):undefined);label.append(replace);
      const remove=document.createElement('button');remove.type='button';remove.className='plain danger';remove.textContent=tr('Remove');
      remove.addEventListener('click',()=>upload('remove',[],photo.id));row.append(image,label,remove);list.append(row);
    });
    if(!images.length){const empty=document.createElement('p');empty.className='muted';empty.textContent=tr('No additional photos yet.');list.append(empty);}
  }
  function populate(record){
    revision++;request?.abort();destination=Number(record?.id||0);add.value='';feedback.textContent='';
    controls.hidden=!destination;first.hidden=!!destination;render(record?.gallery||[]);enable(false);
  }
  async function upload(mode,files,photoId=0){
    if(pending||!destination)return;
    const selected=destination,current=revision;enable(true);feedback.textContent=tr('Uploading photos...');
    let completed=0;
    try{
      const queue=mode==='remove'?[null]:files;
      for(const file of queue){
        if(current!==revision)return;
        if(file&&(!['image/jpeg','image/png','image/webp'].includes(file.type)||file.size>5*1024*1024))throw new Error(tr('Upload a JPG, PNG or WebP image up to 5 MB.'));
        const body=new FormData();body.set('csrf',form.querySelector('[name="csrf"]').value);body.set('destination_id',String(selected));body.set('mode',mode);if(photoId)body.set('photo_id',String(photoId));if(file)body.set('image',file);
        request=new AbortController();const controller=request,timeout=setTimeout(()=>controller.abort(),25000);
        try{
          const response=await fetch(panel.dataset.endpoint,{method:'POST',body,credentials:'same-origin',signal:controller.signal,headers:{Accept:'application/json'}});
          const data=await response.json();if(current!==revision)return;
          if(!response.ok||!data.ok)throw new Error(data.message||tr('The gallery could not be updated. Please try again.'));
          completed++;render(data.images);enable(true);feedback.textContent=mode==='remove'?data.message:tr('Photos saved')+': '+completed+' / '+queue.length;
        }finally{clearTimeout(timeout);}
      }
      if(current===revision)feedback.textContent=tr('Gallery updated.');
    }catch(error){
      if(current===revision)feedback.textContent=(completed?tr('Photos saved')+': '+completed+'. ':'')+(error.name==='AbortError'?tr('The request timed out. Check the gallery before retrying.'):error.message);
    }finally{if(current===revision){add.value='';enable(false);request=null;}}
  }
  add.addEventListener('change',()=>upload('add',[...add.files]));
  dialog.addEventListener('tripora:record-populated',event=>populate(event.detail.record));
  dialog.addEventListener('tripora:record-loading',()=>{revision++;request?.abort();enable(false);});
  dialog.addEventListener('close',()=>{revision++;request?.abort();enable(false);});
  let initial=[];try{initial=JSON.parse(panel.dataset.images||'[]');}catch{}
  populate(destination?{id:destination,gallery:initial}:null);
});
