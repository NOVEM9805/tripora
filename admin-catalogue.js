'use strict';
document.querySelectorAll('[data-admin-catalogue]').forEach(panel=>{
  const form=panel.querySelector('[data-catalogue-form]'),country=form.querySelector('[data-catalogue-country]'),destination=form.querySelector('[data-catalogue-destination]'),search=form.querySelector('[data-catalogue-search]');
  const rows=panel.querySelector('[data-catalogue-rows]'),results=panel.querySelector('[data-catalogue-results]'),feedback=panel.querySelector('[data-catalogue-feedback]');
  const pager=panel.querySelector('[data-catalogue-pager]'),prev=panel.querySelector('[data-catalogue-prev]'),next=panel.querySelector('[data-catalogue-next]'),counter=panel.querySelector('[data-catalogue-count]');
  const editor=document.querySelector('[data-record-editor]');let page=Number(panel.dataset.page)||1,pages=1,timer=null,request=null,revision=0;
  const bindRows=()=>{
    rows.querySelectorAll('[data-record-edit]').forEach(link=>link.addEventListener('click',event=>{event.preventDefault();editor?.dispatchEvent(new CustomEvent('tripora:edit-record',{detail:{id:link.dataset.recordId}}));}));
    rows.querySelectorAll('form[data-confirm]').forEach(rowForm=>rowForm.addEventListener('submit',event=>{if(!window.confirm(rowForm.dataset.confirm))event.preventDefault();}));
  };
  async function load(target=1){
    clearTimeout(timer);request?.abort();const current=++revision;results.hidden=true;pager.hidden=true;prev.disabled=true;next.disabled=true;
    if(!country.value&&!search.value.trim()){
      rows.replaceChildren();feedback.textContent=tr('Choose a country or search to view records.');if(destination){destination.value='';destination.disabled=true;}
      const url=new URL(window.location.href);['edit','country_id','destination_id','list_page'].forEach(key=>url.searchParams.delete(key));
      if(search.value)url.searchParams.set('q',search.value);else url.searchParams.delete('q');window.history.replaceState(null,'',url);return;
    }
    feedback.textContent=tr('Searching...');request=new AbortController();const controller=request,timeout=setTimeout(()=>controller.abort(),15000);
    const params=new URLSearchParams({entity:panel.dataset.entity,country_id:country.value,destination_id:destination?.value||'',q:search.value,list_page:String(target)});
    try{
      const response=await fetch(panel.dataset.endpoint+'?'+params,{credentials:'same-origin',signal:controller.signal,headers:{Accept:'application/json'}});
      const data=await response.json();if(current!==revision)return;
      if(!response.ok||!data.ok)throw new Error(data.message||tr('Could not load records. Please try again.'));
      if(destination){
        destination.replaceChildren();const all=document.createElement('option');all.value='';all.textContent=tr('All destinations in this country');destination.append(all);
        data.destinations.forEach(item=>{const option=document.createElement('option');option.value=String(item.id);option.textContent=item.name;destination.append(option);});
        destination.value=data.destination_id?String(data.destination_id):'';destination.disabled=!data.country_id;
      }
      // HTML is rendered and escaped by the authenticated, same-origin endpoint.
      rows.innerHTML=data.html;bindRows();page=data.page;pages=data.pages;feedback.textContent=data.message;
      results.hidden=!data.total;pager.hidden=!data.total;counter.textContent=page+' / '+pages+' · '+data.total;prev.disabled=page<=1;next.disabled=page>=pages;
      const url=new URL(window.location.href);url.searchParams.delete('edit');
      if(country.value)url.searchParams.set('country_id',country.value);else url.searchParams.delete('country_id');
      if(destination?.value)url.searchParams.set('destination_id',destination.value);else url.searchParams.delete('destination_id');
      if(search.value)url.searchParams.set('q',search.value);else url.searchParams.delete('q');url.searchParams.set('list_page',String(page));window.history.replaceState(null,'',url);
    }catch(error){if(current===revision)feedback.textContent=error.name==='AbortError'?tr('The request timed out. Please try again.'):error.message;}
    finally{clearTimeout(timeout);}
  }
  form.addEventListener('submit',event=>{event.preventDefault();load(1);});
  country.addEventListener('change',()=>{if(destination){destination.value='';destination.disabled=true;}load(1);});
  destination?.addEventListener('change',()=>load(1));
  search.addEventListener('input',()=>{request?.abort();revision++;results.hidden=true;pager.hidden=true;clearTimeout(timer);timer=setTimeout(()=>load(1),220);});
  prev.addEventListener('click',()=>load(Math.max(1,page-1)));next.addEventListener('click',()=>load(page+1));
  window.addEventListener('pagehide',()=>{revision++;request?.abort();clearTimeout(timer);});
});
